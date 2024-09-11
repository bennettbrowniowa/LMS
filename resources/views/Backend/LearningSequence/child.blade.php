

{{--<div class="form-group">--}}
{{--    <label class="control-label">Child Title<span class="requiredAsterisk">*</span></label>--}}
{{--    <input type="text" name="child_title[]" class="validate[required] form-control" value="{{ $child->title }}">--}}
{{--</div>--}}
{{--<div class="form-group">--}}
{{--    <label class="control-label">Child Description<span class="requiredAsterisk">*</span></label>--}}
{{--    <textarea name="child_description[]" class="validate[required] form-control" rows="4">{{ $child->description }}</textarea>--}}
{{--</div>--}}

{{--@foreach ($child->children as $grandchild)--}}
{{--    <div class="panel panel-default">--}}
{{--        <div class="panel-heading" data-toggle="collapse" data-target="#collapse{{ $grandchild->id }}">--}}
{{--            <h5 class="panel-title">--}}
{{--                {{ $grandchild->title }}--}}
{{--                @if ($grandchild->children->isNotEmpty())--}}
{{--                    <i class="fa fa-chevron-right"></i>--}}
{{--                @endif--}}
{{--            </h5>--}}
{{--        </div>--}}
{{--        <div id="collapse{{ $grandchild->id }}" class="panel-collapse collapse">--}}
{{--            <div class="panel-body">--}}
{{--                @include('Backend.LearningSequence.child', ['child' => $grandchild])--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endforeach--}}







<div class="form-group">
    <label class="control-label">Child Title<span class="requiredAsterisk">*</span></label>
    <input type="text" name="child_title[]" class="validate[required] form-control" value="{{ $child->title }}">
    <input type="hidden" name="child_id[]" value="{{ $child->id }}">
</div>

@if ($child->children->isEmpty())
    <div class="form-group">
        <label class="control-label">Child Description<span class="requiredAsterisk">*</span></label>
        <textarea name="child_description[]" class="validate[required] form-control" rows="4">{{ $child->description }}</textarea>
    </div>
@endif

@foreach ($child->children as $grandchild)
    <div class="panel panel-default">
        <div class="panel-heading" data-toggle="collapse" data-target="#collapse{{ $grandchild->id }}">
            <h5 class="panel-title">
                {{ $grandchild->title }}
                @if ($grandchild->children->isNotEmpty())
                    <i class="fa fa-chevron-right"></i>
                @endif
            </h5>
        </div>
        <div id="collapse{{ $grandchild->id }}" class="panel-collapse collapse">
            <div class="panel-body">
                @include('Backend.LearningSequence.child', ['child' => $grandchild])
            </div>
        </div>
    </div>
@endforeach
