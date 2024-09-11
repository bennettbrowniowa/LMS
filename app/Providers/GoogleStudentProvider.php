<?php

namespace App\Providers;

use Laravel\Socialite\Two\GoogleProvider;
use Laravel\Socialite\Two\User;
use Illuminate\Http\Request;

class GoogleStudentProvider extends GoogleProvider
{
    /**
     * The scopes that should be requested.
     *
     * @var array
     */
    protected $scopes = ['openid', 'profile', 'email'];

    /**
     * Create a new provider instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $clientId
     * @param  string  $clientSecret
     * @param  string  $redirect
     * @return void
     */
    public function __construct(Request $request, $clientId, $clientSecret, $redirect)
    {
        parent::__construct($request, $clientId, $clientSecret, $redirect);
    }

    /**
     * {@inheritdoc}
     */
    protected function getAuthUrl($state)
    {
        $authUrl = parent::getAuthUrl($state);

        return $authUrl;
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenUrl()
    {
        return 'https://oauth2.googleapis.com/token';
    }

    /**
     * {@inheritdoc}
     */
    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get('https://www.googleapis.com/oauth2/v2/userinfo', [
            'headers' => [
                'Authorization' => 'Bearer '.$token,
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * {@inheritdoc}
     */
    protected function mapUserToObject(array $user)
    {
        return (new User())->setRaw($user)->map([
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'avatar' => $user['picture'],
        ]);
    }
}
