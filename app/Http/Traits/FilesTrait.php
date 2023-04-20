<?php

namespace App\Http\Traits;

use Intervention\Image\Facades\Image;

trait FilesTrait
{

    public function getImageAttribute()
    {
        if(request()->image){
        if (isset($this->attributes['image'])) {
                Image::make(request()->image)->resize(300,null,function($constraint){
                    // aspectRatio function this function aspectRat width and hight
                    $constraint->aspectRatio();
                })->save(public_path($this->imgFolder.request()->image->hashName()));
               return  $user_data['image'] = request()->image->hashName();
            }//end of if
        }
    }
}
