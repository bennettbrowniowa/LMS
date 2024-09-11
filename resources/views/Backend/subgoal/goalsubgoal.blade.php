@foreach ($subGoals as $index=> $subGoal)
    <li class="pb-li-div px-3" data-id="{{ $subGoal->id }}" data-parent-id="{{ $subGoal->parrent_id }}" title="{{ $subGoal->description }}">

        @if ($subGoal->subGoals->isNotEmpty())
            <i class="indicator fa fa-chevron-right"></i>
        @endif
            <span class="goal-info"  data-description="{{ $subGoal->description }}" data-title="{{ $subGoal->title }}">
               {{Str::limit( $subGoal->title,50) }}: {{Str::limit( $subGoal->description,50) }}
            </span>

            <ul class="nk_ul_2">
            <li class="nk_li_2"></li>

            <li class="nk_li_2">
                <button type="button" class="btn btn-primary btn-sm addSubGoalButton" data-toggle="modal" data-parent-id="{{ $subGoal->id }}">Add Sub Goal</button>
            </li>

            <li class="nk_li_2">
                @php
                    $url_update = route('editGoal', ['id' => $subGoal->id]);
                @endphp

                <button type="button" class="move_btn_001 movesubGoalsButton" data-toggle="modal" data-subgoal-id="{{ $subGoal->id }}">Move Subgoal</button>
                <a class="label label-primary" data-title="Edit Goal" data-act="ajax-modal" data-append-id="AjaxModelContent" data-action-url="{{ $url_update }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit </a>
                @if($index < count($subGoals) - 1)
                    <button class="down-arrow-btn" onclick="moveSubgoalDown('{{ $subGoal->id }}', '{{ $subGoals[$index + 1]->id }}')">▼</button>
                @endif
            </li>
        </ul>
        @if (count($subGoal->subGoals))
            <ul class="nk_ul_2">
                @include('Backend.subgoal.goalsubgoal', ['subGoals' => $subGoal->subGoals])
            </ul>
        @endif
    </li>
@endforeach

