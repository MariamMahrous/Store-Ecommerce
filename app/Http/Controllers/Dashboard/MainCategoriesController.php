<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Requests\MainCategoryValidate;
use DB;

class MainCategoriesController extends Controller
{
     public function index(){
     $categories = Category::Parent()->paginate(PAGINATION_COUNT);
     return view('dashboard.maincategories.index',compact('categories'));
     }


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
        
      return redirect()->back()->with(['success'=>__('messages.success')]);

        }catch(\Exception $ex){
        return redirect()->back()->with(['error'=>__('messages.error')]);
 }
     }







    
}
