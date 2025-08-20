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
        return true; // Since Demo/Test returing true directly
    }

    public function rules(): array
    {
        return [
            'customer_name' => ['required', 'string', 'max:255'],
            'item_name'     => ['required', 'string', 'max:255'],
            'price'         => ['required', 'numeric', 'min:0'],
            'status'        => ['required', 'in:pending,paid,cancelled'],
        ];
    }

    // public function prepareForValidation(): void
    // {
    //     if (!$this->has('status')) {
    //         $this->merge(['status' => 'pending']);
    //     }
    // }
}
