<?php


namespace App\Http\Controllers\Dashboard;

use App\Models\Tag;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductPriceRequest;
use App\Http\Requests\ProductStockRequest;
use App\Http\Requests\ProductGeneralRequest;

class ProductController extends Controller
{

  public function index(){

   $products=Product::select('id','slug','price','created_at')->paginate(PAGINATION_COUNT);
   return view('dashboard.products.general.index',compact('products'));

      
   }




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


   // Begin Product Price Mehtods


   public function setPrice($product_id){

     return view('dashboard.products.prices.create')->with('id',$product_id);

   }

   public function storePrice(ProductPriceRequest $request){

      try{
        Product::whereId($request->product_id)->update($request->only(['price','special_price','special_price_type','special_price_start','special_price_end']));
      return redirect()->route('admin.products')->with(['success' => __('messages.success')]);


      }catch(\Exception $ex){
   return redirect()->back()->with(['error' => __('messages.error')]);
      }

   }
  
// End Product Price Mehtods


// Begin Product Inventory Mehtods


public function setStock($product_id){
   return view('dashboard.products.stock.create')->with('id',$product_id);
}


public function storeStock(ProductStockRequest $request){
try{
        Product::whereId($request->product_id)->update($request->only(['sku','manage_stock','in_stock','qty']));
      return redirect()->route('admin.products')->with(['success' => __('messages.success')]);


      }catch(\Exception $ex){
   return redirect()->back()->with(['error' => __('messages.error')]);
      }



}

// End Product Inventory Mehtods











}
