<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->isAdmin();

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'        => 'string',
            'description' => 'string',
        ];
    }
     public function messages(): array
    {
        return [
            'name.required'        => 'Please provide a category name when updating.',
            'name.string'          => 'Category name must be text.',
            'name.max'             => 'Category name may not exceed 255 characters.',
            'description.string'   => 'Description must be text if provided.',
            'type.required'        => 'Please specify a category type when updating.',
            'type.string'          => 'Category type must be text.',
            'type.max'             => 'Category type may not exceed 100 characters.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->messages();

        throw new HttpResponseException(response()->json([
            'status'  => 'error',
            'message' => 'Validation failed',
            'errors'  => $errors,
        ], 422));
    }
}
