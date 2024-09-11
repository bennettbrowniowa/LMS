@extends('Backend.main')

@section('content')
    <div class="content-wrapper">


        <!-- Main content -->
        <section class="content">

            <div class="row">
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon"><img class="admin-home-image-3" src="{{url('/')}}/uploads/profilePhoto/user-gear.png"></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Admin</span>
                            <span class="info-box-number">{{$data['admins'] ?? ''}}</span>
                        </div>

                    </div>
                </div>

                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-yellow"> <img class="admin-home-image-3" src="{{url('/')}}/uploads/profilePhoto/instructor.png"></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Approved Instructor</span>
                            <span class="info-box-number">{{$data['approved_instractor'] ?? ''}}</span>
                        </div>

                    </div>

                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua"><img class="admin-home-image-3" src="{{url('/')}}/uploads/profilePhoto/instructor.png"></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Pending Instructor</span>
                            <span class="info-box-number">{{$data['pending_instractor'] ?? ''}}</span>
                        </div>

                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-red"><img class="admin-home-image-3" src="{{url('/')}}/uploads/profilePhoto/instructor.png"></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Todays Instructor</span>
                            <span class="info-box-number">{{$data['today_instractor'] ?? ''}}</span>
                        </div>

                    </div>

                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-blue"><img class="admin-home-image-3" src="{{url('/')}}/uploads/profilePhoto/instructor.png"></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Blocked Instructor</span>
                            <span class="info-box-number">{{$data['block_instractor'] ?? ''}}</span>
                        </div>

                    </div>

                </div>

                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-green"><img class="admin-home-image-3" src="{{url('/')}}/uploads/profilePhoto/instructor.png"></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Specialization</span>
                            <span class="info-box-number">{{$data['specialization'] ?? ''}}</span>
                        </div>


                    </div>
                </div>


            </div>

            <!-- /.box -->

        </section>
        <!-- /.content -->
    </div>
@endsection
