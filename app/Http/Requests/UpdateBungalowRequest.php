<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBungalowRequest extends FormRequest
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
            'name' => 'required|unique:bungalows,name,'.$this->bungalow->id,
            'no_ac_room' => 'required|numeric',
            'no_none_ac_room' => 'required|numeric',
            'no_guest' => 'required|numeric',
            'serving_price' => 'required|numeric',
            'retired_price' => 'required|numeric',
            'official_price' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The Name field is required.',           
            'name.unique' => 'This Name is already exists',
            'no_ac_room.required' => 'The No. of AC Room field is required.',           
            'no_ac_room.numeric' => 'This No. of AC Room must be a number',
            'no_none_ac_room.required' => 'The No. of None AC Room field is required.',           
            'no_none_ac_room.numeric' => 'This No. of None AC Room must be a number',
            'no_guest.required' => 'The No. of Guest field is required.',           
            'no_guest.numeric' => 'This No. of Guest must be a number',
            'serving_price.required' => 'The Serving Price field is required.',           
            'serving_price.numeric' => 'This Serving Price must be a number',
            'retired_price.required' => 'The Retired Price field is required.',           
            'retired_price.numeric' => 'This Retired Price must be a number', 
            'official_price.required' => 'The Death Price field is required.',           
            'official_price.numeric' => 'This Death Price must be a number',         
        ];
    }
}
