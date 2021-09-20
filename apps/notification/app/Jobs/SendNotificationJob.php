<?php

namespace App\Jobs;

use App\Mail\BaseMail;
use App\Models\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;

class SendNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $notification;

    /**
     * Create a new job instance.
     *
     * @param Notification $notification
     */
    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Redis::throttle('any_key')->allow(2)->every(1)->then(function () {
            Mail::to($this->notification->send_to)->send(new BaseMail($this->notification));

            if (count(Mail::failures()) > 0) {
                $this->notification->status = Notification::STATUS_ERROR;

                foreach (Mail::failures() as $failure) {
                    $this->notification->error .= $failure;
                }
            } else {
                $this->notification->status = Notification::STATUS_SENT;
            }

            $this->notification->save();

            Log::info('Emailed notification ' . json_encode($this->notification));

        }, function () {
            // Could not obtain lock; this job will be re-queued
            return $this->release(2);
        });
    }
}
