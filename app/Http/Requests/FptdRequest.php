<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FptdRequest extends FormRequest
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
            'from' => 'required',
            'to' => 'required',
            'drqty_total' => 'integer',
            'crqty_total' => 'integer|same:drqty_total',
            "items.*.itemcode" => 'required',
            "items.*.expdate" => 'required|date|after:tomorrow',
            #"items.*.drqty" => 'required_if:items.*.crqty,=,0',
            #"items.*.crqty" => 'required_if:items.*.drqty,=,0',
        ];

    }
    public function messages()
    {
        return [
            'trndate.required' => 'The Date field is require.',
            'trndate.date' => 'The Date field invalid format.',
            'trndate.after' => 'The Date field invalid format.',
            'refno.required' => 'The Reference No. field is require.',
            'from.required' => 'The "From" field is require.',
            'to.required' => 'The "To" field is require.',
            'crqty_total.same' => 'The Dedit total and Credit must match.',
            'crqty_total.gt' => 'The Credit total must be greater than 0.',
            'drqty_total.gt' => 'The Dedit total must be greater than 0.',
            'items.*.itemcode.required' => 'The Item product field is require.',
            'items.*.expdate.required' => 'The Expiry Date field is require.',
            'items.*.expdate.after' => 'The Expiry Date must be a date after tomorrow.',
            'items.*.crqty.required' => 'The Credit Quantity field is require.',
            'items.*.crqty.min' => 'The Credit Quantity must be at least 1.',
            'items.*.drqty.required' => 'The Dedit Quantity field is require.',
            'items.*.drqty.min' => 'The Dedit Quantity must be at least 1.',
        ];
    }
}
