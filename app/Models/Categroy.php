<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categroy extends Model
{

    use HasTranslations;

    public $translatable = ['name'];
    use HasFactory;
    protected $guarded = [];
    public function product()
    {
        return $this->hasMany(Product::class);
    }
    public function getNamelangAttribute()
    {
        return  @((array)json_decode($this->attributes['name'])) ?? false;
    }
}
