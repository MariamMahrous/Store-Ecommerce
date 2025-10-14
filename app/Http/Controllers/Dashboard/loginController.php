<?php

namespace App\Http\Controllers\Dashboard;


use auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;

class loginController extends Controller
{
   public function login()
   {
      return view('dashboard.auth.login');
   }

   public function postLogin(AdminLoginRequest $request) {
    $remember_me= $request->has('remember_me')? true :false;

     if(auth()->guard('admin')->attempt(['email'=>$request->input('email'),'password'=>$request->input('password')],$remember_me)){
                return redirect()->route('admin.dashboard');
     }else{
        return redirect()->back()->with(['error'=>'الايميل او كلمة السر خطأ برجاء المحاولة مرة اخر']);
     }
  



   }

    public function logout(){
      $guard = $this->getGaurd();
      $guard->logout();
      return redirect()->route('admin.login');
    }
   private function getGaurd(){
      return auth('admin');
   }









}
