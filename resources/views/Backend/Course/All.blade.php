@extends('Backend.main')
@section('content')
    <div class="content-wrapper">
        panakaj mishra how are u doing

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
                    <h3 class="box-title">All Courses</h3>
                </div>


                <div class="box-body table-responsive">
                    <table id="Datatable" class="table table-striped">
                        <thead>
                        <tr>
                            <th>Course ID</th>
                            <th>Course Title</th>
                            <th>Instructors</th>
                            <th>Students</th>

                            <th style="width: 80px; text-align: center;"><i class="fa fa-bars"></i> </th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Course ID</th>
                            <th>Course Title</th>
                            <th>Instructors</th>
                            <th>Students</th>
                            <th style="width: 80px; text-align: center;"><i class="fa fa-bars"></i> </th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>


            <div class="modal fade" id="addInstructorModal" tabindex="-1" role="dialog" aria-labelledby="addInstructorModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addInstructorModalLabel">Add Instructor</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="addInstructorForm" method="POST">
                            @csrf

                            <input type="hidden" name="course_id" id="course_id">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="email">Instructor Email<span class="requiredAsterisk">*</span></label>
                                    <input type="text" name="email" class="validate[required, custom[email]] form-control" id="email" placeholder="Instructor email">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Add Instructor</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </section>
        <!-- /.content -->
    </div>


@endsection


@push('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#Datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('allcourseDatatable') }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'title', name: 'title' },
                    { data: 'instructors', name: 'instructors' },
                    { data: 'students_count', name: 'students_count' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
                ],
                "order": [[0, 'desc']],
                "pageLength": {{ AppSetting::getRowsPerPage() }},
                "drawCallback": function(settings) {
                    $('.magnific-image').magnificPopup({ type: 'image' });
                }
            });

            $('#addInstructorModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var courseId = button.data('course-id');
                var form = $('#addInstructorForm');
                var actionUrl = '{{ route('courses_addInstructor', ['courseId' => '__COURSE_ID__']) }}';
                actionUrl = actionUrl.replace('__COURSE_ID__', courseId);
                form.attr('action', actionUrl);
                form.find('#course_id').val(courseId);

                form.validationEngine({
                    promptPosition: 'inline',
                    scroll: false
                });
            });

            $('#addInstructorForm').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                if (form.validationEngine('validate')) {
                    $.ajax({
                        url: form.attr('action'),
                        method: 'POST',
                        data: form.serialize(),
                        success: function(response) {
                            $('#addInstructorModal').modal('hide');
                            $('#Datatable').DataTable().ajax.reload();
                            toastr.success(response.message);
                        },
                        error: function(xhr) {
                            toastr.error('Error: ' + xhr.responseJSON.message);
                        }
                    });
                }
            });
        });


    </script>
@endpush

