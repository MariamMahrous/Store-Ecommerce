<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Requests\SubCategoryValidate;
use DB;

class SubCategoriesController extends Controller
{  
     /////// Begin Index Sub Category///////////
     public function index(){
     $categories = Category::Child()->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
   
     return view('dashboard.subcategories.index',compact('categories'));
     }

 /////// Begin Create Sub Category///////////
   public function create(){
    $categories=Category::Parent()->orderBy('id','DESC')->get();
  
     return view('dashboard.subcategories.create',compact('categories'));
   }
     

   /////// Begin Store Sub Category///////////

   public function store(SubCategoryValidate $request){
    //VALIDATION
    //STORE IN DATABASE
    try{
    if(!$request->has('is_active')){
        $request->request->add(['is_active'=>0]);
       }else{
         $request->request->add(['is_active'=>1]);
       }
    DB::beginTransaction();
    $category=Category::create(
     $request->except('_token')
    );
$category->name=$request->name;
$category->save();

          return redirect()->route('admin.subcategories')->with(['success'=>__('messages.success')]);
           DB::commit();
          }catch(\Exception $ex){
    DB::rollback();
         return redirect()->back()->with(['error'=>__('messages.error')]);
 
 }

   }

 /////// End Store Main Category///////////
  

  /////// Begin Edit && Update Main Category///////////
     public function edit($id){
   $subCategory= Category::orderBy('id','DESC')->find($id);
    
   if(!$subCategory){
    return redirect()->route('admin.subcategories')->with(['error'=>__('messages.categoryError')]);
   }
   $categories=Category::Parent()->orderBy('id','DESC')->get();
  return view ('dashboard.subcategories.edit',compact('subCategory','categories'));


     }




     public function update (  $id ,SubCategoryValidate $request){
        try{
                DB::beginTransaction();
     if(!$request->has('is_active')){
        $request->request->add(['is_active'=>0]);
       }else{
         $request->request->add(['is_active'=>1]);
       }
        $category=Category::find($id);
        if(!$category){
    return redirect()->route('admin.subcategories')->with(['error'=>__('messages.categoryError')]);
        }
  
        $category->name = $request->name;
        $category->update($request->all());
         
        $category->save();
        return redirect()->route('admin.subcategories')->with(['success'=>__('messages.updatesucces')]);

        DB::commit();
       
        }catch(\Exception $ex){
          DB::rolleback();
         return redirect()->route('admin.subcategories')->with(['error'=>__('messages.error')]);
 }
     }

/////// End Edit && Update Main Category///////////

 /////// Begin Delete Main Category///////////
public function destroy($id){
try{
  $category=Category::find($id);
  if(!$category)
   return redirect()->route('admin.subcategories')->with(['error'=>__('messages.categoryError')]);

  
  $category->delete();
     return redirect()->route('admin.subcategories')->with(['success'=>__('messages.deletesuccess')]);
}catch(\Exception $ex){
 return redirect()->route('admin.subcategories')->with(['error'=>__('messages.error')]);

}

}
 /////// End Delete Main Category///////////

    
}
