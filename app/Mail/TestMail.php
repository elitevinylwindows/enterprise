<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $datas;
    public function __construct($datas)
    {
        $this->datas = $datas;
    }

    public function build()
    {
        $datass = $this->datas;
        $settings = $datass['settings'];
        $subject = $datass['subject'];
        $data = [
            'company_logo' => $settings['company_logo'],
            'message' => $datass['message'],
        ];

        return $this->from($settings['FROM_EMAIL'], $settings['FROM_NAME'])->markdown('email.test_email_notification')->subject($subject)->with('data', $data);
    }
}
