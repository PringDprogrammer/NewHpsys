<template>
	<div class="form-group" id="mainDiv">
		<div class="form-group">
			<h2 class="text-center" id="order"><strong>Order Detail(s)</strong></h2>
		</div>
		<div class="form-group">
			<div class="row">
				<label class="col-sm-2 col-form-label">Patient's Name: </label>
				<div class="col">
					<input type="text" class="form-control" v-model="order.fullname" disabled>
				</div>
			</div><br>
			<div class="row">
				<label class="col-sm-2 col-form-label">Patient's ID: </label>
				<div class="col">
					<input type="text" class="form-control" v-model="order.inpatient_id" disabled>
				</div>
			</div><br>
			<div class="row">
				<label class="col-sm-2 col-form-label">Patient's Classification: </label>
				<div class="col">
					<input type="text" class="form-control" v-model="order.p_clasif" disabled>
				</div>
			</div><br>
			<div class="row">
				<label class="col-sm-2 col-form-label">Patient's Status: </label>
				<div class="col">
					<input type="text" class="form-control" v-model="order.status" disabled>
				</div>
			</div><br>
		</div>
		<div class="scrollable overflow-auto" id="divTable">
			<h3 align="center"><strong>Order Table</strong></h3>
			<table class="table table-striped" id="orderTable"> 
				<thead>
					<th>OR No.</th>
					<th>PatientID</th>
					<th>Transaction Date</th>
					<th>Itemcode</th>
					<th>Item Description</th>
					<th>Consignor</th>
					<th>Stock</th>
					<th>Qty</th>
					<th>Item Price</th>
					<th>Item Total</th>
					<th>Action</th>
				</thead>
				<tbody>
					<template>
						<tr v-for="(patientOrder, k) in patientOrderItem" :key="k">
						<td>{{patientOrder.reference_no}}</td>
						<td>{{patientOrder.patient_order_id}}</td>
						<td>{{patientOrder.transdate}}</td>
						<td>{{patientOrder.itemcode}}</td>
						<td>{{patientOrder.itemName}}({{patientOrder.itemType}})</td>
						<td>{{patientOrder.consignor}}</td>
						<td>{{patientOrder.stock}}</td>
						<td>{{patientOrder.quantity}}</td>
						<td>{{formatPrice(patientOrder.sellPrice)}}</td>
						<td>{{formatPrice(patientOrder.itemTotal)}}</td>
						<td id="disable" width="500px">
	                        <button class="btn" type="button" :disabled="patientOrder.stock <= 0" @click="increment(k)">+</button>
	                        <button class="btn" type="button" :disabled="patientOrder.quantity <= 0" @click="decrement(k)">-</button>
	                        <button class="btn" type="button" name="button" @click="removeItem(k, patientOrder)"><i class="fa fa-trash"></i>X</button>
	                    </td></tr>
					</template>
				</tbody>
			</table>
		</div>
		<div class="form-group row " id="disc">
			<label class="col-sm-2 col-form-label">Discount Type: </label>
			<div class="col-sm-3">
				<input type="text" class="form-control" v-model="order.discount" disabled>
			</div>
		</div>
		<div class="form-group row " id="afterbreak">
			<label class="col-sm-2 col-form-label">Discount Ref. No.: </label>
			<div class="col-sm-3">
				<input type="text" class="form-control" v-model="order.disc_ref" disabled>
			</div>
		</div><br>
		<div align="center">
			<h3><strong>Payment Methods</strong></h3>
		</div>
		<div>
	        <table class="table">
	            <thead>
	                <th>Payment Type</th>
	                <th>Amount</th>
	                <th>Reference No.</th>
	                <th>Description</th>
	            </thead>
	            <tbody>
	                <tr>
	                    <th>Cash </th>
	                    <td><input type="text" class="form-control col-sm-5" v-model="payment.cash_amount"></td>
	                    <td><input type="text" class="form-control col-sm-7" v-model="payment.cash_ref"></td>
	                    <td></td>
	                </tr>
	                <tr>
	                    <th>Coupon </th>
	                    <td><input type="text" class="form-control col-sm-5" v-model="payment.coupon_amount"></td>
	                    <td><input type="text" class="form-control col-sm-7" v-model="payment.coupon_ref"></td>
	                    <td></td>
	                </tr>
	                <tr>
	                    <th>(PHIC)PhilHealth </th>
	                    <td><input type="text" class="form-control col-sm-5" v-model="payment.phic_amount"></td>
	                    <td><input type="text" class="form-control col-sm-7" v-model="payment.phic_ref"></td>
	                    <td></td>
	                </tr>
	                <tr>
	                    <th>Others </th>
	                    <td><input type="text" class="form-control col-sm-5" v-model="payment.others_amount"></td>
	                    <td><input type="text" class="form-control col-sm-7" v-model="payment.others_ref"></td>
	                    <td>
	                        <div class="row">
	                            <div class="col">
	                                <input type="text" class="form-control col-sm-9" v-model="payment.others_desc">
	                            </div>
	                        </div>
	                    </td>
	                </tr>
	            </tbody>
	        </table>
	        </div>
		<div class="form-group">
            <h3><strong>Total</strong></h3>
            <table>
                <tr>
                    <th><h4>Order Total: </h4></th>
                    <td>&nbsp;</td>
                    <td><h4>₱ {{ Ordertotal }}</h4></td>
                </tr>
                <tr>
                    <th><h4>Discount: </h4></th>
                    <td>&nbsp;</td>
                    <td><h4>₱ {{ discountTotal }}</h4></td>
                </tr>
                <tr>
                    <th><h4>Sum Total:</h4></th>
                    <td>&nbsp;</td>
                    <td><h4>₱ {{ sumTotal }}</h4></td>
                </tr>
                <tr>
                    <th><h4>Payment Total:</h4></th>
                    <td>&nbsp;</td>
                    <td><h4>₱ {{ paymentTotal }}</h4></td>
                </tr>
                <tr>
                    <th><h4><strong>Total:</strong></h4></th>
                    <td>&nbsp;</td>
                    <td><h4><strong>₱ {{ grandTotal }}</strong></h4></td>
                </tr>
            </table>
        </div>
        <div align="center">
        	<div clas="form-group">
					<input type="button" id="printBtn" class="btn btn-secondary col-sm-3" @click.prevent="print()" value="Print">
			</div><br>
	    	<input type="submit" id="submitBtn" @click="updateOrder" value="Submit" class="btn btn-primary col-sm-3">
	    </div>
	    <div class="errors" v-if="errors">
            <ul>
                <li v-for="(fieldsError, fieldName) in errors" :key="fieldName">
                    <strong>{{ fieldName }}</strong> {{ fieldsError.join('\n') }}
                </li>
            </ul>
        </div>
	</div>
</template>

<script>
	import validate from 'validate.js';
    import Datepicker from 'vuejs-datepicker';
    import moment from "moment";
    import Toaster from "v-toaster";

    export default {
    	components: {
    		Datepicker,
    		moment
    	},
    	created() {
           	var pat_id = this.$route.params.inpatient_id;
            
            axios.get('/api/inPatient/getOrder', {params: {pat_id: pat_id}})
                .then((response) => {
                    this.order = response.data.order[0];
                    this.order.p_clasif = response.data.order[0].pat_categ;
                    this.order.status = response.data.order[0].pat_type;
                    this.order.discount = response.data.patientOrderItem[0].disc_type;
					this.order.disc_ref = response.data.patientOrderItem[0].disc_ref;
  					this.patientOrderItem = response.data.patientOrderItem;
                });

        },
    	data() {
    		return {
	    		order: {
	    			fullname: '',
	    			inpatient_id: '',
	    			p_clasif: '',
	    			status: '',
	    			discount: '',
	    			disc_ref: ''
	    		},
	    		payment: {
	    			cash_amount: 0,
	    			cash_ref: '',
	    			coupon_amount: 0,
	    			coupon_ref: '',
	    			phic_amount: 0,
	    			phic_ref: '',
	    			others_amount: 0,
	    			others_ref: '',
	    			others_desc: ''
	    		},
	    		errors: null,
	    		patientOrderItem: [],
	    		discounts: [
	    			{
	    				name: '',
	    				value: ''
	    			},
	    			{
	    				name: 'PWD',
	    				value: '0.20'
	    			},
	    			{
	    				name: 'SC',
	    				value: '0.20'
	    			}
	    		],
	    		totalPrice: 0,
	    		disc_total: 0,
	    		sumtotal: 0,
	    		payment_total: 0,
	    		grandtotal: 0

    		}
    	},
    	computed: {
    		//getting the total of item orders
    		Ordertotal: function() {
                this.totalPrice =  this.patientOrderItem.reduce(function(sum, itemOrder){
                    return sum + itemOrder.sellPrice * itemOrder.quantity;
                },0);
                return parseFloat(this.totalPrice).toFixed(2);
            },
            //getting discount total of all transaction
            discountTotal: function() {
            	var disc = this.order.discount;
            	if(disc === 'PWD' || disc === 'SC') {
            		disc = 0.20;
            	} else {
            		disc = 0;
            	}
            	return this.disc_total = parseFloat(this.Ordertotal * disc).toFixed(2);
            },
            //getting the deducted total of order
            sumTotal: function() {
                return this.sumtotal = (this.Ordertotal - this.disc_total).toFixed(2);
            },
            //getting the payment total
            paymentTotal:function() {
                var cash = this.payment.cash_amount;
                var coupon = this.payment.coupon_amount;
                var phic = this.payment.phic_amount;
                var othersamount = this.payment.others_amount;
                return this.payment_total = (parseFloat(cash) + parseFloat(coupon) + parseFloat(phic) + parseFloat(othersamount)).toFixed(2);
            },
            //getting all total
            grandTotal: function() {
                return this.grandtotal = (this.sumTotal - this.paymentTotal).toFixed(2);
            }
    	},
    	methods: {
    		//format number to 2 decimal places
            formatPrice(value) {
                let val = (value/1).toFixed(2).replace('.', ',')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            },
            //pag dagdag ng bilang ng order sa bawat row ng order table
            increment(index) {
              let patientOrder = this.patientOrderItem[index];
                  patientOrder.stock--;
                  patientOrder.quantity++;
                  patientOrder.itemTotal = (parseFloat(patientOrder.sellPrice) * patientOrder.quantity).toFixed(2);
            },
            //pag bawas ng bilang ng order sa bawat row ng order table
            decrement(index) {
                let patientOrder = this.patientOrderItem[index];
                    patientOrder.quantity--;
                    patientOrder.stock++;
                    patientOrder.itemTotal = (parseFloat(patientOrder.sellPrice) * patientOrder.quantity).toFixed(2);
            },
            //pag delete ng item order sa order table
            removeItem(index) {
            	var ref_no = this.patientOrderItem[index].reference_no;
            	var item_code = this.patientOrderItem[index].itemcode;
            	var item = this.patientOrderItem[index];
                axios.delete('/api/inPatient/deleteOrderItem', {params: {ref_no, item_code, item}})
                	.then((response) => {
                		this.patientOrderItem.splice(index, 1);
                		console.log('Item Deleted');
                		//this.$toaster.success('Item Deleted', {timeout: 5000});
                	}, 2000)
                	.catch((error) => {
                		alert(error);
                	})
            },
            updateOrder() {
            	var data = {
            		payment_info: this.payment,
            		orderItem: this.patientOrderItem,
            		totals : {
			    		disc_total: this.disc_total,
			    		total_sum: this.sumtotal,
			    		total_payment: this.payment_total,
			    		total_grand: this.grandtotal
            		},
            		orderDetails: this.order
            	}
            	axios.post('/api/inPatient/updateOrder', data)
            		.then((response) => {
            			// location.load();
            		}, 3000)
            		.catch((error) => {
            			alert(error);
            		})
            },
            print: function() {
            	$('#submitBtn').hide()
            	$('#printBtn').hide()
            	$('table th:eq(10)').hide();
            	$('table tr').find('td:eq(10)').hide();
            	window.print();
            	window.close();
            	$('#submitBtn').show()
            	$('#printBtn').show()
            	$('table th:eq(10)').show();
            	$('table tr').find('td:eq(10)').show();
            }

    	}

        
    };
</script>

<style type="text/css">
	.scrollable {
		height: 400px;
		margin-bottom: 20px;
		text-align: center;
	}
	.scrollable th { position: sticky; top: 0; }
	.scrollable th { background: #006400; color: white; }
	.scrollable th { text-align: center; }
	@media print {
		.scrollable {
			height: 100%;
		}
		@page { 
			size: auto;
			margin: 0mm; 
		}
		@page {
			margin-top: 20px;
		}
	    input[type=text] {
	        display: inline-block;
	        border:none;
	        border-bottom: 1px solid #000000;
    	}
		#info {
			display: none;
		}
		#mainDiv {
			display: inline ;
		}
		#disc {
			margin-top: 50px;
		}
		#afterbreak {
			page-break-after: always;
		}
		.scrollable table { page-break-after:auto }
		.scrollable tr { page-break-inside:avoid; page-break-after:auto }
		.scrollable td { page-break-inside:avoid; page-break-after:auto }
		.scrollable th { color: #000000}
		#orderTable {
			height: auto;
		}

	}
</style>