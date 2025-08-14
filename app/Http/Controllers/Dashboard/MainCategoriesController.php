<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Requests\MainCategoryValidate;
use DB;

class MainCategoriesController extends Controller
{
     public function index(){
     $categories = Category::Parent()->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
   
     return view('dashboard.maincategories.index',compact('categories'));
     }


   public function create(){
     return view('dashboard.maincategories.create');
   }
     

   /////// Begin Store Main Category///////////

   public function store(MainCategoryValidate $request){
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


   
           return redirect()->back()->with(['success'=>__('messages.success')]);
           DB::commit();
          }catch(\Exception $ex){
    DB::rollback();
         return redirect()->back()->with(['error'=>__('messages.error')]);
 
 }

   }

 /////// End Store Main Category///////////
  

  /////// Begin Edit && Update Main Category///////////
     public function edit($id){
   $mainCategory= Category::orderBy('id','DESC')->find($id);
  
   if(!$mainCategory){
    return redirect()->route('admin.maincategories')->with(['error'=>__('messages.categoryError')]);
   }
  return view ('dashboard.maincategories.edit',compact('mainCategory'));


     }




     public function update (  $id ,MainCategoryValidate $request){
        try{
     if(!$request->has('is_active')){
        $request->request->add(['is_active'=>0]);
       }else{
         $request->request->add(['is_active'=>1]);
       }
        $category=Category::find($id);
        if(!$category){
    return redirect()->route('admin.maincategories')->with(['error'=>__('messages.categoryError')]);
        }
        DB::beginTransaction();
        $category->name = $request->name;
        $category->update($request->all());
         
        $category->save();
       
        DB::commit();
        return redirect()->route('admin.maincategories')->with(['success'=>__('messages.updatesucces')]);

        }catch(\Exception $ex){
          DB::rolleback();
         return redirect()->route('admin.maincategories')->with(['error'=>__('messages.error')]);
 }
     }

/////// End Edit && Update Main Category///////////

 /////// Begin Delete Main Category///////////
public function destroy($id){
try{
  $category=Category::find($id);
  if(!$category)
   return redirect()->route('admin.maincategories')->with(['error'=>__('messages.categoryError')]);

  
  $category->delete();
     return redirect()->route('admin.maincategories')->with(['success'=>__('messages.deletesuccess')]);
}catch(\Exception $ex){
 return redirect()->route('admin.maincategories')->with(['error'=>__('messages.error')]);

}

}
 /////// End Delete Main Category///////////

    
}
