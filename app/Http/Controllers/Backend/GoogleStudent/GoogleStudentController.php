<?php

namespace App\Http\Controllers\Backend\GoogleStudent;

use App\Http\Controllers\Controller;


use App\Mail\RegisterMail;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use Exception;


class GoogleStudentController extends Controller
{
    public function redirectToGoogleStudent()
    {
        return Socialite::driver('google_student')->stateless()->redirect();

    }

    public function handleGoogleStudentCallback(Request $request)
    {
         try {
                  $googleUser = Socialite::driver('google_student')->stateless()->user();
            $user = User::where('email', $googleUser->email)->first();

            if (!$user) {
                $password = 'Qusteam12345678';

                $user = User::create([
                    'profile_photo' => $googleUser->avatar,
                    'google_id' => $googleUser->id,
                    'auth_type' => 'google',
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'password' => Hash::make($password),
                    'api_token' => sha1(time()),
                    'type' => 'Student',
                ]);
                $studentRole = Role::where('name', 'Student')->first();
                if ($studentRole) {
                    $user->attachRole($studentRole);
                }

                Mail::to($user->email)->send(new RegisterMail($password));
            } else {
                $user->update([
                    'name' => $googleUser->name,
                    'profile_photo' => $googleUser->avatar,
                ]);
            }

            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->route('student_dashboard');

         } catch (Exception $e) {
             return redirect()->route('login_student')->with('error', $e->getMessage());
         }
    }
}
