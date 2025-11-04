<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use Translatable;
    use SoftDeletes;
     
    protected $fillable=[
        'brand_id',
        'slug',
        'sku',
        'price',
        'special_price',
        'special_price_type',
        'special_price_start',
        'special_price_end',
        'selling_price',
        'manage_stock',
        'qty',
        'in_stock',
        'is_active',
    
    ];




    protected $casts=[
  'manage_stock'=>'boolean',
  'in_stock'=>'boolean',
  'is_active' =>'boolean',
    ];


    protected $dates=[
 'special_price_start',
 'special_price_end',
 'start_date',
 'end_date',
 'deleted_at',
    ];
protected $translatedAttributes=['name','description','short_description'];


public function brand(){
    return $this->belongsTo(Brand::class)->withDefault();

}


public function categories(){
    return $this->belongsToMany(Category::class,'product_categories');
    
}


public function tags(){
    return $this->belongsToMany(Tag::class,'product_tags');
}

public function getActive(){
  return $this->is_active == 1 ? __('messages.is_active') : __('messages.not_active');
    
}

}
