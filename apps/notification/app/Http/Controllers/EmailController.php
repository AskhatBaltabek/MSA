<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailCheckRequest;
use App\Http\Requests\EmailTemplateCheckRequest;
use App\Jobs\SendEmailJob;
use App\Models\EmailMessage;
use App\Models\NotificationTemplate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    /**
     * Сохраняем данные по email для отправки
     * @param EmailCheckRequest $request
     * @return JsonResponse
     */
    public function save(EmailCheckRequest $request): JsonResponse
    {
        $response['success'] = 0;
        $email               = EmailMessage::create($request->all());

        if ($email) {
            SendEmailJob::dispatch($email)->onQueue('email');
            $response['success'] = 1;
            $response['message'] = 'Email успешно отправлен!';
        }

        return response()->json($response);
    }

    /**
     * Сохраняем данные по email для отправки
     * @param EmailTemplateCheckRequest $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function sendTemplate(EmailTemplateCheckRequest $request): JsonResponse
    {
        $response['success'] = 0;
        $message_data        = NotificationTemplate::generateMessage(request()->input('code'), request()->input('values'));
        if ($message_data['success'] == 0) {
            return response()->json($message_data);
        }

        $email = EmailMessage::create([
            'send_from'   => $request->input('send_from'),
            'send_to'     => $request->input('send_to'),
            'title'       => $message_data['title'],
            'message'     => $message_data['message'],
            'template_id' => $message_data['template_id'],
            'attachments' => $request->has('attachments') ? json_encode($request->input('attachments')) : null
        ]);

        if ($email) {
            SendEmailJob::dispatch($email)->onQueue('email');
            $response['success'] = 1;
            $response['message'] = 'Email успешно отправлен!';
        }

        return response()->json($response);
    }

    public function list(Request $request)
    {
        $query = EmailMessage::query();

        if ($s = $request->input('_search')) {
            $query->whereRaw("title LIKE '%" . $s . "%'")
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
