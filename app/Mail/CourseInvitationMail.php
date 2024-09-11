<?php

namespace App\Mail;

use App\Models\CompanySetting;
use App\Models\GeneralSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CourseInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user;
    public $password;
    public $invitation;
    public function __construct($user, $password, $invitation)
    {
        $this->user = $user;
        $this->password = $password;
        $this->invitation = $invitation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $generalDetails = GeneralSetting::select('site_logo')->first();
        $companyDetails = CompanySetting::first();
        return $this->view('Mail.invitationmail')
            ->subject('You are invited to a course')
            ->with([
                'name' => $this->user->name,
                'email' => $this->user->email,
                'password' => $this->password,
                'invitation_token' => $this->invitation->invitation_token,
                'generalDetails'=>$generalDetails,
                'companyDetails'=>$companyDetails,

            ]);
    }
}
