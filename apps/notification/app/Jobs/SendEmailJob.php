<?php

namespace App\Jobs;

use App\Mail\BaseEmail;
use App\Models\EmailMessage;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $email;

    /**
     * Create a new job instance.
     *
     * @param EmailMessage $email
     */
    public function __construct(EmailMessage $email)
    {
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Redis::throttle('any_key')->allow(2)->every(1)->then(function () {
            Mail::to($this->email->send_to)->send(new BaseEmail($this->email));

            if (count(Mail::failures()) > 0) {
                $this->email->status_id = EmailMessage::STATUS_ERROR_ON_SENDING;

                foreach (Mail::failures() as $failure) {
                    $this->email->error .= $failure;
                }
            } else {
                $this->email->status_id = EmailMessage::STATUS_SENT;
                $this->email->sent_at   = Carbon::now();
            }

            $this->email->save();

            Log::info('Emailed email ' . json_encode($this->email));

        }, function () {
            // Could not obtain lock; this job will be re-queued
            return $this->release(2);
        });
    }
}
