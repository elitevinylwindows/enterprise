<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class   Common extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
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
        $data = $this->data;
        $module = $data['module'];
        $settings = $data['settings'];
        $subject = $data['subject'];
        if (!empty($module) && $module == 'owner_create') {
            $data = [
                'company_logo' => $settings['company_logo'],
                'message' => $this->data,
                'company_name' => $settings['company_name'],
                'company_email' => $settings['company_email'],
            ];
        } else {

            $data = [
                'company_logo' => $settings['company_logo'],
                'company_name' => $settings['company_name'],
                'message' => $data['message'],
            ];
        }
        if (!empty($module) && $module == 'send_email') {
            return  $this->from($settings['FROM_EMAIL'], $settings['FROM_NAME'])
                ->markdown('email.document')
                ->subject($subject)
                ->with('content', $this->data['message']);
        } elseif (!empty($module) && $module == 'owner_create') {
            return  $this->from($settings['FROM_EMAIL'], $settings['FROM_NAME'])
                ->markdown('email.owner_create')
                ->subject($subject)
                ->with('content', $data);
        } else {
            return $this->from($settings['FROM_EMAIL'], $settings['FROM_NAME'])->markdown('email.email_notification')->subject($subject)->with('content', $data);
        }
    }
}
