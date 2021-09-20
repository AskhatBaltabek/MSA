<?php

namespace App\Mail;

use App\Models\EmailMessage;
use App\Services\RestService;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

/**
 * @property EmailMessage $data
 */
class BaseEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     * @param object|EmailMessage $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->from($this->data->send_from)
            ->view('emails.index')
            ->subject($this->data->title);

        if ($this->data->attachments) {
            foreach (json_decode($this->data->attachments) as $key => $value) {
                $content = (new RestService())->getFileContentFromRepo($value);
                $bin = base64_decode($content, true);
                if (strpos($bin, '%PDF') !== 0) {
                    Log::error('Email Missing the PDF file signature!');
                }
                $mail->attachData($bin, $value.'.pdf', ['mime' => 'pdf']);
            }
        }

        return $mail;
    }
}
