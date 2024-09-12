<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Mail\InstructorAdded;
use App\Models\Course;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Zizaco\Entrust\EntrustFacade as Entrust;


class CourseController extends Controller
{
    ///pankaj
    public function index(){
        return view('Backend.Course.All');
    }

    public function publiccourse(){
        return view('Backend.Course.publiccourse');
    }

    public function publiccoursedatatable()
    {
        $query = Course::select('id', 'title', 'visibility');

        return DataTables::eloquent($query)
            ->addColumn('visibility', function ($course) {
                return $course->visibility == 'public' ? 'Public' : 'Private';
            })
            ->addColumn('actions', function ($course) {
                if ($course->visibility == 'public') {
                    return '<form action="' . route('courses_unpublish', $course->id) . '" method="POST" style="display:inline;">'
                        . csrf_field() . method_field('POST')
                        . '<button type="submit" class="btn btn-warning">Unpublish</button>'
                        . '</form>';
                } else {
                    return '<form action="' . route('courses_publish', $course->id) . '" method="POST" style="display:inline;">'
                        . csrf_field() . method_field('POST')
                        . '<button type="submit" class="btn btn-success">Publish</button>'
                        . '</form>';
                }
            })
            ->rawColumns(['actions'])
            ->toJson();
    }
    public function publishCourse($id)
    {
        $course = Course::findOrFail($id);
        $course->update(['visibility' => 'public']);


        Session::flash('success', 'Course has been published to public!');
        return redirect()->back();
    }

    public function unpublishCourse($id)
    {
        $course = Course::findOrFail($id);
        $course->update(['visibility' => 'private']);

        Session::flash('success', 'Course has been unpublished and is now private.');
        return redirect()->back();
    }


    public function datatable()
    {
        $courses = Course::withCount('students')->with('instructors')->get();

        return DataTables::of($courses)
            ->addColumn('instructors', function ($course) {
                return $course->instructors->pluck('email')->implode(', ');
            })
            ->addColumn('actions', function ($course) {
                return '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addInstructorModal" data-course-id="' . $course->id . '">Add Instructor</button>';
            })
            ->editColumn('students_count', function ($course) {
                return $course->students_count;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }



    public function addInstructor(Request $request, $courseId)
    {
        $rules = [
            'email' => 'required|email',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Error.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $course = Course::findOrFail($courseId);

        $instructor = User::where('email', $request->email)->first();

        if ($instructor) {
            return response()->json([
                'message' => 'This email is already associated with an existing Instructor or Student. Please use another email.',
            ], 400);
        }

        $password = Str::random(8);
        if (!$instructor) {
            $instructor = User::create([
                'name' => $request->name ?? 'Instructor',
                'email' => $request->email,
                'password' => Hash::make($password),
                'type' => 'Instructor',
                'profile_photo' => 'avatar.png',
                'api_token' => Str::random(60),
            ]);
            $instructor->attachRole(3);

        }
        if ($course->instructors->contains($instructor->id)) {
            return response()->json(['message' => 'Instructor already added.'], 400);
        }

        $course->instructors()->attach($instructor->id);

        $email=$request->email;

        Mail::to($email)->send(new InstructorAdded($course, $password, $email));

        return response()->json(['message' => 'Instructor added successfully.']);
    }



}
