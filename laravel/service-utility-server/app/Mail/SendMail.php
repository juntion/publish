<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $blade;
    protected $data;

    /**
     * SendMail constructor.
     * @param $subject
     * @param $blade
     * @param array $data
     * @param array $cc
     * @param array $attachments
     */
    public function __construct($subject, $blade, $data = [], $cc = [], $attachments = [])
    {
        $this->blade = $blade;
        $this->subject = $subject;
        $this->data = $data;

        $this->cc($cc);

        foreach ($attachments as $attachment) {
            $this->attach($attachment);
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view($this->blade, $this->data);
    }
}
