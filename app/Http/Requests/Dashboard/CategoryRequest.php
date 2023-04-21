<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;
use CodeZero\UniqueTranslation\UniqueTranslationRule;

class CategoryRequest extends FormRequest
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
                 'name.*' =>   ['required', UniqueTranslationRule::for('categroys')],

                ];
            }
            case 'PUT':
            case 'PATCH':
                {
                return [
                    'name.*' =>  UniqueTranslationRule::for('categroys')->ignore(request()->cat_id),


                ];
            }
            default: break;
    }
    }
}
