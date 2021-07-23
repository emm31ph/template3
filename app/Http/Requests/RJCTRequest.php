<?php

namespace App\Http\Requests;

use App\Rules\equalToZero;
use Illuminate\Foundation\Http\FormRequest;

class RJCTRequest extends FormRequest
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

        
        $rules = [
            'refno' => 'required',
            'trndate' => 'required|date',
            'from' => ['required'],
            'to' => 'required',
            // 'drqty_total' => 'integer', 
            'items_variance_total' => ['not_in:0',new equalToZero],
            "items.*.itemcode" => 'required',
          
            // "items.*.drqty" => "required|not_in:0",
            // "items.*.crqty" => 'required|different:items.*.drqty',
            // "items.*.drqty" => '|different:items.*.crqty',
            // "items.*.crqty" => 'required_if:items.*.drqty,>=,0|nullable',
        ];

        // $val = $this->items[0];
        // $val = $val['drqty'];
        // if($val==0){
            // $rules += [   "items.*.expdate" => 'required_if:items.*.itemcode,!=,null|date|after:tomorrow|date_format:Y-m-d',];
        // }

        return $rules;

    }

    public function messages()
    {
        $val = $this->items[0];
        $val = $val['itemcode'];
        return [
            'trndate.required' => 'The Date field is require.',
            'trndate.date' => 'The Date field invalid format.',
            'trndate.after' => 'The Date field invalid format.',
            'refno.required' => 'The Reference No. field is require.'. $val,
            'refno.unique' => 'The Reference No. field is all ready exist.',
            'from.required' => 'The "From" field is require.',
            'to.required' => 'The "To" field is require.',
            'crqty_total.gt' => 'The Credit total must be greater than 0.',
            'drqty_total.gt' => 'The Dedit total must be greater than 0.',
            'items.*.itemcode.required' => 'The Item product field is require.',
            'items.*.expdate.required' => 'The Expiry Date field is require.',
            'items.*.expdate.date' => 'The Expiry Date is not a valid date.',
            'items.*.expdate.after' => 'The Expiry Date must be a date after tomorrow.',
            'items.*.crqty.required' => 'The Credit Quantity field is require.',
            'items.*.crqty.min' => 'The Credit Quantity must be at least 1.',
            'items.*.drqty.required' => 'The Dedit Quantity field is require.',
            'items.*.drqty.min' => 'The Dedit Quantity must be at least 1.',
            'items_variance_total.not_in' => 'Must not be equal to zero',
        ];
    }
    // public function rules()
    // {
    //     return [
    //         'refno' => 'required',
    //         'trndate' => 'required|date',
    //         'from' => ['required'],
    //         'to' => 'required',
    //         "items.*.itemcode" => 'required',
    //         "items.*.expdate" => 'required_if:items.*.itemcode,!=,null|date|after:tomorrow|date_format:Y-m-d',
    //         "items.*.qty" => 'required_if:items.*.itemcode,!=,null|nullable',
    //     ];

    // }

    // public function messages()
    // {
    //     return [
    //         'trndate.required' => 'The Date field is require.',
    //         'trndate.date' => 'The Date field invalid format.',
    //         'trndate.after' => 'The Date field invalid format.',
    //         'refno.required' => 'The Reference No. field is require.',
    //         'refno.unique' => 'The Reference No. field is all ready exist.',
    //         'from.required' => 'The "From" field is require.',
    //         'to.required' => 'The "To" field is require.',
    //         'items.*.itemcode.required' => 'The Item product field is require.',
    //         'items.*.expdate.required' => 'The Expiry Date field is require.',
    //         'items.*.expdate.date' => 'The Expiry Date is not a valid date.',
    //         'items.*.expdate.after' => 'The Expiry Date must be a date after tomorrow.',
    //         'items.*.qty.required' => 'The Quantity field is require.',
    //         'items.*.qty.min' => 'The Quantity must be at least 1.',
    //     ];
    // }
}
