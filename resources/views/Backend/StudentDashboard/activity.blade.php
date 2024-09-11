@php
    $studentId = Auth::user()->id;
                $assignedCourses = App\Models\Course::whereHas('courseStudents', function ($query) use ($studentId) {
                    $query->where('student_id', $studentId);
                                })
            ->with(['learningSequences' => function ($query) {
                         $query->orderBy('course_learning_sequences.order_column', 'asc');
                                    }])

                   ->get();

$CourseIDS=[];
foreach($assignedCourses as $course){
   foreach($course->learningSequences as $cls)
       {
        array_push($CourseIDS,$cls->id);
   }
}
    $isSubmitted = \App\Models\Submission::where('learning_sequence_id', $activity->id)
        ->where('student_id', Auth::id())
        ->exists();

$position1 = array_search($activity->id, $CourseIDS);
$isLastActivity = $position1 == sizeof($CourseIDS) - 1;

@endphp

<style>
    button.btn.btn-primary.float_btn {
        float: right;
    }
    label.goals_label_1 {
        font-size: 18px;
        font-weight: 600;
    }
    /*li.goals_li_1 {*/
    /*    font-size: 16px;*/
    /*    text-align: center;*/
    /*    font-weight: 600;*/
    /*    border: 1px solid #c5c5c5;*/
    /*    padding: 10px;*/
    /*}*/

    .foil-feedback-group {
        margin-bottom: 20px;
    }
    .foil-feedback-group label {
        font-weight: bold;
    }
    .foil-feedback-group .foil, .foil-feedback-group .feedback {
        margin-bottom: 10px;
    }
    .p-new-ul{
        padding-left: 67px;
    }
    .goals_li_1 {
        list-style-type: disc;
    }

    .learning-activity {
        overflow: hidden;
        text-overflow: ellipsis;
        padding: 5px;
        width: 100%;
        height: 100px;
        overflow-y: scroll;
    }
    .learning-activity::-webkit-scrollbar {
        width: 0px;
    }
    .learning-activity::-webkit-scrollbar-thumb {
        border-radius: 10px;
    }
    .learning-activity strong {
        font-weight: bold;
    }

    .learning-activity {
        margin: 10px 0;
    }

    .status-wrapper {
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
        background-color: #f9f9f9;
        margin-bottom: 15px;
    }

    .status-heading {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .status-message {
        padding: 10px 15px;
        border-radius: 4px;
        border: 1px solid #d6e9c6;
        background-color: #dff0d8;
        color: #3c763d;
    }
    .p-flex-title{
        display: flex;
        align-items: baseline;
    }
</style>

<div class="box box-primary">

    <div class="box-body">
        <div class="form-group">
            <label class="goals_label_1">Goals :</label>
            <ul class="list-unstyled p-new-ul">
                @if ($activity->goals && $activity->goals->isNotEmpty())
                    @foreach($activity->goals as $goal)
                        <li class="goals_li_1">{{ $goal->title }}</li>
                    @endforeach
                @else
                    <li class="goals_li_1">No goals available.</li>
                @endif
            </ul>
        </div>
        <div class="form-group p-flex-title">
            <label class="goals_label_1">Title:</label>
            <h4 class="text-bold learning-activity">{{ $activity->title ?? ''}}</h4>
        </div>
        @if ($isSubmitted)
            <div class="row">
                <div class="col-md-12">
                    <div class="status-wrapper">
                        <h5 class="status-heading">Submission Status</h5>
                        <div class="alert alert-success status-message">
                            <strong>Status:</strong> {{ $isLastActivity ? 'Course Completed' : 'Activity Submitted' }}
                        </div>
                    </div>
                </div>
            </div>

        @else
            <form method="post" action="{{ route('next.learning_sequence', ['sequenceId' => $activity->id]) }}" id="activityForm">
                @csrf
                @if ($activity->content_type === 'qti')
                    <label>{{ $activity->stem ?? '' }}</label>
                    @if ($activity->foilFeedbacks && $activity->foilFeedbacks->isNotEmpty())
                        @foreach ($activity->foilFeedbacks as $index =>$foilFeedback)
                            <div class="foil-feedback-group">
                                <div class="form-group foil">

                                    <input type="radio" class=" validate[required] form-control mb-2" name="foils[]" value="{{ $foilFeedback->foil }}" id="foil-{{ $index }}">
                                    <label class="form-check-label" for="foil-{{ $index }}">{{ $foilFeedback->foil }}</label>
                                </div>


                            </div>
                        @endforeach
                    @endif
                    <input type="hidden" name="qti_data[stem]" value="{{ $activity->stem }}">
                    <input type="hidden" name="qti_data[key_data]" value="{{ $activity->key_data }}">

                @elseif (in_array($activity->content_type, ['html', 'txt', 'js', 'md']))
                    <div class="form-group">

                        <div id="descriptionContainer" >
                            {!! $activity->description !!}
                        </div>
                        <input type="hidden" name="html_content" id="html_content">
                    </div>
                @else
                    <div class="callout callout-warning">
                        <p>Unknown content type: {{ $activity->content_type }}</p>
                    </div>
                @endif

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary float_btn">
                        @if($position1 != sizeof($CourseIDS) - 1)
                            <i class="fa fa-arrow-right"></i>
                        @endif
                        @if($position1 == sizeof($CourseIDS) - 1)
                            Submit
                        @else
                            Next
                        @endif
                    </button>
                </div>

            </form>
        @endif
    </div>
</div>











