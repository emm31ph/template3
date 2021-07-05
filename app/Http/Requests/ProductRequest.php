<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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

    public function rules()
    {

        // dd($this->id);
        $rules = [
            'u_stockcode' => 'required',
            'pckgsize' => 'required',
            'numperuompu' => 'required',
            'uompu' => 'required',

        ];
        switch ($this->getMethod()) {
            case 'POST':
                $rules += ['itemcode' => 'required|min:4|unique:items'];
                $rules += ['itemdesc' => 'required|min:4|unique:items'];

                break;
            case 'PUT':
                $rules += ['itemcode' => 'required|min:4|unique:items,itemcode' . (!isset($this->itemcode) ? "," : ',' . $this->itemcode)];
                $rules += ['itemdesc' => 'required|min:4|unique:items,itemdesc' . (!isset($this->itemcode) ? "," : ',' . $this->itemcode)];

                break;
            default:
                # code...
                break;
        }
        return $rules;

    }
    public function messages()
    {
        return [
            'itemcode.required' => 'Itemcode is required',
            'itemcode.unique' => 'Itemcode is already exist',
            'itemdesc.required' => 'Item description is required',
            'itemdesc.unique' => 'Item description is already exist',
            'u_stockcode.required' => 'Shortcode is required',
            'pckgsize.required' => 'Package size is required',
            'numperuompu.required' => 'Number per Unit is required',
            'uompu.required' => 'UOM is required',
        ];
    }
}
