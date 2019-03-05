<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Mail;
use Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;
class User extends Authenticatable
{
    protected $fillable = [
        'name', 'email', 'password', 'birth_date','phone',
    ];

protected $primaryKey = 'id';
    /***************************************************************************
     ***************************************************************************
     * Validation Rules
     ***************************************************************************
    ***************************************************************************/
    
    //validations
    public static $SignUpRules = array(
        //'eligible_nominee_type_id'=> 'required',
        'name' => 'required',
        'email' => 'required|email|Unique:users',
        'password' => 'required|min:6',
       
    );
     public static $LoginRules = array(
        'lemail' => 'required|email',
        'lpassword' => 'required',
    );

    //signup
    public static function SignUp($request) {
        $password = Hash::make($request->password);
      
        $user_id = DB::table('users')->insertGetId(array(
            //'eligible_nominee_type_id' => $request -> eligible_nominee_type_id,
            'name' => $request->name,
           // 'phone' => $request->phone,
            'email' => $request->email,
            'password' => $password,
           // 'birth_date'=>$request->birth_date,
        
        ));

        $user_details = User::where('id', $user_id)->first();

        //Send response
        return $user_details;
    }


      //Login
    public static function Login($request) {

        $email = $request->lemail;
        $password = $request->lpassword;
        $current_time = Carbon::now();

        $user_data = DB::select(
                        "SELECT `id`, `password`, `phone`,'birth_date',`deleted_at`,`verified` 
                    FROM `users` 
                    WHERE `email` = '$email'
                ");

        if (empty($user_data))
        	return redirect('/home#Login')->with(['error' => 'email not exists']);
      
        $user_data = $user_data[0];

        if (!empty($user_data)) {
            if ($user_data->deleted_at != null)
            	return redirect('/home#Login')->with(['error' => 'This user is deactivated']);
              
            else {
                if ((Hash::check($password, $user_data->password))) {
                     if($user_data->verified==1)  
                     {         
                                 $userdata = array(
                        'email'     => Input::get('lemail'),
                        'password'  => Input::get('lpassword')
                    );

                     if (Auth::attempt($userdata)) {

       
                        $user_id = $user_data->id;

                        $user_details = User::getUserDetailsById($user_data->id);

                        $data = $user_details[0];
                       // print_r(Auth::User());
                       // die();
                        return $data;
                   
                  
                }
            }
             else
                    return redirect('/home#Login')->with(['error' => 'Please Verify Your Account Using the link in welcome email sent to you']);
        }
                // Password incorrect
                else
                	return redirect('/home#Login')->with(['error' => 'Password incorrect']);
                   
            }
        } else
        return redirect('/home#Login')->with(['error' => 'Email and Password do not match']);
           
    }

     public static function getUserDetailsById($user_id) {

        $users_details = DB::select(
                        "SELECT `id`,`name`, `email`,`birth_date`,`phone`
                    FROM `users` 
                    WHERE `id` = '$user_id'
                ");





        return $users_details;
    }

    //store phone number
    public static function Store($request) {
        $password = Hash::make($request->password);
        $id = DB::table('users')->insertGetId(array(
        
            'name' => $request->name,
            'email' => $request->email,
            'password' =>  $password,
           
        
        ));

        $user_details = User::where('id', $id)->first();

        //Send response
        return $user_details;
    }

}
