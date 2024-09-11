@extends('Backend.main')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Course</h3>
                </div>
                <div class="box-body">
                    <div class="row">

                        <div class="col-md-12">
                            @if ($firstActivity)
                                @include('Backend.StudentDashboard.activity', ['activity' => $firstActivity])
                            @else
                                <p>No activity available.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection



@push('script')
    <script type="text/javascript">
        jQuery("#activityForm").validationEngine({promptPosition: 'inline'});
        $(document).ready(function () {

            const form = document.getElementById('activityForm');
            if (form) {
                form.addEventListener('submit', function () {

                    const elements = document.querySelectorAll('#descriptionContainer input, #descriptionContainer textarea, #descriptionContainer select');

                    elements.forEach(element => {
                        if (element.tagName === 'SELECT') {

                            const options = element.querySelectorAll('option');
                            options.forEach(option => {
                                if (option.selected) {
                                    option.setAttribute('selected', 'selected');
                                } else {
                                    option.removeAttribute('selected');
                                }
                            });
                        } else if (element.type === 'checkbox' || element.type === 'radio') {

                            if (element.checked) {
                                element.setAttribute('checked', 'checked');
                            } else {
                                element.removeAttribute('checked');
                            }
                        } else {

                            element.setAttribute('value', element.value);
                        }
                    });

                    const htmlContent = document.getElementById('descriptionContainer').innerHTML;
                    document.getElementById('html_content').value = htmlContent;
                });
            }

        });
    </script>
    @endpush




