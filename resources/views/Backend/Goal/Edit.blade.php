<form id="validation2" action="{{route('updateGoal',$records->id)}}" class="form-horizontal" method="post" enctype="multipart/form-data">
    {{csrf_field()}}

    <div class="modal-body clearfix">
        <div class="form-group">
            <label class="col-sm-3 control-label">Title<span class="requiredAsterisk">*</span></label>
            <div class="col-sm-8">
                <input type="text" name="title" class="validate[required] form-control" value="{{$records->title}}">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">Description<span class="requiredAsterisk">*</span></label>
            <div class="col-sm-8">
                <textarea type="text" name="description" class="validate[required] form-control" cols="4" rows="4">{!! $records->description !!}</textarea>
            </div>
        </div>

    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-flat" onclick="delete_subgoal('{{$records->id}}')" >
            <span class="fa fa-trash"></span> Delete
        </button>
        <button type="submit" class="btn btn-primary btn-flat"><span class="fa fa-check-circle"></span> Save</button>

    </div>
</form>



<script type="text/javascript">
    jQuery("#validation2").validationEngine({promptPosition: 'inline'});

    $('.select2').select2();

    $('.modal-body').slimScroll({
        height: '370px',
    });



    function delete_subgoal(subgoalId) {
        if(confirm('Are you sure you want to delete this goal')) {
            $.ajax({
                url: '{{ route("deleteGoal", ["id" => ":subgoalId"]) }}'.replace(':subgoalId', subgoalId),
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    toastr.success('Goal deleted successfully!');
                    window.location.reload();
                },
                error: function(error) {
                    toastr.error('Error deleting goal.');
                }
            });
        }
    }


</script>





