<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasTranslations;

    use HasFactory;
    public $translatable = ['name','description'];
    protected $guarded = [];

    protected $appends = ['profit_percent'];
    public function category(){
        return $this->belongsTo(Categroy::class,'cat_id');
    }

    public function getImagePathAttribute(){
        return asset('uploads/products/'.$this->image);
    }
    public function getProfitPercentAttribute(){
        $profit =  $this->purchase_price - $this->sale_price;
        $profit_percent  = $profit * 100 / $this->purchase_price;
        return number_format($profit_percent,2);
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
