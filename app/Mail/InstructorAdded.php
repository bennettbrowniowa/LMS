<?php

namespace App\Mail;

use App\Models\CompanySetting;
use App\Models\GeneralSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InstructorAdded extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $course;
    public $password;
    public $email;

    public function __construct($course,$password,$email)
    {
              $this->course=$course;
             $this->password=$password;
             $this->email=$email;
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
        return $this->view('Mail.instructoraddedmail')
            ->with([
                'course' => $this->course,
                'password' => $this->password,
                'email' => $this->email,
                'generalDetails'=>$generalDetails,
                'companyDetails'=>$companyDetails,
            ]);
    }
}
