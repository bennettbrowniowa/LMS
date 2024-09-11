<?php

namespace App\Http\Controllers\Backend\Instructor;

use App\Helpers\UserHelper;
use App\Http\Controllers\Controller;
use App\Mail\AccountActivationMail;
use App\Mail\CourseInvitationMail;
use App\Models\Course;
use App\Models\CourseLearningSequence;
use App\Models\CourseStudent;
use App\Models\GeneralSetting;
use App\Models\InstructorInfo;
use App\Models\Invitation;
use App\Models\LearningSequence;
use App\Models\LearningSequenceGoal;
use App\Models\Specialization;
use App\Models\UserSpecialization;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class InstructorController extends Controller
{
    public function instructor_dashboard()
    {
        return view('Backend.Instructor.index');

    }
    public function coursedatatable(Request $request)
    {

        $instructorId = Auth::id();
        $courses = Course::where(function ($query) use ($instructorId) {
            $query->whereHas('instructors', function ($query) use ($instructorId) {
                $query->where('course_students.instructor_id', $instructorId);
            })
                ->orWhere('user_id', $instructorId);
        })
            ->with(['learningSequences.goals', 'learningSequences.pedagogyTags', 'learningSequences.resourceTypes', 'learningSequences.files'])
            ->get();

        return DataTables::of($courses)

            ->addColumn('title', function ($course) {
                return '<strong>' . htmlspecialchars($course->title) . '</strong>';
            })
            ->addColumn('title_description', function ($course) {
                $formatted = [];
                foreach ($course->learningSequences as $sequence) {
                    $title = $sequence->pivot->title;
                    $description = $sequence->pivot->description;
                    $content_type = $sequence->pivot->content_type;

                    if (!in_array($content_type, ['html', 'js', 'qti'])) {
                        $formatted[] = "<div class='formatdata'><strong>" . htmlspecialchars($title) . "</strong>: " . strip_tags($description) . "</div>";
                    } else {
                        $formatted[] = "<div class='formatdata'><strong>" . htmlspecialchars($title) . "</strong></div>";
                    }
                }
                return "<div class='scrollable'>" . implode('<br>', $formatted) . "</div>";
            })
            ->addColumn('goals', function ($course) {
                return $course->learningSequences->map(function ($ls) {
                    $goals = $ls->goals->pluck('title');
                    return $goals->isEmpty() ? '' : $goals->map(function ($goal) {
                        return '<span class="badge badge-primary">' . $goal . '</span>';
                    })->implode(' ');
                })->filter()->implode('<br>');
            })
            ->addColumn('pedagogy_tags', function ($course) {
                return $course->learningSequences->map(function ($ls) {
                    $tags = $ls->pedagogyTags->pluck('title');
                    return $tags->isEmpty() ? ' ' : $tags->map(function ($tag) {
                        return '<span class="badge badge-info">' . $tag . '</span>';
                    })->implode(' ');
                })->filter()->implode('<br>');
            })
            ->addColumn('resource_types', function ($course) {
                return $course->learningSequences->map(function ($ls) {
                    $resources = $ls->resourceTypes->pluck('title');
                    return $resources->isEmpty() ? ' ' : $resources->map(function ($resource) {
                        return '<span class="badge badge-success">' . $resource . '</span>';
                    })->implode(' ');
                })->filter()->implode('<br>');
            })
            ->addColumn('files', function ($course) {
                return $course->learningSequences->map(function ($ls) {
                    $files = $ls->files->pluck('filename')->map(function ($filename) {
                        return basename($filename);
                    });
                    return $files->isEmpty() ? ' ' : $files->map(function ($file) {
                        return '<span class="badge badge-warning">' . $file . '</span>';
                    })->implode(' ');
                })->filter()->implode('<br>');
            })
            ->addColumn('file_urls', function ($course) {
                return $course->learningSequences->map(function ($ls) {
                    $urls = $ls->files->pluck('url');
                    return $urls->isEmpty() ? ' ' : $urls->map(function ($url) {
                        return '<span class="badge badge-light">' . $url . '</span><span class="space">&nbsp;</span>';
                    })->implode('<br>');
                })->filter()->implode('<br>');
            })
            ->addColumn('action', function ($course) {
                if ($course->learningSequences->isEmpty()) {
                    return '';
                }
                $url_enroll = route('courseenroll', ['id' => $course->id]);
                $url_invite = route('inviteStudentsForm', ['id' => $course->id]);
                $url_remove = route('removeInstructor', ['courseId' => $course->id]);
                $url_delete = route('deleteCourse', ['courseId' => $course->id]);
                $edit = '<a class="label label-primary view-button-2" data-title="Enroll Student" data-act="ajax-modal" data-append-id="AjaxModelContent" data-action-url="' . $url_enroll . '" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp Enroll Students </a>';
                $edit .= '&nbsp <button class="label label-primary view-button-1" data-toggle="modal" data-target="#enrolledStudentsModal" data-course-id="' . $course->id . '"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp View Enrolled Students</button>';
                $edit .= '&nbsp <a class="label label-primary view-button-3" data-title="Invite Students" data-act="ajax-modal" data-append-id="AjaxModelContent" data-action-url="' . $url_invite . '" ><i class="fa fa-envelope" aria-hidden="true"></i>&nbsp Invite Students </a>';
                if ($course->users->contains(Auth::id())) {
                    $edit .= '&nbsp <a class="label label-danger view-button-4" href="#" data-toggle="modal" data-target="#removeInstructorModal" data-url="' . $url_remove . '"><i class="fa fa-trash" aria-hidden="true"></i>&nbsp Remove Me From Course </a>';
                }
                $edit .= '&nbsp <a class="label label-danger view-button-5" href="#" data-toggle="modal" data-target="#deleteCourseModal" data-url="' . $url_delete . '"><i class="fa fa-trash" aria-hidden="true"></i>&nbsp Delete Course </a>';

                return $edit;
            })
            ->rawColumns(['title_description', 'goals', 'pedagogy_tags', 'resource_types', 'files', 'file_urls','title', 'action'])
            ->toJson();
    }

    public function inviteStudentsForm($courseId)
    {
        $course = Course::findOrFail($courseId);
        return view('Backend.Instructor.invitestudent', compact('course'));
    }
    public function store_invitation(Request $request)
    {

        $userExists = User::where('email', $request->email)->exists();
        if ($userExists) {
            Session::flash('error', 'This email is already associated with a Student. Please use another email.');
            return redirect()->back();
        }

        $existingInvitation = Invitation::where('course_id', $request->course_id)
            ->where('student_email', $request->email)
            ->where('status', 'pending')
            ->exists();

        if ($existingInvitation) {
            Session::flash('error', 'An invitation has already been sent to this email for this course.');
            return redirect()->back();
        }

        $password = Str::random(8);
        $user = User::create([
            'name' => $request->name ?? 'Student',
            'email' => $request->email,
            'password' => Hash::make($password),
            'type' => 'Student',
            'profile_photo' => 'avatar.png',
            'api_token' => Str::random(60),
            'instructor_id' => Auth::id(),
        ]);
        $user->attachRole(4);


        $invitation = new Invitation();
        $invitation->course_id = $request->course_id;
        $invitation->user_id = Auth::id();
        $invitation->student_email = $request->email;
        $invitation->invitation_token = Str::random(64);
        $invitation->status = 'pending';
        $invitation->save();

        Mail::to($request->email)->send(new CourseInvitationMail($user, $password, $invitation));
        Session::flash('success', 'Invite mail sent successfully');
        return redirect()->back();
    }



    public function acceptInvitation($token)
    {

        $invitation = Invitation::where('invitation_token', $token)->firstOrFail();


        if ($invitation->status !== 'pending') {
            return redirect()->route('login_student')->with('error', 'This invitation has already been handled.');
        }
        if (Auth::check()) {
            $user = Auth::user();
            $course = Course::findOrFail($invitation->course_id);


            $instructorId = $invitation->user_id;

            DB::table('course_students')->insert([
                'course_id' => $course->id,
                'student_id' => $user->id,
                'instructor_id' => $instructorId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $invitation->status = 'accepted';
            $invitation->save();
            return redirect()->route('student_dashboard')->with('success', 'You have successfully joined the course.');
        } else {
            return redirect()->route('login_student', ['invitation_token' => $token])
                ->with('info', 'Please login to accept this invitation.');
        }
    }

    public function courseenroll($id){

        $course = Course::findOrFail($id);

        $students = User::whereHas('roles', function($query) {
            $query->where('name', 'Student');
        })->where('instructor_id', Auth::user()['id'])->get();
        
        return view('Backend.Instructor.courseenroll', compact('course', 'students'));


    }


    public function courseassign(Request $request)
    {
        $studentIds = $request->input('student');
        $courseId = $request->input('course_id');
        $instructorId = Auth::id();

        foreach ($studentIds as $studentId) {
            $studentExists = User::where('id', $studentId)->exists();

            if (!$studentExists) {
                return response()->json(['success' => false, 'message' => "Student with ID $studentId does not exist."]);
            }

            CourseStudent::updateOrCreate(
                ['course_id' => $courseId, 'student_id' => $studentId],
                ['instructor_id' => $instructorId]
            );


            $learningSequences = LearningSequence::whereHas('courses', function ($query) use ($courseId, $instructorId) {
                $query->where('course_id', $courseId)
                    ->where('course_learning_sequences.user_id', $instructorId);
            })->get();



            foreach ($learningSequences as $learningSequence) {
                $goals = $learningSequence->goals;
                foreach ($goals as $goal) {
                    LearningSequenceGoal::updateOrCreate(
                        ['learning_sequence_id' => $learningSequence->id, 'goal_id' => $goal->id, 'user_id' => $studentId],
                        ['user_id' => $studentId]
                    );
                }
            }
        }

        return response()->json(['success' => true, 'message' => 'Students enrolled  successfully']);
    }



    public function getEnrolledStudents($courseId)
    {

        $course = Course::findOrFail($courseId);

        $enrolledStudents = $course->students()->wherePivot('instructor_id', auth()->id())->get();
        return $enrolledStudents;
    }



    public function index()
    {
        $user_submit_status=UserHelper::User_status_check('is_verified');
        if($user_submit_status=='0'){
            return redirect()->route('register_success');
        }
        elseif(UserHelper::User_status_check('is_blocked')==1)
        {
            return redirect()->route('block');
        }
        else{

            return redirect()->route('login_instructor');
        }
    }
    public function block_user()
    {
        return view('Backend.Instructor.block');
    }
    public function form_submit()
    {
        $user_submit_status=UserHelper::User_status_check('is_profile_completed');
        $data = GeneralSetting::first();
        if($user_submit_status==1){
            return redirect()->route('register_success');
        }
        else{
            $Specialization=Specialization::get();

            return view('Backend.Instructor.instructor_form',compact('Specialization','data'));
        }

    }
    public function form_save(Request $request)
    {
        $user_submit_status=UserHelper::User_status_check('is_profile_completed');
        if($user_submit_status==1){
            return redirect()->route('register_success');
        }
        else{
            $validator = Validator::make($request->all(), [
                'linkdin_link' => 'required',
                'gihub_id' => 'required',
                'google_auth_id' => 'required|email',
                'webaddress' => ['required', 'url', 'website_alive'],
                'Slack_email' => 'required|email',
                'Specialization' => 'required|array',
                'Specialization.*' => 'exists:specializations,id',
                'twiter_link' => ['required', 'url', 'twiter_link'],
                'exprience_details' => 'required|string|max:200|min:20',
            ]);


            $validator->setAttributeNames([
                'linkdin_link' => 'LinkedIn Link',
                'gihub_id' => 'GitHub ID',
                'google_auth_id' => 'Google Auth ID',
                'webaddress' => 'Web Address',
                'Slack_email' => 'Slack Email',
                'Specialization' => 'Specialization',
                'Specialization.*' => 'Selected Specialization',
                'twiter_link' => 'Twitter Link',
                'exprience_details' => 'Experience Details',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }


            $user_info=$request->all();
            $info_data=new InstructorInfo();
            $info_data->user_id=Auth::user()->id;
            $info_data->website_url=$user_info['webaddress'];
            $info_data->google_auth_share_drive_email=$user_info['google_auth_id'];
            $info_data->github_user_name=$user_info['gihub_id'];
            $info_data->slack_mail_id=$user_info['Slack_email'];
            $info_data->linkdin_link=$user_info['linkdin_link'];
            $info_data->twiter_link=$user_info['twiter_link'];
            $info_data->is_other_checked = isset($user_info['oth_item']) && $user_info['oth_item'] == 'Yes' ? 'Yes' : 'No';
            $info_data->other_value_text = isset($user_info['other_value']) ? $user_info['other_value'] : null;
            $info_data->exprience_short_desc=$user_info['exprience_details'];

            if($info_data->save())
            {

                $specializationsIds=$user_info['Specialization'];
                $user_id=Auth::user()->id;
                $has_another=0;
                $another_name=1;
                $data = collect($specializationsIds)->map(function ($specializationId) use ($request, $user_id, $has_another, $another_name) {
                    return [
                        'user_id' => $user_id,
                        'specialization_id' => $specializationId,
                        'has_another' => $has_another,
                        'another_name' => $another_name,
                    ];
                })->toArray();

                UserSpecialization::insert($data);
                User::where('id',Auth::user()->id)->update(['is_profile_completed'=>1,'is_verified'=>0]);

                UserHelper::sent_email(Auth::user()->email,'Registration Submitted','Your Account Registration process Complete Please Wait While Admin Approval !!');
                return redirect()->route('register_success');
            }
        }


    }


public function success_msg()
{
    $user_submit_status = UserHelper::User_status_check('is_verified');

    if ($user_submit_status == '0') {
        return view('Backend.Instructor.success');
    } elseif (UserHelper::User_status_check('is_blocked') == 1) {
        return redirect()->route('block');
    } elseif (Auth::user() && Auth::user()->hasRole('Instructor')) {
    if (Auth::user()->is_verified == '1' && Auth::user()->is_profile_completed == '1') {
            return redirect()->route('instructor_dashboard');
        }
    }


    return redirect()->route('login_instructor');
}



    public function instructor_list()
    {
         $admin_list=User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Instructor');
        })->paginate(10);
        return view('Backend.Instructor.instructorlist',compact('admin_list'));
    }

    public function instructor_details($id)
    {
        $instractor =  User::with('user_information', 'spasilization.spacilazations')
            ->where('id', $id)
            ->whereHas('roles', function ($query) {
                $query->where('name', 'Instructor');
            })
            ->first();

        return view('Backend.Instructor.instructordetails', compact('instractor'));


    }

    public function instructor_approve($id)
    {
        $user_item = User::where(['id' => $id])
            ->whereHas('roles', function ($query) {
                $query->where('name', 'Instructor');
            })
            ->first();
        if(!empty($user_item)){
            if($user_item->is_profile_completed=='0'){

                Session::flash('error', "Account profile not completed!!");
                return redirect()->back();
            }
            else{
                User::where('id',$id)->update(['is_verified'=>1]);
                UserHelper::sent_email($user_item->email,'Account Approoved','Your Account Approved By Admin !!');
                return redirect()->back()->with('success','Account Verification Success!!');
            }
        }
        else
        {
            Session::flash('error', "This User not exist!!");
            return redirect()->back();
        }

    }
    public function instructor_activate($id)
    {

        $user_item=User::where('id',$id)->first();
        if(!empty($user_item)){
            if($user_item->is_profile_completed=='0'){
                return redirect()->back()->with('error','Account profile not completed!!');
            }
            else{
                User::where('id',$id)->update(['is_blocked'=>0]);
                //  UserHelper::sent_email($user_item->email,'Account Activation','Your Account Activated By Admin Now You can Login !!');

                Mail::to($user_item->email)->send(new AccountActivationMail($user_item));

                Session::flash('success', "Your Account Activated By Admin Now You can Login !!!!");
                return redirect()->back();

            }
        }
        else
        {

            Session::flash('error', "This User not exist!!");
            return redirect()->back();
        }

    }
    public function instructor_remove($id)
    {
        $instractor= User::where(['id' => $id])
            ->whereHas('roles', function ($query) {
                $query->where('name', 'Instructor');
            })
            ->first();
        if(!empty($instractor)){
            if(User::where('id',$id)->delete()){

                Session::flash('success', "Instructor has been removed successfully");
                return redirect()->route('allInstructor');
            }
        }else{

            Session::flash('success', "Instructor not exist!!");
            return redirect()->route('allInstructor');
        }
    }



    public function removeInstructor($courseId)
    {
        $instructorId = Auth::id();

        $hasOtherInstructors = CourseStudent::where('course_id', $courseId)
            ->whereNull('student_id')
            ->where('instructor_id', '!=', $instructorId)
            ->exists();

        if (!$hasOtherInstructors) {
            return response()->json(['success' => false, 'message' => 'Cannot remove the only instructor. The course would have no instructors.']);
        }

        CourseStudent::where('course_id', $courseId)
            ->where('instructor_id', $instructorId)
            ->whereNull('student_id')
            ->delete();

        return response()->json(['success' => true, 'message' => 'Instructor removed from course']);
    }

    public function deleteCourse(Request $request, $courseId)
    {
        $course = Course::find($courseId);
        if (!$course) {
            return response()->json(['success' => false, 'message' => 'Course not found.']);
        }
        $hasInstructors = $course->instructors()->exists();
        if ($hasInstructors) {
            CourseLearningSequence::where('course_id', $courseId)->delete();
            $course->delete();
            return response()->json(['success' => true, 'message' => 'Course deleted successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Cannot delete the course as it has no instructors.']);
        }
    }



}
