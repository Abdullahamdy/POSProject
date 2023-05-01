<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
                    'name'    =>  'required',
                    'phone' =>  'required|array|min:1' ,
                    'phone.0' =>  'required' ,
                    'address' =>  'required' ,

                ];
            }
            case 'PUT':
                case 'PATCH':
                {
                    return [
                        'name'    =>  'required',
                        'phone' =>  'required|array|min:1' ,
                        'phone.0' =>  'required' ,
                        'address' =>  'required' ,

                ];
            }
            default: break;
    }
    }
}
