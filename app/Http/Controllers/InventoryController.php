<?php

namespace App\Http\Controllers;

use App\Inventories;
use Illuminate\Http\Request;
use App\Http\Requests\InventoryRequest;
use App\Http\Requests\ConsignorRequest;
use App\Consignor;
use Carbon\Carbon;
use DB;
class InventoryController extends Controller
{
    public function all()
    {
        $inventories = Inventories::all();

        return response()->json([
            'inventory' => $inventories
        ], 200);
    }

    public function get($itemcode)
    {
        $item = Inventories::where('itemcode', $itemcode)->first();

        return response()->json([
            'inventory' => $item
        ], 200);
    }

    public function new(Request $request)
    {
        $invData = $request->input('inv_data');
        $delDate = Carbon::parse($request->input('del_date'))->format('Y-m-d');

        $inventory = Inventories::updateOrCreate(

            ['itemcode'     => $invData['itemcode']],
            ['dr_no'        => $invData['dr_no'],
            'or_no'         => $invData['or_no'],
            'del_date'      => $delDate,
            'itemName'      => $invData['itemName'],
            'brandName'     => $invData['brand'],
            'itemType'      => $invData['itemType'],
            'consignor'     => $invData['consignor'],
            'purchasePrice' => $invData['purchasePrice'],
            'sellPrice'     => $invData['sellPrice'],
            'stock'         => $invData['stock'],
            'quantity'      => $invData['quantity'],
            'or_no'         => $invData['or_no']
        ]);


        // if($invData['itemcode'] > 0){
        //     $inventory = Inventories::where('itemcode', $invData['itemcode']);
        //     $inventory->update([
        //         'dr_no'         => $invData['dr_no'],
        //         'or_no'         => $invData['or_no'],
        //         'del_date'      => $delDate,
        //         'itemcode'      => $invData['itemcode'],
        //         'itemName'      => $invData['itemName'],
        //         'brandName'     => $invData['brand'],
        //         'itemType'      => $invData['itemType'],
        //         'consignor'     => $invData['consignor'],
        //         'purchasePrice' => $invData['purchasePrice'],
        //         'sellPrice'     => $invData['sellPrice'],
        //         'stock'         => $invData['stock'],
        //         'quantity'      => $invData['quantity'],
        //         'or_no'         => $invData['or_no']
        //     ]);

        // } else {
        //     $inventory = new Inventories();
        //     $inventory->dr_no         = $invData['dr_no'];
        //     $inventory->or_no         = $invData['or_no'];
        //     $inventory->del_date      = $delDate;
        //     $inventory->itemcode      = $invData['itemcode'];
        //     $inventory->itemName      = $invData['itemName'];
        //     $inventory->brandName     = $invData['brand'];
        //     $inventory->itemType      = $invData['itemType'];
        //     $inventory->consignor     = $invData['consignor'];
        //     $inventory->purchasePrice = $invData['purchasePrice'];
        //     $inventory->sellPrice     = $invData['sellPrice'];
        //     $inventory->stock         = $invData['stock'];
        //     $inventory->quantity      = $invData['quantity'];
        //     $inventory->or_no         = $invData['or_no'];
        //     $inventory->save();
        // }

        return response()->json([
            'inventory' => $inventory
        ], 200);
    }

    public function update($itemcode, Request $request)
    {
        $inventory = Inventories::where('itemcode', $itemcode)->first();
        $inventory->update($request->all());
        return $inventory;
    }
 
    public function delete($itemcode)
    {
        $inventory = Inventories::where('itemcode', $itemcode)->first();
        $inventory->delete();
        return response('Item deleted');
    }

    public function addConsignor(ConsignorRequest $request)
    {
        $doctor = new Consignor();
        $doctor->name       = $request['name'];
        $doctor->alias      = $request['alias'];
        $doctor->contact    = $request['contact'];
        $doctor->save();
    }

    public function pickConsignor()
    {
        $consign = Consignor::select('alias')->get();

        return response()->json(['consignor' => $consign]);
    }
}
