<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;

use App\Http\Requests\CreateCustomerRequest;

class CustomersController extends Controller
{
    /**
     * Show all customer entries
     *
     * @return JsonResponse
     */
    public function all()
    {
        $customers = Customer::all();

        return response()->json([
            'customers' => $customers
        ], 200);
    }

    /**
     * Get customer by id
     * @param $id
     * @return JsonResponse
     */
    public function get($id)
    {
        $customer = Customer::whereId($id)->first();

        return response()->json([
            'customer' => $customer
        ], 200);
    }

    /**
     * Show all walkin entries
     * @param CreateCustomerRequest $request
     * @return JsonResponse
     */

    public function new(CreateCustomerRequest $request)
    {
        $customer = Customer::create($request->only(['name', 'email', 'phone', 'website']));

        return response()->json([
            'customer' => $customer
        ], 200);
    }
}
