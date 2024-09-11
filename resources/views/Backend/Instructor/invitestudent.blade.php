<form id="validation2" action="{{route('store_invitation')}}" class="form-horizontal" method="post" enctype="multipart/form-data">
    {{csrf_field()}}
    <div class="modal-body clearfix">
        <input type="hidden" name="course_id" value="{{ $course->id }}">
        <div class="form-group">
            <label for="title" class="col-sm-3 control-label">Student Email Address<span class="requiredAsterisk">*</span></label>
            <div class="col-sm-9">
                <input type="text" name="email" class="validate[required, custom[email]] form-control" value="">
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
</script>


