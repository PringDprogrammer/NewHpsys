<?php

namespace App\Http\Controllers;

use App\Inventories;
use App\ItemList;
use App\InventoryAdditem;
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
        // $inventories = ItemList::all();
        $inventories = DB::table('itemlists')
            ->join('inventories', 'itemlists.itemcode', '=', 'inventories.itemcode')
            ->select('itemlists.itemcode', 'itemlists.itemName', 'itemlists.itemType', 'itemlists.consignor', 'itemlists.brandName', 'inventories.unit_cost', 'inventories.sellPrice', 'inventories.quantity')
            ->get();

        return response()->json([
            'inventory' => $inventories
        ], 200);
    }
    
    public function itemPick($itemcode) 
    {
        $item = ItemList::where('itemcode', $itemcode)->first();

        return response()->json([
            'item' => $item
        ]);
    }

    public function addDelivery(Request $request) {
        $inv_data   = $request->input('inv_data');
        $items      = $request->input('order_item');
        $del_date   = Carbon::parse($request->input('del_date'))->format('Y-m-d');

        $or_no = $inv_data['or_no']; 
        $dr_no = $inv_data['dr_no'];
        $con = $inv_data['consignor'];

        foreach ($items as $item) {
            $delivery = new Inventories();
            $delivery->dr_no        = $dr_no;
            $delivery->or_no        = $or_no;
            $delivery->del_date     = $del_date;
            $delivery->itemcode     = $item['itemcode'];
            $delivery->itemName     = $item['itemName'];
            $delivery->brandName    = $item['brandName'];
            $delivery->itemType     = $item['itemType'];
            $delivery->consignor    = $con;
            $delivery->quantity     = $item['quantity'];
            $delivery->unit         = strtoupper($item['unit']);
            $delivery->sellPrice    = $item['sellprice'];
            $delivery->unit_cost    = $item['unit_cost'];
            $delivery->total        = $item['item_total'];
            $delivery->save();
        }


    }

    public function itemChange(Request $request) 
    {
        $consigns = $request->input('consignor');
        
        $delItem = DB::table('itemlists')
            ->select('itemcode', 'itemName', 'itemType', 'brandName')
            ->where('consignor', '=', $consigns)
            ->get();

        return response()->json([
            'invItem' => $delItem
        ]);
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
        $inventory = new ItemList();
        $inventory->itemcode      = $invData['itemcode'];
        $inventory->itemName      = $invData['itemName'];
        $inventory->brandName     = $invData['brand'];
        $inventory->itemType      = $invData['itemType'];
        $inventory->consignor     = $invData['consignor'];
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
