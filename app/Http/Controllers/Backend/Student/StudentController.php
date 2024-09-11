<?php

namespace App\Http\Controllers\Backend\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseLearningSequence;
use App\Models\CourseStudent;
use App\Models\LearningSequence;
use App\Models\QtiResponse;

use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{


    //    public function showCourse($courseId)
//    {
//
//        $learningSequence = LearningSequence::findOrFail($courseId);
//
//        $firstActivity = CourseLearningSequence::where('learning_sequence_id', $learningSequence->id)
//            ->with(['learningSequence.goals','learningSequence.foilFeedbacks'])
//            ->orderBy('order_column', 'asc')
//            ->first();
//
//        if ($firstActivity) {
//            $learningSequence = LearningSequence::with(['goals', 'foilFeedbacks'])
//                ->findOrFail($firstActivity->learning_sequence_id);
//
//            return view('Backend.StudentDashboard.course', [
//                'firstActivity' => $learningSequence,
//            ]);
//        } else {
//            return redirect()->route('student_dashboard')->withErrors(['msg' => 'No activities found for this course.']);
//        }
//
//    }
    public function student_dashboard()
    {
        $studentId = Auth::id();
        $instructorId = Auth::user()->instructor_id;


        $publicCourses = Course::where('visibility', 'public')
            ->with(['learningSequences' => function ($query) {
                $query->orderBy('course_learning_sequences.order_column', 'asc');
            }, 'learningSequences.goals'])
            ->get();


        $assignedCourses = Course::whereHas('courseStudents', function ($query) use ($studentId) {
            $query->where('student_id', $studentId);
        })
            ->with(['learningSequences' => function($query) {
                $query->orderBy('course_learning_sequences.order_column', 'asc');
            }, 'learningSequences.goals'])
            ->get();


        $instructorCourses = Course::whereHas('courseStudents', function ($query) use ($studentId, $instructorId) {
            $query->where('student_id', $studentId)
                ->where('instructor_id', $instructorId);
        })
            ->with(['learningSequences' => function($query) {
                $query->orderBy('course_learning_sequences.order_column', 'asc');
            }, 'learningSequences.goals'])
            ->get();

        $invitedCourses = Course::whereHas('invitations', function ($query) use ($studentId) {
            $query->where('user_id', $studentId)
             ->where('status', 'accepted');
        })
            ->with(['learningSequences' => function ($query) {
                $query->orderBy('course_learning_sequences.order_column', 'asc');
            }, 'learningSequences.goals'])
            ->get();


        $courses = $publicCourses
            ->merge($assignedCourses)
            ->merge($instructorCourses)
            ->merge($invitedCourses)
            ->unique('id');

        return view('Backend.StudentDashboard.dashboard', compact('courses'));
    }

    public function showCourse($courseId)
    {

        $learningSequence = LearningSequence::findOrFail($courseId);
        $firstActivity = CourseLearningSequence::where('learning_sequence_id', $learningSequence->id)
            ->with(['learningSequence.goals','learningSequence.foilFeedbacks'])
            ->orderBy('order_column', 'asc')
            ->first();
        if ($firstActivity) {
            $learningSequence = LearningSequence::with(['goals', 'foilFeedbacks'])
                ->findOrFail($firstActivity->learning_sequence_id);

            return view('Backend.StudentDashboard.course', [
                'firstActivity' => $learningSequence,
            ]);
        } else {
            return redirect()->route('student_dashboard')->withErrors(['msg' => 'No activities found for this course.']);
        }

    }


    public function renderActivity($sequenceId)
    {
        $activity =  CourseLearningSequence::with(['learningSequence', 'learningSequence.goals', 'learningSequence.foilFeedbacks'])
            ->where('learning_sequence_id', $sequenceId)->first();
        if (!$activity) {
            return redirect()->route('student_dashboard')->withErrors(['msg' => 'Activity not found.']);
        }
        return view('Backend.StudentDashboard.activity', compact('activity'));
    }

    public function rendernextActivity($sequenceId)
    {
        $activity =  CourseLearningSequence::with(['learningSequence', 'learningSequence.goals', 'learningSequence.foilFeedbacks'])
            ->where('learning_sequence_id', $sequenceId)->first();

        if (!$activity) {
            return redirect()->route('student_dashboard')->withErrors(['msg' => 'Activity not found.']);
        }
        return view('Backend.StudentDashboard.activites', compact('activity'));

    }



    public function nextActivity(Request $request, $sequenceId)
    {
        $studentId = Auth::id();
        $currentSequence = LearningSequence::find($sequenceId);

        if (!$currentSequence) {
            return redirect()->route('student_dashboard')->withErrors(['msg' => 'Invalid learning sequence ID.']);
        }

        DB::beginTransaction();

        try {
            if ($currentSequence->content_type === 'qti') {
                $submission = Submission::updateOrCreate(
                    ['learning_sequence_id' => $sequenceId, 'student_id' => $studentId],
                    ['content_type' => $currentSequence->content_type]
                );

                $correctFoils = $currentSequence->foilFeedbacks()->where('is_correct', 1)->pluck('foil')->toArray();
                foreach ($request->input('foils', []) as $foil) {
                    $isCorrect = in_array($foil, $correctFoils);
                    $feedback = $this->generateFeedback($foil, $correctFoils);
                    QtiResponse::create([
                        'submission_id' => $submission->id,
                        'stem' => $request->input('qti_data.stem'),
                        'key_data' => $request->input('qti_data.key_data'),
                        'foils' => $foil,
                        'student_id' => $studentId,
                        'feedbacks' => $feedback,
                        'is_correct' => $isCorrect ? 1 : 0,
                    ]);
                }
            } elseif (in_array($currentSequence->content_type, ['html', 'txt', 'js', 'md'])) {
                Submission::updateOrCreate(
                    ['learning_sequence_id' => $sequenceId, 'student_id' => $studentId],
                    ['content_type' => $currentSequence->content_type, 'description' => $request->input('html_content')]
                );
            } else {
                DB::rollback();
                return redirect()->route('student_dashboard')->withErrors(['msg' => 'Unsupported content type.']);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('student_dashboard')->withErrors(['msg' => 'Error processing submission.']);
        }

        $currentActivity = CourseLearningSequence::where('learning_sequence_id', $sequenceId)->first();

        if (!$currentActivity) {
            return redirect()->route('student_dashboard')->withErrors(['msg' => 'Current activity not found.']);
        }

        $nextActivity = CourseLearningSequence::where('course_id', $currentActivity->course_id)
            ->where('order_column', '>', $currentActivity->order_column)
            ->orderBy('order_column', 'asc')
            ->first();

        if ($nextActivity) {
            return redirect()->route('render.nextlearning_sequence', ['sequenceId' => $nextActivity->learning_sequence_id]);
        } else {
            return redirect()->route('student_dashboard');
        }
    }

    private function generateFeedback($studentFoil, $correctFoils)
    {
        return in_array($studentFoil, $correctFoils) ? 'Correct answer! Well done.' : 'Incorrect answer. Please review the material and try again.';
    }



}
