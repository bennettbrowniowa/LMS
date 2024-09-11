

@extends('Backend.main')

@section('content')

    <style>
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
            margin: 0;
            padding: 0 1em;
            line-height: 2em;
            color: #369;
            font-weight: 700;
            position: relative;
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
            margin: 0px 0px 0px 0px;
            padding: 0px 0px 0px 0px;
            outline: 0;
        }
        .nk_li_1 {
            display: inline-block;
            width: 24%;
            text-align: center;
            padding: 8px;
            background-color: #ebebeb;
        }



        li.nk_li_2 {
            display: inline-block;
            padding-right: 20px;
        }
        .addSubGoalButton {
            background-color: green !important;
            color: white !important;
            padding: 2px 10px !important;
        }

        .tree ul li.nk_li_2:before {
            display: none !important;
        }
    </style>
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
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
                    <h2>Sub Goal</h2>

                    <div class="box-tools">
                        <a href="javascript:void(0);" class="btn btn-primary btn-flat" data-act="ajax-modal"
                           data-title="Add Sub Goal" data-append-id="AjaxModelContent"
                           data-action-url="{{ route("addsubGoal", ['id' => $id]) }}">
                            <i class="fa fa-plus-circle"></i> Add
                        </a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <div class="tree-structured-list">
                        <ul class="list-header nk_ul_1">
                            <li class="nk_li_1">Title</li>

                        </ul>

                        <ul id="tree1" class="tree">
                            @foreach($subGoals as $goal)
                                <li>
                                    <i class="indicator fa fa-plus"></i>{{ $goal->title }}
                                    <ul class="nk_ul_2">
                                        <li class="nk_li_2">Description : {{ $goal->description }}</li>
                                        <li class="nk_li_2">  <button type="button" class="btn btn-primary btn-sm addSubGoalButton" data-toggle="modal" data-sub-goal-id="{{ $goal->id }}">Add Sub Goal</button></li>
                                        <li class="nk_li_2">
                                            @php
                                                $url_update = route('editsubGoal', ['id' => $goal->id]);

                                            @endphp

                                        <a class="label label-primary" data-title="Edit Sub Goal" data-act="ajax-modal" data-append-id="AjaxModelContent"  data-action-url="{{ $url_update }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit </a>

                                    </ul>

                                    <ul class="nk_ul_2">
                                        @include('Backend.subgoal.subgoal_row', ['subGoals' => $goal->subGoals])
                                    </ul>


                                </li>

                            @endforeach
                        </ul>
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
                <div class="modal-body">
                    <form id="addSubGoalForm">
                        <input type="hidden" id="parentSubGoalId" name="parentSubGoalId" value="">
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
    </div>


@endsection
@push('script')
    <script type="text/javascript">
        $(document).ready(function() {
            jQuery("#addSubGoalForm").validationEngine({promptPosition: 'inline'});


            $('.addSubGoalButton').on('click', function() {
                var parentSubGoalId = $(this).data('sub-goal-id');
                $('#parentSubGoalId').val(parentSubGoalId);
                $('#addSubGoalModal').modal('show');
            });


            $('#saveSubGoalBtn').on('click', function() {

                if ($("#addSubGoalForm").validationEngine('validate')) {
                    var parentSubGoalId = $('#parentSubGoalId').val();
                    var title = $('#subGoalTitle').val();
                    var description = $('#subGoalDescription').val();

                    $.ajax({
                        url: '{{ route("save_sub_Goal") }}',
                        type: 'POST',
                        data: {
                            _token: '<?php echo csrf_token();?>',
                            parentSubGoalId: parentSubGoalId,
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

        $.fn.extend({
            treed: function (o) {

                var openedClass = 'fa-minus';
                var closedClass = 'fa-plus';

                if (typeof o != 'undefined'){
                    if (typeof o.openedClass != 'undefined'){
                        openedClass = o.openedClass;
                    }
                    if (typeof o.closedClass != 'undefined'){
                        closedClass = o.closedClass;
                    }
                };


                var tree = $(this);
                tree.addClass("tree");
                tree.find('li').has("ul").each(function () {
                    var branch = $(this);
                    branch.prepend("");
                    branch.addClass('branch');
                    branch.on('click', function (e) {
                        if (this == e.target) {
                            var icon = $(this).children('i:first');
                            icon.toggleClass(openedClass + " " + closedClass);
                            $(this).children().children().toggle();
                        }
                    })
                    branch.children().children().toggle();
                });

                tree.find('.branch .indicator').each(function(){
                    $(this).on('click', function () {
                        $(this).closest('li').click();
                    });
                });

                tree.find('.branch>a').each(function () {
                    $(this).on('click', function (e) {
                        $(this).closest('li').click();
                        e.preventDefault();
                    });
                });

                tree.find('.branch>button').each(function () {
                    $(this).on('click', function (e) {
                        $(this).closest('li').click();
                        e.preventDefault();
                    });
                });
            }
        });

        $('#tree1').treed();


    </script>







@endpush


