<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\user\Setting;
use App\OpenEmailLog;

class verifyController extends Controller
{
    public function verifyEmail()
    {
        $email=base64_decode(base64_decode($_REQUEST['config']));
        $string=explode('###', $email);
        $param['email']=$string[0];
        $param['token']=$string[1];
        $param['name']='emailconfig';
        $data=Setting::checkVerifyRequest($param);
        if($data){
            $updated_data = array('verified_at'=>date('Y-m-d h:i:s'),'is_verify'=>1,'token'=>NULL);
            $action=Setting::addUpdateRecord($updated_data,$data->id);
            if($action){
                session()->flash('succ_msg','Email Address Verified Succesfully.');
            }else{
                session()->flash('fail_msg','Something Went Wrong. Please try again!! ');
            }
        }else{
            session()->flash('fail_msg','Sorry !! We could not found any verify request for you.');
        }
        return redirect('dashboard');
    }
}
