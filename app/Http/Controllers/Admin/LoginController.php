<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

use App\Admin;

use DB;


class LoginController extends Controller
{
	//protected $user;
 
	//public function __construct(User $user)
  //{
    //$this->user = $user;
  //}
 
    public function login()
    {
    	return view('admin/login');
    }
    
    public function dologin(Request $request)
    {
    	$validation = Validator::make($request->all(), Admin::$adminLoginCodeRules);
        if($validation->fails())
            return redirect()->back()->withErrors($validation->getMessageBag()->first())->withInput();
                         
        $admin_data = Admin::where([['email','=',$request->email]])->first();
        //dd($admin_data);
        // $p=Hash::make($request->password);
        // dd($p);
        if(empty($admin_data))

            return redirect()->back()->withErrors("Invalid Username/Password")->withInput();
        // else
        //     return redirect('dashboard');
        else {
            if(Hash::check($request->password, $admin_data->password)) 
            {

                // Updating the user Token
                $remember_token = Admin::generateAndSaveUserToken($admin_data->id);
                Session::put('remember_token', $remember_token);
                return redirect('adminpanel/dashboard');
            
            }
            
            else            
                return redirect()->back()->withErrors("Password Incorrect")->withInput();
        
              }
    
    
	}

     public function logout(Request $request) {      

        $request->session()->forget('remember_token');
        return redirect('adminpanel/login');
    }
}

