<?php

namespace App\Jobs;

use App\Mail\BaseMail;
use App\Models\Notification;
use App\Models\SmsMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;

class SendSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $sms;

    /**
     * Create a new job instance.
     *
     * @param SmsMessage $sms
     */
    public function __construct(SmsMessage $sms)
    {
        $this->sms = $sms;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Redis::throttle('any_key')->allow(2)->every(1)->then(function () {
            $sending = SmsMessage::sendSms($this->sms);

            if (gettype($sending) == 'object') {
                $data[$this->sms->id] = [
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
                $data[$this->sms->id] = [
                    'error' => $sending['error'],
                ];
            }

            Log::info('Emailed notification ' . json_encode($data));

        }, function () {
            // Could not obtain lock; this job will be re-queued
            return $this->release(2);
        });
    }
}
