<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Http\Requests\AdminProfileValidate;

class ProfileController extends Controller
{
    public function editProfile(){
    
     $admin = Admin::find(auth('admin')->user()->id);
    return view('dashboard.profile.edit',compact('admin'));
    }



    public function updateProfile(AdminProfileValidate $request){
 try{

     $admin=Admin::find(auth('admin')->user()->id);
    $data = $request->only(['name', 'email']); 
    if($request->filled('password')){
        //  $request->merge(['password'=> bcrypt($request->password)]);
          $data['password'] = bcrypt($request->password);
    }


    // unset($request['id']);
    // unset($request['password_confirmation']);
//    $admin->update($request->all());

    $admin->update($data);
   return redirect()->back()->with(['success'=>__('messages.success')]);

 }catch(\Exception $ex){
        return redirect()->back()->with(['error'=>__('messages.error')]);
     
       }
   

    }
}
