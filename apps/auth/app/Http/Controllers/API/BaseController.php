<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\Collection;

class BaseController extends Controller
{
    protected $model = NULL;

    /**
     * @param Request $request
     * @param string $modelName
     * @param int|null $id
     * @return mixed
     */
    public function show(Request $request, string $modelName, int $id = NULL)
    {
        $modelName = BaseModel::MODELS[$modelName];
        $model     = new $modelName;

        $relations = is_array($request->with) ? $request->with : [];
        $whereClauses = $request->where;

        /* Определяем только существующие методы */
        foreach ($relations as $key => $relation) {
            if (!method_exists($model, $relation)) {
                unset($relations[$key]);
            }
        }
        $model = $model->with($relations);

        if ($whereClauses && is_array($whereClauses)) {
            foreach ($whereClauses as $column => $value) {
                $rel = explode('.', $column);
                if(count($rel) > 1) {
                    $model->whereHas($rel[0], function(Builder $q) use ($rel, $value) {
                        if(is_array($value)) {
                            $value['value'] = str_replace('\\', '', $value['value']);
                            $q->whereRaw($rel[1] . " " . $value['operator'] . " '" . $value['value'] . "'");
                        } else {
                            $q->where($rel[1], $value);
                        }
                    });
                    continue;
                }
                // replace js json format to php json format (`.` to `->`)
                $column = str_replace('.', '->', $column);
                if (is_array($value)) {
                    $value['value'] = str_replace('\\', '', $value['value']);
                    $model->whereRaw("$column " . $value['operator'] . " '" . $value['value'] . "'");
                } else {
                    $model->where($column, $value);
                }
            }
        }

        $orderClauses = $request->order;
        if ($orderClauses && is_array($orderClauses)) {
            foreach ($orderClauses as $column => $orderType) {
                if($column)
                    // replace js json format to php json format (`.` to `->`)
                    $column = str_replace('.', '->', $column);
                $model->orderBy($column, $orderType);
            }
        }

        if ($request->pagination) {
            $pagination = $request->pagination;
            return $model->paginate($pagination['pageSize']);
        }

        if ($id) {
            return $model->findOrFail($id);
        } else {
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
        $model     = new $modelName;

        $relations = is_array($request->with) ? $request->with : [];

        /* Определяем только существующие методы */
        foreach ($relations as $key => $relation) {
            if (!method_exists($model, $relation))
                unset($relations[$key]);
        }
        $model = $model->with($relations);

        $whereClauses = $request->where;
        if ($whereClauses && is_array($whereClauses)) {
            foreach ($whereClauses as $column => $value) {
                $model->where($column, $value);
            }
        }

        return $model->where($fieldName, $fieldValue)->firstOrFail();
    }

    /**
     * @param Request $request
     * @param string $modelName
     * @return array|JsonResponse
     */
    public function create(Request $request, string $modelName)
    {
        $modelName = (new BaseModel)->getModel($modelName);
        $model = new $modelName;

        /* Валидация запроса если в классе прописан метод rules() */
        if(method_exists($model, 'rules'))
        {
            $valid = self::requestValidate($request->all(), $model->rules());
            if(!$valid['isValid'])
            {
                return $this->sendError($valid['message'], $valid['messages'], 404);
            }
        }

        /* Задаем значении и сохраняем */
        foreach($model->fillable as $field)
        {
            $model->$field = $request->$field;
        }
        $model->save();

        return $this->sendResponse($model, 'Created successfully!');
    }

    /**
     * @param Request $request
     * @param $modelName
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $modelName, $id)
    {
        $modelName = (new BaseModel)->getModel($modelName);
        $model = (new $modelName)->find($id);

        if(!$model) return $this->sendError('Error', ['error' => "Record ID:$id not found!"], 404);

        /* Задаем значении и сохраняем */
        foreach($model->fillable as $field)
        {
            $model->$field = $request->$field;
        }
        $model->save();

        return $this->sendResponse($model, 'Updated successfully!');
    }

    /**
     * @param $modelName
     * @param $id
     * @return mixed
     */
    public function delete($modelName, $id)
    {
        $modelName = (new BaseModel)->getModel($modelName);
        $model = (new $modelName)->find($id);
        if($model) $model->delete();
        else return $this->sendError('Error', ['error' => "Record ID:$id not found!"]);

        return $this->sendResponse(true, "Record ID:$id deleted!");
    }

    /**
     * @param $modelName
     * @return JsonResponse
     */
    public function getDefaultNFields($modelName) {
        $modelName = (new BaseModel)->getModel($modelName);
        $model = new $modelName;
        $fields = [];
        $default = [];
        $labels = $model->labels;

        $query = /** @lang text|SQL */
            "SELECT
              `COLUMN_NAME` as column_name,
              `COLUMN_DEFAULT` as column_default,
              `DATA_TYPE` as data_type,
               IF(`COLUMN_NAME` IN ('".implode("','", $model->readOnlyFields)."'), 1, 0) readonly
            FROM `INFORMATION_SCHEMA`.`COLUMNS`
            WHERE `TABLE_NAME` = '".$model->getTable()."'
              AND `TABLE_SCHEMA` = 'auth'
              AND (`COLUMN_NAME` IN ('".implode("','", $model->fillable)."')
                    OR `COLUMN_NAME` IN ('".implode("','", $model->readOnlyFields)."'))";

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
        return $this->sendResponse($data, 'Success');
    }

    /**
     * @param array $data
     * @param array $rules
     * @return array|JsonResponse
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
     * @return JsonResponse
     */
    public function unauthorized()
    {
        return $this->sendError('Unauthorized', ['error'=>'Please enter correct email or password!'],401);
    }

    /**
     * success response method.
     *
     * @param $result
     * @param $message
     * @return JsonResponse
     */
    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];


        return response()->json($response, 200);
    }


    /**
     * return error response.
     *
     * @param $error
     * @param array $errorMessages
     * @param int $code
     * @return JsonResponse
     */
    public function sendError($error = 'Error!', $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];


        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }

}
