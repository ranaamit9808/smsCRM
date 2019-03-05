<?php

namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{

	 protected $fillable = [
        'phone_number', 'status', 'user_id', 'assigned_from','assigned_till',
    ];
     /***************************************************************************
     ***************************************************************************
     * Validation Rules
     ***************************************************************************
    ***************************************************************************/
    
    //validations
    public static $Rules = array(
        
        'phone_number' => 'required|numeric|Unique:phones,phone_number',
        'status' => 'required',
       
    );

   
      //store phone number
    public static function Store($request) {
      
        $id = DB::table('phones')->insertGetId(array(
        
            'phone_number' => $request->phone_number,
            'status' => $request->status,
            'user_id' => $request->user_id,
            'assigned_from' => $request->assigned_from,
            'assigned_till'=>$request->assigned_till,
        
        ));

        $phone_details = Phone::where('id', $id)->first();

        //Send response
        return $phone_details;
    }
}
