<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\user\Emaillog;
use App\OpenEmailLog;

class feedbackController extends Controller
{
    public function open()
    {
    	$logid=sp_decryption($_REQUEST['log']);
        $email_log=Emaillog::find($logid);

        $count = $email_log->open_count +1;
        $log_data = array('open_count'=>$count,'open_datetime'=>date('Y-m-d h:i:s'));
        Emaillog::addUpdateRecord($log_data,$logid);

        $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $_SERVER['REMOTE_ADDR'])); 

        $opened_log_data = array('log_id'=>$logid,'username'=>$_SERVER["REMOTE_ADDR"],'user_agent'=>$_SERVER['HTTP_USER_AGENT'],'latitude'=>$ipdat->geoplugin_latitude,'longitude'=>$ipdat->geoplugin_longitude,'city'=>$ipdat->geoplugin_city,'state'=>$ipdat->geoplugin_regionName,'country'=>$ipdat->geoplugin_countryName,'continent'=>$ipdat->geoplugin_continentName,'time_zone'=>$ipdat->geoplugin_timezone,'currency'=>$ipdat->geoplugin_currencyCode,'created_at'=>date('Y-m-d h:i:s'));
        OpenEmailLog::addUpdateRecord($opened_log_data,0);
    	return true;
    }
}
