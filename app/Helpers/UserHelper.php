<?php
namespace App\Helpers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;

use Illuminate\Support\Facades\Session;

class UserHelper
{
    public static function User_status_check($return_value)
    {
        $userInfo=User::where('id',Auth::user()->id)->first();
        return $userInfo->$return_value;
    }
    public static function get_user_info($passing_value,$matching_value,$return_value)
    {
        $userInfo=User::where($matching_value,$passing_value)->first();
        return $userInfo->$return_value;
    }

    public static function sent_email($mail_id,$subject,$body){
        $url = 'https://api2.juvlon.com/v4/httpSendMail';
 $data = '{"ApiKey":"OTg2NDIjIyMyMDIzLTEyLTI5IDE2OjE3OjU0",
    "requests":
          [{
            "subject":"'.$subject.'",
            "from":"sagorika@technexttechnosoft.com",
            "body":"'.$body.'",
            "to":"'.$mail_id.'"
          }]
        }';
$options = array(
       'http' => array(
           'header'  => "Content-type: application/json\r\n",
           'method'  => 'POST',
           'content' => $data
            )
        );
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);

    }

}
