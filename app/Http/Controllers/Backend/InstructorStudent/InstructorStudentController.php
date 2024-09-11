<?php

namespace App\Http\Controllers\Backend\InstructorStudent;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeMail;
use App\Models\GeneralSetting;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Zizaco\Entrust\EntrustFacade as Entrust;

class InstructorStudentController extends Controller
{

    public function index(){;
        return view('Backend.Student.All');
    }

    public function datatable()
    {

        $query = User::where('instructor_id', Auth::id())->select(['id', 'name', 'email']);

        return DataTables::eloquent($query)
            ->addColumn('roles', function ($data) {
                $roles = '';
                foreach ($data->roles as $role) {
                    $roles .= '<span class="label label-primary nk_label_1">' . $role->name . '</span> &nbsp';
                }
                return $roles;
            })
            ->addColumn('action', function ($data) {
                $url_update = route('editinstructorstudent', ['id' => $data->id]);
                $url_delete = route('deleteinstructorstudent', ['id' => $data->id]);
                $edit = '<a class="label label-primary" data-title="Edit Student" data-act="ajax-modal" data-append-id="AjaxModelContent" data-action-url="' . $url_update . '" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit </a>';
                $edit .= '&nbsp<a href="' . $url_delete . '" class="label label-danger" data-confirm="Are you sure to delete Student: <span class=&#034;label label-primary&#034;>' . $data->name . '</span>"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete </a>';

                return $edit;
            })
            ->rawColumns(['action', 'roles'])
            ->toJson();
    }

    public function add(){

        return view('Backend.Student.Add');
    }

    public function save(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users,email',

        ]);

        $name = $request->get('name');
        $email = $request->get('email');



        $profile_photo = 'avatar.png';


        $User = new User();
        $User->name = $name;
        $User->email = $email;
        $User->password = '';
        $User->profile_photo = $profile_photo;
        $User->api_token = $User->newToken();
        $User->instructor_id = Auth::user()['id'];
        $User->type ='Student';
        $User->save();
        $User->attachRole(4);
        $encryptedId = encrypt($User->id);
        $url = route('student_reset_password', ['id' => $encryptedId]);
        Mail::to($email)->send(new WelcomeMail($email,$url,$name));
        Session::flash('success', "Student has been created successfully");
        return redirect()->back();
    }

    public function student_reset_password(Request $request,$id){
        $uid=decrypt($id);

        $user=User::find($uid);
        $GeneralSetting = GeneralSetting::first();
        return view('Backend.Student.changepassword', ['ID' => $uid,'data'=>$GeneralSetting]);



    }
    public function student_save_reset_password(Request $request){
        try {
            $userId = $request->id;

            $userDetails = User::find($userId);
            $msg = [
                'new_password.required' => 'Please Enter Your Password',
                'retype_new_password.required' => 'Please Enter Your Confirm Password',
                'retype_new_password.same' => 'Password And Confirm Password Must Match',

            ];
            $this->validate($request, [
                'new_password' => 'required',
                'retype_new_password' => 'required|same:new_password',
            ], $msg);

            $password = $request->get('retype_new_password');
            $userDetails->password = Hash::make($password);
            $userDetails->save();
            Session::flash('success', "Your Registeration is Completed Now You Can Login");
            return redirect(url('/auth/student'));

        } catch (\DecryptException $e) {
            Session::flash('error', "invalid Url Link");
            return redirect()->back();
        }

    }

    public function edit($id)
    {
        try {
            $records = User::where('instructor_id', Auth::id())->findOrFail($id);
            return view('Backend.Student.Edit',[ 'ID'=>$id,'records'=>$records]);
        } catch (\Exception $e) {
            return view('Backend.InvalidModalOperation');
        }
    }

    public function update(Request $request,$id){

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $id . ',id'
        ]);
        $student = User::where('instructor_id', Auth::id())->findOrFail($id);
        $student->name = $request->get('name');
        $student->email = $request->get('email');
        $student->save();

        Session::flash('success', "Student has been updated");
        return redirect()->back();



    }

    public function delete($id=null){
        $student = User::where('instructor_id', Auth::id())->findOrFail($id);
        $student->roles()->detach();
        $student->delete();
        Session::flash('success', "Student has been deleted");
        return redirect()->back();
    }

}
