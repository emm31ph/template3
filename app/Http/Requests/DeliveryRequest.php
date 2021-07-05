<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $checkbal = $this->bal * $this->numperuompu;
        return [
            'refno' => 'required',
            'rono' => 'required',
            'trndate' => 'required|date',
            'userid' => 'required',
            'customer' => 'required',
            // "items.itemcode" => 'required|array|min:1',
            // "items.expdate" => 'required|array|min:1|after:tomorrow',
            // "items.qty" => 'required|array|min:1',
            "items.*.itemcode" => 'required',
            "items.*.expdate" => 'required_if:items.*.itemcode,!=,null|nullable|date|after:tomorrow',
            // "items.*.qty" => 'required|integer|min:1',
            "items.*.tins" => 'required|integer|min:1|lte:items.*.bal',
        ];
    }

    public function messages()
    {
        return [
            'trndate.required' => 'The Issued Date field is require.',
            'trndate.date' => 'The Issued Date field invalid format.',
            'trndate.after' => 'The Issued Date field invalid format.',
            'refno.required' => 'The Reference No. field is require.',
            'rono.required' => 'The Supporting Document field is require.',
            'refno.unique' => 'The Reference No. field is all ready exist.',
            'refno.unique' => 'The Reference No. field is all ready exist.',
            'userid.required' => 'The Prepare By field is require.',
            'customer.required' => 'The Customer field is require.',
            'items.*.itemcode.required' => 'The Item product field is require.',
            'items.*.expdate.required' => 'The Expiry Date field is require.',
            'items.*.expdate.date' => 'The Expiry Date is not a valid date.',
            'items.*.expdate.after' => 'The Item is Expired',
            'items.*.qty.required' => 'The Quantity field is require.',
            'items.*.tins.min' => 'The Quantity must be at least 1.',
            'items.*.tins.lte' => 'The Quantity must be less than or equal :value tins',
        ];
    }
}
