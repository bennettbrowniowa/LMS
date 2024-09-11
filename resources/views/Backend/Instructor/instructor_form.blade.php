
<style>

    /*=============== basic css ===============*/

body {
	background-color: white;
	margin: 0px;
	overflow-x: hidden !important;
	font-family: 'Blinker';
	scroll-behavior: smooth !important;
}

*{
	margin: 0px;
}

p{
	margin: 0px;
}

a{
	margin: 0px;
	text-decoration: none;
	color: black;
}

a:hover{
	color: black;
	text-decoration: none;
}

.row{
	margin-right: 0px;
	margin-left: 0px;
}

ul{
	margin: 0px;
	padding: 0px;
	list-style-type: none;
}

img{
	width: 100%;
	height: 100%;
}

h1, h2, h3, h4, h5, h6{
	margin: 0px;
}

button{
	outline: none;
}

input{
	outline: none !important;
}

textarea{
	outline: none;
}

select{
	outline: none;
}

option{
	outline: none;
}

/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
	-webkit-appearance: none;
	margin: 0;
}

/* Firefox */
input[type=number] {
	-moz-appearance: textfield;
}

.container {
    max-width: 1264px;
}



@media only screen and (min-width: 1500px) {

}

/*=============== /basic css ===============*/

/*=============== font css ===============*/

/* latin-ext */
@font-face {
  font-family: 'Blinker';
  font-style: normal;
  font-weight: 300;
  font-display: swap;
  src: url(https://fonts.gstatic.com/s/blinker/v13/cIf4MaFatEE-VTaP_IWDdGgmnbJk.woff2) format('woff2');
  unicode-range: U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
}
/* latin */
@font-face {
  font-family: 'Blinker';
  font-style: normal;
  font-weight: 300;
  font-display: swap;
  src: url(https://fonts.gstatic.com/s/blinker/v13/cIf4MaFatEE-VTaP_IWDdGYmnQ.woff2) format('woff2');
  unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
}

/*=============== /font css ===============*/

/*=============== main css ===============*/

.sidebar-1{
	padding: 0;
}
.navbar-1 {

    height: 100vh;
    background-color: white;
    box-shadow: 0 5px 18px 0 #00000029;
    position: fixed;
    width: 18%;
    top:0;
}
.home-logo-h1{
	font-size: 35px;
  padding: 15px 0;
}
.menu-li {
    background: #e2e2e2;
    margin: 15px 10px;
    padding: 8px;
    border-radius: 3px;
}

.menu-li:hover{
	background: #e77b234f;
	color: black;
	border-left: 4px solid #e77b23;
}
.menu-a i{
    font-size: 13px;
    padding: 5px;
}
.menu-a-1 i{
    font-size: 13px;
    padding: 5px;
}
.menu-a-2 i{
    font-size: 13px;
    padding: 5px;
}
.menu-li-2 {
    background: #e77b23;
    margin: 15px 10px;
    padding: 8px;
    border-radius: 3px;
    color: white;
}
.menu-li-2 a{
	color: white;
}
.menu-li-2 i{
	color: white;
}
.dropdown-1 {
    width: 89%;
    height: 100%;
    margin: 0 auto;
    display:none;
    position: relative;
    padding: 0 10px;
}
.drop-li{
    padding-bottom: 10px;
}
.drop-li a{
    font-size: 14px;
    padding: 0 10px;
}
.drop-li i{
    padding: 0 10px;
}
.admin-home-div-1 {
    padding: 24px 10px;
}
.admin-home-heading-1 {
    box-shadow: 0 4px 35px 5px #dededeb0;
    padding: 10px 26px;
    border-radius: 5px;
}
.admin-home-div-2 {
    padding: 10px 15px;
    box-shadow: 0 4px 34px 5px #dedede;
    border-radius: 5px;
    position: relative;
}
.admin-home-image-3 {
    position: absolute;
    width: 70px;
    height: 70px;
    top: 39px;
    right: 14px;
    opacity: 0.8;
}
.admin-home-text-2 p{
		font-size: 13px;
    line-height: 20px;
}
.admin-home-text-2 {
    border-left: 4px solid #e77b23;
    padding: 2px 0px 2px 8px;
}
.home-profile-1 img{
		width: 30px;
    height: 30px;
}
.home-profile-1{
	padding: 17px 0 0 0;
}
.home-profile-1-p {
    font-size: 23px;
}
.chart {
    box-shadow: 0 5px 18px 0 #0000003d;
    padding: 23px;
}
.menu-li.active{
    background: #e77b234f;
    color: white;
    border-left: 4px solid #e77b23;
}
.dropdown-content {
    display: none;
    position: relative;
    background-color: #ffffff;
    width: 90%;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
    margin: 0 auto;
    margin-top: -15px;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  text-align: left;
}

.dropdown-content a:hover {
    background-color: #e77b2330;
}

.dropdown:hover .dropdown-content {
  display: block;
}
.dropdown-content-1 {
    display: none;
    position: relative;
    background-color: #ffffff;
    width: 100%;
    box-shadow: 0px 2px 7px 0px rgba(0,0,0,0.2);
    z-index: 1;
    margin: 0 auto;
    margin-top: 6px;
}
.dropdown-content-1 a {
  color: black;
  padding: 9px 16px;
  text-decoration: none;
  display: block;
  text-align: left;
}
.dropdown:hover .dropdown-content-1 {
  display: block;
}
.content-2 a {
    color: black;
    padding: 7px 7px;
    text-decoration: none;
    display: block;
    text-align: left;
    font-size: 12px;
}
.dropdown-content-1 a:hover {
    background-color: #e77b2330;
}


/*=============== /main css ===============*/

/*=============== login css ===============*/

.admin-login {
    background-color: white;
    padding: 21px;
    border-top: 3px solid #e77b23;
    box-shadow: 0 5px 15px 0 #0000003d;
}
.admin-login-btn {
    background: #1b75d0;
    width: 100%;
    color: white !important;
}
.admin-login-btn:hover {
    color: white;
}
.admin-login-1 {
    margin-top: 126px;
}
.input-title-group {
    justify-content: space-between;
}
.input-group-1 label{
    font-size: 15px;
    font-weight: 600;
    margin-bottom: 5px;
}
.forgot-password-btn {
    color: #1ba0e4;
    font-size: 13px;
}
.login-select-1:focus{
	box-shadow: none;
}
.login-input-1:focus{
    box-shadow: none;
}
.admin-logo-h1 {
    text-align: center;
    font-size: 25px;
    margin-bottom: 21px;
}
.logo-1 {
    height: auto;
    width: 91px;
    margin: 0 auto 10px auto;
}
.admin-logo{
    text-align: center;
}

/*=============== / login css ===============*/

/*=============== sidenav css ===============*/
.sidenav {
  height: 100%;
  width: 0;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: white;
  overflow-x: hidden;
  transition: 0.5s;
  padding-top: 60px;
  box-shadow: 0 10px 25px 0 #00000030;
}

.sidebar-menu-ul a {
  padding: 9px 8px 9px 5px;
    text-decoration: none;
    font-size: 16px;
    color: #000000;
    display: block;
    transition: 0.3s;
}

.sidenav a:hover {
  color: #f1f1f1;
}

.sidenav .closebtn {
  position: absolute;
  top: 0;
  right: 25px;
  font-size: 36px;
  margin-left: 50px;
}
.mobile-nav{
	display: none;
}

@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}
/*=============== /sidenav css ===============*/

/*=============== profile css ===============*/

.profile-1 {
    padding: 15px;
}
.my-profile-h2 {
    padding: 15px;
    font-size: 32px;
}
.my-profile-heading{
    border-radius: 5px;
    box-shadow: 0 3px 14px 5px #80808040;
}
.profile-img-1 {
    box-shadow: 0 5px 13px 8px #80808038;
    margin-top: 38px;
/*    text-align: center;*/
    padding: 25px 10px;
}
.profile-img-1 .img-1{
    text-align: center;
    margin-top: -73px;
}
.admin-profile-img {
    width: 150px;
    height: 150px;
    margin: 0 auto;
}
.profile-name-h3 {
    font-size: 27px;
    color: black;
    font-weight: 600;
    padding: 12px 0;
    text-align: center;
}
.profile-name-p {
    text-align: center;
    font-size: 14px;
    line-height: 20px;
    padding: 0 15px;
}
.profile-details-1{
    box-shadow: 0 5px 13px 8px #80808038;
    margin-top: 38px;
    padding: 25px 15px;
    position: relative;
}
.profile-details-h4 {
    border-bottom: 1px solid;
    width: fit-content;
    padding-bottom: 9px;
}
.profile-details-text {
    margin-top: 14px;
    padding: 0 13px;
}
.profile-text-2 p{
    font-weight: bold;
    font-size: 13px;
    padding: 0 14px 0 0px;
}
.profile-text-3 p{
    font-size: 12px;
}
.profile-text-1{
    padding: 5px 0;
}
.edit-icon{
    position: absolute;
    right: 21px;
    top: 8px;
    background: #e77b23;
    color: white;
    padding: 6px 10px;
    border-radius: 50px;
}
.img-1{
    position: relative;
}
.edit-icon-2 {
    display: flex;
    justify-content: center;
}
.edit-icon-1 {
    background: #e77b23;
    color: white;
    padding: 5px 10px;
    border-radius: 50px;
    font-size: 11px;
    margin: 0 2px;
}

/*=============== /profile css ===============*/

/*=============== form css ===============*/

.form-div-1{
    box-shadow: 0 5px 15px 2px #dbdbdb;
    background: white;
    margin: 25px auto 0 auto;
}
.form-div-inner-h1 {
    font-size: 23px;
    font-weight: 600;
    letter-spacing: 1px;
}
.form-div-2 {
    background: #ffa55c;
    padding: 12px 0;
    color: black;
    overflow: hidden;
    border-radius: 5px;
    height: 131px;
}
.form-div-inner-p {
    font-size: 13px;
    margin-top: 10px;
    line-height: 15px;
}
.form-div-inner-img{
    transform: rotate(339deg);
    text-align: end;
}
.form-div-inner-img img{
    width: 150px;
}
.form-div-3 {
    background: #ffdabc;
    border-radius: 5px;
    margin-top: 15px;
    padding: 7px 12px;
    position: relative;
}
.form-div-3-img{
    width: 20px;
    height: 20px;
    background: white;
    border-radius: 50px;
    margin-top: 4px;
}
.form-div-3-p {
    font-weight: 600;
    padding-left: 10px;
}
.form-div-3-icon {
    position: absolute;
    right: 18px;
}
.form-div-3-icon img{
    width: 20px;
    height: 20px;
    margin-top: -31px;
}
.form-div-4 p{
    text-align: center;
    font-size: 22px;
    font-weight: 700;
}
.form-div-5.mb-3 {
    box-shadow: 0 5px 15px 5px #8080803d;
    padding: 12px 15px;
    border-left: 4px solid white;
    transition: .5s;
}
.form-div-5.active {
    border-left: 4px solid #ffa55c;
    box-shadow: 0 2px 13px 1px #8080803d;
    transition: .5s;
}
.form-input-div-1 {
    border: none;
    border-bottom: 1px solid #ffa55c;
    border-radius: 0;
    margin-bottom: 9px;
}
.form-input-div-1:focus{
    box-shadow: none;
    border: 1px solid #ffa55c;
}
.form-input-div-label{
    font-weight: bold;
}
.form-button {
    text-align: center;
    padding: 30px 0 10px 1px;
}
.btn-form-submit {
    background: #e77b23;
    color: white;
    padding: 5px 33px;
    text-align: center;
}
.btn-form-submit:hover{
    color: white;
}

/*=============== /form css ===============*/

/*=============== add admin css ===============*/

.add-admin-heading-1 {
    background: white;
    margin-top: 20px;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 4px 35px 5px #dededeb0;
}
.add-admin-div-2 {
    background: white;
    padding: 20px;
    margin-top: 50px;
}
.admin-control {
    padding: 10px;
    height: auto;
}
.admin-control:focus{
    box-shadow: none;
}
.add-admin-button{
    text-align: center;
}
.btn-admin-1 {
    border: none;
    background: #e77b23;
    color: white;
    padding: 6px 29px;
    border-radius: 5px;
}.navbar-1
.admin-label {
    color: black;
    font-weight: 600;
    font-size: 14px;
}

/*=============== add admin css ===============*/
/*=============== table css ===============*/

.admin-table-2 {
    width: 100%;
    background: white;
}
.admin-th-1{
    padding: 8px;
    border-right: 1px solid #8a8a8a;
    background: #9f9f9f;
    color: white;
}
.admin-tr-1{
    /*border: 1px solid #c5c5c5;*/
}
.admin-td-1 {
    border-right: 1px solid #cbcbcb;
    padding: 6px;
}
.admin-table-1 {
    background: white;
    padding: 26px 16px;
}
.admin-table-inner {
    display: flex;
}
.admin-table-img-01{
    width: 31px;
}
.admin-table-p-01 {
    padding: 5px 10px;
}
.admin-table-p-02 {
    font-size: 15px;
    margin-bottom: 3px;
}
.edit-icon-2 {
    display: flex;
    justify-content: center;
}
.edit-icon-1 {
    background: #e77b23;
    color: white;
    border-radius: 50px;
    font-size: 11px;
    margin: 0 2px;
    width: 30px;
    height: 30px;
    padding: 8px 10px;
}
.admin-table-btn-1 {
    border: none;
    background: #e77b23;
    color: white;
    margin-right: 8px;
    padding: 5px 14px;
    border-radius: 50px;
    font-size: 14px;
}
.admin-table-btn-2{
    border: none;
    background: #169100;
    color: white;
    margin-right: 8px;
    padding: 5px 14px;
    border-radius: 50px;
    font-size: 14px;
}
.act{
    background: #efefef;
    /*border: 1px solid #c5c5c5;*/
}

.icheckbox_square-blue div div {
    position: absolute !important;
    left: 101px !important;
    width: 200px !important;
    margin-top: -5px !important;
}

/*=============== /table css ===============*/
</style>


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
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Google Font -->
    <link rel="stylesheet" href="{{url('assets/backend/font/style.css')}}">

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
</head>
<body>

<div class="main_div">

 @if ($errors->any())
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<form action="{{route('save_form')}}" method="post" id="validation">
    {{csrf_field()}}
    <div class="container-fluid my-4">
        <div class="row justify-content-center">
            <div class="col-lg-12 form-div-1 py-4">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="form-div-2 d-flex">
                            <div class="form-div-2-inner col-lg-10">
                                <h2 class="form-div-inner-h1">Registration with QuSTEAM community of instructors and industry experts</h2>

                                <p class="form-div-inner-p">This form provides the QuSTEAM user with instructor permissions across a variety of resources for accessing, contributing, and reviewing curriculum materials.</p>
                            </div>
                            <div class="form-div-2-inner col-lg-4 d-none d-lg-block">
                                <div class="form-div-inner-img">
                                    <img src="{{asset('uploads/generalSetting/'.$data->site_logo)}}" style="max-width: 100%;max-height: 100px;">
                                </div>
                            </div>
                        </div>

                        <div class="form-div-3 mb-3 d-flex">
                            <img class="form-div-3-img" src="{{Auth::user()->profile_photo['path']}}" alt="">
                            <p class="form-div-3-p">{{Auth::user()->email}}</p>
                            <div class="form-div-3-icon">
                                <img src="{{url('/')}}/uploads/profilePhoto/done.png" alt="">
                            </div>
                        </div>

                        <div class="form-div-4 mb-3">
                            <p>Indicates required question</p>
                        </div>
                        <div class="form-div-5 mb-3">
                            <label for="name" class="form-input-div-label">Name</label>
                            <input type="text" name="name"  class="validate[required] form-control form-input-div-1" disabled value="{{Auth::user()->name}}">
                        </div>
                        <div class="form-div-5 mb-3">
                            <label for="name" class="form-input-div-label">Professional email address</label>
                            <input type="email" name="email" class="validate[required] form-control form-input-div-1" disabled value="{{Auth::user()->email}}">
                        </div>
                        <div class="form-div-5 mb-3">
                            <label for="name" class="form-input-div-label">Professional webpage address(es). (Instructors: please include your institutional faculty webpage. Researchers: please include lab group webpage. Industry experts: please include your company team's webpage or other page that best clarifies your role. All experts: feel free to include an additional relevant webpage such as google scholar or a page about your professional work.)</label>
                            <input type="text" name="webaddress" value="{{old('webaddress')}}" class="validate[required] form-control form-input-div-1" placeholder="Your Answer">

                        </div>
                        <div class="form-div-5 mb-3">
                            <label for="name" class="form-input-div-label">Google authentication email address, if different than professional email address (used, for example, for access to QuSTEAM Shared Drive)</label>
                            <input type="text" name="google_auth_id"  class="validate[required] form-control form-input-div-1" value="{{Auth::user()->email}}">

                        </div>
                        @if(Auth::user()->auth_type=='github')
                            <div class="form-div-5 mb-3">
                                <label for="name" class="form-input-div-label">GitHub user name (used for access to QuSTEAM repositories)</label>
                                <input type="text" name="gihub_id"  class="validate[required] form-control form-input-div-1" value="{{Auth::user()->github_user_name}}">

                            </div>
                        @else
                            <div class="form-div-5 mb-3">
                                <label for="name" class="form-input-div-label">GitHub user name (used for access to QuSTEAM repositories)</label>
                                <input type="text" name="gihub_id" value="{{old('gihub_id')}}" class="validate[required]form-control form-input-div-1" placeholder="Your Answer">

                            </div>
                        @endif
                        <div class="form-div-5 mb-3">
                            <label for="name" class="form-input-div-label">Slack invitation email address, if different than professional email (used for the community discussions)</label>
                            <input type="text" name="Slack_email" value="{{old('Slack_email')}}" class=" validate[required] form-control form-input-div-1" placeholder="Your Answer">

                        </div>
                        <div class="form-div-5 mb-3">
                            <label for="name" class="form-input-div-label">LinkedIn page</label>

                     <input type="text" name="linkdin_link" value="{{ old('linkdin_link') }}" class="validate[required] form-control" placeholder="LinkedIn Link">


                        </div>
                        <div class="form-div-5 mb-3">
                            <label for="name" class="form-input-div-label">Twitter handle</label>
                            <input type="text" name="twiter_link" value="{{old('twiter_link')}}" class="validate[required] form-control form-input-div-1" placeholder="Your Answer">

                            <div class="form-div-5 mb-3">
                                <label for="name" class="form-input-div-label mb-4">Please mark your areas of subject matter expertise as indicated by graduate degrees, publications, and faculty appointments. For subject matter expertise based on other qualifications, provide that information in the next question rather than this question.</label>
                                @if(!empty($Specialization))
                                    @foreach($Specialization as $Specializations)
                                  <div class="form-div-inner-5 form-check">
                                            <input type="checkbox" value="{{$Specializations->id}}" {{ in_array($Specializations['id'], old('Specialization', [])) ? 'checked' : '' }} name="Specialization[]"  class="validate[required] form-check-input" id="check1">
                                            <label class="form-check-label" for="check1">{{$Specializations->name}}</label>
                                        </div>
                                    @endforeach
                                @endif

                                <div class="form-check d-lg-flex d-block align-items-center">
                                    <input type="checkbox" {{ old('oth_item') == 'Yes' ? 'checked' : '' }} class="form-check-input" name="oth_item" id="check9" value="others_type">
                                    <label class="form-check-label" for="check9">Others</label>
                                </div>

                                <div id="other_value_container" style="{{ old('oth_item') == 'Yes' ? '' : 'display: none;' }}">
                                    <input type="text" name="other_value" value="{{ old('other_value') }}" class="validate[required] form-control form-input-div-1 mx-4" placeholder="Your Answer">
                                </div>


                            </div>
                            <div class="form-div-5 mb-3">
                                <label for="name" class="form-input-div-label">If your qualifications are based on experience, please summarize your qualification as an expert in one or more disciplines as suggested in the previous question. Also use this question to be more specific about your expertise (e.g., "My research focuses on nitrogen vacancies in diamond.")</label>
                                <input type="text" name="exprience_details" value="{{old('exprience_details')}}" class=" validate[required] form-control form-input-div-1" placeholder="Your Answer">

                            </div>

                            <div class="form-button">
                                <button type="submit" class="btn btn-form-submit">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
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

<script>
    jQuery("#validation").validationEngine({promptPosition: 'inline'});



</script>

<script>
  $('#check9').on('ifChecked', function(event){
        $('#other_value_container').show();
    });
    $('#check9').on('ifUnchecked', function(event){
        $('#other_value_container').hide();
    });
</script>



</body>
</html>

