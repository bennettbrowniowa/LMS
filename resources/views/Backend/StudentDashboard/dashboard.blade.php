@extends('Backend.main')

@section('content')

    <style>
        .ul_001 {
            margin: 0px;
            padding: 0px;
        }
        .li_001 {
            list-style-type: none;
            display: inline-block;
            width: 23%;
            text-align: center;
            margin-bottom: 20px;
        }
        .p_001 {
            margin: 0px;
            border: 1px solid #c5c5c5;
            padding: 30px;
            font-size: 18px;
            letter-spacing: .5px;
            font-weight: 600;
            transition: all 0.4s ease;
            box-shadow: 0 2px 43px 0 rgba(2, 2, 2, .07);
            color: #4144bb;
        }
        .p_001:hover {
            -webkit-transform: translateY(-5px);
            -ms-transform: translateY(-5px);
            transform: translateY(-5px);
            -webkit-box-shadow: 0 50px 30px -40px rgba(0, 0, 0, .1);
            box-shadow: 0 50px 30px -40px rgba(0, 0, 0, .1);
        }
        @media only screen and (max-width: 990px) {
            .li_001 {
                width: 30%;
            }
        }
        @media only screen and (max-width: 770px) {
            .li_001 {
                width: 48%;
            }
        }
    </style>
    <div class="content-wrapper">
        <section class="content">

            <div class="box">
                <div class="box-header with-border text-center">
                    <h3 class="box-title">Check Your Course Below</h3>

                </div>
                <div class="box-body">
                    <div class="card">
                        <div class="card-body">

                            <ul class="ul_001">

                                @if($courses->isEmpty())
                                    <div style="text-align: center">No courses found.</div>
                                @else
                                    <ul class="ul_001">
                                        @foreach($courses as $course)
                                            <li class="li_001">
                                                <p class="p_001"> {{ Str::limit($course->title, 20) }} </p>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif

                            </ul>

                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>



@endsection


@push('script')
    <script>
        $(document).ready(function () {

            const form = document.getElementById('activityForm');
            if(form){

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
