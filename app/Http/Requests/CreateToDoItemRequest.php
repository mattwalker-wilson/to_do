<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateToDoItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'between:3,255',
                'regex:/^[a-zA-Z0-9\s]+$/'
            ],
            'description' => [
                'nullable',
                'string',
                'max:255'
            ],
            'completed' => [
                'boolean',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'The :attribute field is required.',
            'string' => 'The :attribute field must be a string.',
            'max' => 'The :attribute field must be lass than :max.',
            'boolean' => 'The :attribute must be True or False.',
        ];
    }
}
