<?php

namespace App\Http\Controllers\Backend\GitHub;

use App\Helpers\UserHelper;
use App\Http\Controllers\Controller;
use App\Mail\RegisterMail;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

class GitHubController extends Controller
{
    public function gitRedirect()
    {
        return Socialite::driver('github')->redirect();
    }

    // public function gitCallback()
    // {


    //     try {
    //         $user = Socialite::driver('github')->user();


    //         $searchUser = User::where('github_id', $user->id)->first();

    //         if ($searchUser) {

    //             User::where('email', $user->email)->update([
    //                 'name' => $user->name,
    //                 'profile_photo' => $user->avatar,
    //             ]);


    //             Auth::login($searchUser);

    //             if ($searchUser->is_verified == '1' && $searchUser->is_profile_completed == '1') {
    //                 return redirect()->route('instructor_dashboard');
    //             } else {
    //              return redirect()->route('sps_form');
    //             }
    //         } else {
    //             $gitUser = User::create([
    //                 'name' => $user->name ?: $user->nickname,
    //                 'email' => $user->email,
    //                 'github_id' => $user->id,
    //                 'auth_type' => 'github',
    //                 'profile_photo' => $user->avatar,
    //                 'password' => Hash::make('Qusteam12345678'),
    //                 'is_profile_completed' => 0,
    //                 'is_blocked' => 1,
    //                 'github_user_name' => $user->nickname,
    //                  'type'=>'Instructor',
    //             ]);


    //             Auth::login($gitUser);


    //             $instructorRole = Role::where('name', 'Instructor')->first();

    //             if ($instructorRole) {
    //                 $gitUser->attachRole($instructorRole);
    //             }

    //             if ($gitUser->is_verified == '1' && $gitUser->is_profile_completed == '1') {
    //                 return redirect()->route('instructor_dashboard');
    //             } else {
    //                 UserHelper::sent_email($gitUser->email, 'Registration', 'Registration Via GitHub Success!! Please Complete the next process for Account Verification!!');
    //                 return redirect()->route('sps_form');
    //             }



    //         }
    //     } catch (Exception $e) {
    //         dd($e->getMessage());
    //     }
    // }

//    public function gitCallback(Request $request)
//{
//    try {
//        $user = Socialite::driver('github')->user();
//
//        $searchUser = User::where('github_id', $user->id)->first();
//
//        if ($searchUser) {
//            User::where('email', $user->email)->update([
//                'name' => $user->name ?: $user->nickname ?: 'DefaultName',
//                'profile_photo' => $user->avatar,
//            ]);
//
//            Auth::login($searchUser);
//            $request->session()->regenerate();
//
//            if ($searchUser->is_verified == '1' && $searchUser->is_profile_completed == '1') {
//                return redirect()->route('instructor_dashboard');
//            } else {
//                return redirect()->route('sps_form');
//            }
//        } else {
//            $gitUser = User::create([
//                'name' => $user->name ?: $user->nickname ?: 'DefaultName',
//                'email' => $user->email,
//                'github_id' => $user->id,
//                'auth_type' => 'github',
//                'profile_photo' => $user->avatar,
//                'password' => Hash::make('Qusteam12345678'),
//                'is_profile_completed' => 0,
//                'is_blocked' => 1,
//                'api_token'=> sha1(time()),
//                'github_user_name' => $user->nickname,
//                'type' => 'Instructor',
//            ]);
//
//            Auth::login($gitUser);
//
//            $instructorRole = Role::where('name', 'Instructor')->first();
//
//            if ($instructorRole) {
//                $gitUser->attachRole($instructorRole);
//            }
//
//            if ($gitUser->is_verified == '1' && $gitUser->is_profile_completed == '1') {
//                return redirect()->route('instructor_dashboard');
//            } else {
//                UserHelper::sent_email($gitUser->email, 'Registration', 'Registration Via GitHub Success!! Please Complete the next process for Account Verification!!');
//                return redirect()->route('sps_form');
//            }
//        }
//    } catch (Exception $e) {
//        dd($e->getMessage());
//    }
//}

    public function gitCallback(Request $request)
    {
        try {
            $user = Socialite::driver('github')->stateless()->user();
            $searchUser = User::where('github_id', $user->id)->first();

            if ($searchUser) {
                User::where('email', $user->email)->update([
                    'name' => $user->name ?: $user->nickname ?: 'DefaultName',
                    'profile_photo' => $user->avatar,
                ]);

                Auth::login($searchUser);
                $request->session()->regenerate();

                if ($searchUser->is_verified == '1' && $searchUser->is_profile_completed == '1') {
                    return redirect()->route('instructor_dashboard');
                } else {
                    return redirect()->route('sps_form');
                }
            } else {

                $password = 'Qusteam12345678';
                $gitUser = User::create([
                    'name' => $user->name ?: $user->nickname ?: 'DefaultName',
                    'email' => $user->email,
                    'github_id' => $user->id,
                    'auth_type' => 'github',
                    'profile_photo' => $user->avatar,
                    'password' => Hash::make($password),
                    'is_profile_completed' => 0,
                    'is_blocked' => 1,
                    'api_token'=> sha1(time()),
                    'github_user_name' => $user->nickname,
                    'type' => 'Instructor',
                ]);

                Auth::login($gitUser);

                $instructorRole = Role::where('name', 'Instructor')->first();

                if ($instructorRole) {
                    $gitUser->attachRole($instructorRole);
                }
                Mail::to($gitUser->email)->send(new RegisterMail($password));

                if ($gitUser->is_verified == '1' && $gitUser->is_profile_completed == '1') {
                    return redirect()->route('instructor_dashboard');
                } else {
                    UserHelper::sent_email($gitUser->email, 'Registration', 'Registration Via GitHub Success!! Please Complete the next process for Account Verification!!');
                    return redirect()->route('sps_form');
                }
            }
        } catch (Exception $e) {
            return redirect()->route('login_instructor')->with('error', $e->getMessage());
        }
    }
}
