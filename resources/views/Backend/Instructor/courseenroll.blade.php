<form id="validation2" action="{{route('courseassign')}}" class="form-horizontal" method="post">
    {{csrf_field()}}
    <div class="modal-body clearfix">
      <input type="hidden" name="course_id" value="{{$course->id}}">
        <div class="form-group">
            <label for="title" class="col-sm-3 control-label">Student<span class="requiredAsterisk">*</span></label>
            <div class="col-sm-9">
                <select name="student[]"  class="validate[required] select2" multiple data-placement="select multiple Student">
                    @if(!empty($students))
                        @foreach($students as $student)
                            <option value="{{$student->id}}">{{$student->email}}</option>
                        @endforeach
                        @endif

                </select>
            </div>
        </div>


    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><span class="fa fa-close"></span> Close</button>

        <button type="submit" class="btn btn-primary btn-flat"><span class="fa fa-check-circle"></span> Save</button>

    </div>
</form>

<script type="text/javascript">
    jQuery("#validation2").validationEngine({promptPosition: 'inline'});
    $('.select2').select2();
    $(document).ready(function() {
        $('#validation2').submit(function(event) {
            event.preventDefault();
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var formData = $(this).serialize();
            formData += '&_token=' + csrfToken;
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: formData,
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    }else {
                        toastr.error('Failed to enroll students: ' + response.message);
                    }
                },

            });
        });
    });
</script>


