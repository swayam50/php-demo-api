<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BulkStoreInvoiceRequest extends FormRequest
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
        // * cause we're working with an array, instead of single object
        return [
            '*.customerId' => ['required', 'integer'],
            '*.status' => ['required', Rule::in(['B', 'P', 'V', 'b', 'p', 'v'])],
            '*.amount' => ['required', 'numeric'],
            '*.billedDated' => ['required', 'date_format:Y-m-d H:i:s'],
            '*.paidDated' => ['nullable', 'date_format:Y-m-d H:i:s'],
        ];


        // if it was data: [ { customerId, ... } ]
        // the key would have been like data.*.customerId
    }

    protected function prepareForValidation()
    {
        $data = [];

        foreach ($this->toArray() as $obj) {
            // modifying the child object itself
            $obj['customer_id'] = $obj['customerId'] ?? null;
            $obj['billed_dated'] = $obj['billedDated'] ?? null;
            $obj['paid_dated'] = $obj['paidDated'] ?? null;

            // adding that to the data
            $data[] = $obj;
        }

        $this->merge($data);
    }
}
