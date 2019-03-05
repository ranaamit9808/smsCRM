<?php

namespace App\Http\Controllers;

use App\User;
use App\Message;
use Redirect;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Mail;
use Aloha\Twilio\Support\Laravel\Facade as Twilio;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {//print_r(1);

        if(Auth::check())
            {

                $user_sms_details = Message::where('user_id', Auth::User()->id)->orderBy('created_at','desc')->take(5)->get();  
                return view('index')->with(compact('user_sms_details'));
            }
        else
        return view('index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result= User::find($id);
        // dd($result);
      return view('user/edituserprofile',compact('result'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $res= User::find($id);
        return view('user/edituserprofile',compact('res'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // return $id;
         
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
       
        
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator->getMessageBag()->first())
                        ->withInput();
        }

         $user = User::find($id);
        
        $user->name= $request->name;
        $user->email= $request->email;
     
        $user->save($request->all());
        //session()->flash('message','update successfully');

        return redirect("user/dashboard/".$id);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }



    // register user
    public function register(Request $request)
    {
         //Check Validation
        $input = $request->all();
        $validation = Validator::make($input, User::$SignUpRules);
        if($validation->fails())
             return redirect('/home#Register')->withErrors($validation);
            //return response()->json(['error' => 'bad_request', 'error_description' => $validation->getMessageBag()->first()], 400);

       $response = User::SignUp($request);
        if ($response)
        {
                   $user     = Input::get('email');
                   $id= $response->id;
           Mail::to('email',array('user' => $user,'id'=>$id), function($message) use ($user,$id)
              {
                 $message->from('12cdeepika@gmail.com', 'SmsCRM');
                 $message->subject('Welcome Mail');
                 $message->to($user);
     
               });


            return redirect('/home#Register')
            ->with(['success' => 'Congratulations! your account is registered, you will shortly receive an email to activate your account.']);
    }

    }


     public static function login(Request $request) {
        
        //Check Validation
        $input = $request->all();
        $validation = Validator::make($input, User::$LoginRules);
        if($validation->fails())
            return redirect('/home#Login')->withErrors($validation);

     $response = User::Login($request);
    // print_r($response);
     if(isset($response))
          {

           

            return redirect('/home');
    }
    }

    public function doLogout()
{
    Auth::logout(); // log the user out of our application
    return Redirect::to('/home'); // redirect the user to the login screen
}

 public function verification($id)
{
    $user_details = User::where('id', $id)->update(['verified' => 1]);
     return Redirect::to('/home#Login')->with(['success1' => 'Congratulations! your account is verified, Please login.']);
}
   public function smsSend()
{

      $phone     = Input::get('phone');
      $message     = Input::get('message');
    //  print_r($phone );
     // print_r( $message);
// $account_id = 'AC69c42c7d839d101131b0c681b8ffe307';
// $auth_token = '3e2810e93a6c51e958fa69a0f5c5e8c2';
// $from_phone_number = '+12012319130'; // phone number you've chosen from Twilio
// $twilio = new Twilio($account_id, $auth_token, $from_phone_number);

// //$to_phone_number = '+37062218617'; // who are you sending to?
// $twilio->message($phone, $message1);


  $sms=Twilio::message($phone, $message);
if($sms)
{
      $user_id = DB::table('messages')->insertGetId(array(
         
            'user_id' => Auth::User()->id,
            'send_to' => $phone ,
            'message' => $message,
         
        
        ));

        $user_sms_details = Message::where('user_id', Auth::User()->id)->get();

        //Send response
      //  return $user_details;
         return Redirect::to('/home#sms')->with(['success2' => 'sms sent successfully.']);
}

}

 public function dashboard($id)
    {
       // $users = User::get()->count();
        $messages = Message::where('user_id',$id)->count();
        


        return view('user/dashboard', array(
               'messages' => $messages));
    }

    public function profile($id=null)
    {
         $result= User::where('id',$id)->orderBy('id','desc')->first();
        // dd($result);
      return view('user/profile',compact('result'));
    }

        //user password change
        public function changePassword( $id=null)
        {
            if( Auth::id()!=$id ) 
            {
                return Redirect::to('user/dashboard/'.$id);
            } 
            else {
                if(!empty($_POST))
                {
                    $rules = array(
                    'password'                  => 'required|min:6|confirmed',
                    'password_confirmation'     => 'required',
                    );
                    $messages = array(
                    'password.min'        => "Password length should not be less than 6 characters",
                    'password.confirmed'  => "Password does not match",
                    );
                    $validator = Validator::make( Input::all(), $rules, $messages ); 
                    
                    if ($validator->fails()) 
                    {
                        Session::flash('errormessage', 'Password could not be changed, Please correct errors');
                        return Redirect::to('user/profile/password/'.$id)->withErrors($validator);
                    } 
                    else{
                        $user = User::find($id);
                        $user->password     = Hash::make(Input::get('password'));
                        if($user->save()){
                            return Redirect::to('user/profile/password/'.$id)->with('message', 'User password has been changed successfully.');
                        }
                    }
                }
                
                $data = User::find($id);
                 return view('user.change_password', compact('data'));
            }
        }

}
