
@foreach($subGoals as $subGoal)
    <li>
        <i class="indicator fa fa-plus"></i>{{ $subGoal->title }}
        <ul class="nk_ul_2">
            <li class="nk_li_2">Description : {{ $subGoal->description }}</li>
            <li class="nk_li_2"><button type="button" class="btn btn-primary btn-sm addSubGoalButton" data-toggle="modal" data-sub-goal-id="{{ $subGoal->id }}">Add Sub Goal</button></li>
            <li class="nk_li_2">
                @php
                    $url_update = route('editsubGoal', ['id' => $subGoal->id]);
                @endphp

                <a class="label label-primary" data-title="Edit Sub Goal" data-act="ajax-modal" data-append-id="AjaxModelContent"  data-action-url="{{ $url_update }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit </a>

        </ul>
        @if(count($subGoal->subGoals))
            <ul class="nk_ul_2">

                @include('Backend.subgoal.subgoal_row', ['subGoals' => $subGoal->subGoals])
            </ul>
        @endif
    </li>

@endforeach

