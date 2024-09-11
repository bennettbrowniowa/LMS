<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=.1">
    <title></title>

    <style>
        .success-message {
            text-align: center;
        }

        .success-message__icon {
            max-width: 51px;
        }

        .success-message__title {
            color: #3DC480;
            transform: translateY(25px);
            opacity: 0;
            transition: all 200ms ease;
        }
        .active .success-message__title {
            transform: translateY(0);
            opacity: 1;
            font-size: 23px;
            margin: 5px 0;
        }

        .success-message__content {
            color: #B8BABB;
            transform: translateY(25px);
            opacity: 0;
            transition: all 200ms ease;
            transition-delay: 50ms;
        }
        .active .success-message__content {
            transform: translateY(0);
            opacity: 1;
        }

        .icon-checkmark circle {
            fill: #3DC480;
            transform-origin: 50% 50%;
            transform: scale(0);
            transition: transform 200ms cubic-bezier(0.22, 0.96, 0.38, 0.98);
        }
        .icon-checkmark path {
            transition: stroke-dashoffset 350ms ease;
            transition-delay: 100ms;
        }
        .active .icon-checkmark circle {
            transform: scale(1);
        }
    </style>
</head>
<body>



<div class="email-signature-1"
     style="width: 60%;
    margin: 25px 0px;
    border-radius: 5px;
    overflow: hidden;
            ">

    <div class="email-logo"
         style="text-align: center;
                    margin: 0;
                    font-size: 28px;
                    background: #e6e6e6;
                    color: white;">
        <img src="{{asset('uploads/generalSetting/'.$data->site_logo)}}" style="width: 82px">


    </div>

    <h2
        style="font-size: 22px;
                    text-align: center;
                    margin: 0;
                    padding: 18px 0;">

        Welcome to QU STEAM
    </h2>
    <div class="received-text-div">
        <div class="success-message">
            <svg viewBox="0 0 76 76" class="success-message__icon icon-checkmark">
                <circle cx="38" cy="38" r="36"/>
                <path fill="none" stroke="#FFFFFF" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M17.7,40.9l10.9,10.9l28.7-28.7"/>
            </svg>
            <h1 class="success-message__title">You Have Received Email Notification</h1>
            <div class="success-message__content">

            </div>
        </div>
    </div>

    <div class="user-id" style="display: flex; justify-content: center; margin-top: 10px;">

        <p
            style="padding: 10px 29px 0 0px;
                        font-size: 17px;
                        margin: 0;
                        margin: 0 75px 0 0;">
            <b>Email:</b> {{$email ?? ''}}
        </p>
    </div>
    <div class="user-id" style="display: flex; justify-content: center;">

        <p
            style="padding: 10px 29px 0 0px;
                        font-size: 17px;
                        margin: 0;
                        margin: 0 75px 0 0;">

            <b>Password:</b>Qusteam12345678
        </p>
    </div>

    <p
        style="text-align: center;
                    color: #8e8e8e;
                    padding-bottom: 12px;">

        You can now log in and start using our services .
    </p>
</div>





</body>
</html>
