<?php

namespace App\Mail;

use App\Models\CompanySetting;
use App\Models\GeneralSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegisterMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $password;

    public function __construct($password)
    {
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $GeneralSetting = GeneralSetting::first();
        return $this->view('Mail.Registerinstructormail')
            ->with([
                'password' => $this->password,
                'data'=>$GeneralSetting
            ]);
    }
}
