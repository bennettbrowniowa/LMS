<style>
    .mg_001 {
        margin-bottom: 20px;
    }
    .h4001 {
        color: #4144bb;
        font-size: 15px;
        font-weight: 600;
    }
    .icon_001 {
        float: right;
    }
    #contentContainer {
        border: 1px solid #ccc;
        padding: 10px;
        min-height: 200px;
        background-color: #f9f9f9;
        margin-top: 20px;
    }
    .table-bordered tr,
    .table-bordered td,
    .table-bordered th {
        border: 1px solid black !important;
    }
    .html_input_div {
        display: flex;
        align-items: center;
    }
    .html_input_span {
        margin-left: 10px;
    }
    .html_input_div {
        display: flex;
        align-items: center;
        padding: 5px 15px;
        border: 2px solid #999999;
        background-color: #f6f8f9;
        border-radius: 4px;
    }
    .html_input_div:hover {
        border: 2px solid #00a0af;
        background-color: #00a0af1a;
    }
    .checkbox-inline, .radio-inline {
        padding-left: 0px !important;
    }
    .button-move {
        margin-top: -30px;
    }

    label.correct_label {
        padding: 10px 20px;
        border: 1px solid #d7d7d7;
        line-height: normal;
        display: flex;
        align-items: center;
        width: fit-content;
    }

    label.correct_label input {
        margin: 0px;
        margin-left: 10px;
        width: 20px;
        height: 20px;
    }
</style>


    <form action="{{ route('updateLearningSequence', $learningSequence->id) }}" method="post" enctype="multipart/form-data" id="validation2">
        {{ csrf_field() }}

        <div class="modal-body clearfix">

            <div class="form-group">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-12">
                        <label class="control-label">Title<span class="requiredAsterisk">*</span></label>
                    </div>
                    <div class="col-sm-8">
                        <input type="text" name="title" class="validate[required] form-control mg_001" value="{{ $learningSequence->title }}">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-12">
                        <label class="control-label">Content Type<span class="requiredAsterisk">*</span></label>
                    </div>
                    <div class="col-sm-8">
                        <label class="radio-inline">
                            <div class="html_input_div">
                                <input type="radio" name="content_type" class="html_input" value="html" {{ $learningSequence->content_type === 'html' ? 'checked' : '' }}> <span class="html_input_span">HTML</span>
                            </div>
                        </label>
                        <label class="radio-inline">
                            <div class="html_input_div">
                                <input type="radio" name="content_type" class="html_input" value="txt" {{ $learningSequence->content_type === 'txt' ? 'checked' : '' }}> <span class="html_input_span">TXT</span>
                            </div>
                        </label>
                        <label class="radio-inline">
                            <div class="html_input_div">
                                <input type="radio" name="content_type" class="html_input" value="js" {{ $learningSequence->content_type === 'js' ? 'checked' : '' }}> <span class="html_input_span">JS</span>
                            </div>
                        </label>
                        <label class="radio-inline">
                            <div class="html_input_div">
                                <input type="radio" name="content_type" class="html_input" value="md" {{ $learningSequence->content_type === 'md' ? 'checked' : '' }}> <span class="html_input_span">MD</span>
                            </div>
                        </label>
                        <label class="radio-inline">
                            <div class="html_input_div">
                                <input type="radio" name="content_type" class="html_input" value="qti" {{ $learningSequence->content_type === 'qti' ? 'checked' : '' }}> <span class="html_input_span">QTI</span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <div id="qtiFields" class="content-type-fields" style="{{ $learningSequence->content_type === 'qti' ? '' : 'display: none;' }}">
                <div class="form-group">
                    <label class="col-lg-3 col-md-3 col-12 control-label">Stem</label>
                    <div class="col-sm-8">
                        <textarea name="stem" class="validate[required] form-control" rows="4" cols="4" style="margin-bottom: 10px;">{{ $learningSequence->stem ?? '' }}</textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 col-md-3 col-12 control-label">Key (right answer)</label>
                    <div class="col-sm-8">
                        <textarea name="key" class="validate[required] form-control" rows="4" cols="4">{{ $learningSequence->key_data ?? ''}}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 col-md-3 col-12 control-label">Foils</label>
                    <div class="col-sm-8" id="foilContainer">
                        @if(isset($foils) && count($foils) > 0)
                        @foreach ($foils as $index => $foil)
                            <div class="form-group" data-foil-id="{{ $index }}">
                                <label>Foil {{ $index + 1 }}:</label>
                                <textarea name="foils[]" class="validate[required] form-control" rows="4" cols="4" style="margin-bottom: 10px;">{{ $foil }}</textarea>
                                <label>Feedback:</label>
                                <textarea name="feedbacks[]" class="validate[required] form-control" rows="4" cols="4" style="margin-bottom: 10px;">{{ $feedbacks[$index] ?? '' }}</textarea>

                                <label style="margin-top: 10px" class="correct_label">
                                    Correct:
                                    <input type="checkbox" name="correct_foils[]"  value="{{ $index }}" style="margin:0px; margin-left: 10px"  {{ in_array($index, $correctFoils) ? 'checked' : '' }}>
                                </label>
                                <br>
                                <button type="button" class="btn btn-danger remove-foil-field">Delete</button>
                            </div>
                        @endforeach
                        @endif
                        <br>
                        <button type="button" id="addMoreFoilBtn" class="btn btn-success btn-flat add-foil-field" style="margin-bottom: 10px;">Add Foil</button>
                    </div>
                </div>
            </div>

            <div class="form-group" id="descriptionField" style="{{ $learningSequence->content_type === 'qti' ? 'display: none;' : '' }}">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-12">
                        <label class="control-label">Content<span class="requiredAsterisk">*</span></label>
                    </div>
                    <div class="col-sm-8">
                        <div id="contentContainer" style="display:none;"></div>
                        <textarea id="rawContent" name="description" class="validate[required] form-control mg_001" rows="6" cols="6" style="margin-top: 10px;">{!! $learningSequence->description !!}</textarea>
                        <button type="button" class="btn btn-primary btn-flat" id="toggleViewBtn" style="margin-top: 10px;">Toggle View</button>
                    </div>
                </div>
            </div>

            <span id="result"></span>

            <div class="table">
                <table class="table table-bordered table-striped" id="dynamicAddRemove">
                    <thead>
                    <tr>
                        <th>Files</th>
                        <th>Linked Content</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($files as $value)
                        <tr data-file-id="{{$value->id }}">
                            <td><input type="file" name="files[]" placeholder="Enter File" class="form-control"/>
                                {{ substr($value->filename, strpos($value->filename, '.') + 1) }}
                            </td>
                            <td><input type="text" name="linked_content[]" placeholder="Enter Linked Content" class="form-control" value="{{$value->url}}"/>
                            </td>
                            <td><button type="button" class="btn btn-danger remove_field">Delete</button></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <button type="button" name="add" id="dynamic-ar" class="btn btn-success btn-flat button-move"><span class="fa fa-plus"></span> Add </button>
            </div>

            @if ($learningSequence->children->isNotEmpty())
                @foreach ($learningSequence->children as $child)
                    <div class="panel panel-default">
                        <a class="toggleCollapse" data-toggle="collapse" href="#collapse{{ $child->id }}">
                            <div class="panel-heading">
                                <h4 class="panel-title h4001">
                                    {{ $child->title }}
                                    @if ($child->children->isNotEmpty())
                                        <i class="fa fa-chevron-right toggleIcon icon_001"></i>
                                    @endif
                                </h4>
                            </div>
                        </a>
                        <div id="collapse{{ $child->id }}" class="panel-collapse collapse">
                            <div class="panel-body">
                                @if ($child->children->isEmpty())
                                    <div class="form-group">
                                        <label class="control-label">Child Description<span class="requiredAsterisk">*</span></label>
                                        <textarea name="child_description[]" class="validate[required] form-control" rows="4">{{ $child->description }}</textarea>
                                        <input type="hidden" name="child_id[]" value="{{ $child->id }}">
                                    </div>
                                @endif
                                @include('Backend.LearningSequence.child', ['child' => $child])
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-danger btn-flat" id="deleteRecord"><span class="fa fa-trash"></span> Delete</button>
            <button type="submit" class="btn btn-primary btn-flat"><span class="fa fa-check-circle"></span> Save</button>
        </div>
    </form>




<script type="text/javascript">

    jQuery("#validation2").validationEngine({promptPosition: 'inline'});

        $('.modal-body').slimScroll({ height: '370px' });

        $(document).ready(function() {
            $('.toggleCollapse').on('click', function() {
                var $icon = $(this).find('.toggleIcon');
                $icon.toggleClass('fa-chevron-right fa-chevron-down');
            });
            $('#deleteRecord').on('click', function() {
                if (confirm('Are you sure you want to delete this record?')) {
                    $.ajax({
                        url: '{{ route("deleteLearningSequence", ["id" => $learningSequence->id]) }}',
                        type: 'GET',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        success: function(response) {
                            toastr.success(response.message);
                            window.location.reload();
                        },
                        error: function(error) {
                            toastr.error('Error deleting Learning Sequence.');
                        }
                    });
                }
            });


        var i = 0;
        $("#dynamic-ar").click(function () {
            ++i;
            $("#dynamicAddRemove").append('<tr>' +
                '<td><input type="file" name="files[]" placeholder="Enter File" class="form-control" /></td>' +
                '<td><input type="text" name="linked_content[]" placeholder="Enter Linked Content" class="form-control" /></td>' +

                '<td><button type="button" class="btn btn-danger remove_field">Delete</button></td>'+
                '</tr>'
            );
        });
        $(document).on('click','.remove_field',function () {
            $(this).parents('tr').remove();
        });


        $(document).on('click', '.remove_field', function() {
            var fileId = $(this).closest('tr').data('file-id');
            var row = $(this).closest('tr');
            $.ajax({
                url: "learning-sequence/"+fileId,
                type: 'GET',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                success: function(response) {
                    row.remove();
                },

            });
        });

$('.panel-heading').click(function() {
    var icon = $(this).find('.fa');
    if (icon.hasClass('fa-chevron-right')) {
        icon.removeClass('fa-chevron-right').addClass('fa-chevron-down');
    } else {
        icon.removeClass('fa-chevron-down').addClass('fa-chevron-right');
    }
});




function renderContent(content, contentType) {
    var contentContainer = $('#contentContainer');

    switch (contentType) {
        case 'html':
            contentContainer.html(content);
            break;
        case 'js':
            contentContainer.empty();
            try {
                var sanitizedContent = sanitizeJavaScriptCode(content);
                var script = document.createElement('script');
                script.textContent = sanitizedContent;
                document.head.appendChild(script).parentNode.removeChild(script);
            } catch (error) {
                renderUnsupportedContentMessage(contentType);
            }
            break;
        case 'qti':
            renderQTIContent(content);
            break;
        case 'md':
            renderMarkdownContent(content);
            break;
        case 'txt':
            contentContainer.text(content);
            break;
        default:
            contentContainer.text(content);
            break;
    }
}


function renderQTIContent(content) {
    var contentContainer = $('#contentContainer');
    contentContainer.html('');

    var parser = new DOMParser();
    var xmlDoc = parser.parseFromString(content, 'application/xml');
    var outputHtml = '';
    var itemBodyFound = false;

    try {
        var assessmentItem = xmlDoc.querySelector('assessmentItem');
        if (!assessmentItem) {
            toastr.error('Invalid QTI XML: assessmentItem element not found.');
        }

        var itemBody = assessmentItem.querySelector('itemBody');
        if (!itemBody) {
            toastr.error('ItemBody not found in the QTI XML.');
        }

        itemBodyFound = true;

        var interactions = itemBody.querySelectorAll('*');
        interactions.forEach(function (interaction) {
            switch (interaction.tagName.toLowerCase()) {
                case 'choiceinteraction':
                    outputHtml += renderChoiceInteraction(interaction);
                    break;
                case 'inlinechoiceinteraction':
                    outputHtml += renderInlineChoiceInteraction(interaction);
                    break;
                case 'gapmatchinteraction':
                    outputHtml += renderGapMatchInteraction(interaction);
                    break;
                case 'associablehotspotinteraction':
                    outputHtml += renderAssociableHotspotInteraction(interaction);
                    break;
                case 'extendedtextinteraction':
                    outputHtml += renderExtendedTextInteraction(interaction);
                    break;
                case 'matchinteraction':
                    outputHtml += renderMatchInteraction(interaction);
                    break;
                default:
                    outputHtml += renderNode(interaction);
                    break;
            }
        });

        contentContainer.html(outputHtml);
    } catch (error) {
        if (!itemBodyFound) {
            // toastr.error(error.message);
            contentContainer.html('');
        }
    }
}


function renderChoiceInteraction(interaction) {
    var output = '';
    var prompt = interaction.querySelector('prompt');
    if (prompt) {
        output += '<p>' + prompt.textContent.trim() + '</p>';
    }

    var simpleChoices = interaction.querySelectorAll('simpleChoice');
    if (simpleChoices.length > 0) {
        output += '<ul>';
        simpleChoices.forEach(function (simpleChoice) {
            output += '<li>' + simpleChoice.textContent.trim() + '</li>';
        });
        output += '</ul>';
    }

    return output;
}


function renderInlineChoiceInteraction(interaction) {
    var output = '';
    var prompt = interaction.querySelector('prompt');
    if (prompt) {
        output += '<p>' + prompt.textContent.trim() + '</p>';
    }

    var inlineChoices = interaction.querySelectorAll('inlineChoice');
    if (inlineChoices.length > 0) {
        output += '<select>';
        inlineChoices.forEach(function (inlineChoice) {
            output += '<option value="' + inlineChoice.getAttribute('identifier') + '">' + inlineChoice.textContent.trim() + '</option>';
        });
        output += '</select>';
    }

    return output;
}


function renderGapMatchInteraction(interaction) {
    var output = '';
    var prompt = interaction.querySelector('prompt');
    if (prompt) {
        output += '<p>' + prompt.textContent.trim() + '</p>';
    }

    var gaps = interaction.querySelectorAll('gap');
    if (gaps.length > 0) {
        output += '<ul>';
        gaps.forEach(function (gap) {
            output += '<li>' + gap.textContent.trim() + '</li>';
        });
        output += '</ul>';
    }

    return output;
}


function renderAssociableHotspotInteraction(interaction) {
    var output = '';
    var prompt = interaction.querySelector('prompt');
    if (prompt) {
        output += '<p>' + prompt.textContent.trim() + '</p>';
    }

    var hotspots = interaction.querySelectorAll('associableHotspot');
    if (hotspots.length > 0) {
        output += '<div class="hotspots">';
        hotspots.forEach(function (hotspot) {
            output += '<span>' + hotspot.textContent.trim() + '</span>';
        });
        output += '</div>';
    }

    return output;
}


function renderExtendedTextInteraction(interaction) {
    var output = '';
    var expectedLines = interaction.getAttribute('expectedLines');
    if (expectedLines) {
        output += '<p>Expected Lines: ' + expectedLines + '</p>';
    }

    return output;
}


function renderMatchInteraction(interaction) {
    var output = '';
    var simpleMatchSets = interaction.querySelectorAll('simplematchset');
    simpleMatchSets.forEach(function (matchSet) {
        var choices = matchSet.querySelectorAll('simpleassociablechoice');
        output += '<ul>';
        choices.forEach(function (choice) {
            output += '<li>' + choice.textContent.trim() + '</li>';
        });
        output += '</ul>';
    });

    return output;
}


function renderUnsupportedContentMessage(contentType) {
    var message = 'Unsupported content type: ' + contentType;
    toastr.error(message);
    $('#contentContainer').html('');
}


function renderNode(node) {
    var output = '';

    switch (node.nodeType) {
        case Node.ELEMENT_NODE:
            switch (node.tagName.toLowerCase()) {
                case 'p':
                case 'mattext':
                    output += '<p>' + node.textContent.trim() + '</p>';
                    break;
                case 'choiceinteraction':
                    output += renderChoiceInteraction(node);
                    break;
                case 'inlinechoiceinteraction':
                    output += renderInlineChoiceInteraction(node);
                    break;
                case 'gapmatchinteraction':
                    output += renderGapMatchInteraction(node);
                    break;
                case 'associablehotspotinteraction':
                    output += renderAssociableHotspotInteraction(node);
                    break;
                case 'extendedtextinteraction':
                    output += renderExtendedTextInteraction(node);
                    break;
                case 'matchinteraction':
                    output += renderMatchInteraction(node);
                    break;
                case 'simplechoice':
                case 'response_label':
                    output += '<div>' + node.textContent.trim() + '</div>';
                    break;
                case 'prompt':
                    output += '<p>' + node.textContent.trim() + '</p>';
                    break;
                case 'feedbackinline':
                    output += '<div class="feedback">' + node.textContent.trim() + '</div>';
                    break;
                default:
                    output += '<div>' + node.textContent.trim() + '</div>';
                    break;
            }
            break;
        case Node.TEXT_NODE:
            output += renderTextNode(node);
            break;
    }

    return output;
}


function renderTextNode(textNode) {
    return textNode.textContent;
}


function renderMarkdownContent(content) {
    try {
        var sanitizedHtml = DOMPurify.sanitize(marked(content));
        $('#contentContainer').html(sanitizedHtml);
    } catch (error) {
        toastr.error('Error rendering Markdown content');
    }
}


$('#toggleViewBtn').click(function () {

    var contentContainer = $('#contentContainer');
    var rawContentTextarea = $('#rawContent');
    var toggleViewBtn = $(this);

    var content = rawContentTextarea.val().trim();

    if (content === '') {
        toastr.error('Please enter content');
        return;
    }

    if (contentContainer.is(':visible')) {
        contentContainer.hide();
        rawContentTextarea.show();
        toggleViewBtn.text('Toggle View');
    } else {
        var contentType = $('input[name="content_type"]:checked').val();

        switch (contentType) {
            case 'js':
                try {
                    renderContent(content, contentType);
                } catch (error) {
                    toastr.error('JavaScript format is invalid');
                    return;
                }
                break;
            case 'html':
                renderContent(content, contentType);
                break;
            case 'qti':
                renderQTIContent(content);
                break;
            case 'md':
                renderMarkdownContent(content);
                break;
            case 'txt':
                renderContent(content, contentType);
                break;
            default:
                renderContent(content, contentType);
                break;
        }

        contentContainer.show();
        rawContentTextarea.hide();
        toggleViewBtn.text('Edit Raw');
    }
});

            function sanitizeJavaScriptCode(code) {
             return code.replace(/<[^>]*>?/gm, '');
                }


            $(document).ready(function() {
                var index = $('#foilContainer .form-group').length;

                $('#addMoreFoilBtn').click(function() {
                    var newFoilField = `
            <div class="form-group" data-index="${index}">
            <label>Foil:</label>
            <textarea name="foils[]" placeholder="Enter Foil" class="validate[required] form-control" rows="4" cols="4"></textarea>
            <label>Feedback:</label>
            <textarea name="feedbacks[]" placeholder="Enter Feedback" class="validate[required] form-control" rows="4" cols="4"></textarea>
            <label style="margin-top: 10px" class="correct_label">
                Correct:
                <input type="checkbox" name="correct_foils[]" value="${index}" style="margin:0px; margin-left: 10px">
            </label>
            <br>
            <button type="button" class="btn btn-danger remove-foil-field">Delete</button>
          </div>
        `;

                    $('#foilContainer').append(newFoilField);
                    index++;
                });

                $('#foilContainer').on('click', '.remove-foil-field', function() {
                    $(this).closest('.form-group').remove();
                });
            });



            $('input[name="content_type"]').on('change', function() {
    if ($(this).val() === 'qti') {
        $('#qtiFields').show();
        $("#validation2").validationEngine({promptPosition: 'inline'});
        $('#descriptionField').hide();
    } else {
        $('#qtiFields').hide();
        $("#validation2").validationEngine('detach');
        $('#descriptionField').show();
    }
     });
        });


    {{--$(document).ready(function() {--}}
    {{--    $(document).on('click', '.remove-foil-field', function() {--}}
    {{--        var foilId = $(this).closest('.form-group').data('foil-id');--}}
    {{--        var row = $(this).closest('.form-group');--}}
    {{--        $.ajax({--}}
    {{--            url: "/learning-sequence/foil/" + foilId,--}}
    {{--            type: 'get',--}}
    {{--            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },--}}
    {{--            success: function(response) {--}}
    {{--                row.remove();--}}
    {{--            },--}}

    {{--        });--}}
    {{--    });--}}
    {{--});--}}

</script>






