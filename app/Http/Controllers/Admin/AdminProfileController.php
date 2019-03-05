<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator ;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Admin;
class AdminProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result= Admin::orderBy('id','desc')->paginate(10);
        // dd($result);
      return view('admin/adminprofile',compact('result'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result= Admin::find($id);
        // dd($result);
      return view('admin/editadminprofile',compact('result'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $res= Admin::find($id);
        return view('admin/editadminprofile',compact('res'));
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
        // return $id;
         
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
        'password'=>'required|unique:admins',
        
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator->getMessageBag()->first())
                        ->withInput();
        }

         $user = Admin::find($id);
        
        $user->name= $request->name;
        $user->email= $request->email;
        $user->password= Hash::make($request->password);
        $user->save($request->all());
        //session()->flash('message','update successfully');

        return redirect("/adminpanel/adminprofile");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
