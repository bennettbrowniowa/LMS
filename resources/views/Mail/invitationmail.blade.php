<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            padding: 0;
            margin: 0;
        }
        html {
            -webkit-text-size-adjust: none;
            -ms-text-size-adjust: none;
        }
        @media only screen and (max-device-width: 680px), only screen and (max-width: 680px) {
            *[class="table_width_100"] {
                width: 96% !important;
            }
            *[class="border-right_mob"] {
                border-right: 1px solid #dddddd;
            }
            *[class="mob_100"] {
                width: 100% !important;
            }
            *[class="mob_center"] {
                text-align: center !important;
            }
            *[class="mob_center_bl"] {
                float: none !important;
                display: block !important;
                margin: 0px auto;
            }
            .iage_footer a {
                text-decoration: none;
                color: #929ca8;
            }
            img.mob_display_none {
                width: 0px !important;
                height: 0px !important;
                display: none !important;
            }
            img.mob_width_50 {
                width: 40% !important;
                height: auto !important;
            }
        }
        .table_width_100 {
            width: 680px;
        }
    </style>
</head>
<body>
<div id="mailsub" class="notification" align="center">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="min-width: 320px;">
        <tr>
            <td align="center" bgcolor="#eff3f8">
                <table border="0" cellspacing="0" cellpadding="0" class="table_width_100" width="100%" style="max-width: 680px; min-width: 300px;">
                    <tr>
                        <td align="center" bgcolor="#ffffff">
                            <table width="90%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td align="center">
                                        <a href="#" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; float:left; width:100%; padding:20px;text-align:center; font-size: 13px;">
                                            <img src="{{ url('/') }}/uploads/generalSetting/{{ $generalDetails->site_logo }}" width="250" alt="{{ $companyDetails->company_name ?? '' }}" border="0" />
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td align="center" bgcolor="#fbfcfd">
                            <font face="Arial, Helvetica, sans-serif" size="4" color="#57697e" style="font-size: 15px;">
                                <table width="90%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td>
                                            Dear {{ $name ?? 'Student' }},<br/><br/>
                                            Welcome to {{ $companyDetails->company_name ?? '' }}!<br/><br/>
                                            Your account has been created, and the course link has been generated. Please use the following link to accept your invitation:<br/><br/>
                                            <a href="{{ route('course_invitation', ['token' => $invitation_token]) }}"
                                               style="margin: 20px; padding: 8px;
                                                                        border-radius: 0;
                                                                        -webkit-box-shadow: none;
                                                                        -moz-box-shadow: none;
                                                                        box-shadow: none;
                                                                        border-width: 1px;
                                                                        background-color: #00a65a;
                                                                        border-color: #0a818e;
                                                                        border: 1px solid transparent;
                                                                        color: #fff;
                                                                        text-decoration: none;
                                                        "> Accept Invitation</a><br/><br/>
                                            Your login details are as follows:<br/><br/>
                                            <strong>Email:</strong> {{ $email }}<br/>
                                            <strong>Password:</strong> {{ $password }}<br/><br/>
                                            <i>Please Keep Your Password Safe And Secure And After Login You Can Change Password And Name.</i><br/><br/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center">
                                            <div style="line-height: 24px;"></div>
                                            <div style="height: 60px; line-height: 60px; font-size: 10px;"></div>
                                        </td>
                                    </tr>
                                </table>
                            </font>
                        </td>
                    </tr>

                    <tr>
                        <td class="iage_footer" align="center" bgcolor="#ffffff">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td align="center" style="padding:20px;float:left;width:100%; text-align:center;">
                                        <font face="Arial, Helvetica, sans-serif" size="3" color="#96a5b5" style="font-size: 13px;">
                                                <span style="font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #96a5b5;">
                                                    {{ date('Y') }} © {{ $companyDetails->company_name ?? '' }}. All Rights Reserved.
                                                </span>
                                        </font>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
