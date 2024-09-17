<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'id'               => 'required|string',
            'name'             => 'required|string',
            'address'          => 'required|array',
            'address.city'     => 'required|string',
            'address.district' => 'required|string',
            'address.street'   => 'required|string',
            'price'            => 'required|numeric|gt:0',
            'currency'         => 'required|in:TWD,USD,JPY,RMB,MYR',
        ];
    }

    /**
     * Prepare the data for validation
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'currency' => strtoupper($this->currency),
        ]);
    }
}
