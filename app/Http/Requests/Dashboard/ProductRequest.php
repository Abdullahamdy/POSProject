<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;
use CodeZero\UniqueTranslation\UniqueTranslationRule;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
            {
                return [
                 'name.*' =>   ['required', UniqueTranslationRule::for('products')],
                 'description.*' =>   ['required', UniqueTranslationRule::for('products')],
                 'cat_id'=>'required|exists:categroys,id',
                 'purchase_price'=> 'required|numeric',
                 'sale_price'=>'required|numeric',
                 'stock'=>'required|numeric',
                 'image' => 'required',

                ];
            }
            case 'PUT':
            case 'PATCH':
                {
                return [
                    'name.*' =>  ['required',UniqueTranslationRule::for('products')->ignore(request()->product->id)],
                    'description.*' =>  ['required',UniqueTranslationRule::for('products')->ignore(request()->product->id)],
                    'cat_id'=>'required|exists:categroys,id',
                    'purchase_price'=> 'required|numeric',
                    'sale_price'=>'required|numeric',
                    'stock'=>'required|numeric',
                    'image' => 'nullable',

                ];
            }
            default: break;
    }
    }
}
