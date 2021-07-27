<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\loginModel;
use App\admin\User;
use Cookie;
use Validator;
use Illuminate\Support\Str;
class loginController extends Controller
{
    public function index()
    {
    	if( session()->has('user_id') && session()->has('login_token') && session()->has('role_id') ){
            return redirect('dashboard');
        }
    	return view('login');
    }
    public function adminindex()
    {
        if( session()->has('admin_id') && session()->has('login_token') && session()->has('role_id') ){
            return redirect('admin/dashboard');
        }
        return view('adminlogin');
    }
    public function admincheckLogin(Request $request)
    {
        $validatedData=$request->validate([
            'email'=>'required',
            'password'=>'required',
        ]);

        $data=loginModel::checkAdminUser($request['email'],md5($request['password']));
        if($data['code']==1){
            session()->put('login_token',$data['login_token']); 
            session()->put('admin_id',sp_encryption($data['data']->id)); 
            session()->flash('succ_msg',$data['msg']);
            session()->put('role_id',sp_encryption($data['data']->role_id));
            if(isset($request['remember'])){
                $minutes = 2880;
                \Cookie::queue(\Cookie::make('login_token',$data['login_token'] , $minutes));
                \Cookie::queue(\Cookie::make('admin_id',sp_encryption($data['data']->id) , $minutes));
                \Cookie::queue(\Cookie::make('role_id',sp_encryption($data['data']->role_id) , $minutes));
            }
            return redirect('admin/dashboard');
        }else{
            session()->flash('fail_msg',$data['msg']);
            return redirect('/admin');
        }
    }
    public function checkLogin(Request $request)
    {
    	$data=loginModel::checkUser($request['email'],md5($request['password']));
    	if($data['code']==1){
    		session()->put('login_token',$data['login_token']);	
    		session()->put('user_id',sp_encryption($data['data']->id));	
            session()->flash('succ_msg',$data['msg']);
    		session()->put('role_id',sp_encryption($data['data']->role_id));	
    		return redirect('dashboard');
    	}else{
            session()->flash('fail_msg',$data['msg']);
    		return redirect('/');
    	}
    }

    //Function to load the view of forgot-password 
    public function forgotPassword(Request $request) {
        return view('forgot-password');
    }

    //Function to reset the password and send mail contains the temporary password
    public function setPassword(Request $request) {
        $rules = [
            'email' => 'required|email'
        ];
        $validator = Validator::make($request->all(), $rules, [
            'email.required' => 'Please entered the valid email address.'
        ]);
        if ($validator->fails()) {
            session()->flash('fail_msg', $validator->errors()->first());
            return redirect()->back();
        }
        $email = $request->email;
        $checkExist = User::where('email', $email)->where('role_id', 2)->first();
        if(!empty($checkExist)) {
            $temp_password = Str::random(8);
            $data = array(
                'password' => md5($temp_password)
            );
            $action = User::updateRecord($data, $checkExist->id);
            if($action) {
                \Mail::send(['html' => 'email.forgot-password'], ['notifiable' => $checkExist, 'temp_password' => $temp_password], function ($message) use ($email) {
                    $message->to($email)->subject('Forgot Password Request');
                    $message->from(config('mail.from.address'), 'Forgot Password Request');
                });
                session()->flash('succ_msg', 'We sent you the temporary password. Please check your email!!');
                return redirect()->back();
            }
            session()->flash('fail_msg', 'Something went wrong.Please try again latter!');
            return redirect()->back();
        } else {
            session()->flash('fail_msg', 'No registered user found for this email address.');
            return redirect()->back();
        }
    }
}
