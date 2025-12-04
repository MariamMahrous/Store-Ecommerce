<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Http\Requests\AttributeRequest;
use DB;

class AttributesController extends Controller
{
     public function index(){
     $attributes = Attribute::orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
   
     return view('dashboard.attributes.index',compact('attributes'));
     }


   public function create(){
     return view('dashboard.attributes.create');
   }
     

   /////// Begin Store Main brand///////////

   public function store(AttributeRequest $request){
    //VALIDATION
    //STORE IN DATABASE
   

     $attribute=Attribute::create([]);
     $attribute->name=$request->name;
$attribute->save();
           return redirect()->route('admin.attributes')->with(['success'=>__('messages.success')]);
         
  

  
         return redirect()->back()->with(['error'=>__('messages.error')]);
 
  

   }

 /////// End Store  brand///////////
  

  /////// Begin Edit && Update  brand///////////
   public function edit($id){
   $attribute= Attribute::orderBy('id','DESC')->find($id);
  
   if(!$attribute){
    return redirect()->route('admin.attributes')->with(['error'=>__('messages.AttributeError')]);
   }
  return view ('dashboard.attributes.edit',compact('attribute'));


     }




     public function update (  $id ,AttributeRequest $request){
        try{
          $attribute=Attribute::find($id);
          if(!$attribute)
              return redirect()->route('admin.attributes')->with(['error'=>__('messages.AttributeError')]);
      DB::beginTransaction();
  


      
        $attribute->name = $request->name;
          
        $attribute->save();
       
        DB::commit();
        return redirect()->route('admin.attributes')->with(['success'=>__('messages.updatesucces')]);

        }catch(\Exception $ex){
          DB::rollback();
         return redirect()->route('admin.attributes')->with(['error'=>__('messages.error')]);
 }
     }

/////// End Edit && Update Main brand///////////

 /////// Begin Delete Main brand///////////
public function destroy($id){
try{
  $attribute=Attribute::find($id);
  if(!$attribute)
   return redirect()->route('admin.attributes')->with(['error'=>__('messages.brandError')]);

  
  $attribute->delete();
     return redirect()->route('admin.attributes')->with(['success'=>__('messages.deletesuccess')]);
}catch(\Exception $ex){
 return redirect()->route('admin.attribute')->with(['error'=>__('messages.error')]);

}

}
 /////// End Delete Main brand///////////

    
}
