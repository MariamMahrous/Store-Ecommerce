<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Http\Requests\TagRequest;
use DB;

class TagsController extends Controller
{
     public function index(){
     $tags = Tag::orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
   
     return view('dashboard.tags.index',compact('tags'));
     }


   public function create(){
     return view('dashboard.tags.create');
   }
     

   /////// Begin Store Main tag///////////

   public function store(TagRequest $request){
    //VALIDATION
    //STORE IN DATABASE
    try{
   
    DB::beginTransaction();
    $tag=Tag::create(
     $request->except('_token')
    );
$tag->name= $request->name;
$tag->save();

    DB::commit();
   
           return redirect()->route('admin.tags')->with(['success'=>__('messages.success')]);
       
          }catch(\Exception $ex){
    DB::rollback();
         return redirect()->back()->with(['error'=>__('messages.error')]);
 
 }

   }

 /////// End Store Main tag///////////
  

  /////// Begin Edit && Update Main tag///////////
     public function edit($id){
   $tag= Tag::find($id);
  
   if(!$tag){
    return redirect()->route('admin.tags')->with(['error'=>__('messages.error')]);
   }
  return view ('dashboard.tags.edit',compact('tag'));


     }




     public function update (  $id ,TagRequest $request){
        try{
        DB::beginTransaction();
        $tag=tag::find($id);
        if(!$tag){
    return redirect()->route('admin.maincategories')->with(['error'=>__('messages.error')]);
        }
     
        $tag->name = $request->name;
        $tag->update($request->all());
         
        $tag->save();
       
        DB::commit();
        return redirect()->route('admin.tags')->with(['success'=>__('messages.updatesucces')]);

        }catch(\Exception $ex){
          DB::rolleback();
         return redirect()->route('admin.tags')->with(['error'=>__('messages.error')]);
 }
     }

/////// End Edit && Update Main tag///////////

 /////// Begin Delete Main tag///////////
public function destroy($id){
try{
  $tag=Tag::find($id);
  if(!$tag)
   return redirect()->route('admin.tags')->with(['error'=>__('messages.error')]);

  
  $tag->delete();
     return redirect()->route('admin.tags')->with(['success'=>__('messages.deletesuccess')]);
}catch(\Exception $ex){
 return redirect()->route('admin.tags')->with(['error'=>__('messages.error')]);

}

}
 /////// End Delete Main tag///////////

    
}
