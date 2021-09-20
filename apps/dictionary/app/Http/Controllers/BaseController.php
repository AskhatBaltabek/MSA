<?php

namespace App\Http\Controllers;

use App\Models\BaseModel;
use App\Models\Log;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BaseController extends Controller
{
    /**
     *
     * @param Request $request
     * @param string $modelName
     * @param int|null $id
     * @return mixed
     */
    public function show(Request $request, string $modelName, int $id = NULL)
    {
        $modelName = BaseModel::MODELS[$modelName];
        $model = new $modelName;

        $relations = is_array($request->with) ? $request->with : [];

        /* Определяем только существующие методы */
        foreach($relations as $key => $relation)
        {
            if(!method_exists($model, $relation))
                unset($relations[$key]);
        }
        $model = $model->with($relations);

        $whereClauses = $request->where;
        if($whereClauses && is_array($whereClauses))
        {
            foreach($whereClauses as $column => $value)
            {
                if(is_array($value)) {
                    if(is_array($value['value'])) {
                        $value['value'] = "(" . implode(',', $value['value']) . ")";
                    }
                    $model->whereRaw($column . " " . $value['operator'] . " " . $value['value']);
                }
                else
                    $model->where($column, $value);
            }
        }

        $orderClauses = $request->order;
        if($orderClauses && is_array($orderClauses)) {
            foreach($orderClauses as $column => $orderType) {
                $model->orderBy($column, $orderType);
            }
        }

        /*  */
        if($request->pagination) {
            $pagination = $request->pagination;
            return $model->paginate($pagination['pageSize']);
        }

        if($id) {
            return $model->findOrFail($id);
        }
        else {
            return $model->get();
        }
    }

    /**
     * @param Request $request
     * @param string $modelName
     * @param string $fieldName
     * @param string $fieldValue
     * @return mixed
     */
    public function showByField(Request $request, string $modelName, string $fieldName, string $fieldValue)
    {
        $modelName = BaseModel::MODELS[$modelName];
        $model = new $modelName;

        $relations = is_array($request->with) ? $request->with : [];

        /* Определяем только существующие методы */
        foreach($relations as $key => $relation)
        {
            if(!method_exists($model, $relation))
                unset($relations[$key]);
        }
        $model = $model->with($relations);

        $whereClauses = $request->where;
        if($whereClauses && is_array($whereClauses))
        {
            foreach($whereClauses as $column => $value)
            {
                $model->where($column, $value);
            }
        }

        return $model->where($fieldName, $fieldValue)->firstOrFail();
    }

    /**
     * @param Request $request
     * @param $modelName
     * @return JsonResponse
     */
    public function create(Request $request, $modelName)
    {
        $modelName = BaseModel::MODELS[$modelName];
        $model = new $modelName;

        /* Валидация запроса если в классе прописан метод rules() */
        if(method_exists($model, 'rules'))
        {
            $valid = self::requestValidate($request->all(), $model->rules());
            if(!$valid['isValid'])
            {
                return $this->sendError($valid['message'], $valid['messages'], Response::HTTP_NOT_FOUND);
            }
        }

        $model = $model->create($request->all());

        return $this->sendResponse('Created successfully!', $model, Response::HTTP_CREATED);
    }

    /**
     * @param Request $request
     * @param $modelName
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $modelName, $id)
    {
        $modelName = BaseModel::MODELS[$modelName];
        $model = (new $modelName)->findOrFail($id);

        /* Валидация запроса если в классе прописан метод rules() */
        if(method_exists($model, 'rules'))
        {
            $valid = self::requestValidate($request->all(), $model->rules());
            if(!$valid['isValid'])
            {
                return $this->sendError($valid['message'], $valid['messages'], Response::HTTP_NOT_FOUND);
            }
        }
        $model->update($request->all());
        if($modelName == 'App\Models\Setting'){
            $log = Log::generateLog($request->setting);
            $model->logs()->save($log);
        }

        return $this->sendResponse('Updated successfully!', $model, Response::HTTP_ACCEPTED);
    }

    /**
     * @param $modelName
     * @param $id
     * @return mixed
     */
    public function delete($modelName, $id)
    {
        $modelName = BaseModel::MODELS[$modelName];
        $model = (new $modelName)->findOrFail($id);

        $model->delete();

        return $this->sendResponse("Record ID:$id deleted!", true);
    }

    /**
     * @param array $data
     * @param array $rules
     * @return array
     */
    public static function requestValidate(array $data, array $rules)
    {
        $valid = Validator::make($data, $rules);
        $errorsMessages = $valid->errors()->messages();
        $result = ['isValid' => true, 'message' => '', 'messages' => []];

        if($errorsMessages)
        {
            $result['isValid'] = false;
            $result['messages'] = $errorsMessages;
            foreach($errorsMessages as $m)
            {
                $result['message'] .= implode(', ', $m)."\n";
            }
        }

        return $result;
    }

    /**
     * @param $modelName
     * @return JsonResponse
     */
    public function getDefaultNFields($modelName) {
        $modelName = BaseModel::MODELS[$modelName];
        $model = new $modelName;

        $fields = [];
        $default = [];
        $labels = $model->labels;

        $readOnlyFields = $model->readOnlyFields ? $model->readOnlyFields : ['id'];
        $fillable = $model->fillable ? $model->fillable : [];

        $query = /** @lang text|SQL */
            "SELECT
              `COLUMN_NAME` as column_name,
              `COLUMN_DEFAULT` as column_default,
              `DATA_TYPE` as data_type,
               IF(`COLUMN_NAME` IN ('".implode("','", $readOnlyFields)."'), 1, 0) readonly
            FROM `INFORMATION_SCHEMA`.`COLUMNS`
            WHERE `TABLE_NAME` = '".$model->getTable()."'
              AND `TABLE_SCHEMA` = '".env('DB_DATABASE')."'
              AND (`COLUMN_NAME` IN ('".implode("','", $fillable)."')
                    OR `COLUMN_NAME` IN ('".implode("','", $readOnlyFields)."'))
            ORDER BY `ORDINAL_POSITION`";

        $result = DB::select($query);
        foreach($result as $col) {
            $default[$col->column_name] = $col->column_default;
            $fields[] = [
                'column_index' => $col->column_name,
                'title' => isset($labels[$col->column_name]) ? $labels[$col->column_name] : $col->column_name,
                'data_type' => $col->data_type,
                'readonly' => $col->readonly
            ];
        }

        $data = ['fields' => $fields, 'default' => $default];
        return $this->sendResponse('Success', $data);
    }

    /**
     * success response method.
     *
     * @param $message
     * @param array $data
     * @param int $status
     * @return JsonResponse
     */
    public function sendResponse($message, $data = [], $status = Response::HTTP_OK)
    {
        $response = [
            'success' => true,
            'data'    => $data,
            'message' => $message,
        ];

        return response()->json($response,$status);
    }

    /**
     * return error response.
     *
     * @param string $error
     * @param array $errorMessages
     * @param int $status
     * @return JsonResponse
     */
    public function sendError($error = 'Error!', $errorMessages = [], $status = Response::HTTP_NOT_FOUND)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $status);
    }

    /**
     * Testing routes
     */
    public function test()
    {

    }


    public function test2()
    {

    }
}
