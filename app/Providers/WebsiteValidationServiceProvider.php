<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class WebsiteValidationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Validator::extend('website_alive', function ($attribute, $value, $parameters, $validator) {
            // Add 'www' if it's missing from the URL
            $url = preg_match('/^https?:\/\/(?!www\.)/', $value) ? preg_replace('/^https?:\/\/(?!www\.)/', 'https://www.', $value) : $value;

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_NOBODY, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_exec($ch);
            $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            return $statusCode == 200;
        });

        Validator::replacer('website_alive', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, 'The :attribute website is not reachable.');
        });

        Validator::extend('twiter_link', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^(https?:\/\/)?(www\.)?twitter\.com\/[a-zA-Z0-9_]+\/?$/', $value);
        });

        Validator::replacer('twiter_link', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, 'The :attribute field must be a valid Twitter profile link.');
        });
        Validator::extend('valid_url_array', function ($attribute, $value, $parameters, $validator) {
            if (empty($value)) {
                return true;
            }

            try {
                $url = preg_match('/^https?:\/\//', $value) ? $value : 'https://' . $value;
                $response = Http::get($url);
                return $response->successful();
            } catch (\Exception $e) {
                return false;
            }
        });

        Validator::replacer('valid_url_array', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, 'The :attribute must be a valid URL.');
        });
    }

}
