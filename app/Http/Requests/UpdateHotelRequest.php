<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHotelRequest extends FormRequest
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
            'name' => 'string',
        'address' => 'string',
        'phone_number' => 'string',
        'email' => 'string',
        'about' => 'string',
        'rating' => 'numeric',
        'photos.*' => 'file|mimes:jpg,jpeg,png,gif|max:2048',
        ];
    }
}
