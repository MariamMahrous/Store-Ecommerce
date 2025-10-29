<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class Brand extends Model
{
    use translatable;

    protected $with = ['translations'];

    protected $translatedAttributes = ['name'];

    protected $hidden = ['translations'];

    protected $fillable = ['photo', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];
    public function getActive()
    {
        return $this->is_active == 1 ? __('messages.is_active') : __('messages.not_active');
    }


    public function getPhotoPath($val)
    {
        return ($val !== null) ? asset('assets/images/brands/' . $val) : "";
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
}
