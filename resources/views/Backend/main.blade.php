<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{Config('app.name')}}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{url('assets/backend/plugin/bootstrap/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{url('assets/backend/plugin/font-awesome/css/font-awesome.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{url('assets/backend/plugin/Ionicons/css/ionicons.min.css')}}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{url('assets/backend/plugin/select2/dist/css/select2.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{url('assets/backend/css/AdminLTE.min.css')}}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{url('assets/backend/plugin/iCheck/square/blue.css')}}">
    <!-- Datepicker -->
    <link rel="stylesheet" href="{{url('assets/backend/plugin/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
    <!-- Validation -->
    <link rel="stylesheet" href="{{url('assets/backend/plugin/validation/validationEngine.jquery.css')}}">
    <!-- Toaster-->
    <link rel="stylesheet" href="{{url('assets/backend/plugin/toastr/toastr.min.css')}}">
    <!-- Crop Image While Upload-->
    <link rel="stylesheet" href="{{url('assets/backend/plugin/Croppie/croppie.css')}}">
    <!-- Custom Skin -->
    <link rel="stylesheet" href="{{url('assets/backend/css/skins/custom.css')}}">
    <!-- Summernote Text Editor -->
    <link rel="stylesheet" href="{{url('assets/backend/plugin/summernote/summernote.css')}}">
    <!-- Datatables -->
    <link rel="stylesheet" href="{{url('assets/backend/plugin/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
{{--<link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">--}}
<!-- magnific-popup -->
    <link rel="stylesheet" href="{{url('assets/backend/plugin/magnific/magnific-popup.css')}}">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{url('assets/backend/css/custom.css')}}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

    <link rel="icon" type="image/png" href="{{url('uploads/profilePhoto/favico.jpg')}}">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/prismjs/themes/prism.css" rel="stylesheet"/>

    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' https://cdn.jsdelivr.net https://javafxpert.github.io;">
    <![endif]-->
    <!-- Google Font -->
    <link rel="stylesheet" href="{{url('assets/backend/font/style.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />


    <script type="text/javascript">
        var settings = {
            BaseURL:'{{route('baseURL')}}',
            logOutURL: '{{route('logout')}}',
            lockedURL: '{{route('locked')}}',
            idleCheckURL: '{{route('checkIdle')}}',
            countryWiseStateListURL: '{{route('countrywiseStateOptions')}}',
            LoaderGif: '{{url('assets/backend/img/loader.gif')}}'
        }
    </script>

    <style>

        /*@media only screen and (min-width: 990px) {*/
        /*    .main-sidebar {*/
        /*        min-width: 210px;*/
        /*    }*/
        /*}*/

        .sidebar-resizer {
            position: absolute;
            top: 0;
            right: 0;
            width: 19px;
            height: 100%;
            background: #ddd;
            cursor: ew-resize;
            z-index: 1000;
            transition: background-color 0.2s ease;
        }


        .sidebar-resizer:hover {
            background-color: #bbb;
        }

        @media (min-width: 768px) {
            .sidebar-resizer {
                display: block;
            }
        }

        @media (max-width: 768px) {
            .sidebar-resizer {
                display: none;
            }
        }

        .sidebar-menu {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu li {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .sidebar-menu li a {
            display: block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            padding: 10px;
            text-decoration: none;
            color: #333;
        }

        .sidebar-menu li.active a {
            background-color: #f0f0f0;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s ease;
        }

        .main-sidebar {
            transition: width 0.3s ease;
            overflow: hidden;
        }

        .sidebar-menu a {
            display: block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .learning-sequence-title {
            display: block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            padding: 5px;
            box-sizing: border-box;
            transition: width 0.3s ease;
        }

        .main-sidebar.expanded .learning-sequence-title {
            white-space: normal;
            overflow: visible;
            text-overflow: clip;
        }
        .custom-course-list {
            list-style-type: none;
            padding-left: 10px;
            display: none;
        }

        .skin-blue .sidebar-menu .treeview-menu > li > a {
            color: #000000 !important;
        }

        .custom-course-list.active {
            display: block !important;
            background-color: #fff !important;
        }

        .toggle-course-menu {
            cursor: pointer;
        }

        .rotate-down {
            transform: rotate(90deg);
            transition: transform 0.3s ease;
        }

        .treeview-menu {
            display: none;
            padding-left: 20px;
        }

        .treeview-menu.active {
            display: block;
        }

        .treeview-menu li.active > a {
            background-color: #e2e2e2;
            font-weight: bold;
        }


    </style>


</head>
<body class="hold-transition fixed skin-blue sidebar-mini  @if(AppSetting::SidebarMenuCollapse()) sidebar-collapse @endif">

<!-- Site wrapper -->
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="{{
    Auth::user()->hasRole('admin') ? route('dashboard') : (
    Auth::user()->hasRole('Instructor') ? route('instructor_dashboard') : route('student_dashboard')
) }}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><img src="{{ AppSetting::getLogo() }}" alt="logo"></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg">
        <img src="{{ AppSetting::getLogo() }}" alt="logo">
    </span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            @if(!Auth::user()->hasRole('Student'))
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
            @endif

            <div class="navbar-custom-menu">

                <ul class="nav navbar-nav">
                    <!-- Messages: style can be found in dropdown.less-->
                    <li class="dropdown messages-menu">
                        {{--                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">--}}
                        {{--                            <i class="fa fa-envelope-o"></i>--}}
                        {{--                            <span class="label label-success">4</span>--}}
                        {{--                        </a>--}}
                        <ul class="dropdown-menu">
                            {{--                            <li class="header">You have 4 messages</li>--}}
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                    <li><!-- start message -->
                                        <a href="#">
                                            <div class="pull-left">
                                                <img src="{{Auth::user()->profile_photo['path']}}" class="img-circle" alt="{{Auth::user()->name}}">
                                            </div>
                                            {{--                                            <h4>--}}
                                            {{--                                                Support Team--}}
                                            {{--                                                <small><i class="fa fa-clock-o"></i> 5 mins</small>--}}
                                            {{--                                            </h4>--}}
                                            {{--                                            <p>Why not buy a new awesome theme?</p>--}}
                                        </a>
                                    </li>
                                    <!-- end message -->
                                </ul>
                            </li>
                            {{--                            <li class="footer"><a href="#">See All Messages</a></li>--}}
                        </ul>
                    </li>
                    <!-- Notifications: style can be found in dropdown.less -->
                {{--                    <li class="dropdown notifications-menu">--}}
                {{--                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">--}}
                {{--                            <i class="fa fa-bell-o"></i>--}}
                {{--                            <span class="label label-warning">10</span>--}}
                {{--                        </a>--}}
                {{--                        <ul class="dropdown-menu">--}}
                {{--                            <li class="header">You have 10 notifications</li>--}}
                {{--                            <li>--}}
                {{--                                <!-- inner menu: contains the actual data -->--}}
                {{--                                <ul class="menu">--}}
                {{--                                    <li>--}}
                {{--                                        <a href="#">--}}
                {{--                                            <i class="fa fa-users text-aqua"></i> 5 new members joined today--}}
                {{--                                        </a>--}}
                {{--                                    </li>--}}
                {{--                                </ul>--}}
                {{--                            </li>--}}
                {{--                            <li class="footer"><a href="#">View all</a></li>--}}
                {{--                        </ul>--}}
                {{--                    </li>--}}
                <!-- Tasks: style can be found in dropdown.less -->
                {{--                    <li class="dropdown tasks-menu">--}}
                {{--                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">--}}
                {{--                            <i class="fa fa-flag-o"></i>--}}
                {{--                            <span class="label label-danger">9</span>--}}
                {{--                        </a>--}}
                {{--                        <ul class="dropdown-menu">--}}
                {{--                            <li class="header">You have 9 tasks</li>--}}
                {{--                            <li>--}}
                {{--                                <!-- inner menu: contains the actual data -->--}}
                {{--                                <ul class="menu">--}}
                {{--                                    <li><!-- Task item -->--}}
                {{--                                        <a href="#">--}}
                {{--                                            <h3>--}}
                {{--                                                Design some buttons--}}
                {{--                                                <small class="pull-right">20%</small>--}}
                {{--                                            </h3>--}}
                {{--                                            <div class="progress xs">--}}
                {{--                                                <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar"--}}
                {{--                                                     aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">--}}
                {{--                                                    <span class="sr-only">20% Complete</span>--}}
                {{--                                                </div>--}}
                {{--                                            </div>--}}
                {{--                                        </a>--}}
                {{--                                    </li>--}}
                {{--                                    <!-- end task item -->--}}
                {{--                                </ul>--}}
                {{--                            </li>--}}
                {{--                            <li class="footer">--}}
                {{--                                <a href="#">View all tasks</a>--}}
                {{--                            </li>--}}
                {{--                        </ul>--}}
                {{--                    </li>--}}
                <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{Auth::user()->profile_photo['path']}}" class="user-image profileImage" alt="{{Auth::user()->name}}">
                            <span class="hidden-xs">{{Auth::user()->name}}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="{{Auth::user()->profile_photo['path']}}" class="img-circle profileImage" alt="{{Auth::user()->name}}">
                                <p>
                                    {{Auth::user()->name}}
                                    <small>
                                        @php
                                            $roles = [];
                                        @endphp
                                        @foreach(Auth::user()->roles as $role)
                                            @php
                                                $roles[] = $role->display_name;
                                            @endphp
                                        @endforeach
                                        {{implode(', ',$roles)}}
                                    </small>
                                </p>
                            </li>

                            <!-- Menu Body -->
                            <li class="user-body">
                                <div class="row justify-content-center text-center">
                                    <div class="col-xs-12 text-center">
                                        <a href="{{route('generalProfile')}}">Edit Profile</a>
                                    </div>

                                </div>
                                <!-- /.row -->
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    @if(Auth::check())
                                        @if(Auth::user()->hasRole('admin'))
                                            <a href="{{ route('locked') }}" class="btn btn-default btn-flat">Locked</a>
                                        @elseif(Auth::user()->hasRole('Instructor'))
                                            <a href="{{ route('instructor_locked') }}" class="btn btn-default btn-flat">Locked</a>
                                        @elseif(Auth::user()->hasRole('Student'))


                                        @endif
                                    @endif
                                </div>
                                <div class="pull-right">
                                    @if(Auth::check())
                                        @if(Auth::user()->hasRole('admin'))
                                            <a href="{{ route('logout') }}" class="btn btn-default btn-flat">Log Out</a>
                                        @elseif(Auth::user()->hasRole('Instructor'))
                                            <a href="{{ route('instructor_logout') }}" class="btn btn-default btn-flat">Log Out</a>

                                        @elseif(Auth::user()->hasRole('Student'))
                                            <a href="{{ route('student_logout') }}" class="btn btn-default btn-flat" >Log Out</a>
                                        @endif
                                    @endif
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- =============================================== -->

    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <div class="sidebar-resizer"></div>
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{Auth::user()->profile_photo['path']}}" class="img-circle profileImage" alt="{{Auth::user()->name}}">
                </div>
                <div class="pull-left info">
                    <p>{{Auth::user()->name}}</p>
                    <small>
                        @php
                            $roles = [];
                        @endphp
                        @foreach(Auth::user()->roles as $role)
                            @php
                                $roles[] = $role->display_name;
                            @endphp
                        @endforeach
                        {{implode(', ',$roles)}}
                    </small>
                </div>
            </div>

            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" data-widget="tree">
                @role('admin')
                <li>
                    <a href="{{route('dashboard')}}">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    </a>
                </li>
                @endrole

                @role('Instructor')
                <li>
                    <a href="{{route('instructor_dashboard')}}">
                        <i class="fa fa-dashboard"></i> <span>Course</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('allGoal')}}">
                        <i class="fa fa-dashboard"></i> <span>Goal</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('allLearningSequence')}}">
                        <i class="fa fa-dashboard"></i> <span>Learning Engagement</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('allinstructorstudent')}}">
                        <i class="fa fa-dashboard"></i> <span>Student</span>
                    </a>
                </li>

                @endrole



                @role('admin')
                <li>
                    <a href="{{route('allUsers')}}">
                        <i class="fa fa-users"></i> <span>Users</span>
                    </a>
                </li>
                @endrole

                @role('admin')

                <li>

                    <a href="{{route('allInstructor')}}">
                        <i class="fa fa-users"></i> <span>Instructor</span>
                    </a>
                </li>
                <li>

                    <a href="{{route('allcourse')}}">
                        <i class="fa fa-users"></i> <span>Course</span>
                    </a>
                </li>

                <li>

                    <a href="{{route('allpubliccourse')}}">
                        <i class="fa fa-users"></i> <span>public Course</span>
                    </a>
                </li>
                @endrole




                @role('Student')
                <li>
                    <a href="{{ route('student_dashboard') }}">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    </a>
                </li>

                @php
                    $studentId = Auth::user()->id;
                      $instructorId = Auth::user()->instructor_id;

                    $publicCourses = App\Models\Course::where('visibility', 'public')
                    ->with(['learningSequences' => function ($query) {
                    $query->orderBy('course_learning_sequences.order_column', 'asc');
                        }])
                    ->get();


         $assignedCourses = App\Models\Course::whereHas('courseStudents', function ($query) use ($studentId) {
                  $query->where('student_id', $studentId);
              })
        ->with(['learningSequences' => function ($query) {
            $query->orderBy('course_learning_sequences.order_column', 'asc');
        }])
        ->get();


    $instructorCourses = App\Models\Course::whereHas('courseStudents', function ($query) use ($studentId, $instructorId) {
        $query->where('student_id', $studentId)
              ->where('instructor_id', $instructorId);
           })
         ->with(['learningSequences' => function ($query) {
            $query->orderBy('course_learning_sequences.order_column', 'asc');
            }])
        ->get();

         $invitedCourses = App\Models\Course::whereHas('invitations', function ($query) use ($studentId) {
                 $query->where('user_id', $studentId)
                     ->where('status', 'accepted');
                 })
             ->with(['learningSequences' => function ($query) {
                $query->orderBy('course_learning_sequences.order_column', 'asc');
               }])
               ->get();

             $courses = $publicCourses
                        ->merge($assignedCourses)
                        ->merge($instructorCourses)
                        ->merge($invitedCourses)
                        ->unique('id');

                    $currentCourseId = request()->route('courseId');
                    $currentLearningSequenceId = request()->route('sequenceId');
                    $isAnyCourseActive = $assignedCourses->pluck('learningSequences')->flatten()->contains('id', $currentCourseId);

                    $CourseIDS = [];
                @endphp
                @if($courses->isNotEmpty())
                <li class="treeview {{ $isAnyCourseActive ? 'menu-open' : '' }}">
                    <a href="#" class="toggle-course-menu">
                        <i class="fa fa-product-hunt"></i><span>Courses</span>
                        <span class="pull-right-container" style="right: 22px;">
              <i class="fa fa-chevron-right pull-right {{ $isAnyCourseActive ? 'rotate-down' : '' }}"></i>
                 </span>
                    </a>
                    <ul class="treeview-menu custom-course-list {{ $isAnyCourseActive ? 'active' : '' }}">
                        @foreach($courses as $course)
                            @php
                                $isCourseActive = $course->learningSequences->pluck('id')->contains($currentLearningSequenceId);
                            @endphp
                            <li class="treeview {{ $isCourseActive ? 'menu-open' : '' }}">
                                <a href="#" class="toggle-course-details" data-course-id="{{ $course->id }}">
                                    <i class="fa fa-angle-right"></i> {{ $course->title }}
                                </a>
                                <ul class="treeview-menu course-details {{ $isCourseActive ? 'active' : '' }}">
                                    @foreach($course->learningSequences as $learningSequence)
                                        <?php array_push($CourseIDS, $learningSequence->id); ?>
                                        <li class="{{ $currentLearningSequenceId == $learningSequence->id ? 'active' : '' }}">
                                            <a href="{{ route('show.course', ['courseId' => $learningSequence->id]) }}" data-sequence-id="{{ $learningSequence->id }}" class="learning-sequence-title">{{ $learningSequence->title }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </li>
                @endif
                @endrole



                @role('admin')
                <li>
                    <a href="{{route('allSpecialization')}}">
                        <i class="fa fa-users"></i> <span>Specialization</span>
                    </a>
                </li>
                @endrole


                @role('admin')
                <li>
                    <a href="{{route('allPedagogy')}}">
                        <i class="fa fa-users"></i> <span>Pedagogy Tools</span>
                    </a>
                </li>
                @endrole
                @role('admin')
                <li>
                    <a href="{{route('allResource')}}">
                        <i class="fa fa-users"></i> <span>Resource Type</span>
                    </a>
                </li>
                @endrole

                @role('admin')
                <li>
                    <a href="{{route('generalSetting')}}">
                        <i class="fa fa-cogs"></i> <span>Settings</span>
                    </a>
                </li>
                @endrole

            </ul>
        </section>

    </aside>

    @yield('content')

</div>

<div class="modal fade" id="AjaxModel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-times"></i></span>
                </button>
                <h4 class="modal-title" id="AjaxModelTitle">Default Modal</h4>
            </div>
            <div id="AjaxModelContent">
                <div class="modal-body text-center">
                    <img src="{{url('assets/backend/img/loader.gif')}}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-right btn-flat" data-dismiss="modal"><span class="fa fa-close"></span> Close</button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="cropImagePop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="modalLabel" class="modal-title">Crop Image</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div id="upload-demo" class="center-block"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                <button type="button" id="cropImageBtn" class="btn btn-primary btn-flat">Crop</button>
            </div>
        </div>
    </div>
</div>





<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Session Expiration Warning</h4>
            </div>
            <div class="modal-body">
                <p>You've been inactive for a while. For your security, we'll log you out automatically. Click "Stay Online" to continue your session. </p>
                <p>Your session will expire in <span class="bold" id="sessionSecondsRemaining">120</span> seconds.</p>
            </div>
            <div class="modal-footer">
                <button id="extendSession" type="button" class="btn btn-primary btn-flat" data-dismiss="modal">Stay Online</button>
                <a href="{{route('logout')}}" id="logoutSession" type="button" class="btn btn-default btn-flat" data-dismiss="modal">Logout</a>
            </div>
        </div>
    </div>
</div>



<!-- jQuery 3 -->
<script src="{{url('assets/backend/plugin/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{url('assets/backend/plugin/bootstrap/bootstrap.min.js')}}"></script>
<!-- Select2 -->
<script src="{{url('assets/backend/plugin/select2/dist/js/select2.full.min.js')}}"></script>
<!-- SlimScroll -->
<script src="{{url('assets/backend/plugin/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{url('assets/backend/plugin/fastclick/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{url('assets/backend/js/adminlte.min.js')}}"></script>
<!-- iCheck -->
<script src="{{url('assets/backend/plugin/iCheck/icheck.min.js')}}"></script>
<!-- Datepicker -->
<script src="{{url('assets/backend/plugin/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<!-- validation -->
<script src="{{url('assets/backend/plugin/validation/jquery.validationEngine-en.js')}}"></script>
<script src="{{url('assets/backend/plugin/validation/jquery.validationEngine.js')}}"></script>
<!--Toaster -->
<script src="{{url('assets/backend/plugin/toastr/toastr.min.js')}}"></script>
<!-- Crop Image While Upload-->
<script src="{{url('assets/backend/plugin/Croppie/croppie.js')}}"></script>
<!--Summernote Text Editor-->
<script src="{{url('assets/backend/plugin/summernote/summernote.js')}}"></script>
<!--magnific-popup -->
<script src="{{url('assets/backend/plugin/magnific/jquery.magnific-popup.js')}}"></script>
<!--Datatables-->
<script src="{{url('assets/backend/plugin/datatables.net-bs/js/jquery.dataTables.min.js')}}"></script>
<script src="{{url('assets/backend/plugin/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{url('assets/backend/plugin/datatables.net-bs/js/datatables.responsive.js')}}"></script>
<!-- Idle Timer-->
<script src="{{url('assets/backend/plugin/idle-timer/idle-timer.min.js')}}"></script>
{{--<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>--}}
<!-- cookies -->
<script src="{{url('assets/backend/plugin/cookies/jquery.cookie.js')}}"></script>

<!-- custom -->
<script src="{{url('assets/backend/js/app.js')}}"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/marked/2.0.0/marked.min.js"></script>
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/js-beautify/1.13.0/beautify-html.min.js"></script>--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/2.3.2/purify.min.js"></script>



<script src="https://cdn.jsdelivr.net/npm/prismjs/prism.js"></script>
<!-- Tree.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>



<script>
    $(".permissionDenied").append('<div class="image"></div><img src="{{asset('assets/backend/img/deniedPermission.png')}}">');

    @if (Session::has('success'))
        toastr["success"]("{{ Session::get('success') }}");
    @endif
        @if (Session::has('info'))
        toastr["info"]("{{ Session::get('info') }}");
    @endif
        @if (Session::has('warning'))
        toastr["warning"]("{{ Session::get('warning') }}");
    @endif
        @if (Session::has('error'))
        toastr["error"]("{{ Session::get('error') }}");
    @endif

    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.querySelector('.main-sidebar');
        const resizer = document.querySelector('.sidebar-resizer');
        let isResizing = false;
        const minWidth = 210;
        let maxWidth = window.innerWidth * 0.5;

        resizer.addEventListener('mousedown', function(e) {
            isResizing = true;
            e.preventDefault();
            e.stopPropagation();
            document.addEventListener('mousemove', handleMouseMove);
            document.addEventListener('mouseup', handleMouseUp);
        });

        function handleMouseMove(e) {
            if (isResizing) {
                e.preventDefault();
                e.stopPropagation();
                let newWidth = e.clientX - sidebar.getBoundingClientRect().left;
                newWidth = Math.max(minWidth, Math.min(newWidth, maxWidth));
                sidebar.style.width = `${newWidth}px`;
                sidebar.classList.add('resized');
                adjustMenuLinkOverflow(newWidth);
            }
        }

        function handleMouseUp() {
            isResizing = false;
            document.removeEventListener('mousemove', handleMouseMove);
            document.removeEventListener('mouseup', handleMouseUp);
        }

        window.addEventListener('resize', function() {
            maxWidth = window.innerWidth * 0.5;
            let currentWidth = parseInt(getComputedStyle(sidebar).width, 10);
            if (currentWidth > maxWidth) {
                sidebar.style.width = `${maxWidth}px`;
            }
            adjustMenuLinkOverflow(currentWidth);
        });

        function adjustMenuLinkOverflow(currentWidth) {
            const links = sidebar.querySelectorAll('.learning-sequence-title');
            if (currentWidth > minWidth) {
                links.forEach(link => {
                    link.style.whiteSpace = 'normal';
                    link.style.overflow = 'visible';
                    link.style.textOverflow = 'clip';
                });
            } else {
                links.forEach(link => {
                    link.style.whiteSpace = 'nowrap';
                    link.style.overflow = 'hidden';
                    link.style.textOverflow = 'ellipsis';
                });
            }
        }

        adjustMenuLinkOverflow(parseInt(getComputedStyle(sidebar).width, 10));

        const learningSequenceLinks = document.querySelectorAll('.sidebar-menu a[data-sequence-id]');

        learningSequenceLinks.forEach(link => {
            link.addEventListener('click', function() {
                sidebar.classList.remove('expanded', 'resized');
                adjustMenuLinkOverflow(parseInt(getComputedStyle(sidebar).width, 10));
            });
        });

        document.querySelectorAll('.toggle-course-details').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                sidebar.classList.toggle('expanded');
                adjustMenuLinkOverflow(parseInt(getComputedStyle(sidebar).width, 10));
            });
        });
    });








    $(document).ready(function() {
        $('.toggle-course-menu').click(function(e) {
            e.preventDefault();
            var $this = $(this);
            var $courseMenu = $this.closest('li.treeview').find('.custom-course-list');
            var $chevronIcon = $this.find('.fa-chevron-right');
            $chevronIcon.toggleClass('rotate-down');
            $courseMenu.toggleClass('active');
            $courseMenu.css('display', $courseMenu.hasClass('active') ? 'block' : 'none');
        });

        $('.toggle-course-details').click(function(e) {
            e.preventDefault();
            var $this = $(this);
            var $sequenceMenu = $this.closest('li.treeview').find('.course-details');
            var $angleIcon = $this.find('.fa-angle-right');
            $angleIcon.toggleClass('fa-angle-down');
            $sequenceMenu.toggleClass('active');
            $sequenceMenu.css('display', $sequenceMenu.hasClass('active') ? 'block' : 'none');

            var $parentCourseMenu = $this.closest('li.treeview').find('.custom-course-list');
            if (!$parentCourseMenu.hasClass('active')) {
                $parentCourseMenu.addClass('active').css('display', 'block');
                $parentCourseMenu.closest('li.treeview').find('.fa-chevron-right').addClass('rotate-down');
            }
        });

        var currentCourseId = '{{ $currentCourseId ?? '' }}';
        var currentLearningSequenceId = '{{ $currentLearningSequenceId ?? '' }}';

        if (currentCourseId) {
            $('.treeview').each(function() {
                var $this = $(this);
                var courseId = $this.find('.toggle-course-details').data('course-id');
                if (courseId == currentCourseId) {
                    var $courseMenu = $this.find('.custom-course-list');
                    $courseMenu.addClass('active').css('display', 'block');
                    $this.find('.fa-chevron-right').addClass('rotate-down');

                    $this.find('.course-details').each(function() {
                        var $sequenceMenu = $(this);
                        var isSequenceActive = $sequenceMenu.find('a[data-sequence-id="' + currentLearningSequenceId + '"]').length;
                        if (isSequenceActive) {
                            $sequenceMenu.addClass('active');
                            $sequenceMenu.closest('li.treeview').find('.fa-angle-right').removeClass('fa-angle-right').addClass('fa-angle-down');

                            var $parentCourseMenu = $sequenceMenu.closest('li.treeview').find('.custom-course-list');
                            if (!$parentCourseMenu.hasClass('active')) {
                                $parentCourseMenu.addClass('active').css('display', 'block');
                                $parentCourseMenu.closest('li.treeview').find('.fa-chevron-right').removeClass('fa-chevron-right').addClass('fa-angle-down');
                            }
                        }
                    });
                }
            });
        }
    });









</script>













@stack('script')
</body>
</html>
