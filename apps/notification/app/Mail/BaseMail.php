<?php

namespace App\Mail;

use App\Models\Notification;
use App\Models\NotificationTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * @property NotificationTemplate $template
 * @property Notification $data
 * @property String $location
 */
class BaseMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $template;
    public $location;

    /**
     * Create a new message instance.
     *
     * @param object|Notification $data
     * @param $location
     */
    public function __construct($data, $location = 'ru')
    {
        $this->data = $data;
        $this->location = $location;
        $this->template = $data->template;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->from($this->data->send_from)
                    ->view('mails.index')
                    ->subject($this->template->{'theme_'.$this->location});

        if(!$this->data->attachments)
        {
            foreach($this->data->attachments as $attach)
            {
                $mail->attachFromStorage(storage_path('files/mail'), $attach['filename'], ['mime' => $attach['mime']]);
            }
        }

        return $mail;
    }
}
