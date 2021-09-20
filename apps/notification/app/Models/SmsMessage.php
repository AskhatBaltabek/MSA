<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SmsMessage
 * @package App\Models
 *
 * @property int $id
 * @property string $phone
 * @property string $message
 * @property string $sms_id
 * @property int $status_id
 * @property string $sender
 * @property string $status_code
 * @property string $error
 * @property Carbon|null $sent_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class SmsMessage extends Model
{
    use HasFactory;

    protected $guarded = [];

    const STATUS_NOT_SENT = 0;
    const STATUS_SENT = 1;
    const STATUS_ERROR_ON_SENDING = 2;

    /**
     * @param $phone
     * @param int $without_seven
     * @return false|string|string[]|null
     */
    public static function clearPhone($phone, $without_seven = 0)
    {
        $phone  = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace('-', '', $phone));
        $length = strlen($phone);
        if ($length > 10) {
            $phone = substr($phone, $length - 10, 10);
        }
        if (!$without_seven) {
            $phone = '7' . $phone;
        }
        return $phone;
    }

    /**
     * @param $data
     */
    public static function sendSms(&$data)
    {
        $phone_number = self::clearPhone($data->phone);
        $message      = $data->message;

        $url         = env('SMS_TRAFFIC_URL');
        $access_data = [
            'login'    => env('SMS_TRAFFIC_LOGIN'),
            'password' => env('SMS_TRAFFIC_PASSWORD')
        ];

        $send_data = [
            'want_sms_ids' => 1,
            'phones'       => $phone_number,
            'message'      => $message,
            'rus'          => 5,
            'originator'   => 'Amanat'
        ];

        $send_data = array_merge($send_data, $access_data);

        $sms_service_response = self::callApi($send_data, $url);

        try {
            $response_basic = new \SimpleXMLElement($sms_service_response);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }

        $response = self::parseSendSmsCode($response_basic);

        try {
            $data['phone']     = $phone_number;
            $data['status_id'] = $response['result'];
            if ($response['result'] == self::STATUS_SENT) {
                $data['sms_id']    = $response['sms_id'];
                $data['sent_date'] = Carbon::now();
            } else {
                $data['status_code'] = $response['status_code'];
                $data['error']       = $response['error'];
            }
            $data->save();
            return $data;

        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }

    }

    /**
     * @param $send_data
     * @param $url
     * @return bool|string
     */
    public static function callApi($send_data, $url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Нужно явно указать, что будет POST запрос
        curl_setopt($ch, CURLOPT_POST, true);
        // Здесь передаются значения переменных
        curl_setopt($ch, CURLOPT_POSTFIELDS, $send_data);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    /**
     * @param $response
     * @return array
     */
    public static function parseSendSmsCode($response)
    {
        $return = [];
        if (isset($response->result) && $response->result == 'OK') {
            $return['result'] = self::STATUS_SENT;
            if (isset($response->message_infos->message_info->sms_id)) {
                $return['sms_id'] = (string)$response->message_infos->message_info->sms_id;
                $return['phone']  = (string)$response->message_infos->message_info->phone;
            }
        } else {
            if (isset($response->result) && $response->result == 'ERROR') {
                $return['result']      = self::STATUS_ERROR_ON_SENDING;
                $return['status_code'] = (string)$response->code;
                $return['error']       = (string)$response->description;
            } else {
                $return['error'] = 'Response error undefined!';
            }
        }
        return $return;
    }

}
