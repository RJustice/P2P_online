<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateAdminRequest extends Request
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
            'username' => 'required|max:50',
            'name' => 'required|max:20',
            'email' => 'required|email|unique:users',
            'password' => 'required|max:20',
            'phone' => 'numeric|digits:11',
        ];
    }
}
