@extends('Backend.main')
@section('content')
<style>
    .card {
        box-shadow: 0 1px 3px 0 rgba(0,0,0,.1), 0 1px 2px 0 rgba(0,0,0,.06);
    }

    .card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 0 solid rgba(0,0,0,.125);
        border-radius: .25rem;
    }

    .card-body {
        flex: 1 1 auto;
        min-height: 1px;
        padding: 1rem;
    }

    .gutters-sm {
        margin-right: -8px;
        margin-left: -8px;
    }

    .gutters-sm>.col, .gutters-sm>[class*=col-] {
        padding-right: 8px;
        padding-left: 8px;
    }
    .mb-3, .my-3 {
        margin-bottom: 1rem!important;
    }

    .bg-gray-300 {
        background-color: #e2e8f0;
    }
    .h-100 {
        height: 100%!important;
    }
    .shadow-none {
        box-shadow: none!important;
    }
    
    
       .badge.badge-danger {
            background-color: #dc3545 !important;
            color: #fff !important;
        }

        .badge.badge-success {
            background-color: #28a745; /* Green color */
            color: #fff; /* White text */
        }

        /* Optional: Hover effect */
        .badge.badge-success:hover {
            background-color: #218838; /* Darker green color on hover */
            color: #fff; /* White text on hover */
        }

        .badge-info {
            color: #fff;
            background-color: #17a2b8;
        }
        .badge-light {
    color: #fff;
       background-color: #17a2b8;
}
</style>

    <div class="content-wrapper">

        <!-- Main content -->
        <section class="content">
  
    @if(session('error'))
        <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Success!</strong> {{ session('error') }}
        </div>
    @endif
    <div class="container">
        <div class="main-body">
            <div class="row gutters-sm">
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <img style="width:31%;" src="{{optional($instractor)->profile_photo['path']}}" alt="Admin" class="rounded-circle"  width="150">
                                <div class="mt-3">
                                    <h4>{{optional($instractor)->name}}</h4>
                                    <p class="text-secondary mb-1"><span class="badge badge-light" style="font-size: unset;">{{$instractor->email}}</span></p>

                                    @if($instractor->is_verified=='0')
                                        <a title="click to verify account" onclick="return confirm('Are you sure you want to Verify This Account?')"href="{{route('instructor_approve',$instractor->id)}}"><span class="badge badge-danger" style="font-size: unset;">Verify Now</span></a>
                                    @else
                                        <span  class="badge badge-success" style="font-size: unset;">Verified</span>
                                    @endif
                                    @if($instractor->is_blocked=='1')
                                        <a title="click to activate account" onclick="return confirm('Are you sure you want to Activate This Account?')" href="{{route('instructor_activate',$instractor->id)}}" ><span class="badge badge-danger" style="font-size: unset;">Active Account</span></a>
                                    @else
                                        <a href="{{route('instructor_activate',$instractor->id)}}" ><span title="click to deactive/block account" class="badge badge-success" style="font-size: unset;">Account Activate</span></a>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-globe mr-2 icon-inline"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg></h6>
                                <span class="text-secondary">{{optional($instractor->user_information)->website_url}}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-github mr-2 icon-inline"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path></svg></h6>
                                <span class="text-secondary">https://github.com/{{optional($instractor)->github_user_name}}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-twitter mr-2 icon-inline text-info"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg></h6>
                                <span class="text-secondary">{{optional($instractor->user_information)->twiter_link}}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M0 0v24h24v-24h-24zm8 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.397-2.586 7-2.777 7 2.476v6.759z"/></path></svg></h6>
                                <span class="text-secondary">{{optional($instractor->user_information)->linkdin_link}}</span>
                            </li>

                        </ul>
                    </div>

                </div>

                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h6 class="mb-0">Google authentication email address</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <span class="badge badge-success" style="font-size: unset;">{{optional($instractor->user_information)->google_auth_share_drive_email}}</span>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12">
                                    <h6 class="mb-0">GitHub user name</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <span class="badge badge-info" style="font-size: unset;">{{optional($instractor->user_information)->github_user_name}}</span>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12">
                                    <h6 class="mb-0">Exprience details</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{optional($instractor->user_information)->exprience_short_desc}}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12">
                                    <h6 class="mb-0">Slack invitation email address</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <span class="badge badge-warning" style="font-size: unset;">{{optional($instractor->user_information)->slack_mail_id}}</span>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12">
                                    <h6 class="mb-0">areas of subject matter expertise as indicated by graduate degrees</h6>
                                </div>
                                <div class="col-sm-12 text-secondary">
                                    @if(!empty($instractor->spasilization))
                                        @foreach($instractor->spasilization as $instractor->spasilizations)
                                            <span class="badge badge-dark" style="font-size: unset;"> {{$instractor->spasilizations->spacilazations->name}} </span>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <hr>
                            <div class="row">

                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
        </section>
    </div>
@endsection
