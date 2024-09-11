<?php

namespace App\Http\Controllers\Backend\Profile;

use App\Models\InstructorInfo;
use App\Models\SocialLinks;
use App\Models\Specialization;
use App\Models\User;
use App\Models\UserSpecialization;
use Auth;
use Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class SocialController extends Controller
{
    public function index(){
        $userId = Auth::user()->id;
        $Specialization=Specialization::get();
        $data = SocialLinks::select('*')->where('user_id',$userId)->first();
        $user= User::with(['user_information','spasilization'])->where('id',$userId)->first();
        return view('Backend.Profile.socialLinks',['SocialLinks'=>$data,'user'=>$user,'Specialization'=>$Specialization]);
    }

    public function save(Request $request)
    {
        $userId = Auth::user()->id;
//        $facebook = $request->get('facebook');
//        $google_plus = $request->get('google_plus');
//        $twitter = $request->get('twitter');
//        $linkedin = $request->get('linkedin');
//        $youtube = $request->get('youtube');
//        $instagram = $request->get('instagram');
//
//        $data = SocialLinks::select('*')->where('user_id',$userId)->first();
//        if(!isset($data->id)){
//            $user = new SocialLinks();
//            $user->user_id = $userId;
//        }else{
//            $user = SocialLinks::findOrFail($data->id);
//        }
//        $user->facebook = $facebook;
//        $user->google_plus = $google_plus;
//        $user->twitter = $twitter;
//        $user->linkedin = $linkedin;
//        $user->youtube = $youtube;
//        $user->instagram = $instagram;
//        $user->save();
//
//        Session::flash('success', "Social Links has been updated");
//        return redirect()->back();



        $request->validate([
            'webaddress' => ['required', 'url', 'website_alive'],
            'gihub_id' => 'required',
            'Slack_email' => 'required|email',
            'linkdin_link' => 'required',
            'twiter_link' => ['required', 'url', 'twiter_link'],
            'Specialization' => 'required|array',
            'Specialization.*' => 'exists:specializations,id',
            'exprience_details' => 'required',
        ]);

        $user_info = $request->all();

        $info_data = InstructorInfo::firstOrNew(['user_id' => Auth::user()->id]);
        $info_data->website_url = $user_info['webaddress'];
        $info_data->google_auth_share_drive_email = $user_info['google_auth_id'];
        $info_data->github_user_name = $user_info['gihub_id'];
        $info_data->slack_mail_id = $user_info['Slack_email'];
        $info_data->linkdin_link = $user_info['linkdin_link'];
        $info_data->twiter_link = $user_info['twiter_link'];
        if (isset($user_info['oth_item']) && $user_info['oth_item'] == 'Yes') {
            $info_data->is_other_checked = 'Yes';
            $info_data->other_value_text = $user_info['other_value'];
        } else {
            $info_data->is_other_checked = 'No';
            $info_data->other_value_text = null;
        }
        $info_data->exprience_short_desc = $user_info['exprience_details'];
        $info_data->save();

        $specializationsIds = $user_info['Specialization'];
        $user_id = Auth::user()->id;
        $has_another = 0;
        $another_name = 1;
        $data = collect($specializationsIds)->map(function ($specializationId) use ($request, $user_id, $has_another, $another_name) {
            return [
                'user_id' => $user_id,
                'specialization_id' => $specializationId,
                'has_another' => $has_another,
                'another_name' => $another_name,
            ];
        })->toArray();

        UserSpecialization::insert($data);
        Session::flash('success', "Profile has been updated");
        return redirect()->back();
    }
}
