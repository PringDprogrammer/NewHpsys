<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderitemsRequest extends FormRequest
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
            'itemcode'          => 'string', 
            'itemName'          => 'string',
            'itemType'          => 'string',
            'quantity'          => 'integer',
            'sellPrice'         => 'numeric',
            'itemTotal'         => 'numeric',
            'orderTotal'        => 'numeric',
            'discountType'      => 'string',
            'discount'          => 'numeric',
            'sumtotal'          => 'numeric',
            'cash'              => 'numeric',
            'cashref'           => 'string',
            'coupon'            => 'numeric',
            'couponref'         => 'string',
            'phic'              => 'numeric',
            'phicref'           => 'string',
            'others'            => 'string',
            'othersref'         => 'string',
            'payment_total'     => 'numeric'
        ];
    }
}
