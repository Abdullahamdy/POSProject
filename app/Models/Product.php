<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasTranslations;

    public $translatable = ['name','description'];
    use HasFactory;
    protected $guarded = [];
    public function category(){
        return $this->belongsTo(Categroy::class,'cat_id');
    }

    public function getImagePathAttribute(){
        return asset('uploads/products/'.$this->image);
    }
    public function getNamelangAttribute()
    {
        return  @((array)json_decode($this->attributes['name'])) ?? false;
    }
    public function getDescriptionlangAttribute()
    {
        return  @((array)json_decode($this->attributes['description'])) ?? false;
    }
}
