<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Admin;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
   public function register()
   {
   	return view('admin/register');
   }
   




   public function store(Request $request)
   {
   	  
       
        $this->validate($request,['name'=> 'required']);
   
        $this->validate($request,['email'=> 'required|unique:admins']);
        $this->validate($request,['password'=> 'required|unique:admins']);
       
        $user = new Admin;
        $user->name= $request->name;
       
        $user->email= $request->email;
        $user->password= Hash::make($request->password);
        $user->save();
        //session()->flash('message','added successfully');

        return redirect("adminpanrl/dashboard")->with('status', 'you are registered');
   }
}
