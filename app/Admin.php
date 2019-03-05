<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Admin extends Model
{
     public static $adminLoginCodeRules = array(                            
            'email' => 'required',
            'password' => 'required',
        );

     /**************************************************************************
	|**************************************************************************
	| Common Function
	|**************************************************************************
	**************************************************************************/

	    public static function generateAndSaveUserToken($user_id) {
	        $token = str_random(30);
	        Admin::where('id', $user_id)->update(['remember_token' => $token]);
	        return $token;
	    }
	    
}
