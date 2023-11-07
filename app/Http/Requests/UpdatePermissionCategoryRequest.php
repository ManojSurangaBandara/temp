<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePermissionCategoryRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|unique:permission_categories,name,'.$this->permissioncategory->id,
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The Name field is required.',           
            'name.unique' => 'This Name is already exists',           
        ];
    }
}
