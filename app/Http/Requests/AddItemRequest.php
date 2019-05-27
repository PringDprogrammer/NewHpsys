<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddItemRequest extends FormRequest
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
            'itemcode'  => 'string',
            'itemName'  => 'string',
            'itemType'  => 'string',
            'quantity'  => 'integer',
            'sellPrice' => 'decimal'
        ];
    }
}
