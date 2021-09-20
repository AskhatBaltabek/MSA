<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Http\Requests\{GetClientRequest, SetClientRequest};
use App\Services\EsbdService;
use App\Services\OnesService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;

class ClientController extends Controller
{
    /**
     * @throws GuzzleException
     */
    public function exchangeClient(GetClientRequest $request): JsonResponse
    {
        $data = (new EsbdService())->exchangeClient($request->all());
        if (isset($data->ID)) {
            if ($data->Natural_Person_Bool == 1) {
                $onesClient                = (new OnesService)->getClient($request->all());
                $data->document_number     = $onesClient->DocNumber ?? '';
                $data->document_gived_date = $onesClient->DocGivedAt ?? '';
                $data->document_type_id    = $onesClient->DocType ?? '';
                $data->document_gived_by   = $onesClient->DocGivedBy ?? '';
                $data->mobile_phone        = $onesClient->MobilePhone ?? '';
                $data->address             = $onesClient->AddressStreet ?? '';
                $data->fio                 = $onesClient->AccountName ?? '';
            }

            return $this->sendResponse('Данные успешно получены!', $data);
        }

        return $this->sendError('Error!', $data);
    }

    /**
     * @param GetClientRequest $request
     * @return JsonResponse
     */
    public function getClient(GetClientRequest $request): JsonResponse
    {
        $response = (new EsbdService())->getClient($request->all());
        if (!empty($response->success)) {
            if (!empty($response->data) && isset($response->data['natural_person_bool']) && $response->data['natural_person_bool'] == 1) {
                $onesClient = (new OnesService)->getClient($request->all());

                $response->data['first_name']                 = $response->data['first_name'] ?? ($onesClient->FirstName ?? '');
                $response->data['last_name']                  = $response->data['last_name'] ?? ($onesClient->LastName ?? '');
                $response->data['middle_name']                = $response->data['middle_name'] ?? ($onesClient->MiddleName ?? '');
                $response->data['fio']                        = implode(' ', [$response->data['last_name'], $response->data['first_name'], $response->data['middle_name']]);
                $response->data['document_number']            = $response->data['document_number'] ?? ($onesClient->DocNumber ?? '');
                $response->data['document_gived_date']        = $response->data['document_gived_date'] ?? ($onesClient->DocGivedAt ?? '');
                $response->data['document_type_id']           = $response->data['document_type_id'] ?? ($onesClient->DocType ?? '');
                $response->data['document_gived_by']          = $response->data['document_gived_by'] ?? ($onesClient->DocGivedBy ?? '');
                $response->data['mobile_phone']               = isset($response->data['phones']) && strlen($response->data['phones']) > 6 ? $response->data['phones'] : ($onesClient->MobilePhone ?? '');
                $response->data['address']                    = $response->data['address'] ?? ($onesClient->AddressStreet ?? '');
                $response->data['driver_certificate']         = $onesClient->DRIVER_CERTIFICATE ?? '';
                $response->data['driver_certificate_date']    = !empty($onesClient->DRIVER_CERTIFICATE_DATE) ? Carbon::parse($onesClient->DRIVER_CERTIFICATE_DATE)->format('d.m.Y') : '';
                $response->data['driver_certificate_type_id'] = $onesClient->DRIVER_CERTIFICATE_TYPE_ID ?? '';
            }

            return $this->sendResponse('Данные успешно получены!', (object)$response->data);
        }

        return $this->sendError('Ошибка при запросе!', $response);
    }

    /**
     * @param SetClientRequest $request
     * @return JsonResponse
     * @throws GuzzleException
     */
    public function setClient(SetClientRequest $request): JsonResponse
    {
        $response = (new EsbdService())->setClient($request->all());

        if (!empty($response->success)) {
            return $this->sendResponse('Проверка и сохранения карточка клиента в ЕСБД успешно пройдена.', $response->data);
        }

        if ($response->message)
            return $this->sendError($response->message, $response);
        else
            return $this->sendError('Ошибка при сохранении карточки клиента.', $response);
    }
}
