<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'github' => [
        'client_id' => '63012357c4ba2f0a59f4',
        'client_secret' => '2fff8155d24f6a638d29b57043b2f0f41d8b0322',
        'redirect' => 'https://newlms.inextwebs.com/public/auth/github/callback',
    ],
 

'google' => [
    'client_id' => env('GOOGLE_CLIENT_ID'),
    'client_secret' => env('GOOGLE_CLIENT_SECRET'),
    'redirect' => env('GOOGLE_REDIRECT_URL'),
],

 'google_student' => [
        'client_id' => env('STUDENT_GOOGLE_CLIENT_ID'),
        'client_secret' => env('STUDENT_GOOGLE_CLIENT_SECRET'),
        'redirect' => env('STUDENT_GOOGLE_REDIRECT_URL'),
    ],

];
