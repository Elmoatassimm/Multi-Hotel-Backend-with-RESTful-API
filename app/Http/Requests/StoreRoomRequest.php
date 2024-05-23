<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoomRequest extends FormRequest
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
            'hotel_id' => 'required|exists:hotels,id',
            'room_type' => 'required|string',
            'description' => 'nullable|string',
            'price_per_night' => 'required|numeric|min:0',
            'availability' => 'required|boolean',
            'photos.*' => 'required|file|mimes:jpg,jpeg,png,gif|max:2048',
        ];
    }
}
