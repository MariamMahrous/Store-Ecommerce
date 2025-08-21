<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Http\Requests\BrandRequest;
use DB;

class BrandsController extends Controller
{
     public function index(){
     $brands = Brand::orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
   
     return view('dashboard.brands.index',compact('brands'));
     }


   public function create(){
     return view('dashboard.brands.create');
   }
     

   /////// Begin Store Main brand///////////

   public function store(BrandRequest $request){
    //VALIDATION
    //STORE IN DATABASE
    
    try{
  
      DB::beginTransaction();
    if(!$request->has('is_active')){
        $request->request->add(['is_active'=>0]);
       }else{
         $request->request->add(['is_active'=>1]);
       }
    
  $filename = "";
  if($request->has('photo')){
    $filename = uploadImage('brands',$request->photo);
  }
 

  $brand = Brand::create(
    array_merge(
        $request->except('_token', 'photo'),
        ['photo' => $filename]
    )
);

$brand->name=$request->name;
$brand->save();
  DB::commit();
           return redirect()->route('admin.brands')->with(['success'=>__('messages.success')]);
         
          }catch(\Exception $ex){
    DB::rollback();
         return redirect()->back()->with(['error'=>__('messages.error')]);
 
 }

   }

 /////// End Store  brand///////////
  

  /////// Begin Edit && Update  brand///////////
   public function edit($id){
   $brand= brand::orderBy('id','DESC')->find($id);
  
   if(!$brand){
    return redirect()->route('admin.brands')->with(['error'=>__('messages.brandError')]);
   }
  return view ('dashboard.brands.edit',compact('brand'));


     }




     public function update (  $id ,BrandRequest $request){
        try{
          $brand=brand::find($id);
          if(!$brand)
              return redirect()->route('admin.brands')->with(['error'=>__('messages.brandError')]);
      DB::beginTransaction();
    
   if($request->has('photo')){
    $filename=uploadImage('brands',$request->photo);
  Brand::where('id',$id)->update([
      'photo'=>$filename
    ]);
   }

     if(!$request->has('is_active')){
        $request->request->add(['is_active'=>0]);
       }else{
         $request->request->add(['is_active'=>1]);
       }
        
        $brand->update($request->except('_token','id','photo'));
      
        $brand->name = $request->name;
          
        $brand->save();
       
        DB::commit();
        return redirect()->route('admin.brands')->with(['success'=>__('messages.updatesucces')]);

        }catch(\Exception $ex){
          DB::rollback();
         return redirect()->route('admin.brands')->with(['error'=>__('messages.error')]);
 }
     }

/////// End Edit && Update Main brand///////////

 /////// Begin Delete Main brand///////////
public function destroy($id){
try{
  $brand=brand::find($id);
  if(!$brand)
   return redirect()->route('admin.brands')->with(['error'=>__('messages.brandError')]);

  
  $brand->delete();
     return redirect()->route('admin.brands')->with(['success'=>__('messages.deletesuccess')]);
}catch(\Exception $ex){
 return redirect()->route('admin.brands')->with(['error'=>__('messages.error')]);

}

}
 /////// End Delete Main brand///////////

    
}
