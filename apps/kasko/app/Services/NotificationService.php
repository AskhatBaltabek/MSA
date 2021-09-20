<?php


namespace App\Services;

use App\Traits\ApiClient;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class NotificationService
{
    use ApiClient;

    public $baseUri;
    /**
     * Variable store instance object of GuzzleHttp
     *
     * @var client
     */
    private $client;

    /**
     * Create instance new object.
     * @param null $uri
     */
    public function __construct($uri = NULL)
    {
        $this->baseUri = $uri ?? env('NOTF_SERVICE_BASE_URI');
    }

    public function sendNotification($form_data, $type): array
    {
        if($type == 'email'){
            $url = '/api/email/send-template';
        }else if($type == 'sms'){
            $url = '/api/sms/send-template';
        }else{
            $response['success'] = false;
            $response['message'] = 'Тип уведомления не определен!';
            return $response;
        }
        $params['form_params'] = $form_data;
        $request = $this->request('POST', $url, $params, true);

        if (is_array($request) && isset($request['error'])) {
            $request = (array)$request['error'];
            $response['success'] = false;
            $response['message'] = $request['messages'] ?? $request['errors'];
            return $response;
        } else if (is_object($request) && $request->success == true) {
            $response['success'] = true;
            $response['message'] = $request->message;
            return $response;
        }
        else if (is_null($request)) {
            $response['success'] = false;
            $response['message'] = "Ошибка на стороне сервера Уведомления($type)! ";
            return $response;
        } else {
            $response['success'] = false;
            $response['message'] = "Ошибка на стороне сервера Уведомления($type)! ";
            $response['message'] .= property_exists($request, 'messages') ? $request->messages : '';
            return $response;
        }

    }
}
