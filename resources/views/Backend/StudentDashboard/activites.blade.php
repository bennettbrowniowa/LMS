@extends('Backend.main')

@section('content')

    @php
        $studentId = Auth::user()->id;
        $assignedCourses = App\Models\Course::whereHas('courseStudents', function ($query) use ($studentId) {
            $query->where('student_id', $studentId);
        })
        ->with(['learningSequences' => function ($query) {
            $query->orderBy('course_learning_sequences.order_column', 'asc');
        }])
        ->orderBy('id','desc')
        ->get();

        $CourseIDS = [];
        foreach($assignedCourses as $course){
            foreach($course->learningSequences as $cls) {
                array_push($CourseIDS, $cls->id);
            }
        }

        $isSubmitted = \App\Models\Submission::where('learning_sequence_id', $activity->id)
            ->where('student_id', Auth::id())
            ->exists();

        $position1 = array_search($activity->learning_sequence_id, $CourseIDS);

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
        li.goals_li_1 {
            font-size: 16px;
            text-align: center;
            font-weight: 600;
            border: 1px solid #c5c5c5;
            padding: 10px;
        }
        .goals_ul_1{
            list-style-type: none;
            padding: 0;
        }
        .title-h5{
            margin: 0;
        }

        .margin-div-1{
            margin: 30px 0 35px 0;
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

    </style>

    <div class="content-wrapper">
    <section class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12 my-3 .margin-div-1">
                        <label class="goals_label_1">Goals -</label>
                        <ul class="goals_ul_1">
                            @if ($activity->learningSequence->goals && $activity->learningSequence->goals->isNotEmpty())
                                @foreach($activity->learningSequence->goals as $goal)
                                    <li class="goals_li_1">{{ $goal->title }}</li>
                                @endforeach
                            @else
                                <li class="goals_li_1">No goals available.</li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 my-5">
                        <div class="form-group margin-div-1">
                            <label class="goals_label_1">Title-</label>
                            <h5 class="title-h5 learning-activity"><strong>{{ $activity->learningSequence->title ?? ''}}</strong></h5>
                        </div>
                    </div>
                </div>

                @if ($isSubmitted)
                    <div class="row">
                        <div class="col-md-12">
                            <div class="status-wrapper">
                                <h5 class="status-heading">Submission Status</h5>
                                <div class="alert alert-success status-message">
                                    <strong>Status:</strong>  {{ $isLastActivity ? 'Course Completed' : 'Activity Submitted' }}
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <form method="post" id="activityForm" action="{{ route('next.learning_sequence', ['sequenceId' => $activity->learning_sequence_id]) }}">
                        @csrf

                        @if ($activity->learningSequence->content_type === 'qti')
                            <input type="hidden" name="qti_data[stem]" value="{{ $activity->learningSequence->stem ?? '' }}">
                            <input type="hidden" name="qti_data[key_data]" value="{{ $activity->learningSequence->key_data ?? ''}}">
                            <label>{{ $activity->learningSequence->stem ?? '' }}</label>
                            <div class="form-group">
                                @if ($activity->learningSequence->foilFeedbacks && $activity->learningSequence->foilFeedbacks->isNotEmpty())
                                    @foreach ($activity->learningSequence->foilFeedbacks as $index => $foilFeedback)
                                        <div class="form-group">
                                            <input type="radio" name="foils[]" class="validate[required] form-control mb-2" value="{{ $foilFeedback->foil }}" id="foil-{{ $index }}">
                                            <label class="form-check-label" for="foil-{{ $index }}">{{ $foilFeedback->foil }}</label>

                                        </div>

                                    @endforeach
                                @endif
                            </div>
                        @elseif (in_array($activity->learningSequence->content_type, ['html', 'txt', 'js', 'md']))
                            <div class="form-group description-container flex-div">

                                <div id="descriptionContainer" class="p-10">
                                    {!! $activity->learningSequence->description ?? '' !!}
                                </div>
                                <input type="hidden" name="html_content" id="html_content">
                            </div>
                        @else
                            <div class="alert alert-warning">Unknown content type: {{ $activity->learningSequence->content_type ?? '' }}</div>
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
    </section>
    </div>




@endsection



@push('script')
    <script>
        jQuery("#activityForm").validationEngine({promptPosition: 'inline'});

        $(document).ready(function () {

            const form = document.getElementById('activityForm');
            if (form) {
                form.addEventListener('submit', function () {

                    const elements = document.querySelectorAll('#descriptionContainer input, #descriptionContainer textarea, #descriptionContainer select');

                    elements.forEach(element => {
                        if (element.tagName === 'SELECT') {

                            const options = element.querySelectorAll('option');
                            options.forEach(option => {
                                if (option.selected) {
                                    option.setAttribute('selected', 'selected');
                                } else {
                                    option.removeAttribute('selected');
                                }
                            });
                        } else if (element.type === 'checkbox' || element.type === 'radio') {

                            if (element.checked) {
                                element.setAttribute('checked', 'checked');
                            } else {
                                element.removeAttribute('checked');
                            }
                        } else {

                            element.setAttribute('value', element.value);
                        }
                    });

                    const htmlContent = document.getElementById('descriptionContainer').innerHTML;
                    document.getElementById('html_content').value = htmlContent;
                });
            }

        });

    </script>
@endpush
