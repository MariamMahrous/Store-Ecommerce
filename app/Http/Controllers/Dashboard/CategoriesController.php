<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\SubCategoryValidate;

use DB;

class CategoriesController extends Controller
{
  public function index()
  {
    $categories = Category::Child()->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);

     return view('dashboard.categories.index',compact('categories'));
   }


  public function create()
  {
    $categories = Category::select('id', 'parent_id')->get();
    return view('dashboard.categories.create', compact('categories'));
  }


  /////// Begin Store  Category///////////

  public function store(CategoryRequest $request)
  { //VALIDATION
    //STORE IN DATABASE
    try {
      DB::beginTransaction();
      if (!$request->has('is_active')) {
        $request->request->add(['is_active' => 0]);
      } else {
        $request->request->add(['is_active' => 1]);
      }
      // If User Choose Main Category We must Remove Parent_id From Request
      if ($request->type == 1) {
        $request->request->add(['parent_id' => null]);
      }
      // If User Choose Sub Category We must Add Parent_id
      $category = Category::create(
        $request->except('_token')
      );
      $category->name = $request->name;
      $category->save();
      DB::commit();
     return redirect()->route('admin.categories.create')->with(['success' => __('messages.success')]);
    } catch (\Exception $ex) {
      DB::rollback();
      return redirect()->back()->with(['error' => __('messages.error')]);
    }
  }
  /////// End Store  Category///////////

  /////// Begin Edit && Update  Category///////////
     public function edit($id){
   $subCategory= Category::orderBy('id','DESC')->find($id);
    
   if(!$subCategory){
    return redirect()->route('admin.categories')->with(['error'=>__('messages.categoryError')]);
   }
   $categories=Category::Parent()->orderBy('id','DESC')->get();
  return view ('dashboard.categories.edit',compact('subCategory','categories'));


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
    return redirect()->route('admin.categories')->with(['error'=>__('messages.categoryError')]);
        }
  
        $category->name = $request->name;
        $category->update($request->all());
         
        $category->save();
        return redirect()->route('admin.categories')->with(['success'=>__('messages.updatesucces')]);

        DB::commit();
       
        }catch(\Exception $ex){
          DB::rolleback();
         return redirect()->route('admin.categories')->with(['error'=>__('messages.error')]);
 }
     }

/////// End Edit && Update  Category///////////

  /////// Begin Delete  Category///////////
  public function destroy($id)
  {
    try {
      $category = Category::find($id);
      if (!$category)
        return redirect()->route('admin.categories')->with(['error' => __('messages.categoryError')]);


      $category->delete();
      return redirect()->route('admin.categories')->with(['success' => __('messages.deletesuccess')]);
    } catch (\Exception $ex) {
      return redirect()->route('admin.categories')->with(['error' => __('messages.error')]);
    }
  }
  /////// End Delete  Category///////////


}
