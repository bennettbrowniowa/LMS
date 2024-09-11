@extends('Backend.Profile.header')

@section('profileContent')
    <style>
        .form-grid-div{
            display: grid;
        }
    </style>
<div class="box profile-tab">
    <div class="nav-tabs-custom">

        @include('Backend.Profile.tab')


        <div class="tab-content">
{{--            <form id="validation" class="form-horizontal dashed-row white-field" action="{{route('saveSocialLink')}}" method="post">--}}
{{--                {{csrf_field()}}--}}
{{--                <div class="box-body">--}}

{{--                    @if (count($errors) > 0)--}}
{{--                        <div class="alert alert-error alert-dismissible">--}}
{{--                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">--}}
{{--                                <span aria-hidden="true">&times;</span>--}}
{{--                            </button>--}}
{{--                            @foreach ($errors->all() as $error)--}}
{{--                                <div>{{ $error }}</div>--}}
{{--                            @endforeach--}}
{{--                        </div>--}}
{{--                    @endif--}}

{{--                    <div class="form-group">--}}
{{--                        <label class="">Professional webpage address(es). (Instructors: please include your institutional faculty webpage. Researchers: please include lab group webpage. Industry experts: please include your company team's webpage or other page that best clarifies your role. All experts: feel free to include an additional relevant webpage such as google scholar or a page about your professional work.)</label>--}}
{{--                        <div class="col-sm-10">--}}
{{--                            <input type="text" name="webaddress" value="{{$user->user_information->website_url ?? ''}}" class="validate[required] form-control form-input-div-1" placeholder="Your Answer">--}}


{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="form-group">--}}
{{--                        <label class="">GitHub user name (used for access to QuSTEAM repositories)</label>--}}
{{--                        <div class="col-sm-10">--}}
{{--                            <input type="text" name="gihub_id"  class="validate[required] form-control form-input-div-1" value="{{$user->user_information->github_user_name ?? ''}}">--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="form-group">--}}
{{--                        <label class="">Slack invitation email address, if different than professional email (used for the community discussions)</label>--}}
{{--                        <div class="col-sm-10">--}}

{{--                            <input type="text" name="Slack_email" value="{{$user->user_information->slack_mail_id ?? ''}}" class=" validate[required] form-control form-input-div-1" placeholder="Your Answer">--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="form-group">--}}
{{--                        <label class="col-sm-2">Linkedin page</label>--}}
{{--                        <div class="col-sm-10">--}}

{{--                            <input type="text" name="linkdin_link" value="{{$user->user_information->linkdin_link ?? ''}}" class="validate[required] form-control" placeholder="LinkedIn Link">--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="form-group">--}}
{{--                        <label class="col-sm-2">Twitter handle</label>--}}
{{--                        <div class="col-sm-10">--}}

{{--                            <input type="text" name="twiter_link" value="{{$user->user_information->twiter_link ?? ''}}" class="validate[required] form-control form-input-div-1" placeholder="Your Answer">--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                        <div class="form-div-5 mb-3">--}}
{{--                            <label for="name" class="form-input-div-label mb-4">Please mark your areas of subject matter expertise as indicated by graduate degrees, publications, and faculty appointments. For subject matter expertise based on other qualifications, provide that information in the next question rather than this question.</label>--}}

{{--                            @php $userSpecializations = Auth::user()->spasilization->pluck('specialization_id')->toArray();--}}

{{--                          @endphp--}}

{{--                            @foreach($Specialization as $specialization)--}}
{{--                                <div class="form-div-inner-5 form-check">--}}
{{--                                    <input type="checkbox" value="{{ $specialization->id }}" {{ in_array($specialization->id, $userSpecializations) ? 'checked' : '' }} name="Specialization[]" class="validate[required] form-check-input" id="check{{ $specialization->id }}">--}}
{{--                                    <label class="form-check-label" for="check{{ $specialization->id }}">{{ $specialization->name }}</label>--}}
{{--                                </div>--}}
{{--                            @endforeach--}}



{{--                            <div class="form-check d-lg-flex d-block align-items-center">--}}
{{--                                <input type="checkbox" {{ $user->user_information->is_other_checked == 'Yes' ? 'checked' : '' }} class="form-check-input" name="oth_item" id="check9" value="others_type">--}}
{{--                                <label class="form-check-label" for="check9">Others</label>--}}
{{--                            </div>--}}

{{--                            <div id="other_value_container" style="{{ $user->user_information->is_other_checked == 'Yes' ? '' : 'display: none;' }}">--}}
{{--                                <input type="text" name="other_value" value="{{ $user->user_information->other_value_text ?? '' }}" class="validate[required] form-control form-input-div-1 mx-4" placeholder="Your Answer">--}}
{{--                            </div>--}}


{{--                        </div>--}}

{{--                    <div class="form-group">--}}
{{--                        <label class="">If your qualifications are based on experience, please summarize your qualification as an expert in one or more disciplines as suggested in the previous question. Also use this question to be more specific about your expertise (e.g., "My research focuses on nitrogen vacancies in diamond.")</label>--}}
{{--                        <div class="col-sm-10">--}}

{{--                            <input type="text" name="exprience_details" value="{{$user->user_information->exprience_short_desc ?? ''}}" class=" validate[required] form-control form-input-div-1" placeholder="Your Answer">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                @permission('update-social-link')--}}
{{--                <div class="box-footer">--}}
{{--                    <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-check-circle"></i> Save</button>--}}
{{--                </div>--}}
{{--                @endpermission--}}

{{--            </form>--}}


{{--            <form action="{{route('save_form')}}" method="post" id="validation">--}}
{{--                {{csrf_field()}}--}}
{{--                <div class="container-fluid my-4">--}}
{{--                    <div class="row justify-content-center">--}}
{{--                        <div class="col-lg-12 form-div-1 py-4">--}}
{{--                            <div class="row justify-content-center">--}}
{{--                                <div class="col-lg-12">--}}
{{--                                    <div class="form-div-2 d-flex">--}}
{{--                                        <div class="form-div-2-inner col-lg-10">--}}
{{--                                            <h2 class="form-div-inner-h1">Registration with QuSTEAM community of instructors and industry experts</h2>--}}

{{--                                            <p class="form-div-inner-p">This form provides the QuSTEAM user with instructor permissions across a variety of resources for accessing, contributing, and reviewing curriculum materials.</p>--}}
{{--                                        </div>--}}
{{--                                        <div class="form-div-2-inner col-lg-4 d-none d-lg-block">--}}
{{--                                            <div class="form-div-inner-img">--}}
{{--                                                <img src="{{asset('uploads/generalSetting/'.$data->site_logo)}}" style="max-width: 100%;max-height: 100px;">--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                    <div class="form-div-3 mb-3 d-flex">--}}
{{--                                        <img class="form-div-3-img" src="{{Auth::user()->profile_photo['path']}}" alt="">--}}
{{--                                        <p class="form-div-3-p">{{Auth::user()->email}}</p>--}}
{{--                                        <div class="form-div-3-icon">--}}
{{--                                            <img src="{{url('/')}}/uploads/profilePhoto/done.png" alt="">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                    <div class="form-div-4 mb-3">--}}
{{--                                        <p>Indicates required question</p>--}}
{{--                                    </div>--}}
{{--                                    <div class="form-div-5 mb-3">--}}
{{--                                        <label for="name" class="form-input-div-label">Name</label>--}}
{{--                                        <input type="text" name="name"  class="validate[required] form-control form-input-div-1" disabled value="{{Auth::user()->name}}">--}}
{{--                                    </div>--}}
{{--                                    <div class="form-div-5 mb-3">--}}
{{--                                        <label for="name" class="form-input-div-label">Professional email address</label>--}}
{{--                                        <input type="email" name="email" class="validate[required] form-control form-input-div-1" disabled value="{{Auth::user()->email}}">--}}
{{--                                    </div>--}}
{{--                                    <div class="form-div-5 mb-3">--}}
{{--                                        <label for="name" class="form-input-div-label">Professional webpage address(es). (Instructors: please include your institutional faculty webpage. Researchers: please include lab group webpage. Industry experts: please include your company team's webpage or other page that best clarifies your role. All experts: feel free to include an additional relevant webpage such as google scholar or a page about your professional work.)</label>--}}
{{--                                        <input type="text" name="webaddress" value="{{old('webaddress')}}" class="validate[required] form-control form-input-div-1" placeholder="Your Answer">--}}

{{--                                    </div>--}}
{{--                                    <div class="form-div-5 mb-3">--}}
{{--                                        <label for="name" class="form-input-div-label">Google authentication email address, if different than professional email address (used, for example, for access to QuSTEAM Shared Drive)</label>--}}
{{--                                        <input type="text" name="google_auth_id"  class="validate[required] form-control form-input-div-1" value="{{Auth::user()->email}}">--}}

{{--                                    </div>--}}
{{--                                    @if(Auth::user()->auth_type=='github')--}}
{{--                                        <div class="form-div-5 mb-3">--}}
{{--                                            <label for="name" class="form-input-div-label">GitHub user name (used for access to QuSTEAM repositories)</label>--}}
{{--                                            <input type="text" name="gihub_id"  class="validate[required] form-control form-input-div-1" value="{{Auth::user()->github_user_name}}">--}}

{{--                                        </div>--}}
{{--                                    @else--}}
{{--                                        <div class="form-div-5 mb-3">--}}
{{--                                            <label for="name" class="form-input-div-label">GitHub user name (used for access to QuSTEAM repositories)</label>--}}
{{--                                            <input type="text" name="gihub_id" value="{{old('gihub_id')}}" class="validate[required]form-control form-input-div-1" placeholder="Your Answer">--}}

{{--                                        </div>--}}
{{--                                    @endif--}}
{{--                                    <div class="form-div-5 mb-3">--}}
{{--                                        <label for="name" class="form-input-div-label">Slack invitation email address, if different than professional email (used for the community discussions)</label>--}}
{{--                                        <input type="text" name="Slack_email" value="{{old('Slack_email')}}" class=" validate[required] form-control form-input-div-1" placeholder="Your Answer">--}}

{{--                                    </div>--}}
{{--                                    <div class="form-div-5 mb-3">--}}
{{--                                        <label for="name" class="form-input-div-label">LinkedIn page</label>--}}

{{--                                        <input type="text" name="linkdin_link" value="{{ old('linkdin_link') }}" class="validate[required] form-control" placeholder="LinkedIn Link">--}}


{{--                                    </div>--}}
{{--                                    <div class="form-div-5 mb-3">--}}
{{--                                        <label for="name" class="form-input-div-label">Twitter handle</label>--}}
{{--                                        <input type="text" name="twiter_link" value="{{old('twiter_link')}}" class="validate[required] form-control form-input-div-1" placeholder="Your Answer">--}}

{{--                                        <div class="form-div-5 mb-3">--}}
{{--                                            <label for="name" class="form-input-div-label mb-4">Please mark your areas of subject matter expertise as indicated by graduate degrees, publications, and faculty appointments. For subject matter expertise based on other qualifications, provide that information in the next question rather than this question.</label>--}}
{{--                                            @if(!empty($Specialization))--}}
{{--                                                @foreach($Specialization as $Specializations)--}}
{{--                                                    <div class="form-div-inner-5 form-check">--}}
{{--                                                        <input type="checkbox" value="{{$Specializations->id}}" {{ in_array($Specializations['id'], old('Specialization', [])) ? 'checked' : '' }} name="Specialization[]"  class="validate[required] form-check-input" id="check1">--}}
{{--                                                        <label class="form-check-label" for="check1">{{$Specializations->name}}</label>--}}
{{--                                                    </div>--}}
{{--                                                @endforeach--}}
{{--                                            @endif--}}


{{--                                            <div class="form-check d-lg-flex d-block align-items-center">--}}
{{--                                                <input type="checkbox" {{ old('oth_item') == 'others_type' ? 'checked' : '' }} class="form-check-input" name="oth_item" id="check9" value="others_type">--}}
{{--                                                <label class="form-check-label" for="check9">Others</label>--}}
{{--                                            </div>--}}

{{--                                            <div id="other_value_container" style="display: none;">--}}
{{--                                                <input type="text" name="other_value" value="{{ old('other_value') }}" class="validate[required] form-control form-input-div-1 mx-4" placeholder="Your Answer">--}}
{{--                                            </div>--}}


{{--                                        </div>--}}
{{--                                        <div class="form-div-5 mb-3">--}}
{{--                                            <label for="name" class="form-input-div-label">If your qualifications are based on experience, please summarize your qualification as an expert in one or more disciplines as suggested in the previous question. Also use this question to be more specific about your expertise (e.g., "My research focuses on nitrogen vacancies in diamond.")</label>--}}
{{--                                            <input type="text" name="exprience_details" value="{{old('exprience_details')}}" class=" validate[required] form-control form-input-div-1" placeholder="Your Answer">--}}

{{--                                        </div>--}}

{{--                                        <div class="form-button">--}}
{{--                                            <button type="submit" class="btn btn-form-submit">Submit</button>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </form>--}}

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
            <form id="validation" class="form-horizontal dashed-row white-field" action="{{ route('saveSocialLink') }}" method="post">
                {{ csrf_field() }}
                <div class="box-body">
                    <!-- Your existing form fields -->
                    <!-- Webpage Address -->
                    <div class="form-group">
                        <label class=" col-sm-4">Professional Webpage Address.<span class="requiredAsterisk">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" name="webaddress" value="{{ old('webaddress', $user->user_information->website_url ?? '') }}" class="validate[required] form-control form-input-div-1" placeholder="Your Answer">
                        </div>
                    </div>

                    <!-- GitHub Username -->
                    <div class="form-group ">
                        <label class=" col-sm-12">GitHub User Name (Used For Access To QuSTEAM Repositories)<span class="requiredAsterisk">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" name="gihub_id" value="{{ old('gihub_id', $user->user_information->github_user_name ?? '') }}" class="validate[required] form-control form-input-div-1">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="form-input-div-label col-sm-12">Google authentication Email Address, If Different Than Professional Email Address (Used, For Example, For Access To QuSTEAM Shared Drive)<span class="requiredAsterisk">*</span></label>
                        <input type="text" name="google_auth_id"  class="validate[required] form-control form-input-div-1" value="{{old('google_auth_id',$user->user_information->google_auth_share_drive_email ?? '')}}" style="margin-left: 12px;">

                                   </div>

                    <!-- Slack Email -->
                    <div class="form-group">
                        <label for="name" class="form-input-div-label col-sm-4">Slack Invitation Email Address<span class="requiredAsterisk">*</span></label>
                        <input type="text" name="Slack_email" value="{{ old('Slack_email', $user->user_information->slack_mail_id ?? '') }}" class="validate[required, email] form-control form-input-div-1 " placeholder="Your Answer" style="margin-left: 12px">

                    </div>

                    <!-- LinkedIn Link -->
                    <div class="form-group form-grid-div">
                        <label class="col-sm-2">LinkedIn page<span class="requiredAsterisk">*</span></label>
                        <div class="col-sm-10 px-0">
                            <input type="text" name="linkdin_link" value="{{ old('linkdin_link', $user->user_information->linkdin_link ?? '') }}" class="validate[required] form-control" placeholder="LinkedIn Link">
                        </div>
                    </div>

                    <!-- Twitter Link -->
                    <div class="form-group form-grid-div">
                        <label class="col-sm-2">Twitter handle<span class="requiredAsterisk">*</span></label>
                        <div class="col-sm-10 px-0">
                            <input type="text" name="twiter_link" value="{{ old('twiter_link', $user->user_information->twiter_link ?? '') }}" class="validate[required] form-control form-input-div-1" placeholder="Your Answer">
                        </div>
                    </div>

                    <!-- Specialization checkboxes -->
                    <div class="form-div-5 mb-3">
                        <label for="name" class="form-input-div-label mb-4">Please Mark Your areas of subject matter expertise as indicated by graduate degrees, publications, and faculty appointments. For subject matter expertise based on other qualifications, provide that information in the next question rather than this question.<span class="requiredAsterisk">*</span></label>
                      @php $userSpecializations = Auth::user()->spasilization->pluck('specialization_id')->toArray();@endphp
                        @foreach($Specialization as $specialization)
                            <div class="form-div-inner-5 form-check">
                                <input type="checkbox" value="{{ $specialization->id }}" {{ in_array($specialization->id, old('Specialization', $userSpecializations)) ? 'checked' : '' }} name="Specialization[]" class="validate[required] form-check-input" id="check{{ $specialization->id }}">
                                <label class="form-check-label" for="check{{ $specialization->id }}">{{ $specialization->name }}</label>
                            </div>
                    @endforeach

                        <div class="form-check d-lg-flex d-block align-items-center">
                            <input type="checkbox" {{ old('oth_item', $user->user_information->is_other_checked == 'Yes' ? 'checked' : '') }} class="form-check-input" name="oth_item" id="check9" value="Yes">
                            <label class="form-check-label" for="check9">Others</label>
                        </div>

                        <!-- Other value input -->
                        <div id="other_value_container" style="{{ old('oth_item', $user->user_information->is_other_checked == 'Yes' ? '' : 'display: none;') }}">
                            <input type="text" name="other_value" value="{{ old('other_value', $user->user_information->other_value_text ?? '') }}" class="validate[required] form-control form-input-div-1 mx-4" placeholder="Your Answer">
                        </div>
                    </div>
                    <br>

                    <!-- Experience Details -->
                    <div class="form-group form-grid-div">
                        <label class="col-sm-4">Qualifications based on experience <span class="requiredAsterisk">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" name="exprience_details" value="{{ old('exprience_details', $user->user_information->exprience_short_desc ?? '') }}" class="validate[required] form-control form-input-div-1" placeholder="Your Answer">
                        </div>
                    </div>
                </div>

                <!-- Save button -->
                @permission('update-social-link')
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-check-circle"></i> Save</button>
                </div>
                @endpermission
            </form>


        </div>

    </div>


</div>
@endsection

@push('script')
    <script>
        $(document).on('ifChecked', '#check9', function(event){
            $('#other_value_container').show();
        });

        $(document).on('ifUnchecked', '#check9', function(event){
            $('#other_value_container').hide();
            $('#other_value_container input[name="other_value"]').val('');
        });
    </script>

    @endpush
