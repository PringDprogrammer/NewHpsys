<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PatientAddItemRequest;
use App\Http\Requests\NewDoctorRequest;
use App\Inventories;
use App\Patientadditem;
use App\InPatient;
use App\Patientorderitem;
use App\Inpatient_history;
use App\Doctor;
use Carbon\Carbon;
use DB;
class InPatientController extends Controller
{
    /**
     * Show all walkin entries
     *
     * @return JsonResponse
     */
    public function all()
    {
        $inpatient = DB::table('inpatients')
            ->join('inpatients_history', 'inpatients.inpatient_id', '=', 'inpatients_history.patientID')
            ->select('inpatients.inpatient_id', 'inpatients.fullname', 'inpatients_history.pat_type')
            ->get();

        return response()->json([
            'inpatients' => $inpatient
        ]);
    }

    /**
     * Get walkin by id
     * @param $walkInid
     * @return JsonResponse
     */
    public function get($inPatient_id)
    {
        $inpatient = InPatient::where('inpatient_id', $inPatient_id)->first();

        return response()->json([
            'inPatients' => $inpatient
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
        $inpatient      = $request->input('inpatient');
        $fname          = $inpatient['fname'];
        $mname          = $inpatient['mname'];
        $lname          = $inpatient['lname'];
        $fullname       = $fname.' '.$mname.'. '.$lname;
        $dob            = Carbon::parse($request->input('dob'))->format('Y-m-d');

        $patient = InPatient::where('fullname', '=', $fullname)->first();

        if(count($patient) > 0) {
            return response()->json(['error' => 'Already exist']);
        } else {
            $inPatient = new InPatient();
            $lastId = $inPatient->count();
            $sn = 'P' . date('y') . str_pad($lastId+1, 5, '00000', STR_PAD_LEFT);
            $inPatient->inpatient_id   = $sn;
            $inPatient->fullname       = strtoupper($fullname);
            $inPatient->age            = $inpatient['age'];
            $inPatient->dateBirth      = $dob;
            $inPatient->suffix         = strtoupper($inpatient['suffix']);
            $inPatient->gender         = strtoupper($inpatient['gender']);
            $inPatient->marital        = $inpatient['marital'];
            $inPatient->address        = strtoupper($inpatient['address']);
            $inPatient->brngy          = strtoupper($inpatient['barangay']);
            $inPatient->municipal      = strtoupper($inpatient['municipal']);
            $inPatient->province       = strtoupper($inpatient['province']);
            $inPatient->telNo          = $inpatient['telNo'];
            $inPatient->celNo          = $inpatient['celNo'];
            $inPatient->save();
            
            return response()->json('successfuly added');
        }
    }

    public function addOrder(Request $request) {
        //getting data from vueJs(front)
        $orderInfo      = $request->input('pat_info');
        $disc_type      = $orderInfo['discountType'];
        $disc_ref       = $orderInfo['disc_ref'];

        $calcu          = $request->input('calcu');
        $disc_amount    = $calcu['discount'];
        $sumtotal       = $calcu['sumtotal'];
        $totalPrice     = $calcu['totalPrice'];
            
        $item           = $request->input('item');
        $patientID      = $request->input('patient_id');
        $transdate      = Carbon::parse($request->input('date'))->format('Y-m-d');

        //looping the stock item in inventory
        foreach ($item as $gamit) {
            $inventory = Inventories::where('itemcode', $gamit['itemcode']);
            $inventory->update(['stock' => $gamit['stock']]);
        }

        //for referrence no.
        // $count = InPatient::count();

        // $addOrder   = Patientorderitem::groupBy('patient_order_id');
        // $lastId     = $addOrder->count();

        $addOrder = DB::table('patientorderitems')->latest('reference_no');
        $lastId = count($addOrder);
        $rn = 'RN' . date('ymd') . str_pad($lastId+1, 5, '00000', STR_PAD_LEFT);
            
        //saving item order
        foreach ($item as $items) {
            $newOrder = new Patientorderitem();
            $newOrder->patient_order_id = $patientID;
            $newOrder->reference_no     = $rn;
            $newOrder->transdate        = $transdate;
            $newOrder->itemcode         = $items['itemcode'];
            $newOrder->itemName         = $items['itemName'];
            $newOrder->itemType         = $items['itemType'];
            $newOrder->consignor        = $items['consignor'];
            $newOrder->disc_type        = $disc_type;
            $newOrder->disc_ref         = $disc_ref;
            $newOrder->quantity         = $items['quantity'];
            $newOrder->sellPrice        = $items['sellPrice'];
            $newOrder->itemTotal        = $items['itemTotal'];
            $newOrder->orderTotal       = $totalPrice;
            $newOrder->disc_amount      = $disc_amount;
            $newOrder->grnd_total       = $sumtotal;
            $newOrder->save();
        }
        return response()->json('successfuly added');
    }

    public function getPatienInfo() {

        $inpatient = InPatient::select('inpatient_id', 'fullname')
            ->orderBy('inpatient_id', 'dec')
            ->first();

        return response()->json([
            'inPatients' => $inpatient
        ]);
    }

    public function admissionDetails(Request $request) {
        $details = $request->input('details');
        $inpatient_id = $request->input('inpatient_id');


        $admision = new Inpatient_history();
            $lastId = $admision->count();
            $trans_no = date('ymd') . str_pad($lastId+1, 5, '00000', STR_PAD_LEFT);
            $admision->transaction_no       = $trans_no;
            $admision->patientID            = $inpatient_id;
            $admision->gname                = strtoupper($details['g_name']);
            $admision->grelation            = strtoupper($details['g_relation']);
            $admision->gcontact             = strtoupper($details['g_contact']);
            $admision->gaddress             = strtoupper($details['g_address']);
            $admision->bp                   = $details['bp'];
            $admision->temp                 = $details['temp'];
            $admision->pulse_rate           = $details['pulse_rate'];
            $admision->pat_categ            = $details['p_clasif'];
            $admision->pat_type             = $details['p_type'];
            $admision->doctor               = strtoupper($details['doctor']);
            $admision->room                 = $details['room'];
            $admision->remarks              = strtoupper($details['remark']);
            $admision->save();

        return response()->json('Successfully Admitted');
    }

    public function getPersonal(Request $request) {

        $id = $request->input('pat_id');

        $personal = DB::table('inpatients')
            ->join('inpatients_history', 'inpatients.inpatient_id', '=', 'inpatients_history.patientID')
            ->select('inpatients.inpatient_id', 'inpatients.fullname', 'inpatients.dateBirth', 'inpatients.suffix', 'inpatients.age', 'inpatients.gender', 'inpatients.marital', 'inpatients.address', 'inpatients.brngy', 'inpatients.municipal', 'inpatients.province', 'inpatients.telNo', 'inpatients.celNo', 'inpatients_history.status')
            ->where('inpatient_id', '=', $id)
            ->get();

        return response()->json([
            'inpatient' => $personal
        ]);
    }

    public function updatePersonal(Request $request) {
        $info   = $request->input('inpatient');
        $ID     = $request->input('pat_id');
        $birth  = Carbon::parse($request->input('dob'))->format('Y-m-d');

        $updatePerson = DB::table('inpatients')
            ->where('inpatient_id', '=', $ID)
            ->update([
                'inpatient_id' => $ID,
                'fullname'  => strtoupper($info['fullname']),
                'age'       => $info['age'],
                'gender'    => strtoupper($info['gender']),
                'marital'   => $info['marital'],  
                'address'   => strtoupper($info['address']),
                'brngy'     => strtoupper($info['brngy']),
                'municipal' => strtoupper($info['municipal']),
                'province'  => strtoupper($info['province']),
                'telNo'     => $info['telNo'],
                'celNo'     => $info['celNo'],
                'dateBirth' => $birth
            ]);
    }

    public function getCurrent(Request $request) {

        $id = $request->input('pat_id');

        $current = DB::table('inpatients')
            ->join('inpatients_history', 'inpatients.inpatient_id', '=', 'inpatients_history.patientID')
            ->select('inpatients.inpatient_id', 'inpatients.fullname', 'inpatients.created_at', 'inpatients_history.temp', 'inpatients_history.transaction_no', 'inpatients_history.bp', 'inpatients_history.pulse_rate', 'inpatients_history.pat_categ', 'inpatients_history.pat_type', 'inpatients_history.doctor', 'inpatients_history.room', 'inpatients_history.remarks', 'inpatients_history.gname', 'inpatients_history.grelation', 'inpatients_history.gcontact', 'inpatients_history.gaddress', 'inpatients_history.status', 'inpatients_history.finaldiagnosis', 'inpatients_history.releasedDate')
            ->where('inpatient_id', '=', $id)
            ->get();

        return response()->json([
            'adDetails' => $current
        ]);
    }

    public function updateRecord(Request $request) {
        $detail     = $request->input('details');
        $patid      = $request->input('pat_id');
        $final       = $request->input('finals');
        $admit      = Carbon::parse($request->input('admit'))->format('Y-m-d');
        $released   = Carbon::parse($request->input('released'))->format('Y-m-d');

        $updateRecord = DB::table('inpatients_history')
            ->where('patientID', '=', $patid)
            ->update([
                'transaction_no'    => $detail['ref_num'],
                'patientID'         => $patid,
                'gname'             => strtoupper($detail['gname']),
                'grelation'         => strtoupper($detail['grelation']),
                'gcontact'          => $detail['gcontact'],
                'gaddress'          => strtoupper($detail['gaddress']),
                'bp'                => $detail['bp'],
                'temp'              => $detail['temp'],
                'pulse_rate'        => $detail['pulse_rate'],
                'pat_categ'         => $detail['p_clasif'],
                'pat_type'          => $detail['p_type'],
                'doctor'            => strtoupper($detail['doctor']),
                'room'              => $detail['room'],
                'remarks'           => strtoupper($detail['remarks']),
                'finaldiagnosis'    => strtoupper($final['finaldiagnosis']),
                'releasedDate'      => $released,
                'status'            => $final['status']
                
            ]);

    }

    public function getOrder(Request $request) {

        $id = $request->input('pat_id');

        $current = DB::table('inpatients')
            ->join('inpatients_history', 'inpatients.inpatient_id', '=', 'inpatients_history.patientID')
            ->select('inpatients.inpatient_id', 'inpatients.fullname', 'inpatients_history.pat_categ', 'inpatients_history.pat_type')
            ->where('inpatient_id', '=', $id)
            ->get();

        $itemOrder = DB::table('patientorderitems')
            ->join('inventories', 'patientorderitems.itemcode', '=', 'inventories.itemcode')
            ->select('patientorderitems.reference_no', 'patientorderitems.patient_order_id', 'patientorderitems.transdate', 'patientorderitems.itemcode', 'patientorderitems.itemName', 'patientorderitems.itemType', 'patientorderitems.consignor', 'patientorderitems.quantity', 'patientorderitems.sellPrice', 'patientorderitems.itemTotal', 'patientorderitems.disc_type', 'patientorderitems.disc_ref', 'patientorderitems.cash_ref', 'patientorderitems.cash_amount', 'patientorderitems.coupon_amount', 'patientorderitems.coupon_ref', 'patientorderitems.phic_amount', 'patientorderitems.phic_ref', 'patientorderitems.others_desc', 'patientorderitems.others_ref', 'patientorderitems.others_amount', 'inventories.stock')
            ->where('patientorderitems.patient_order_id', '=', $id)
            ->orderBy('patientorderitems.transdate', 'DESC')
            ->get();

        return response()->json([
            'order' => $current,
            'patientOrderItem' => $itemOrder
        ]);
    }

    public function updateOrder(Request $request) {
        
        $payment        = $request->input('payment_info');
        $orderitem      = $request->input('orderItem');
        $total          = $request->input('totals');
        $orderDetails   = $request->input('orderDetails');



        foreach ($orderitem as $orderitemStock) {
            $inventory = Inventories::where('itemcode', $orderitemStock['itemcode']);
            $inventory->update([
                    'stock' => $orderitemStock['stock']
                ]);
        }

        foreach ($orderitem as $orderitems) {
            $updateItem = Patientorderitem::where('itemcode', $orderitems['itemcode']);
            $updateItem->update([
                'itemcode' => $orderitems['itemcode'],
                'itemName' => $orderitems['itemName'],
                'itemType' => $orderitems['itemType'],
                'consignor' => $orderitems['consignor'],
                'quantity' => $orderitems['quantity'],
                'sellPrice' => $orderitems['sellPrice'],
                'itemTotal' => $orderitems['itemTotal']
            ]);
        }


    }

    public function deleteOrderItem(Request $request) {
        
        $refNo = $request->input('ref_no');
        $itemCode = $request->input('item_code');

        $res=Patientorderitem::where('reference_no', '=', $refNo)
            ->where('itemcode', '=', $itemCode)
            ->delete();

    }

    public function getOrderName(Request $request) {
        
        $id = $request->input('pat_id');

        $ordername = DB::table('inpatients')
            ->select('inpatient_id', 'fullname')
            ->where('inpatient_id', '=', $id)
            ->get();

        return response()->json([
            'addorder' => $ordername
        ]);
    }

    /**
     * Perform new walkin order
     *
     * @return JsonResponse
     */
    public function newOrder()
    {
        $patientOrder = Inventories::select(
            'itemName',
            'itemcode',
            'itemType',
            'stock',
            'sellPrice'
        )->get();
        return response()->json([
            'patientOrder' => $patientOrder
        ]);
    }

    /**
     * Perform add item
     *
     * @param AddItemRequest $request
     * @return JsonResponse
     */
    public function addItem(PatientAddItemRequest $request)
    {
        $add_item = PatientAdditem::create($request->only([
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

    public function newdoctor(Request $request) {
        $doctor = new Doctor();
        $doctor->fname      = $request['fname'];
        $doctor->mname      = $request['mname'];
        $doctor->lname      = $request['lname'];
        $doctor->suffix     = $request['suffix'];
        $doctor->lcno       = $request['lcno'];
        $doctor->specialty  = $request['specialty'];
        $doctor->save();
    }

    public function pickDoctor() {
        $pickD = Doctor::select(
            'fname',
            'mname',
            'lname',
            'suffix',
            'specialty'
        )->get();

        return response()->json([
            'doctor' => $pickD
        ]);
    }

    public function ViewPatient($inpatient_id) {
        $UpdatePatient = DB::table('inpatients')
            ->select('inpatient_id', 'transdate', 'fullname', 'doctor', 'discountType', 'discount', 'orderTotal', 'sumtotal', 'cash', 'cashref', 'coupon', 'couponref', 'phic', 'phicref', 'others', 'othersamount', 'othersref', 'payment_total')
            ->where('inpatient_id', '=', $inpatient_id)
            ->get();
        $UpdateOrderPatient = DB::table('patientorderitems')
            ->join('inventories', 'patientorderitems.itemcode', '=', 'inventories.itemcode')
            ->select('patientorderitems.patient_order_id', 'patientorderitems.itemcode', 'patientorderitems.itemName', 'patientorderitems.itemType', 'patientorderitems.consignor', 'patientorderitems.quantity', 'patientorderitems.sellPrice', 'patientorderitems.itemTotal', 'inventories.stock')
            ->where('patient_order_id', '=', $inpatient_id)
            ->get();
        return response()->json([
           'inpatient' => $UpdatePatient,
           'patientAddItem' => $UpdateOrderPatient
        ]);
    }

    // public function UpdatePatient(Request $request) {

    //     $info       = $request->input('info');
    //     $orders     = $request->input('order');
    //     $bills      = $request->input('bills');
    //     $patientID  = $request->input('patientID');
    //     $transdate  = Carbon::parse($request->input('date'))->format('Y-m-d');


    //     //update for inpatients info
    //     $updatePatientQuery = DB::table('inpatients')
    //         ->where('inpatient_id', '=', $patientID)
    //         ->update([
    //             'transdate'     => $transdate,
    //             'discount'      => $bills['discount'],
    //             'sumtotal'      => $bills['sumtotal'],
    //             'payment_total' => $bills['paymentTotal'],
    //             'orderTotal'    => $bills['totalPrice'],
    //             'fullname'      => $info['fullname'],
    //             'cash'          => $info['cash'],
    //             'coupon'        => $info['coupon'],
    //             'couponref'     => $info['couponref'],
    //             'phic'          => $info['phic'],
    //             'phicref'       => $info['phicref'],
    //             'others'        => $info['others'],
    //             'othersamount'  => $info['othersamount'],
    //             'othersref'     => $info['othersref'],
    //             'cash'          => $info['cash']
    //         ]);


    //     $patientorderid = $orders[0]['patient_order_id'];
    //     foreach ($orders as $order) {

    //         $UpdateOrder =  Patientorderitem::firstOrCreate([
    //             'patient_order_id' => $patientorderid,
    //             'itemcode' => $order['itemcode'],
    //             'itemName' => $order['itemName'],
    //             'itemType' => $order['itemType'],
    //             'consignor' => $order['consignor'],
    //             'quantity' => $order['quantity'],
    //             'sellPrice' => $order['sellPrice'],
    //             'itemTotal' => $order['itemTotal']
    //         ]);

    //     }

    //     foreach ($orders as $ord) {
    //         $updateInventory = DB::table('inventories')
    //             ->where('itemcode', '=', $ord['itemcode'])
    //             ->update(['stock' => $ord['stock'] ]);
    //     }
    //     return response()->json([
    //         'updatePatientQuery'    => $updatePatientQuery, 
    //         'UpdateOrder'           => $UpdateOrder
    //     ]); 
    // }
}
