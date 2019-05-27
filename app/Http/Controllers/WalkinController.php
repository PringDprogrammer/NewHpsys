<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddItemRequest;
use App\Inventories;
use App\Additem;
use App\Walkin;
use App\Orderitem;
use Carbon\Carbon;
class WalkinController extends Controller
{
    /**
     * Show all walkin entries
     *
     * @return JsonResponse
     */
    public function all()
    {
        $walkin = Walkin::all();
        return response()->json([
            'walkins' => $walkin
        ]);
    }

    /**
     * Get walkin by id
     * @param $walkInid
     * @return JsonResponse
     */
    public function get($walkInid)
    {
        $walkin = Walkin::where('walkInid', $walkInid)->first();

        return response()->json([
            'walkin' => $walkin
        ]);
    }

    /**
     * store new walkin
     * @param WalkinRequest $request
     * @return JsonResponse
     */
    public function new(Request $request)
    {
        //getting the object in vue
        $bills      = $request->input('bills');
        $orders     = $request->input('orders');
        $customer   = $request->input('customer');
        $fname      = $customer['fname'];
        $mname      = $customer['mname'];
        $lname      = $customer['lname'];
        $fullName   = $fname.' '.$mname.'. '.$lname; 
        $transdate  = Carbon::parse($request->input('transdate'))->format('Y-m-d');
        
        //Saving walkin Information to walkins table
        $walkin = new Walkin();
        $lastId = $walkin->count();
        $sn = 'W' . date('y') . str_pad($lastId+1, 5, '00000', STR_PAD_LEFT);
        $walkin->walkin_id      = $sn;
        $walkin->fullname       = $fullName;
        $walkin->cash           = $customer['cash'];
        $walkin->cashref        = $customer['cashref'];
        $walkin->coupon         = $customer['coupon'];
        $walkin->couponref      = $customer['couponref'];
        $walkin->phic           = $customer['phic'];
        $walkin->phicref        = $customer['phicref'];
        $walkin->others         = $customer['others'];
        $walkin->othersamount   = $customer['othersamount'];
        $walkin->othersref      = $customer['othersref'];
        $walkin->cash           = $customer['cash'];
        $walkin->discountType   = $customer['discountType'];
        $walkin->discount       = $bills['discount'];
        $walkin->payment_total  = $bills['paymentTotal'];
        $walkin->sumTotal       = $bills['sumtotal'];
        $walkin->orderTotal     = $bills['totalPrice'];
        $walkin->transdate      = $transdate;
        $walkin->save();
        
        // update inventory stock
        foreach ($orders as $ord) {
            $inventory = Inventories::where('itemcode', $ord['itemcode']);
            $inventory->update(['stock' => $ord['stock']]);
        }

        //saving ordered items in orderitems table
        $sn = 'W' . date('y') . str_pad($lastId+1, 5, '00000', STR_PAD_LEFT);
        foreach ($orders as $order) {
            $orderedItem = new Orderitem();
            $orderedItem->order_id      = $sn;
            $orderedItem->itemcode      = $order['itemcode'];
            $orderedItem->itemName      = $order['itemName'];
            $orderedItem->itemType      = $order['itemType'];
            $orderedItem->consignor     = $order['consignor'];
            $orderedItem->quantity      = $order['quantity'];
            $orderedItem->sellPrice     = $order['sellPrice'];
            $orderedItem->itemTotal     = $order['itemTotal'];
            $orderedItem->save();
        }
        return response()->json('successfuly added');
    }

    /**
     * Perform new walkin order
     *
     * @return JsonResponse
     */
    public function newOrder()
    {
        $walkinOrder = Inventories::select(
            'itemName',
            'itemcode',
            'itemType',
            'stock',
            'sellPrice'
        )->get();

        return response()->json([
            'walkinOrder' => $walkinOrder
        ]);
    }

    /**
     * Perform add item
     *
     * @param AddItemRequest $request
     * @return JsonResponse
     */
    public function addItem(AddItemRequest $request)
    {
        $add_item = Additem::create($request->only([
            'itemcode',
            'itemName',
            'itemType',
            'stock',
            'sellPrice'
        ]));

        return response()->json([
            'additem' => $add_item
        ]);
    }

    /**
     * Get itemcode
     *
     * @param $itemcode
     * @return JsonResponse
     */
    public function showItem($itemcode)
    {
        $item = Inventories::where('itemcode', $itemcode)->first();
        return response()->json([
        'item' => $item
        ]);
    }
}
