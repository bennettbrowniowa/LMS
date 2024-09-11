@extends('Backend.main')

@section('content')

    <style>
        .select2-container--default .select2-selection--single, .select2-selection .select2-selection--single {
            padding: 6px 0px !important;
        }

        .controls {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: #fff;
            z-index: 1;
            padding: 6px 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
        }

        /* Style for the tree view container */
        .treeview {
            margin-top: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            height: 100%;
            overflow-y: scroll;
            max-height: 300px;
            white-space: nowrap;
            width: 100%;
        }

        /* Style for the goal item */
        .goal-item {
            margin-bottom: 5px;
        }

        /* Style for the subgoal item */
        .subgoal-item {
            margin-left: 20px; /* Indent subgoals */
            margin-bottom: 3px;
        }

        /* Style for the checkbox */
        .goal-checkbox {
            margin-right: 5px;
        }

        /* Style for the hover effect */
        .goal-item:hover .subgoals,
        .subgoal-item:hover .subgoals {
            display: block;
        }

        /* Style for the collapse/expand button */
        .collapse-expand-btn {
            margin-left: 10px;
        }

        /* Style for the buttons */
        .button-container {
            margin-top: 10px;
        }

        /* Style for the modal footer buttons */
        .modal-footer-btns {
            float: right;
            margin-top: 10px;
        }

        .subgoals {
            display: none;
        }
        .goal-item:hover .subgoals,
        .subgoal-item:hover .subgoals {
            display: block;
        }




        .treeview div input {
            margin-right: 6px;
        }

        .treeview div div ul li {
            list-style-type: none;
        }

        .nk_btn_1 {
            background-color: #4144bb !important;
            color: white !important;
            border: 1px solid #4144bb !important;
        }


        .badge {
            padding: 7px 9px;
            width: fit-content;
            margin-bottom: 5px;
            background-color: #44ddd4;
        }
        .btn-success{
            background-color: #4144bb !important;

        }
        .btn-success:focus{
            background-color: #4144bb !important;
            border: none;
            outline: none;

        }
        .nk_new_modal {
            height: auto;
            width: 100%;
            overflow-y: scroll;
            white-space: nowrap;
            max-height: 300px;
            max-width: 1200px;
        }
        .resource-type-checkbox {
            margin-right: 10px !important;
        }
        .pedagogy-tag-checkbox {
            margin-right: 10px !important;
        }
        #selectAllPedagogyTags{
            margin-right: 10px !important;
        }
        /*#selectAllResourceTags{*/
        /*    margin-right: 10px !important;*/
        /*}*/
        .modal_td_1 {
            border: 0px !important;
            border-top: 0px !important;
        }
        .modal_tr_1 {
            border: 0px !important;
            border-top: 0px !important;
        }
        .modal-footer {
            border: 0px !important;
        }
        button.btn.btn-primary.btn-sm {
            margin-bottom: 15px;
        }

        .fa-chevron {
            color: #369;
        }
        .goal-item .fa-chevron {
            color: #369;
        }

        .fa-chevron-right {
            color: #369;
        }

        .fa-chevron-down {
            color: #369;
        }
        .learning-activity {
            overflow: hidden;
            text-overflow: ellipsis;
            padding: 5px;
            width: 500px;
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
        .file-list {
            margin-top: 10px;
        }
        .file-list ul {
            list-style-type: none;
            padding: 0;
        }
        .file-item {
            margin-bottom: 5px;
        }
        .download-link {
            margin-left: 10px;
            color: #007bff;
            text-decoration: none;
        }
        .download-link:hover {
            text-decoration: underline;
        }
        .fa-download {
            margin-right: 5px;
        }


        .file-list {
             margin-top: 10px;
         }
        .file-list ul {
            list-style-type: none;
            padding: 0;
        }
        .file-item {
            margin-bottom: 5px;
        }
        .download-link {
            margin-left: 10px;
            color: #007bff;
            text-decoration: none;
        }
        .download-link:hover {
            text-decoration: underline;
        }
        .fa-download {
            margin-right: 5px;
        }
        .modal-body .file-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #cdcdcd;
            border-radius: 4px;
            width: fit-content;
        }

        .modal-body .file-item .file-name {
            margin-right: 10px;
        }


        .view-files {
            display: inline-flex;
            align-items: center;
            padding: 5px 6px;
            margin-left: 0px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }


        .view-files .fa-file {
            margin-right: 5px;
        }

        .view-files:hover {
            background-color: #0056b3;
        }


        #courseModal .modal-dialog {
            max-width: 800px;

        }

        #courseModal .modal-content {
            max-height: 500px;
            overflow-y: auto;
        }

        #courseModal .modal-body {
            padding: 1rem;
        }

        #courseModal .modal-header,
        #courseModal .modal-footer {
            padding: 0.5rem 1rem;
        }
        #courseModal .modal-title {
            font-size: 1.25rem;
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
                    <h2>Learning Engagement</h2>

                    <div class="box-tools">

                        <a href="javascript:void(0);" id="buildCourseButton" class="btn btn-primary btn-flat">
                            <i class="fa fa-book"></i> Build Course
                        </a>
                        <a href="javascript:void(0);" class="btn btn-primary btn-flat" id="aggregateButton">
                            <i class="fa fa-tasks"></i> Aggregate
                        </a>
                        <a href="javascript:void(0);" id="createButton" class="btn btn-primary btn-flat" style="display: none;">
                            <i class="fa fa-check-circle"></i> Create
                        </a>

                        <a href="javascript:void(0);"  id="addButton" class="btn btn-primary btn-flat" data-act="ajax-modal" data-title="Add Learning Engagement" data-append-id="AjaxModelContent"  data-action-url="{{ route("addLearningSequence") }}">
                            <i class="fa fa-plus-circle"></i> Add
                        </a>
                    </div>
                </div>

                <div class="box-body table-responsive">
                    <table id="Datatable" class="table table-striped">
                        <thead>
                        <tr>
                            <th></th>
                            <th>ID</th>
                            <th>Learning Activity</th>
                            <th>Pedagogy Tools</th>
                            <th>Resource Types</th>
                            <th>Goals</th>
                            <th style="width: 80px; text-align: center;">Action</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th></th>
                            <th>ID</th>
                            <th>Learning Activity</th>
                            <th>Pedagogy Tools</th>
                            <th >Resource Types</th>
                            <th>Goals</th>
                            <th style="width: 80px; text-align: center;">Action</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </section>
    </div>


    <div class="modal fade" id="addGoalModal" tabindex="-1" role="dialog" aria-labelledby="addGoalModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="addGoalModalLabel">Assign Goal</h4>
                </div>
                <div class="modal-body">
                    <button type="button" class="btn btn-default collapse-all-btn nk_btn_1">Collapse All</button>
                    <button type="button" class="btn btn-default expand-all-btn nk_btn_1">Expand All</button>
                    <button type="button" class="btn btn-primary check-all-btn nk_btn_1">Check All</button>
                    <button type="button" class="btn btn-primary uncheck-all-btn nk_btn_1">Uncheck All</button>
                    <div class="treeview">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary save-button nk_btn_1">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="splitModal" tabindex="-1" role="dialog" aria-labelledby="splitModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><span id="splitModalLabel">Split Description</span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="splitForm">
                        <div class="form-group">
                            <label for="contentToSplit" class="col-form-label">Description<span class="requiredAsterisk">*</span></label>
                            <textarea class="form-control" id="contentToSplit" rows="6" cols="6"></textarea>
                            <input type="hidden" id="sequenceId" value="">
                            <input type="hidden" id="parentGoalIds" value="">
                            <input type="hidden" id="pedagogyTags">
                            <input type="hidden" id="resourceTags">
                            <input type="hidden" id="contentType">

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="submitSplit()">Split</button>
                </div>
            </div>
        </div>
    </div>

    <div id="aggregateModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="aggregatedSequenceForm">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Create New Aggregated Learning Sequence</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="aggregatedTitle">Title<span class="requiredAsterisk">*</span></label>
                            <input type="text" id="aggregatedTitle" name="aggregatedTitle" class="validate[required] form-control" placeholder="Enter Aggregate Title">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="createAggregatedSequence">Create Aggregate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="pedagogyTagsModal" tabindex="-1" role="dialog" aria-labelledby="pedagogyTagsModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pedagogyTagsModalLabel">Pedagogy Tags</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="pedagogyTagsContainer">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="selectAllPedagogyTags">
                        <label class="form-check-label" for="selectAllPedagogyTags">Select All</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="savePedagogyTags">Save</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="resourceTypesModal" tabindex="-1" role="dialog" aria-labelledby="resourceTypesModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="resourceTypesModalLabel">Resource Types</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="resourceTypesContainer">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="selectAllResourceTags">
                        <label class="form-check-label" for="selectAllResourceTags">Select All</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveResourceTypes">Save</button>

                </div>
            </div>
        </div>
    </div>
    <!-- Modal Structure -->
    <div id="fileModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Files</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>




    <!-- Modal for course details -->
    <div id="courseModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Enter Course Name</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="courseTitle">Course Name:</label>
                        <input type="text" class="form-control" id="courseTitle" placeholder="Enter course Name" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="saveCourseButton">Save Course</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>




@endsection

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>

    <script type="text/javascript">

        jQuery("#aggregatedSequenceForm").validationEngine({promptPosition: 'inline'});
        var learningSequenceId;

        $('.modal-body').slimScroll({ height: '370px' });

        var dataTable = $('#Datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('allLearningSequenceDatatable') }}',
                columns: [
                    {
                        data: null,
                        name: 'checkbox',
                        orderable: false,
                        searchable: false,
                        render: function (data, type, full, meta) {
                            return '<input type="checkbox" class="learning-sequence-checkbox" data-sequence-id="' + full.id + '"  data-sequence-title="' + full.title + '"  data-sequence-description="' + full.description + '" data-content-type="' + full.content_type + '" style="display: none;">';
                        }
                    },
                    { data: 'id', name: 'id', visible: false },

                    {
                        data: null,
                        name: 'learning_activity',
                        render: function (data, type, full, meta) {
                            if (type === 'display') {
                                var output = '<strong class="activity-title">' + full.title + '</strong>';
                                if (full.content_type === 'html' || full.content_type === 'qti' || full.content_type === 'md' || full.content_type === 'js') {

                                    return '<div class="learning-activity">' + output + '</div>';
                                } else {

                                    output += '<br><span class="activity-description ">' + full.description + '</span>';
                                    return '<div class="learning-activity">' + output + '</div>';
                                }
                            } else {
                                return full.description;
                            }
                        }
                    },

                    {
                        data: 'pedagogy_titles',
                        name: 'pedagogy_titles',
                        render: function (data, type, full, meta) {
                            var pedagogyTagsInput = '<input type="hidden" class="pedagogyTagsHidden" data-sequence-id="' + full.id + '" value="' + data + '">';
                            var openModalButton = '<button type="button" class="btn btn-primary btn-sm openPedagogyTagsModal" style="outline: none;" data-sequence-id="' + full.id + '">Add</button>';
                            var pedagogyTags = data ? data.split(',') : [];
                            var badges = '';
                            pedagogyTags.forEach(function (tag) {
                                var parts = tag.split(':');
                                var tagID = parts[0];
                                var tagTitle = parts[1];
                                var displayedTag = tagTitle.length > 15 ? tagTitle.substring(0, 15) + '...' : tagTitle;
                                badges += '<span class="badge badge-info" data-toggle="tooltip" data-placement="top" title="' + tagTitle + '" data-tag-id="' + tagID + '">' + displayedTag + '</span>&nbsp;';
                            });
                            return pedagogyTagsInput + openModalButton + '<div style="margin-top: 1px;">' + badges + '</div>';
                        }
                    },
                    {
                        data: 'resource_titles',
                        name: 'resource_titles',
                        render: function (data, type, full, meta) {
                            var resourceTagsInput = '<input type="hidden" class="resourceTagsHidden" data-sequence-id="' + full.id + '" value="' + data + '">';
                            var openModalButton = '<button type="button" class="btn btn-primary btn-sm openResourceTypesModal" style="outline: none;" data-sequence-id="' + full.id + '">Add</button>';
                            var resourceTags = data ? data.split(',') : [];
                            var badges = '';
                            resourceTags.forEach(function (tag) {
                                var parts = tag.split(':');
                                var tagID = parts[0];
                                var tagTitle = parts[1];
                                var displayedTag = tagTitle.length > 15 ? tagTitle.substring(0, 15) + '...' : tagTitle;
                                badges += '<span class="badge badge-primary" data-toggle="tooltip" data-placement="top" title="' + tagTitle + '" data-tag-id="' + tagID + '">' + displayedTag + '</span>&nbsp;';
                            });
                            return resourceTagsInput + openModalButton + '<div style="margin-top: 1px;">' + badges + '</div>';
                        }
                    },
                    {
                        data: 'assigned_goals',
                        name: 'assigned_goals',
                        render: function (data, type, full, meta) {
                            var editGoalsButton = '<button type="button" class="btn btn-success btn-sm addGoalButton" data-learning-sequence-id="' + full.id + '">Edit Goals</button>';

                            var assignedGoals = full.assigned_goals ? full.assigned_goals.split(',') : [];

                            var goalsHtml = '';
                            assignedGoals.forEach(function (goal) {

                                var trimmedGoal = goal.trim();
                                var displayText = trimmedGoal.length > 15 ? trimmedGoal.substring(0, 15) + '...' : trimmedGoal;
                                goalsHtml += `<span class="badge assigned-goals" data-toggle="tooltip" data-placement="top" title="${trimmedGoal}" style="white-space: normal;">${displayText}</span>&nbsp;`;
                            });
                            return editGoalsButton + '<div style="margin-top: 5px;">' + goalsHtml + '</div>';
                        }
                    },

                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '0px',
                        height: '0px'
                    }
                ],
                initComplete: function () {
                    var table = this;
                    table.api().columns().every(function () {
                        var column = this;
                        $('input', column.footer()).on('keyup change', function () {
                            if (column.search() !== this.value) {
                                column.search(this.value).draw();
                            }
                        });
                    });
                },
                pageLength: {{ AppSetting::getRowsPerPage() }},
                drawCallback: function (settings) {
                    $('[data-toggle="tooltip"]').tooltip();
                    $('.magnific-image').magnificPopup({ type: 'image' });
                }
            });

        $(document).ready(function () {
            var selectedActivities = [];
            var checkboxesVisible = false;

            function hideCheckboxes() {
                $('.learning-sequence-checkbox').hide();
            }


            $('#Datatable').on('change', '.learning-sequence-checkbox', function () {
                var sequenceId = $(this).data('sequence-id');
                var title = $(this).data('sequence-title');
                var description = $(this).data('sequence-description');
                var contentType = $(this).data('content-type');
                if ($(this).is(':checked')) {
                    selectedActivities.push({
                        sequenceId: sequenceId,
                        title: title,
                        description: description,
                        content_type: contentType
                    });
                } else {
                    selectedActivities = selectedActivities.filter(function (activity) {
                        return activity.sequenceId !== sequenceId;
                    });
                }
            });


            $('#buildCourseButton').click(function () {
                if (!checkboxesVisible) {
                    showCheckboxes();
                    checkboxesVisible = true;
                } else {
                    if (selectedActivities.length < 2) {
                        toastr.error('Please select at least two learning engagements to build a course.');
                        return;
                    }

                    $('#courseModal').modal('show');


                }
            });


            $('#saveCourseButton').click(function () {
                var courseTitle = $('#courseTitle').val();

                if (!courseTitle) {
                    toastr.error('Please Enter Course Name');
                    return;
                }

                $.ajax({
                    url: '{{ route('build_course') }}',
                    method: 'POST',
                    data: {
                        title: courseTitle,
                        activities: selectedActivities,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        if (response.success) {
                            toastr.success(response.message);
                            setTimeout(function () {
                                window.location.href = '{{ route('instructor_dashboard') }}';
                            }, 1000);
                        } else {
                            toastr.error('Failed to build course: ' + response.message);
                        }
                    }
                });
            });


            $('#Datatable').on('draw.dt', function () {
                if (checkboxesVisible) {
                    showCheckboxes();
                } else {
                    hideCheckboxes();
                }
            });
        });

        $(document).on('click', '.view-files', function () {
            var filenames = $(this).data('filenames');

            if (filenames) {
                var filenamesArray = filenames.split(',');
                var filesListHtml = '';

                filenamesArray.forEach(function(filename) {
                    var filenameOnly = filename.split('.').slice(1).join('.').split('/').pop();
                    var downloadUrl = '{{ route("download_file", ["filename" => ":filename"]) }}'.replace(':filename', encodeURIComponent(filename.split('/').pop()));
                    filesListHtml += '<div class="file-item">';
                    filesListHtml += '<span class="file-name">' + filenameOnly + '</span>';
                    filesListHtml += '<a href="' + downloadUrl + '"><i class="fa fa-download"></i></a>';
                    filesListHtml += '</div>';
                });

                $('#fileModal .modal-body').html(filesListHtml);
            } else {
                $('#fileModal .modal-body').html('<div class="text-center"><p>No documents found.</p></div>');
            }
        });

        var oldOrder = [];

        var tbody = dataTable.table().body();
        Sortable.create(tbody, {
            animation: 150,
            direction: 'vertical',
            onStart: function(evt) {
                oldOrder = [];
                $(tbody).find('tr').each(function(index, row) {
                    var full = dataTable.row(row).data();
                    var itemId = full.id;
                    oldOrder.push(itemId);
                });
            },
            onEnd: function(evt) {
                var newOrder = [];

                $(tbody).find('tr').each(function(index, row) {
                    var full = dataTable.row(row).data();
                    var itemId = full.id;
                    newOrder.push(itemId);
                });


                var isOrderChanged = !arraysEqual(oldOrder, newOrder);

                if (isOrderChanged) {
                    $.ajax({
                        url: '{{ route('updateOrder') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            newOrder: newOrder
                        },
                        success: function(response) {
                            toastr.success('Order updated successfully!');
                        },
                        error: function(xhr, status, error) {
                            toastr.error('An error occurred while updating order.');
                        }
                    });
                }
            }
        });


        function arraysEqual(arr1, arr2) {
            if (arr1.length !== arr2.length) return false;
            for (var i = 0; i < arr1.length; i++) {
                if (arr1[i] !== arr2[i]) return false;
            }
            return true;
        }

        $('.learning-sequence-checkbox').change(function() {
            var checkedCount = $('.learning-sequence-checkbox:checked').length;
            if (checkedCount > 0) {
                $('#createButton').show();
            } else {
                $('#createButton').hide();
                $('#aggregateButton').show();
            }
        });

        $('#createButton').click(function() {
            var selectedSequences = $('.learning-sequence-checkbox:checked');
            if (selectedSequences.length < 2) {
                toastr.error('Please select at least two learning sequences for aggregation.');
                return;
            }
            $('#aggregateModal').modal('show');
        });

        $('#createAggregatedSequence').click(function(event) {
            event.preventDefault();
            if (!$("#aggregatedSequenceForm").validationEngine('validate')) {
                return false;
            }
            var title = $('#aggregatedTitle').val().trim();

            var selectedSequenceIds = $('.learning-sequence-checkbox:checked').map(function() {
                return $(this).data('sequence-id');
            }).get();

            var promises = selectedSequenceIds.map(function(sequenceId) {
                return fetchSequenceData(sequenceId);
            });



            Promise.all(promises)
                .then(function(sequences) {
                    aggregateSequences(sequences, title, selectedSequenceIds);
                })
                .catch(function(error) {

                    toastr.error('Error fetching sequence data. Please try again.');
                });
        });

        function fetchSequenceData(sequenceId) {
            return new Promise(function(resolve, reject) {
                $.ajax({
                    url: '{{ route("fetch_sequence_data", ["id" => ":sequenceId"]) }}'.replace(':sequenceId', sequenceId),
                    method: 'GET',
                    success: function(response) {

                        resolve(response.data);
                    },
                    error: function(xhr, status, error) {
                        reject(error);
                    }
                });
            });
        }
        function aggregateSequences(sequences, title, selectedSequenceIds) {
            var description = sequences.map(seq => seq.description).join(' ');
            var goals = [];
            var pedagogyTags = [];
            var resourceTags = [];
            var fileData = [];


            sequences.forEach(function(sequence) {
                goals = [...new Set([...goals, ...sequence.goals])];
                pedagogyTags = [...new Set([...pedagogyTags, ...sequence.pedagogyTags])];
                resourceTags = [...new Set([...resourceTags, ...sequence.resourceTags])];

                if (sequence.fileData && sequence.fileData.length > 0) {
                    sequence.fileData.forEach(function(file) {
                        fileData.push({
                            filename: file.filename,
                            url: file.url,
                            learningSequenceId: file.learningSequenceId,
                            userId: file.userId
                        });
                    });
                }
            });


            var aggregatedSequence = {
                title: title !== '' ? title : '<aggregate>',
                description: description,
                goals: goals,
                pedagogyTags: pedagogyTags,
                resourceTags: resourceTags,
                fileData: fileData,
                selectedSequences: selectedSequenceIds
            };

            saveAggregatedSequence(aggregatedSequence);
        }


        function saveAggregatedSequence(sequence) {

            $.ajax({
                url: '{{ route('create_aggregated_sequence') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    title: sequence.title,
                    description: sequence.description,
                    goals: sequence.goals,
                    pedagogyTags: sequence.pedagogyTags,
                    resourceTags: sequence.resourceTags,
                    fileData: sequence.fileData,
                    selectedSequences: sequence.selectedSequences


                },
                success: function(response) {
                    toastr.success(response.message);
                    window.location.reload();
                },
                error: function(xhr, status, error) {
                    toastr.error('Error saving aggregated sequence. Please try again.');
                }
            });
        }

        function showCheckboxes() {
            $('.learning-sequence-checkbox').show();
        }

        $(document).ready(function () {
            $('.learning-sequence-checkbox').hide();
            $('#aggregateButton').click(function() {
                showCheckboxes();
                $(this).hide();
                $('#createButton').show();
            });


            function stripTags(html) {
                return html.replace(/<[^>]*>?/gm, '');
            }
            $(document).on('click', '.splitButton', function() {
                var description = $(this).data('description');
                var id = $(this).data('id');
                var parentGoalIds = $(this).data('parent-goal-ids');
                var contentType = $(this).data('content-type');


                var strippedDescription = stripTags(description);

                var pedagogyIds = $('.pedagogyTagsHidden[data-sequence-id="' + id + '"]').val().split(',').map(function(item) {
                    return item.split(':')[0];
                }).join(',');

                var resourceIds = $('.resourceTagsHidden[data-sequence-id="' + id + '"]').val().split(',').map(function(item) {
                    return item.split(':')[0];
                }).join(',');


                var modalTitle = 'Split Description';
                var modalMessage = '';
                if (contentType === 'qti' || contentType === 'js' || contentType === 'html') {
                    modalMessage = 'You cannot split this content.';
                } else if (contentType === 'txt' || contentType === 'md') {
                    modalMessage = 'Please insert "-^|^-" where you want to split the description.';
                }
                if (contentType === 'qti') {
                    modalTitle += ' (QTI)';
                    strippedDescription = '';
                } else if (contentType === 'md') {
                    modalTitle += ' (Markdown)';
                } else if (contentType === 'js') {
                    modalTitle += ' (JavaScript)';
                    strippedDescription = '';
                } else if (contentType === 'txt') {
                    modalTitle += ' (Text)';

                } else if (contentType === 'html') {
                    modalTitle += ' (HTML)';
                    strippedDescription = '';
                }

                $('#contentToSplit').val(strippedDescription);
                $('#sequenceId').val(id);
                $('#parentGoalIds').val(parentGoalIds);
                $('#pedagogyTags').val(pedagogyIds);
                $('#resourceTags').val(resourceIds);
                $('#contentType').val(contentType);
                $('#splitModalLabel').text(modalTitle + ': ' + modalMessage);
                $('#splitModal').modal('show');
            });

            window.submitSplit = function() {
                var id = $('#sequenceId').val();
                var description = $('#contentToSplit').val();
                var parentGoalIds = $('#parentGoalIds').val();
                var pedagogyIds = $('#pedagogyTags').val();
                var resourceIds = $('#resourceTags').val();
                var contentType = $('#contentType').val();

                if (contentType !== 'txt') {
                    toastr.warning('Splitting for ' + contentType + ' content type is not supported.');
                    return;
                }


                if (description.trim() === '') {
                    toastr.error('Please enter a description before splitting.');
                    return;
                }
                if (description.indexOf('-^|^-') === -1) {
                    toastr.error('Please insert the "-^|^-" symbol to indicate where you want to split the description.');
                    return;
                }

                $.ajax({
                    url: '{{ route('split_description') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id,
                        description: description,
                        parent_goal_ids: parentGoalIds,
                        pedagogy_tags: pedagogyIds,
                        resource_tags: resourceIds
                    },
                    success: function(response) {
                        toastr.success(response.message);
                        $('#Datatable').DataTable().ajax.reload();
                        $('#splitModal').modal('hide');
                    },
                    error: function(xhr, status, error) {
                        toastr.error('Error during split operation');
                    }
                });
            };
            $('#splitModal').on('hidden.bs.modal', function () {
                $('#contentToSplit').val('');
                $('#sequenceId').val('');
            });


        });
        $(document).ready(function() {
            $('#savePedagogyTags').on('click', function() {
                var learningSequenceId =  $(this).data('sequence-id');
                var selectedTags = [];
                $('.pedagogy-tag-checkbox:checked').each(function() {
                    selectedTags.push($(this).val());
                });

                if (selectedTags.length === 0) {
                    toastr.error('Please select at least one pedagogy tag.');
                    return;
                }

                $.ajax({
                    url: '{{route('store_pedagogy_tags')}}',

                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        pedagogyTags: selectedTags,
                        learningSequenceId: learningSequenceId,
                    },
                    success: function(response) {
                        toastr.success(response.message);
                        setTimeout(function() {
                            $('#pedagogyTagsModal').modal('hide');
                            window.location.reload();
                        }, 1000);

                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.error;
                            var errorMessages = Object.values(errors).map(function(err) {
                                return err.join('<br>');
                            }).join('<br>');
                            toastr.error('Validation Error: ' + errorMessages);
                        } else {
                            toastr.error('Error: ' + xhr.responseJSON.error);
                        }
                    }
                });
            });

            $('#saveResourceTypes').on('click', function() {
                var learningSequenceId =  $(this).data('sequence-id');
                var selectedTypes = [];
                $('.resource-type-checkbox:checked').each(function() {
                    selectedTypes.push($(this).val());
                });

                if (selectedTypes.length === 0) {
                    toastr.error('Please select at least one resource type.');
                    return;
                }

                $.ajax({
                    url: '{{route('storeResourceTypes')}}',

                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        resourceTypes: selectedTypes,
                        learningSequenceId: learningSequenceId,
                    },
                    success: function(response) {
                        toastr.success(response.message);
                        setTimeout(function() {
                            $('#resourceTypesModal').modal('hide');
                            window.location.reload();
                        }, 1000);

                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.error;
                            var errorMessages = Object.values(errors).map(function(err) {
                                return err.join('<br>');
                            }).join('<br>');
                            toastr.error('Validation Error: ' + errorMessages);
                        } else {
                            toastr.error('Error: ' + xhr.responseJSON.error);
                        }
                    }
                });
            });
        });

        $(document).ready(function() {
            $(document).on('change', '#selectAllPedagogyTags', function() {
                $('.pedagogy-tag-checkbox').prop('checked', $(this).prop('checked'));
            });


            $(document).on('change', '.pedagogy-tag-checkbox', function() {
                var allChecked = $('.pedagogy-tag-checkbox:checked').length === $('.pedagogy-tag-checkbox').length;
                $('#selectAllPedagogyTags').prop('checked', allChecked);
            });


            $(document).on('change', '#selectAllResourceTypes', function() {
                $('.resource-type-checkbox').prop('checked', $(this).prop('checked'));
            });

            $(document).on('change', '.resource-type-checkbox', function() {
                var allChecked = $('.resource-type-checkbox:checked').length === $('.resource-type-checkbox').length;
                $('#selectAllResourceTypes').prop('checked', allChecked);
            });

            $(document).on('click', '.openPedagogyTagsModal', function() {
                var learningSequenceId = $(this).data('sequence-id');

                $.get('{{ route('open_pedagogy_tags_modal') }}', { learningSequenceId: learningSequenceId }, function(data) {
                    var pedagogyTags = data.pedagogyTags;
                    var assignedPedagogyTags = data.assignedPedagogyTags || [];

                    var tagsContainer = $('#pedagogyTagsContainer');
                    tagsContainer.empty();

                    pedagogyTags.forEach(function (tag) {
                        var checked = assignedPedagogyTags.some(function (assignedTag) {
                            return assignedTag.id === tag.id;
                        }) ? 'checked' : '';
                        var checkboxHTML = '<div><input type="checkbox" class="pedagogy-tag-checkbox" value="' + tag.id + '" ' + checked + '> ' + tag.title + '</div>';
                        tagsContainer.append(checkboxHTML);
                    });


                    var selectAllCheckbox = $('<input type="checkbox" class="form-check-input" id="selectAllPedagogyTags">');
                    var selectAllLabel = $('<label class="form-check-label" for="selectAllPedagogyTags">Select All</label>');
                    var selectAllContainer = $('<div class="form-check"></div>').append(selectAllCheckbox).append(selectAllLabel);
                    tagsContainer.prepend(selectAllContainer);


                    if ($('.pedagogy-tag-checkbox:checked').length === pedagogyTags.length) {
                        selectAllCheckbox.prop('checked', true);
                    }
                    $('#savePedagogyTags').data('sequence-id', learningSequenceId);

                    $('#pedagogyTagsModal').modal('show');
                });
            });

            $(document).on('click', '.openResourceTypesModal', function() {
                var learningSequenceId = $(this).data('sequence-id');

                $.get('{{ route('open_resource_types_modal') }}', { learningSequenceId: learningSequenceId }, function(data) {
                    var resourceTypes = data.resourceTypes;
                    var assignedResourceTypes = data.assignedResourceTypes || [];

                    var tagsContainer = $('#resourceTypesContainer');
                    tagsContainer.empty();

                    resourceTypes.forEach(function (type) {
                        var checked = assignedResourceTypes.some(function (assignedType) {
                            return assignedType.id === type.id;
                        }) ? 'checked' : '';
                        var checkboxHTML = '<div><input type="checkbox" class="resource-type-checkbox" value="' + type.id + '" ' + checked + '> ' + type.title + '</div>';
                        tagsContainer.append(checkboxHTML);
                    });

                    var selectAllCheckbox = $('<input type="checkbox" class="form-check-input" id="selectAllResourceTypes">');
                    var selectAllLabel = $('<label class="form-check-label" for="selectAllResourceTypes" style="margin-left: 10px;">Select All</label>');
                    var selectAllContainer = $('<div class="form-check"></div>').append(selectAllCheckbox).append(selectAllLabel);
                    tagsContainer.prepend(selectAllContainer);

                    if ($('.resource-type-checkbox:checked').length === resourceTypes.length) {
                        selectAllCheckbox.prop('checked', true);
                    }

                    $('#saveResourceTypes').data('sequence-id', learningSequenceId);
                    $('#resourceTypesModal').modal('show');
                });
            });

        });


        $(document).ready(function() {
            var learningSequenceId = null;
            fetchGoalHierarchy(learningSequenceId);

            $('#addGoalModal').on('click', '.collapse-all-btn', function() {
                $('#addGoalModal .subgoals-dropdown').slideUp();
                $('#addGoalModal .fa-chevron-down').removeClass('fa-chevron-down').addClass('fa-chevron-right');
            });

            $('#addGoalModal').on('click', '.expand-all-btn', function() {
                $('#addGoalModal .subgoals-dropdown').slideDown();
                $('#addGoalModal .fa-chevron-right').removeClass('fa-chevron-right').addClass('fa-chevron-down');
            });

            $('#addGoalModal').on('click', '.check-all-btn', function() {
                $('#addGoalModal input[type="checkbox"]').prop('checked', true);
                $('#addGoalModal .subgoals-dropdown').slideDown();
                $('#addGoalModal .fa-chevron-right').removeClass('fa-chevron-right').addClass('fa-chevron-down');
            });


            $('#addGoalModal').on('click', '.uncheck-all-btn', function() {
                $('#addGoalModal input[type="checkbox"]').prop('checked', false);
                $('#addGoalModal .subgoals-dropdown').slideUp();
                $('#addGoalModal .fa-chevron-down').removeClass('fa-chevron-down').addClass('fa-chevron-right');
            });


            $('#addGoalModal').on('change', '.goal-checkbox', function() {
                var subgoalsDropdown = $(this).siblings('.subgoals-dropdown');
                var hasCheckedSubgoal = subgoalsDropdown.find('.goal-checkbox:checked').length > 0;

                if ($(this).is(':checked')) {
                    subgoalsDropdown.slideDown();
                    subgoalsDropdown.find('.goal-checkbox').prop('checked', true);
                    $(this).siblings('.fa-chevron-right').removeClass('fa-chevron-right').addClass('fa-chevron-down');
                } else {
                    if (subgoalsDropdown.find('.goal-checkbox').length > 0 && !hasCheckedSubgoal) {
                        subgoalsDropdown.siblings('.chevron').addClass('fa fa-chevron-right').removeClass('fa-chevron-down');
                    }
                    subgoalsDropdown.slideUp();
                    subgoalsDropdown.find('.goal-checkbox').prop('checked', false);
                    $(this).siblings('.fa-chevron-down').removeClass('fa-chevron-down').addClass('fa-chevron-right');
                }
            });


            $('#addGoalModal').on('shown.bs.modal', function() {
                $('#addGoalModal .treeview input[type="checkbox"]:checked').each(function() {
                    var subgoalsDropdown = $(this).siblings('.subgoals-dropdown');
                    subgoalsDropdown.slideDown();
                });
            });


            $(document).on('click', '.addGoalButton', function() {
                learningSequenceId = $(this).data('learning-sequence-id');
                fetchGoalHierarchy(learningSequenceId);
                $('#addGoalModal input[type="checkbox"]').prop('checked', false);

                $.ajax({
                    url: '{{ route('get_goal') }}',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        learningSequenceId: learningSequenceId
                    },
                    success: function(response) {
                        if (response.success) {
                            response.goals.forEach(function(goalId) {
                                $('#addGoalModal input[type="checkbox"][value="' + goalId + '"]').prop('checked', true);
                            });
                        } else {
                            toastr.error('Failed to fetch assigned goals.');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        toastr.error('Error occurred while fetching assigned goals.');
                    }
                });
                $('#addGoalModal').modal('show');

                $('#addGoalModal').off('click', '.save-button').on('click', '.save-button', function() {
                    var selectedGoals = [];
                    $('#addGoalModal input[type="checkbox"]:checked').each(function() {
                        selectedGoals.push($(this).val());
                    });

                    $.ajax({
                        url: '{{ route('assign_goals_to_learning_sequence') }}',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            _token: '{{ csrf_token() }}',
                            learningSequenceId: learningSequenceId,
                            selectedGoals: selectedGoals
                        },
                        success: function(response) {
                            if (response.success) {
                                toastr.success('Goals assigned to learning sequence successfully.');
                                setTimeout(function() {
                                    $('#addGoalModal').modal('hide');
                                    window.location.reload();
                                }, 1000);
                            } else {
                                toastr.error(response.errors ? response.errors.join(', ') : 'An error occurred.');
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            toastr.error('Error occurred while assigning goals to learning sequence.');
                        }
                    });
                });
            });
        });


        function fetchGoalHierarchy(learningSequenceId) {
            $.ajax({
                url: '{{ route('get_goal_hierarchy') }}',
                type: 'GET',
                dataType: 'json',
                data: {
                    learningSequenceId: learningSequenceId
                },
                success: function(data) {
                    renderTree(data.goals, data.assignedGoals);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error fetching goal hierarchy:', errorThrown);
                }
            });
        }


        function renderTree(goals, assignedGoals) {
            var treeView = $('#addGoalModal .treeview');
            treeView.empty();
            if (assignedGoals === undefined || assignedGoals === null) {
                assignedGoals = [];
            }
            goals.forEach(function(goal) {
                renderGoal(goal, treeView, assignedGoals);
            });
        }


        function renderGoal(goal, parentContainer, assignedGoals, expand = false) {
            var goalItem = $('<div>').addClass('goal-item').appendTo(parentContainer);
            var checkbox = $('<input>').attr({
                type: 'checkbox',
                class: 'goal-checkbox',
                value: goal.id
            }).appendTo(goalItem);
            $('<label>').text(goal.title).appendTo(goalItem);

            var isAssigned = assignedGoals.includes(goal.id);

            var anySubgoalsAssigned = goal.subGoals.some(function(subGoal) {
                return assignedGoals.includes(subGoal.id);
            });

            var hasSubgoals = goal.subGoals && goal.subGoals.length > 0;

            var isGoalChecked = assignedGoals.includes(goal.id);

            var chevronClass = (anySubgoalsAssigned || expand || isGoalChecked) && hasSubgoals ? 'fa-chevron-down' : 'fa-chevron-right';
            var subGoalsDropdownDisplay = (anySubgoalsAssigned || expand || isGoalChecked) && hasSubgoals ? 'block' : 'none';

            if (hasSubgoals) {
                var chevron = $('<i>').addClass('fa').addClass('chevron').addClass(chevronClass).appendTo(goalItem);
            }

            var subGoalsDropdown = $('<div>').addClass('subgoals-dropdown').css('display', subGoalsDropdownDisplay).appendTo(goalItem);

            if (hasSubgoals) {
                var subGoalsList = $('<ul>').appendTo(subGoalsDropdown);
                goal.subGoals.forEach(function(subGoal) {
                    renderGoal(subGoal, subGoalsList, assignedGoals, expand && isAssigned);
                });

                chevron.on('click', function() {
                    if ($(this).hasClass('fa-chevron-right')) {
                        $(this).removeClass('fa-chevron-right').addClass('fa-chevron-down');
                        subGoalsDropdown.slideDown();
                    } else {
                        $(this).removeClass('fa-chevron-down').addClass('fa-chevron-right');
                        subGoalsDropdown.slideUp();
                    }
                });
            }

            checkbox.on('change', function() {
                var isChecked = $(this).prop('checked');
                var subgoalsDropdown = $(this).siblings('.subgoals-dropdown');

                if (isChecked) {
                    subgoalsDropdown.slideDown();

                    setTimeout(function() {
                        subgoalsDropdown.find('.goal-checkbox').prop('checked', false);
                    }, 100);
                } else {
                    subgoalsDropdown.slideUp();
                }
            });

            if (isAssigned) {
                checkbox.prop('checked', true);
            }
        }

    </script>

@endpush



















































