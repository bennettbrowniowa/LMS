@extends('Backend.main')

@section('content')


<style>
    .badge {
        padding: 7px 9px;
        width: fit-content;
        margin-bottom: 5px;
        background-color: #44ddd4;
    }
    .scrollable {
        max-height: 200px;
        overflow-y: auto;
        padding-right: 15px;
        margin-right: -15px;
    }

    .scrollable::-webkit-scrollbar {
        width: 0;
        background: transparent;
    }


    .formatdata {
        margin-bottom: 10px;
    }
    .modal-lg {
        width: 80%;
    }
    .view-button-2 {
        padding: 7px 10px;
    }
    .view-button-1 {
        margin-top: 10px;
        width: fit-content;
        padding: 7px 10px;
        height: auto;
        background-color: #4144bb;
        border: 0px;
        border-radius: 0px;
        line-height: normal;
    }
    .view-button-1:hover {
        background-color: #4144bb;
        color: white;

    }
</style>


<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">


        <div class="box box-primary">
            <div class="box-header with-border">
                <h2>Course</h2>


            </div>

            <div class="box-body table-responsive">
                <table id="Datatable" class="table table-striped">
                    <thead>
                    <tr>
                        <th>Course Name</th>
                        <th>Course</th>
                        <th>Goals</th>
                        <th>Pedagogy Tags</th>
                        <th>Resource Types</th>
                        <th>Files</th>
                        <th>File URLs</th>
                        <th style="width: 80px; text-align: center;">Action</th>

                    </tr>
                    </thead>

                </table>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="enrolledStudentsModal" tabindex="-1" role="dialog" aria-labelledby="enrolledStudentsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="enrolledStudentsModalLabel">Enrolled Students</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="enrolledStudentsList"></div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="removeInstructorModal" tabindex="-1" role="dialog" aria-labelledby="removeInstructorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="removeInstructorModalLabel">Confirm Removal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to remove yourself from this course?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmRemove">Remove Me</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="deleteCourseModal" tabindex="-1" role="dialog" aria-labelledby="deleteCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteCourseModalLabel">Confirm Deletion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this course? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete Course</button>
            </div>
        </div>
    </div>
</div

@endsection

@push('script')
    <script type="text/javascript">
        $('#Datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{route('coursedatatable')}}',
            columns: [
                { data: 'title', name: 'title' },
                { data: 'title_description', name: 'title_description' },
                { data: 'goals', name: 'goals' },
                { data: 'pedagogy_tags', name: 'pedagogy_tags' },
                { data: 'resource_types', name: 'resource_types' },
                { data: 'files', name: 'files' },
                { data: 'file_urls', name: 'file_urls' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            "order": [[0,'desc']],
            "pageLength": {{AppSetting::getRowsPerPage()}},
            "drawCallback": function( settings ) {
                $('.magnific-image').magnificPopup({type: 'image'});
            }
        });


        $(document).ready(function() {
            $('#enrolledStudentsModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var courseId = button.data('course-id');
                var modal = $(this);

                $.ajax({
                    url: '{{ route("get_enrolled_students", ["courseId" => ":courseId"]) }}'.replace(':courseId', courseId),
                    method: 'GET',
                    success: function(response) {
                        var enrolledStudentsHtml = '';

                        if (response.length > 0) {
                            $.each(response, function(index, student) {
                                enrolledStudentsHtml += '<div style="text-align: center;">' + student.name + '</div>';
                            });
                        } else {
                            enrolledStudentsHtml = '<div style="text-align: center;">No students found for this course.</div>';
                        }

                        modal.find('#enrolledStudentsList').empty().append(enrolledStudentsHtml);
                    },
                    error: function(xhr, status, error) {
                        console.error('An error occurred:', error);
                    }
                });
            });
        });
        $(document).ready(function() {
            $('#removeInstructorModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var url = button.data('url');
                var modal = $(this);

                modal.find('#confirmRemove').off('click').on('click', function() {
                    $.ajax({
                        url: url,
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                toastr.success(response.message);
                                location.reload();
                            } else {
                                toastr.error(response.message);
                            }
                        },
                        error: function(xhr) {
                            toastr.error('An error occurred while processing your request.');
                        }
                    });
                    modal.modal('hide');
                });
            });
        });

        $(document).ready(function() {
            $('#deleteCourseModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var url = button.data('url');
                var modal = $(this);

                modal.find('#confirmDelete').off('click').on('click', function() {
                    $.ajax({
                        url: url,
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                toastr.success(response.message);
                                location.reload();
                            } else {
                                toastr.error(response.message);
                            }
                        },
                        error: function() {
                            toastr.error('An error occurred while deleting the course.');
                        }
                    });
                    modal.modal('hide');
                });
            });
        });





    </script>




@endpush


