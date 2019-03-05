<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\User;
use App\Admin;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Hash;
class todoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   

    public function index()
    {
        $result = User::orderBy('id','desc')->paginate(12);
        return view('admin/user',compact('result'));
    }

    /**
     * Show the form for creating a new resource.

     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      
   
        return view('admin/adduser');
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
        $validation = Validator::make($input, User::$SignUpRules);
        if($validation->fails())
             return redirect('/adminpanel/user/create')->withErrors($validation);
           

       $response = User::Store($request);
        if ($response)
        {
                  
      return redirect('/adminpanel/user')
            ->with(['success' => 'User added successfully']);
    }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    { 
         $result= User::find($id);
        // dd($result);
         $dates=$result->created_at;
         
         $date= $dates->format('l j F Y');

      return view('admin/detail',array('result'=>$result,'date'=>$date));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    // {
    //      $res= User::find($id);
    //     return view('admin/edit',compact('res'));
    // }

     public function edit($id)
    {  
         $res= User::find($id);
       
        return view('admin/edituser',compact('res'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $item=User::find($id);

         if($item->deleted_at == null)
         {  
        
         $item->deleted_at= 1;
         // return $item;
           $item->save();
         }
        else
        {
         $item->deleted_at= null;
          $item->save();
        }

         
        return redirect("/adminpanel/user/$id");
    }
    public function updateUser(Request $request, $id)
    {
         $item=User::find($id);
         $input = $request->all();
         $item->update( $input);
        
         
        return redirect("/adminpanel/user/$id");
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item=User::find($id);
        $item->delete();
        //session()->flash('message','delete successfully');
        return redirect("/adminpanel/user");
    }
}
