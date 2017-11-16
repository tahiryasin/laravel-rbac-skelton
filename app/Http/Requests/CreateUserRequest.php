<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'username' => 'required|min:4|unique:users|max:255',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ];
    }
    
//    public function redirect()
//    {die;
//        return redirect()->route('admin.user.create');
//    }
}
