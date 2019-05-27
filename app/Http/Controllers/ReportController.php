<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Walkin;
use App\Orderitem;
use App\InPatient;
use App\Patientorderitem;
use DB;
use Excel;
class ReportController extends Controller
{

    public function getDailyDate(Request $request)
    {
    	//getting the object in vue and set format same as data in DB
    	$select_patient = $request->input('select_patient');
    	$dailyDate  = Carbon::parse($request->input('dailyDate'))->format('Y-m-d');

    	if($select_patient == 'Walkin')
    	{
			$daily = DB::table('walkins')
			->join('orderitems', 'orderitems.order_id','=','walkins.walkin_id')
			->select('walkins.walkin_id', 'walkins.transdate', 'walkins.fullname', 'walkins.discountType', 'walkins.discount', 'walkins.orderTotal', 'walkins.sumtotal', 'walkins.cash', 'walkins.cashref', 'walkins.coupon', 'walkins.couponref', 'walkins.phic', 'walkins.phicref', 'walkins.others', 'walkins.othersamount', 'walkins.othersref', 'orderitems.itemcode', 'orderitems.itemName', 'orderitems.itemType', 'orderitems.consignor', 'orderitems.quantity', 'orderitems.sellPrice', 'orderitems.itemTotal')
			->where('walkins.transdate', '=', $dailyDate)
			->where('orderitems.itemType', '=', 'CS')
			->get();
			return response()->json([
		    	'walkinreports' => $daily
			]);
			
		}
		else
		{
			$daily = DB::table('inpatients')
			->join('patientorderitems', 'patientorderitems.patient_order_id','=','inpatients.inpatient_id')
			->select('inpatients.inpatient_id', 'inpatients.transdate', 'inpatients.fullname', 'inpatients.discountType', 'inpatients.discount', 'inpatients.orderTotal', 'inpatients.sumtotal', 'inpatients.cash', 'inpatients.cashref', 'inpatients.coupon', 'inpatients.couponref', 'inpatients.phic', 'inpatients.phicref', 'inpatients.others', 'inpatients.othersamount', 'inpatients.othersref', 'patientorderitems.itemcode', 'patientorderitems.itemName', 'patientorderitems.itemType', 'patientorderitems.consignor', 'patientorderitems.quantity', 'patientorderitems.sellPrice', 'patientorderitems.itemTotal')
			->where('inpatients.transdate', '=', $dailyDate)
			->where('patientorderitems.itemType', '=', 'CS')
			->get();
			return response()->json([
		    	'inpatientsReport' => $daily
			]);
			
		}

    }

    public function getMonthlyDate(Request $request)
    {
    	//getting the object in vue and set format same as data in DB
    	$select_patient = $request->input('select_patient');
    	$from  = Carbon::parse($request->input('fromDate'))->format('Y-m-d');
    	$to  = Carbon::parse($request->input('toDate'))->format('Y-m-d');
    	
    	if($select_patient == 'Walkin')
    	{
			$daily = DB::table('walkins')
			->join('orderitems', 'orderitems.order_id','=','walkins.walkin_id')
			->select('walkins.walkin_id', 'walkins.transdate', 'walkins.fullname', 'walkins.discountType', 'walkins.discount', 'walkins.orderTotal', 'walkins.sumtotal', 'walkins.cash', 'walkins.cashref', 'walkins.coupon', 'walkins.couponref', 'walkins.phic', 'walkins.phicref', 'walkins.others', 'walkins.othersamount', 'walkins.othersref', 'orderitems.itemcode', 'orderitems.itemName', 'orderitems.itemType', 'orderitems.consignor', 'orderitems.quantity', 'orderitems.sellPrice', 'orderitems.itemTotal')
			->where('walkins.transdate', '>=', $from)
			->where('walkins.transdate', '<=', $to)
			->where('orderitems.itemType', '=', 'CS')
			->get();
			return response()->json([
		    	'walkinreports' => $daily
			]);
			
		}
		else
		{
			$daily = DB::table('inpatients')
			->join('patientorderitems', 'patientorderitems.patient_order_id','=','inpatients.inpatient_id')
			->select('inpatients.inpatient_id', 'inpatients.transdate', 'inpatients.fullname', 'inpatients.discountType', 'inpatients.discount', 'inpatients.orderTotal', 'inpatients.sumtotal', 'inpatients.cash', 'inpatients.cashref', 'inpatients.coupon', 'inpatients.couponref', 'inpatients.phic', 'inpatients.phicref', 'inpatients.others', 'inpatients.othersamount', 'inpatients.othersref', 'patientorderitems.itemcode', 'patientorderitems.itemName', 'patientorderitems.itemType', 'patientorderitems.consignor', 'patientorderitems.quantity', 'patientorderitems.sellPrice', 'patientorderitems.itemTotal')
			->where('inpatients.transdate', '>=', $from)
			->where('inpatients.transdate', '<=', $to)
			->where('patientorderitems.itemType', '=', 'CS')
			->get();
			return response()->json([
		    	'inpatientsReport' => $daily
			]);
			
		}
    }

}
