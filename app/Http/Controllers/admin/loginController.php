<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\admin\loginModel;

class loginController extends Controller
{
    public function index()
    {
    	if( session()->has('user_id') && session()->has('login_token') && session()->has('role_id') ){
            return redirect('dashboard');
        }
    	return view('login');
    }
    public function checkLogin(Request $request)
    {
    	$data=loginModel::checkUser($request['email'],md5($request['password']));
    	if($data['code']==1){
    		session()->put('login_token',$data['login_token']);	
    		session()->put('user_id',sp_encryption($data['data']->id));	
    		return redirect('dashboard');
    	}else{
    		session()->flash('fail_msg',$data['msg']);
    		return redirect('/login');
    	}
    }
}
