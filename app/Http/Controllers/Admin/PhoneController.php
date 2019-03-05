<?php

namespace App\Http\Controllers\Admin;
use DB;
use App\Phone;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PhoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = DB::table('phones')->select('phones.id','phones.phone_number','phones.status','phones.user_id','phones.assigned_from','phones.assigned_till','users.name')->join('users', 'users.id', '=', 'phones.user_id')->paginate(10);
       // print_r($result);
        //die();
        return view('admin/phone',compact('result'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {  $result = User::orderBy('id','desc')->get();
   
        return view('admin/addphonenumber',compact('result'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         //Check Validation
        $input = $request->all();
        $validation = Validator::make($input, Phone::$Rules);
        if($validation->fails())
             return redirect('/adminpanel/phone/create')->withErrors($validation);
           

       $response = Phone::Store($request);
        if ($response)
        {
                  
      return redirect('/adminpanel/phone')
            ->with(['success' => 'Phone Number added successfully']);
    }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Phone  $phone
     * @return \Illuminate\Http\Response
     */
    public function show(Phone $phone)
    {
       $result = Phone::where('user_id',$id)->orderBy('id','desc')->paginate(10);
        return view('admin/message',compact('result'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Phone  $phone
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   $result = User::orderBy('id','desc')->get();
         $res= Phone::find($id);
         //print_r($res);
        // die();
        return view('admin/editphone',compact('res','result'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Phone  $phone
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $item=Phone::find($id);
         $input = $request->all();
         $item->update( $input);
        
         
        return redirect("/adminpanel/phone");
    }




    public function updateStatus(Request $request, $id)
    {
         $item=Phone::find($id);

         if($item->status == 1)
         {  
        
         $item->status= 0;
         // return $item;
           $item->save();
         }
        else
        {
         $item->status= 1;
          $item->save();
        }

         
        return redirect("/adminpanel/phone");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Phone  $phone
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $item=Phone::find($id);
        $item->delete();
        //session()->flash('message','delete successfully');
        return redirect("/adminpanel/phone");
    }
}
