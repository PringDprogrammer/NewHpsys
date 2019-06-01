<?php

namespace App\Http\Controllers;

use App\Inventories;
use Illuminate\Http\Request;
use App\Http\Requests\InventoryRequest;
use App\Http\Requests\ConsignorRequest;
use App\Consignor;
use Carbon\Carbon;
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

        $inventory = new Inventories();
        $inventory->dr_no         = $invData['dr_no'];
        $inventory->del_date      = $delDate;
        $inventory->itemcode      = $invData['itemcode'];
        $inventory->itemName      = $invData['itemName'];
        $inventory->brandName     = $invData['brand'];
        $inventory->itemType      = $invData['itemType'];
        $inventory->consignor     = $invData['consignor'];
        $inventory->purchasePrice = $invData['purchasePrice'];
        $inventory->sellPrice     = $invData['sellPrice'];
        $inventory->stock         = $invData['stock'];
        $inventory->quantity      = $invData['quantity'];
        $inventory->or_no         = $invData['or_no'];
        $inventory->save();

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
