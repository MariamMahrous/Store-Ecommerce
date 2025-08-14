<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Http\Requests\ShippingValidateRequest;
use DB;

class SettingsController extends Controller
{
    public function editShippingMethods($type){
        //methods type => free  local outer

        if($type === 'free')
            $shippingMethod=Setting::where('key','free_shipping_label')->first();

        elseif($type === 'local')
            $shippingMethod=Setting::where('key','local_label')->first();

         elseif($type === 'outer')
            $shippingMethod=Setting::where('key','outer_label')->first();
        else
   $shippingMethod=Setting::where('key','free_shipping_label')->first();


                  return view('dashboard.settings.shippings.edit',compact('shippingMethod')) ;
    }



  public function updateShippingMethods(ShippingValidateRequest $request ,$id){
try{
    DB::beginTransaction();
     $shipping_method= Setting::find($id);
  $shipping_method -> update([
    'plain_value' => $request->plain_value
  ]);
  $shipping_method->value=$request->value;
  $shipping_method->save();
  DB::commit();
 return redirect()->back()->with(['success'=>__('messages.updatesucces')]);
}
catch(\Exception $ex)
 {
 
   return redirect()->back()->with(['error'=>__('messages.error')]);
     DB::rollback();
 }
}












}
