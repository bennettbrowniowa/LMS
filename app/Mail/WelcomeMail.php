<?php

namespace App\Mail;

use App\Models\CompanySetting;
use App\Models\GeneralSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    protected $email;
    protected $url;
    protected $name;
    public function __construct($email, $url,$name)
    {
        $this->email = $email;
        $this->url = $url;
        $this->name = $name;
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
        return $this->subject('Regarding Register A Student')->view('Mail.registerstudent')
            ->with([
              'email' => $this->email,
               'url' => $this->url,
               'name' => $this->name,
                'generalDetails'=>$generalDetails,
                'companyDetails'=>$companyDetails,
        ]);
    }
}
