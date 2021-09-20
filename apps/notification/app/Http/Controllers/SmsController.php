<?php

namespace App\Http\Controllers;

use App\Http\Requests\SmsCheckRequest;
use App\Http\Requests\SmsTemplateCheckRequest;
use App\Jobs\SendSmsJob;
use App\Models\NotificationTemplate;
use App\Models\SmsMessage;
use Illuminate\Http\JsonResponse;
use \Illuminate\Http\Request;

/**
 * Class SmsController
 * @package App\Http\Controllers
 */
class SmsController extends Controller
{
    /**
     * Сохраняем данные по смс для отправки
     * @param SmsCheckRequest $request
     * @return JsonResponse
     */
    public function save(SmsCheckRequest $request): JsonResponse
    {
        $response['success'] = 0;
        $sms = SmsMessage::create($request->all());

        if ($sms) {
            SendSmsJob::dispatch($sms)->onQueue('sms');
            $response['success'] = 1;
            $response['message'] = 'Смс успешно отправлен!';
        }

        return response()->json($response);
    }

    /**
     * Сохраняем данные по смс для отправки
     * @param SmsTemplateCheckRequest $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function sendTemplate(SmsTemplateCheckRequest $request): JsonResponse
    {
        $response['success'] = false;
        $message_data = NotificationTemplate::generateMessage(request()->input('code'), request()->input('values'));
        if ($message_data['success'] == false) {
            return response()->json($message_data);
        }

        $sms = SmsMessage::create([
            'phone'       => $request->input('phone'),
            'message'     => $message_data['message'],
            'template_id' => $message_data['template_id'],
        ]);

        if ($sms) {
            SendSmsJob::dispatch($sms)->onQueue('sms');
            $response['success'] = true;
            $response['message'] = 'Смс успешно отправлен!';
        }

        return response()->json($response);
    }


    /**
     * Делаем отправку не отправленных смс
     * @return JsonResponse
     */
    public function sending(): JsonResponse
    {
        $messages = SmsMessage::where('status_id', SmsMessage::STATUS_NOT_SENT)->get();
        $data = [];
        if (count($messages)) {
            foreach ($messages as $message) {
                /** @var SmsMessage $sending */
                $sending = SmsMessage::sendSms($message);

                if (gettype($sending) == 'object') {
                    $data[$message->id] = [
                        'phone'       => $sending->phone,
                        'message'     => $sending->status_id,
                        'sender'      => $sending->sender,
                        'sms_id'      => $sending->sms_id,
                        'status_id'   => $sending->status_id,
                        'status_code' => $sending->status_code,
                        'error'       => $sending->error,
                        'sent_date'   => $sending->sent_date,
                        'created_at'  => $sending->created_at,
                    ];
                } else {
                    $data[$message->id] = [
                        'error' => $sending['error'],
                    ];
                }
            }
        } else {
            $data['message'] = 'SMS to send not found';
        }

        return response()->json(['data' => $data]);
    }

    public function list(Request $request)
    {
        $query = SmsMessage::query();

        if ($s = $request->input('_search')) {
            $query->whereRaw("phone LIKE '%" . $s . "%'")
                ->orWhereRaw("message LIKE '%" . $s . "%'");
        }

        if ($sort = $request->input('_sort')) {
            $query->orderBy($sort, $request->input('_order', 'asc'));
        }

        $perPage = $request->input('_limit', 10);
        $page = $request->input('_page', 1);
        $total = $query->count();

        $result = $query->offset(($page - 1) * $perPage)->limit($perPage)->get();

        return [
            'data' => $result,
            'total' => $total,
            'page' => $page,
            'last_page' => ceil($total / $perPage)
        ];
    }
}
