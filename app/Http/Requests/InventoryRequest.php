<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InventoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return boolean
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
        
            'itemcode'      => 'string|required|max:75',
            'itemName'      => 'string|required|max:75',
            'itemType'      => 'required',
            'consignor'     => 'required',
            'purchasePrice' => 'numeric|required',
            'sellPrice'     => 'numeric|required',
            'quantity'      => 'integer|required',
            'stock'         => 'integer|required'
        
        ];
    }
}
