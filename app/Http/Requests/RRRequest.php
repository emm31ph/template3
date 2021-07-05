<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RRRequest extends FormRequest
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
        return [
            'refno' => 'required',
            'trndate' => 'required|date',
            'customer' => 'required',
            'van_no' => 'required',
            'seal_no' => 'required',
            "items.*.itemcode" => 'required',
            "items.*.expdate" => 'required|date|after:tomorrow|date_format:Y-m-d',
            "items.*.qty" => 'required|integer|min:1',
        ];

    }
    public function messages()
    {
        return [
            'trndate.required' => 'The Date field is require.',
            'trndate.date' => 'The Date field invalid format.',
            'trndate.after' => 'The Date field invalid format.',
            'refno.required' => 'The Reference No. field is require.',
            'refno.unique' => 'The Reference No. field is all ready exist.',
            'customer.required' => 'The Customer field is require.',
            'van_no.required' => 'The Van No. field is require.',
            'seal_no.required' => 'The Seal No. field is require.',
            'items.*.itemcode.required' => 'The Item product field is require.',
            'items.*.expdate.date_format' => 'The Expiry Date field is invalid format.',
            'items.*.expdate.required' => 'The Expiry Date field is require.',
            'items.*.expdate.after' => 'The Expiry Date must be a date after tomorrow.',
            'items.*.qty.required' => 'The Quantity field is require.',
            'items.*.qty.min' => 'The Quantity must be at least 1.',
        ];
    }
}
