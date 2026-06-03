<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name'=>'sometimes|required|string|max:255',
            'last_name'=>'sometimes|required|string|max:255',
            'email'=>'sometimes|required|email|unique:users,email,'.$this->route('id'),
            'photo'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'phone'=>'sometimes|required|string|max:10|starts_with:0|unique:users,phone,'.$this->route('id')
        ];
    }
}
