<?php

namespace App\Http\Requests;

use App\Rules\MaxVideoDuration;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateProperty extends FormRequest
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
            'description' => 'required|string',
            'price' => 'required|numeric',
            'location_id' => 'required|exists:loctaions,id',
            'type_id' => 'required|exists:property_types,id',
            'category_id' => 'required|exists:categories,id',
            'video' => [
                'required',
                'file',
                'mimes:mp4,mov,avi',
                new MaxVideoDuration
            ],
            'document' => 'required|file|mimes:pdf,doc,docx',
            'rooms' => 'required|integer',
            'capacity' => 'required|integer',
        ];
    }
}
