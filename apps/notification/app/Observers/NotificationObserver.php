<?php

namespace App\Observers;

use App\Jobs\SendNotificationJob;
use App\Mail\BaseMail;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotificationObserver
{
    public function creating(Notification $notification)
    {
        SendNotificationJob::dispatch($notification)->onQueue('email');

        Log::info('Dispatched order ' . $notification->id);
        return 'Dispatched order ' . $notification->id;
    }
}
