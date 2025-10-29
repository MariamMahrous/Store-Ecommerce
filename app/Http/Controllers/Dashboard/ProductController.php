<?php


namespace App\Http\Controllers\Dashboard;

use App\Models\Tag;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductGeneralRequest;
use App\Models\Product;

class ProductController extends Controller
{
   public function create()
   {
      $data = [];
      $data['brands'] = Brand::Active()->select('id')->get();
      $data['tags'] = Tag::select('id')->get();
      $data['categories'] = Category::Active()->select('id')->get();
      return view('dashboard.products.general.create', $data);
   }

   public function store(ProductGeneralRequest $request)
   {
      try {
         DB::beginTransaction();
         if ($request->has('is_active')) {
            $request->request->add(['is_active' => 1]);
         } else {
            $request->request->add(['is_active' => 0]);
         }
         $products = Product::create([
            'brand_id' => $request->brand_id,
            'slug' => $request->slug,
            'is_active' => $request->is_active
         ]);

         $products->name = $request->name;
         $products->description = $request->description;
         $products->short_description = $request->short_description;
         $products->categories()->attach($request->categories);
         $products->tags()->attach($request->tags);
         $products->save();
         return redirect()->route('admin.products.general.create')->with(['success' => __('messages.success')]);

         DB::commit();
      } catch (\Exception $ex) {
         DB::rollBack();
         return redirect()->back()->with(['error' => __('messages.error')]);
      }
   }
}
