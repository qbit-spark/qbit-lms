<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorestudentRequest extends FormRequest
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
            'name' => "required",
            'address' => "required",
            'gender' => "required",
            'category' => "required",
            'class' => "sometimes|nullable|string",
            'age' => "required",
            'phone' => "required",
            'email' => "required|email",
        ];
    }
}
