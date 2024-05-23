<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHotelRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
        'address' => 'required|string',
        'phone_number' => 'required|string',
        'email' => 'required|string',
        'about' => 'required|string',
        'rating' => 'required|numeric',
        'photos.*' => 'required|file',
        

        ];
    }
}
//'photos.*' => 'required|file|mimes:jpg,jpeg,png,gif|max:2048',