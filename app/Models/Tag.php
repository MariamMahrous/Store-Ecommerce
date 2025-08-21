<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class Tag extends Model
{
    
   use translatable;

   protected $with=['translations'];

   protected $fillable =['slug'];

   protected $translatedAttributes =['name'];

   protected $hidden =['translations'];

   protected $casts=[
    'is_active' =>'boolean'
   ];



}
