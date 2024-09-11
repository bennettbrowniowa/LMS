@extends('Backend.main')

@section('content')

    <style>
        .move_btn_001 {
            background-color: #4144bb !important;
            color: white !important;
            padding: 2px 14px 3px 14px !important;
            line-height: normal;
            border-radius: 2px;
        }
        .tree, .tree ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .tree ul {
            margin-left: 1em;
            position: relative;
        }

        .tree ul ul {
            margin-left: .5em;
        }





        .pb-li-div {
            position: relative;
            display: inline-block;

        }
        .tree ul:before {
            content: "";
            display: block;
            width: 0;
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            border-left: 1px solid;
        }

        .tree li {

        }

        .tree .indicator {
            margin-right: 5px;
            display: inline-block;
        }

        .tree .goal-info {
            display: inline;
            vertical-align: middle;
        }

        .tree ul li:before {
            content: "";
            display: block;
            width: 10px;
            height: 0;
            border-top: 1px solid;
            margin-top: -1px;
            position: absolute;
            top: 1em;
            left: 0;
        }

        .tree ul li:last-child:before {
            background: #fff;
            height: auto;
            top: 1em;
            bottom: 0;
        }

        .indicator {
            margin-right: 5px;
        }

        .tree li a {
            text-decoration: none;
            color: #369;
        }

        .tree li button,
        .tree li button:active,
        .tree li button:focus {
            text-decoration: none;
            color: #369;
            border: none;
            background: transparent;
            margin: 0 6px;
            padding: 5px;
            outline: 0;
        }
        .nk_li_1 {
            display: inline-block;
            width: 24%;
            text-align: center;
            padding: 8px;
            background-color: #4144bb;
            color: white;
            margin-bottom: 10px;
        }



        li.nk_li_2 {
            display: inline-block;
            padding-right: 20px;
        }
        .addSubGoalButton {
            background-color: #4144bb !important;
            color: white !important;
            padding: 2px 10px !important;

        }



        .tree ul li.nk_li_2:before {
            display: none !important;
        }
        .box.box-primary {
            overflow: hidden;
            overflow-x: scroll;
            overflow-y: scroll;
        }
        .pb-li-div{
            overflow-x: auto;
            white-space: nowrap;
            overflow-y: auto;
            max-height: 1000px;
            border: 1px solid black;
            margin-bottom: 8px !important;
        }


        .tree .pb-li-div, .nk_ul_2 {
            display: block;
            margin-bottom: 10px;
        }
        .box-body.table-responsive {
            overflow-x: auto;
            overflow-y: auto;
        }

        .tree-structured-list {
            overflow-x: auto;
            overflow-y: auto;
            max-height: 400px;
        }

        .pb-border-div {
            overflow-x: auto;
            overflow-y: auto;
            max-height: 300px;
        }


        .moveDownButton {
            padding: 5px 10px;
            margin-left: 5px;
            background-color: #6c757d;
            color: #fff;
            border: none;
            border-radius: 3px;
            /*cursor: pointer;*/
        }

        .moveDownButton:hover {
            background-color: #5a6268;
            color: #fff;
        }

        .goal-info {
            cursor: pointer;
            user-select: none;


        }
        .indicator {
            cursor: pointer;
        }

        #tooltip {
            position: absolute;
            background: #333;
            color: #fff;
            padding: 15px;
            border-radius: 8px;
            display: none;
            z-index: 9999;
            max-width: 300px;
            min-width: 150px;
            max-height: 200px;
            overflow-y: auto;
            white-space: normal;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            font-size: 14px;
            line-height: 1.4;
            border: 1px solid #444;
            word-wrap: break-word;
            pointer-events: none;
        }
        .px-3 {
            margin: 0;
            padding: 0 1em;
            line-height: 2em;
            color: #369;
            font-weight: 700;
            position: relative;
            cursor: pointer;
            user-select: none;
        }




    </style>

    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <button id="show-goals" class="btn btn-primary" style="display: none">Show Goals</button>

            @if (count($errors) > 0)
                <div class="alert alert-error alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h2>Goal</h2>

                    <div class="box-tools">
                        <a href="javascript:void(0);" class="btn btn-primary btn-flat" data-act="ajax-modal" data-title="Add Goal" data-append-id="AjaxModelContent" style="background-color: #4144bb;" data-action-url="{{route("addGoal")}}">
                            <i class="fa fa-plus-circle"></i> Add
                        </a>
                    </div>

                </div>

                <div class="box-body table-responsive">
                    <div class="tree-structured-list">
                        @if($parent_goals->isEmpty())
                            <p style="text-align: center;">No Goals or Subgoals Found</p>
                        @else
                            <ul class="list-header nk_ul_1">
                                <ul id="tree1" class="tree pb-border-div">
                                    @foreach($parent_goals as $index => $goal)
                                        <li class="pb-li-div px-3"  data-id="{{ $goal->id }}" data-title="{{ $goal->title }}" data-description="{{ $goal->description }}" data-parent-id="0">

                                            @if(!$goal->subGoals->isEmpty())
                                                <i class="indicator fa fa-chevron-right"></i>
                                            @endif
                                           <span class="goal-info" data-description="{{ $goal->description }}" data-title="{{ $goal->title }}">
                                                {{Str::limit( $goal->title,50) }}: {{Str::limit( $goal->description,50) }}
                                           </span>
                                                @if($goal->hasSiblings())
                                                @if($index < count($parent_goals) - 1)
                                                    <button class="down-arrow-btn" data-goal-id="{{ $goal->id }}">▼</button>
                                                @endif
                                            @endif

                                                <ul class="nk_ul_2">

                                                <li class="nk_li_2"></li>
                                                <li class="nk_li_2">
                                                    <button type="button" class="btn btn-primary btn-sm addSubGoalButton" data-toggle="modal" data-parent-id="{{ $goal->id }}">Add Sub Goal</button>
                                                </li>
                                                <li class="nk_li_2">
                                                    @php
                                                        $url_update = route('editGoal', ['id' => $goal->id]);
                                                    @endphp
                                                    <button type="button" class="move_btn_001 moveGoalButton" data-toggle="modal" data-goal-id="{{ $goal->id }}">Move</button>
                                                    <a class="label label-primary" data-title="Edit Goal" data-act="ajax-modal" data-append-id="AjaxModelContent"  data-action-url="{{ $url_update }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit </a>
                                                </li>
                                            </ul>
                                                @if($goal->subGoals->isNotEmpty())
                                                    <ul class="nk_ul_2">
                                                    @include('Backend.subgoal.goalsubgoal', ['subGoals' => $goal->subGoals])
                                                </ul>
                                            @endif


                                        </li>
                                    @endforeach
                                </ul>
                            </ul>
                        @endif
                    </div>
                </div>

            </div>


        </section>
        <!-- /.content -->
    </div>

    <div class="modal fade" id="addSubGoalModal" tabindex="-1" role="dialog" aria-labelledby="addSubGoalModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSubGoalModalLabel">Add Sub Goal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                </div>
                <div class="modal-body">
                    <form id="addSubGoalForm">

                        <input type="hidden" id="parentId" name="parentId">
                        <div class="form-group">
                            <label for="subGoalTitle">Title</label>
                            <input type="text" class="validate[required] form-control" id="subGoalTitle" name="subGoalTitle" required>
                        </div>
                        <div class="form-group">
                            <label for="subGoalDescription">Description</label>
                            <textarea class="validate[required] form-control" id="subGoalDescription" name="subGoalDescription" rows="4" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveSubGoalBtn">Save</button>
                </div>
            </div>
        </div>










    <div class="modal fade" id="moveSubGoalModal" tabindex="-1" role="dialog" aria-labelledby="moveSubGoalModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="moveSubGoalModalLabel">Move Subgoal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Select the position to move the goal: <span id="data"></span></p>
                    <select id="selectedPosition" class="form-control select2"></select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="moveSubGoalConfirm">Move</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="moveSubGoalsModals" tabindex="-1" role="dialog" aria-labelledby="moveSubGoalModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="moveSubGoalModalLabel">Move Subgoal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Select the position to move the subgoal: <span id="data"></span></p>
                    <select id="selectedPositionsubgoals" class="form-control select2"></select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="moveSubGoalsConfirms">Move</button>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('script')

    <script>
        $(document).ready(function() {
            $.fn.extend({
                treed: function (o) {
                    var openedClass = 'fa-chevron-down';
                    var closedClass = 'fa-chevron-right';

                    if (typeof o != 'undefined'){
                        if (typeof o.openedClass != 'undefined'){
                            openedClass = o.openedClass;
                        }
                        if (typeof o.closedClass != 'undefined'){
                            closedClass = o.closedClass;
                        }
                    }

                    var tree = $(this);
                    tree.addClass("tree");

                    tree.find('li').has("ul").each(function () {
                        var branch = $(this);
                        branch.prepend(" ");
                        branch.addClass('branch');
                        branch.on('click', function (e) {
                            if (this === e.target || $(e.target).hasClass('goal-info')) {
                                e.stopPropagation();
                                var icon = $(this).children('.indicator');
                                icon.toggleClass(openedClass + " " + closedClass);
                                $(this).children('ul').toggle();
                            }
                        });
                        branch.children('ul').hide();
                    });


                    tree.find('.branch a, .branch button').on('click', function (e) {
                        e.preventDefault();
                        $(this).closest('li').click();
                    });

                    tree.find('.indicator').on('click', function (e) {
                        e.stopPropagation();
                        $(this).closest('li').click();
                    });
                }
            });

            $('#tree1').treed();
        });

        $('.select2').select2();



        $(document).ready(function() {

            function showTooltip(e, title, description) {
                $('#tooltip').html('<strong>' + title + '</strong>: ' + description)
                    .css({
                        'top': e.pageY + 10 + 'px',
                        'left': e.pageX + 10 + 'px',
                        'display': 'block'
                    });
            }
            function hideTooltip() {
                $('#tooltip').hide();
            }

            if ($('#tooltip').length === 0) {
                $('body').append('<div id="tooltip"></div>');
            }

            $('body').on('mouseenter', '.goal-info', function(e) {
                var $this = $(this);
                var title = $this.data('title');
                var description = $this.data('description');
                $this.attr('data-title', $this.attr('title')).removeAttr('title');
                $this.attr('data-description', $this.attr('description')).removeAttr('description');
                showTooltip(e, title, description);
            });

            $('.pb-li-div').on('mouseenter', function(e) {
                var $this = $(this);
                var title = $this.data('title');
                var description = $this.data('description');
                $this.attr('data-title', $this.attr('title')).removeAttr('title');
                $this.attr('data-description', $this.attr('description')).removeAttr('description');
                hideTooltip();
            });


            $('body').on('mouseleave', '.goal-info', function() {
                var $this = $(this);
                $this.attr('title', $this.attr('data-title')).removeAttr('data-title');
                $this.attr('data-description', $this.attr('description')).removeAttr('description');
                hideTooltip();
            });

            $('.pb-li-div').on('mouseleave', '.pb-li-div', function() {
                var $this = $(this);
                $this.attr('title', $this.attr('data-title')).removeAttr('data-title');
                $this.attr('data-description', $this.attr('description')).removeAttr('description');

                hideTooltip();
            });



            $('body').on('mousemove', '.goal-info', function(e) {
                showTooltip(e, $(this).data('title'), $(this).data('description'));
            });
        });


        $(document).ready(function() {
            jQuery("#addSubGoalForm").validationEngine({promptPosition: 'inline'});
            $('.addSubGoalButton').on('click', function() {
                var parentId = $(this).data('parent-id');
                $('#parentId').val(parentId);
                $('#addSubGoalModal').modal('show');
            });


            $('#saveSubGoalBtn').on('click', function() {

                if ($("#addSubGoalForm").validationEngine('validate')) {
                    var parentId  = $('#parentId').val();
                    var title = $('#subGoalTitle').val();
                    var description = $('#subGoalDescription').val();

                    $.ajax({
                        url: '{{ route("save_sub_Goal") }}',
                        type: 'POST',
                        data: {
                            _token: '<?php echo csrf_token();?>',
                            parentId: parentId ,
                            title: title,
                            description: description
                        },
                        success: function(response) {
                            toastr.success('Subgoal saved successfully');
                            setTimeout(function() {
                                window.location.reload();
                            }, 1000);
                        },
                        error: function(xhr, status, error) {
                            toastr.error('Error occurred while saving subgoal');
                        }
                    });
                }
            });
        });



        $(document).ready(function() {

            $('.moveGoalButton').click(function() {
                var goalid = $(this).data('goal-id');

                $.ajax({
                    url: '{{route('getAvailablePositions')}}',
                    method: 'GET',
                    data: {
                        goalid: goalid
                    },
                    success: function(response) {
                        $('#selectedPosition').empty();
                        $('#selectedPosition').append('<option value="">Select Goal</option>');

                        response.potentialParentGoals.forEach(function(potentialParentGoal) {
                            var positionText = response.positionText;
                            if (response.highestPositionRow && potentialParentGoal.id === response.highestPositionRow.id) {
                                positionText = (response.positionText === 'As After') ? 'As After' : 'As After';
                            }

                            $('#selectedPosition').append('<option value="' + potentialParentGoal.id + '">' + positionText + ' ' + potentialParentGoal.title + '</option>');
                        });
                        if(response.goal){
                            $("#data").text(response.goal.title);
                        }
                        $('#moveSubGoalModal').modal('show');
                        document.getElementById('moveSubGoalConfirm').setAttribute('data-goal-id', goalid);
                        $('#moveSubGoalConfirm').attr('data-goal-id', goalid);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });



            $('#moveSubGoalConfirm').click(function() {
                var newPosition = $('#selectedPosition').val();

                var goalId = $(this).data('goal-id');
                if (!newPosition) {
                    toastr.error('Please select a Goal.');
                    return;
                }
                $.ajax({
                    url: '{{route('movegoal')}}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        newPosition: newPosition,
                        goalId: goalId
                    },
                    success: function(response) {
                        toastr.success(response.message);
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });


            $('.moveDownButton').click(function() {
                var subgoalId = $(this).data('subgoal-id');


                $.ajax({
                    url: '{{route('reorderSubgoals')}}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        subgoalId: subgoalId
                    },
                    success: function(response) {
                        location.reload();
                    },
                    error: function(xhr, status, error) {

                        console.error(error);
                    }
                });
            });
        });




        $('.movesubGoalsButton').click(function() {
            var subgoalid = $(this).data('subgoal-id');


            $.ajax({
                url: '{{route('getsubgoalAvailablePositions')}}',
                method: 'GET',
                data: {
                    subgoalid: subgoalid
                },
                success: function(response) {
                    $('#selectedPositionsubgoals').empty();
                    $('#selectedPositionsubgoals').append('<option value="">Select SubGoal</option>');
                    response.potentialParentGoals.forEach(function(potentialParentGoal) {
                        var positionText = response.positionText;


                        if (response.highestPositionRow && potentialParentGoal.id === response.highestPositionRow.id) {
                            positionText = 'Under ' + response.goal.title;
                        }


                        $('#selectedPositionsubgoals').append('<option value="' + potentialParentGoal.id + '">' + positionText + ' ' + potentialParentGoal.title + '</option>');
                    });
                    if(response.goal){
                        $("#data").text(response.goal.title);
                    }
                    $('#moveSubGoalsModals').modal('show');
                    document.getElementById('moveSubGoalsConfirms').setAttribute('data-subgoal-id', subgoalid);
                    $('#moveSubGoalsConfirms').attr('data-subgoal-id', subgoalid);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });

        $('#moveSubGoalsConfirms').click(function() {
            var newPosition = $('#selectedPositionsubgoals').val();
            var subgoalId = $(this).data('subgoal-id');
            if (!newPosition) {
                toastr.error('Please select a SubGoal.');
                return;
            }
            $.ajax({
                url: '{{ route('movesubgoal') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    newPosition: newPosition,
                    goalId: subgoalId
                },
                success: function(response) {
                    toastr.success(response.message);
                    setTimeout(function() {
                        location.reload();
                    }, 1000);

                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });


        function moveSubgoalDown(currentId, nextId) {
            $.ajax({
                url: '{{ route('move_subgoal_down') }}',
                type: 'POST',
                data: {
                    currentId: currentId,
                    nextId: nextId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {

                        toastr.success(response.message);
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        toastr.error('Error moving subgoal.');
                    }
                },
                error: function(xhr, status, error) {
                    toastr.error('Error: ' + error);
                }
            });
        }


    </script>



@endpush

