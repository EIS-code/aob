<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class loginModel extends Model
{

    public static function checkAdminUser($email,$password)
    {
        $data = DB::table(CUSTOMER_TABLE)->where([ ['email','=',$email],['password','=',$password],['role_id','=',1] ])->get()->first();
        if($data){
            $number=rand(1001,9999);
            $login_token= $data->id.'spi'.$number;
            $login_token= sp_encryption($login_token);
            $updated=DB::table(CUSTOMER_TABLE)->where('id',$data->id)->update([ 'login_number'=>$number,'login_token'=>$login_token ]);
            if($updated){
                $data1['data']=$data;
                $data1['login_token']=$login_token;
                $data1['login_number']=$number;
                $data1['msg']='Login Succesfully.';
                $data1['code']=1;
                return $data1;
            }else{
                $data1['code']=0;
                $data1['msg']='Something Went Wrong.<br>Please Try Again...';
                return $data1;
            }
        }else{
                $data1['code']=0;
                $data1['msg']='Please Enter correct Email or Password.';
                return $data1;
        }
    }
    public static function checkUser($email,$password)
    {
    	$data = DB::table(CUSTOMER_TABLE)->where([ ['email','=',$email],['password','=',$password],['role_id','=',2] ])->get()->first();
    	if($data){
    		$number=rand(1001,9999);
    		$login_token= $data->id.'spi'.$number;
    		$login_token= sp_encryption($login_token);
    		$updated=DB::table(CUSTOMER_TABLE)->where('id',$data->id)->update([ 'login_number'=>$number,'login_token'=>$login_token ]);
    		if($updated){
    			$data1['data']=$data;
    			$data1['login_token']=$login_token;
    			$data1['login_number']=$number;
    			$data1['msg']='Login Succesfully.';
    			$data1['code']=1;
    			return $data1;
    		}else{
    			$data1['code']=0;
    			$data1['msg']='Something Went Wrong.<br>Please Try Again...';
    			return $data1;
    		}
    	}else{
    		    $data1['code']=0;
    			$data1['msg']='Please Enter correct Email or Password.';
    			return $data1;
    	}
    }
}
