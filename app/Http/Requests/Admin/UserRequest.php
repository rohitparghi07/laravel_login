<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

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
    public function rules(Request $request)
    {
        $rule = [
            'fname' => 'required',
            'lname' => 'required',
            'dob' => 'required'
        ];
        if(!isset($request->id)){
            $rule['password'] = 'required';
        }else{
            $rule['password'] = 'nullable';
        }

        if($request->has("id")){
            $rule['email'] = 'required|Email|unique:users,email,'. $request->id . ',id';
        }else{
            $rule['email'] = 'required|Email|unique:users,email';
        }

        if($request->has("id")){
            $rule['username'] = 'required|unique:users,user_name,'. $request->id . ',id';
        }else{
            $rule['username'] = 'required|unique:users,user_name';
        }
       
        return $rule;
    }
}
