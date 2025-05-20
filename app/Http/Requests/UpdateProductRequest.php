<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() != null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'category_id' => 'numeric',
            'stock_quantity' => 'numeric'
        ];
    }
        public function messages(): array
    {
        return [
            'name.required'           => 'Please provide a product name.',
            'name.max'                => 'Product name may not exceed 255 characters.',
            'price.required'          => 'A price is required.',
            'price.numeric'           => 'The price must be a valid number.',
            'price.min'               => 'Price cannot be negative.',
            'category_id.required'    => 'Please select a category.',
            'category_id.exists'      => 'The selected category does not exist.',
            'stock_quantity.required' => 'Please specify how many items are in stock.',
            'stock_quantity.integer'  => 'Stock quantity must be a whole number.',
            'stock_quantity.min'      => 'Stock quantity cannot be negative.',
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
