<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
                    'first_name' => 'required|max:20',
                    'last_name' => 'required|max:20',
                    'email' => 'required|unique:users',
                    'password' => 'required|min:8|confirmed',

                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'first_name' => 'required|max:20',
                    'last_name' => 'required|max:20',
                    'email' => 'required|unique:users,email,'.$this->user->id,
                ];
            }
            default: break;
    }
}
}
