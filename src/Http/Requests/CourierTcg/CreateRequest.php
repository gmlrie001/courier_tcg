<?php

namespace App\Http\Requests\CourierTcg;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
        return [
            // 'title' => 'required|string',
            'my_name'   => 'honeypot',
            'my_time'   => 'required|honeytime:0'
        ];
    }
    
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            // 'title.required' => 'Title must not be blank.',
            // 'title.string' => 'Title must be text.',
            'my_time.required' => '',
            'my_name.honeypot'  => '',
            'my_time.honeytime'  => ''
        ];
    }
}
