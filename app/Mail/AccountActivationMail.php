<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\GeneralSetting;

class AccountActivationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $user_item;
    public function __construct($user_item)
    {
        $this->user_item=$user_item;
    }

    /**
     * Get the message envelope.
     */
    public function build()
    {
               $GeneralSetting = GeneralSetting::first();
         return $this->subject('Login Details')->view('Mail.accountaactivationmail')
            ->with([
                'email' => $this->user_item->email,
                // 'password' => $this->user_item->password,
                'data'=>$GeneralSetting
            ]);
    }
    /**
     * Get the message content definition.
     */


    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */

}
