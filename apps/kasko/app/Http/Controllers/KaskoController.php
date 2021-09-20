<?php

namespace App\Http\Controllers;

use App\Helpers\ConverterHelper;
use App\Helpers\TextHelper;
use App\Http\Requests\CarAveragePriceRequest;
use App\Http\Requests\CarFromEsbdRequest;
use App\Http\Requests\GetTarifesRequest;
use App\Http\Requests\GetTemplateRequest;
use App\Http\Requests\RescindingPolicyRequest;
use App\Http\Requests\SetCarRequest;
use App\Http\Requests\SetPolicyRequest;
use App\Models\Client;
use App\Models\Franchise;
use App\Models\Policy;
use App\Models\PolicyCar;
use App\Models\User;
use App\Services\DictionaryService;
use App\Services\EsbdService;
use App\Services\FileRepoService;
use App\Services\KolesaService;
use App\Services\NotificationService;
use App\Services\OnesService;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Mpdf\Mpdf;

class KaskoController extends BaseController
{
    public NotificationService $notificationService;
    public OnesService $onesService;

    public function __construct()
    {
        $this->notificationService = new NotificationService;
        $this->onesService         = new OnesService;

    }

    public function getCarAveragePrice(CarAveragePriceRequest $request): JsonResponse
    {
        $data = KolesaService::GetCarPricing($request->all());

        if (empty($data)) {
            return $this->sendError('Средняя стоимость не определена!');
        }

        return $this->sendResponse('Данные успешно получены!', $data);
    }

    /**
     * @param CarFromEsbdRequest $request
     * @return JsonResponse
     * @throws GuzzleException
     */
    public function getCarFromEsbd(CarFromEsbdRequest $request): JsonResponse
    {
        $data = (new EsbdService)->getCar($request->all());

        if ($data) {
            $data->number = $request->number;
            return $this->sendResponse('Данные успешно получены!', $data);
        } else {
            return $this->sendError("Машина по госномеру " . $request->number . " не найден!");
        }
    }

    public function setCar(SetCarRequest $request): JsonResponse
    {
        $car = (new PolicyCar())->setData($request->all());

        return $this->sendResponse('Success!', $car);
    }

    /**
     * @param GetTarifesRequest $request
     * @return JsonResponse
     * @throws GuzzleException
     */
    public function getTarifes(GetTarifesRequest $request): JsonResponse
    {
        $productIds = [200, 206];
        $where      = 'where[code][operator]=IN';
        foreach ($productIds as $id) $where .= "&where[code][value][]=$id";

        $products = (new DictionaryService)->get("api/products?$where");

        $franchises = [];
        foreach ($products as $product) {
            $f = Franchise::where('product_code', $product->code)->get()->toArray();
            foreach ($f as &$v) {
                $v['premium']       = round($request->insurance_sum * $v['tarif']);
                $v['product_title'] = $product->title;
            }
            $franchises[] = $f;
        }

        return $this->sendResponse('Success!', $franchises);
    }


    /**
     * @throws GuzzleException
     */
    public function setPolicy(SetPolicyRequest $request): JsonResponse
    {
        $data = $request->all();

        /* Определяем определяем агента или без агента
         Если агент то его данные берем далее для выписки*/
        $user = Auth::user();
        if(isset($data['policyData']['agent_id_1c']) && $user->id_1c !== $data['policyData']['agent_id_1c']) {
            $agents = collect($user->agents);
            $user = collect($agents->firstWhere('id_1c', $data['policyData']['agent_id_1c']));
        }

        if (isset($data['policy_id'])) {
            $policy         = Policy::with(['car', 'client'])->find($data['policy_id']);
            $policy->status = Policy::STATUS_DONE;
        } else {
            try {
                $policyData = $data['policyData'];
                $clientData = $data['client'];
                $carsData   = $data['cars'];

                $policyData['user_id_1c']    = $user['id_1c'];


                $policyData['manager_id_1c'] = $user['manager_id'];
                $policyData['agent_id_1c']   = $user['agent_id'];
                $policyData['beneficiary']   = $data['beneficiary'];

                if (!empty($user->product_accesses)) {
                    $policyData['sales_channel_id_1c'] = $user->product_accesses[0]['sales_channel_id_1c'];
                    $policyData['detailing_id_1c']     = $user->product_accesses[0]['detailing_id_1c'];
                }

                if (isset($policyData['id']) && $policyData['id'] != 'new') {
                    $policy = Policy::findOrFail($policyData['id']);
                    $policy->setData($policyData);
                } else {
                    $policy = Policy::create($policyData);
                }

                if ($policy->client) {
                    $policyClient = $policy->client->setData($clientData);
                } else {
                    $clientData['policy_id'] = $policy->id;
                    $policyClient            = (new Client)->setData($clientData);
                }
                $policyClient->save();


                foreach ($carsData as $car) {
                    if ($policy->car) {
                        $policyCar = $policy->car->setData($car);
                    } else {
                        $car['policy_id'] = $policy->id;
                        $policyCar        = (new PolicyCar)->setData($car);
                    }
                    $policyCar->save();
                }
            } catch (Exception $exception) {
                return $this->sendError($exception->getMessage(), $exception->getTrace());
            }
        }

        if ($policy->status == Policy::STATUS_DRAFT) {
            $policy->save();
            return $this->sendResponse('Черновик успешно сохранен!', $policy);
        }

        $policy->refresh();
        $result = $this->onesService->setPolicy($policy);
        if ($result['success']) {
            $policy_number         = explode(' ', $result['data']['message'])[1];
            $policy->policy_number = $policy_number;
            $policy->ordered_at    = date('Y-m-d H:i:s');
            $policy->status        = Policy::STATUS_DONE;
            $policy->save();

            try {
                $request = (new GetTemplateRequest());
                $request->merge([
                    'policy_id' => $policy->id,
                    'key'       => $policy->product_code === 200 ? 'kasko_application' : 'grand_kasko_application',
                    'save'      => 1
                ]);

                $res = $this->getTemplate($request)->getData();
                if ($res->success == TRUE && $policy->client->email) {
                    $values = [
                        'full_name'  => $policy->client->fio,
                        'created_at' => date('d.m.Y')
                    ];

                    $email_data  = [
                        "send_from"   => env('MAIL_FROM_ADDRESS', 'noreply@a-i.kz'),
                        "send_to"     => $policy->client->email,
                        "code"        => Policy::EMAIL_KASKO_CODE,
                        "values"      => $values,
                        "attachments" => [$policy->policy_number]
                    ];

                    $this->notificationService->sendNotification($email_data, 'email');
                }
            } catch (Exception $e) {
                return $this->sendError('Не удалось отправить договор на почту клиента!', $e->getMessage());
            }

        } else {
            $this->sendError('Ошибка!', $result);
        }
        return $this->sendResponse('Полис успешно выписан!', $policy);

    }

    public function rescindingPolicy(RescindingPolicyRequest $request)
    {
        dd($request);
    }

    public function cancelPolicy(RescindingPolicyRequest $request)
    {
        $policyNumber = $request->policy_number;
        $policy       = Policy::firstWhere('policy_number', $policyNumber);

        if (!$policy) {
            return $this->sendError("Полис $policyNumber не найден!", "Полис $policyNumber не найден!");
        }

        if ($policy->validateForRescinding()) {
            $res = $this->onesService->setPolicyRescindingReason($policyNumber, Policy::RESCINDING_OPERATOR_MISTAKE);

            if ($res['success']) {
                if (isset($res['data']['status'])) {
                    $policy->status = Policy::RESCINDING_OPERATOR_MISTAKE;
                    $policy->save();
                    return $this->sendResponse($res['data']['message'], $policy);
                } else {
                    return $this->sendError("Полис $policyNumber уже отменен!");
                }
            } else {
                return $this->sendError("Ошибка!", Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } else {
            return $this->sendError("Нельзя отменить полис. Полис должен быть выписан сегодня!", "Нельзя отменить полис. Полис должен быть выписан сегодня!");
        }
    }


    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function getTemplate(GetTemplateRequest $request): JsonResponse
    {
        $template = (new DictionaryService)->get('api/print-templates/key/' . $request->key);

        if (!isset($template->id)) {
            return $this->sendError('Шаблон ' . $request->key . ' не найден!');
        }
        $templateBody = $template->body_ru;

        if (isset($request->policy_id)) {
            $data = Policy::with(['car', 'client'])->findOrFail($request->policy_id)->toArray();
        } else {
            if (!is_array($request->data)) {
                $data = ConverterHelper::parseObj2Arr(json_decode($request->data));
            } else {
                $data = $request->data;
            }
        }

        if (isset($data['agent_id_1c']) && isset($data['manager_id_1c'])) {
            $data['agent']   = User::findBy('id_1c', $data['agent_id_1c'])->toArray();
            $data['manager'] = User::findBy('id_1c', $data['manager_id_1c'])->toArray();
        }


        try {
            // Задаем конфиги mPDF
            $config = ['mode' => 'utf-8'];
            if (!isset($request->config)) {
                $config['format'] = [230, 310];
            } else {
                if (!is_array($request->config)) {
                    $config = ConverterHelper::parseObj2Arr(json_decode($request->config));
                } else {
                    $config = $request->config;
                }
            }

            $mpdf = new Mpdf($config);

            $mpdf->WriteHTML(TextHelper::bladeCompile($templateBody, $data));

            $path = storage_path('app/temp/contracts/');

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $filename = ($data['policy_number'] ?? $request->key) . ".pdf";
            $filepath = $path . $filename;
            $mpdf->Output($filepath, 'F');

            if (isset($request->save) && $request->save == 1) {
                try {
                    (new FileRepoService())->saveFile($data['policy_number'] ?? $request->key, fopen($filepath, 'r'));
                } catch (Exception $e) {
                    // пока хз что делать.
                }
            }

            $resp = [
                'fileName' => $filename,
                'file'     => base64_encode(fread(fopen($filepath, 'r'), filesize($filepath)))
            ];
            return $this->sendResponse('Success!', $resp);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), [], 500);
        }
    }
}
