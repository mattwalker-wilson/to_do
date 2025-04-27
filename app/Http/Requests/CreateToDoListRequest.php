<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CreateToDoListRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'between:3,255',
                Rule::unique('to_do_lists','name')
                    ->where(function ($query) {
                        return $query->where('user_id', $this->user()->id);
                }),
                'regex:/^[a-zA-Z0-9\s]+$/'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'The :attribute field is required.',
            'string' => 'The :attribute field must be a string.',
            'between' => 'The :attribute  ":input" must be between :min and :max.',
            'unique' => 'The :attribute ":input" has already been used.',
            'regex' => 'The :attribute  ":input" must only contain letters, numbers, and spaces.'
        ];
    }
}
