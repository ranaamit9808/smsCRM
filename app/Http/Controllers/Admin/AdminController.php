<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Admin;
use App\Message;
use App\Phone;


class AdminController extends Controller
{
 //     public function __construct()
	// {
	//     $this->middleware('auth');
	// } 
   


    public function dashboard()
    {
        $users = User::get()->count();
        $messages = Message::get()->count();
        $phones= Phone::get()->count();


    	return view('admin/dashboard', array('users' => $users,
               'messages' => $messages,'phones'=>$phones));
    }

    
}
