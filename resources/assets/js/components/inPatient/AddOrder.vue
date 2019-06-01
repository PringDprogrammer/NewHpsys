<template>
	<div class="form-group" id="printForm">
		<div class="form-group">
			<h3 class="text-center" id="title" ><strong>Add Order Items</strong></h3>
			<div class="row">
				<label class="col-sm-2 col-form-label">Patient's Name:</label>
				<div class="col-md-3">
					<input type="text" class="form-control" v-model="fullname">
				</div>
			</div>
			<div class="row ">
				<label class="col-sm-2 col-form-label">Patient ID:</label>
				<div class="col-md-3 ">
					<input type="text" class="form-control" v-model="inpatient_id">
				</div>
			</div>
		</div>
		<form @submit.prevent="">
			<div class="row">
				<label class="col-sm-2 col-form-label">Transaction Date</label>
				<div class="col-md-3">
					<datepicker :bootstrap-styling="true"
		                        v-model="transdate"
		                        :format="customFormatter"
		                        placeholder="MM-DD-YYYY"
		                        required
		            ></datepicker>
				</div>
			</div>
			<div class="form-group" id="item_details">
	            <label>Item List :</label>
	            <div class="row">
	                <div class="col">
	                    <select class="custom-select mr-sm-2" @change="onChange($event)" v-model="additem" v-bind:value="additem.itemcode" required>
	                        <option v-for="patientOrder in patientOrders" >
	                            {{ patientOrder.itemcode }} - {{patientOrder.itemName}} ({{patientOrder.itemType}}) - ({{ patientOrder.stock }}) - {{ formatPrice(patientOrder.sellPrice) }}
	                        </option>
	                    </select>
	                </div>
	                <div class="col">
	                    <button class="btn btn-primary" @click="addItemClick">Add Item </button>
	                </div>
	            </div>
	        </div>

	        <h3 id="order">Order Table</h3>
	        <table class="table" id="table_order">
	            <thead>
	                <th>Item Code</th>
	                <th>Item Name</th>
	                <th>Item Type</th>
	                <th>Consignor</th>
	                <th>Stock</th>
	                <th>Quantity</th>
	                <th>Price</th>
	                <th>Total</th>
	                <th>Action</th>
	            </thead>
	            <tbody>
	                <template v-if="!patientAddItem.length">
	                        <tr>
	                            <td colspan="12" class="text-center">No records found in the database</td>
	                        </tr>
	                </template>
	                <template>
	                    <tr v-for="(item , k) in patientAddItem" :key="k">
	                        <td>{{ item.itemcode }}</td>
	                        <td>{{ item.itemName }}</td>
	                        <td>{{ item.itemType }}</td>
	                        <td>{{ item.consignor }}</td>
	                        <td>{{ item.stock }}</td>
	                        <td><span class="qty">{{ item.quantity ? item.quantity : '0' }}</span></td>
	                        <td>{{ formatPrice(item.sellPrice) }}</td>
	                        <td>{{ item.itemTotal ? item.itemTotal : '0.00' }}</td>
	                        <td id="disable">
	                            <button class="btn" type="button" :disabled="item.stock <= 0" @click="increment(k)">+</button>
	                            <button class="btn" type="button" :disabled="item.quantity <= 0" @click="decrement(k)">-</button>
	                            <button class="btn" type="button" name="button" @click="removeItem(k, item)">X</button>
	                        </td>
	                    </tr>
	                </template>
	            </tbody>
	        </table>
			<div class="form-group">
	            <div class="row">
	                <div class="col">
	                    <h4>Order Total : ₱ <span>{{ Ordertotal }}</span></h4>
	                </div>
	            </div>
	        </div>
	        <div class="form-group">
		        <div class="row">
		        	<label class="col-sm-2 col-form-label"><h3>Discount: </h3></label>
		            <div class="col">
		                <select class="custom-select col-sm-3" v-model="addorder.discountselect" @change="onChangeDiscount($event)">
		                    <option v-for="(discount,i) in discounts" :key="i" :name="discount.name" :value="discount.value">{{ discount.name }}</option>
		                </select>
		            </div>
		        </div>
		        <div class="row">
		        	<label class="col-sm-2 col-form-label"><h3>Discount Ref No. : </h3></label>
		            <div class="col">
		                <input type="text" class="form-control col-sm-3" v-model="addorder.disc_ref">
		            </div>
		        </div>
	        </div>
			
			<div class="form-group">
	            <h2>Total</h2>
	            <table>
	                <tr>
	                    <th><h4>Order Total: </h4></th>
	                    <td>&nbsp;</td>
	                    <td><h4>₱ {{ Ordertotal }}</h4></td>
	                </tr>
	                <tr>
	                    <th><h4>Discount: </h4></th>
	                    <td>&nbsp;</td>
	                    <td><h4>₱ {{ discounted }}</h4></td>
	                </tr>
	                <tr>
	                    <th><h4>Sum Total:</h4></th>
	                    <td>&nbsp;</td>
	                    <td><h4>₱ {{ sumTotal }}</h4></td>
	                </tr>
	                
	            </table>
	        </div>
			<div align="center">
				<div clas="form-group">
					<input type="button" id="printBtn" class="btn btn-secondary col-sm-3" @click.prevent="print()" value="Print">
				</div><br>
				<div class="form-group">
					<input type="submit" @click="add()" id="addBtn" class="btn btn-success col-sm-3" value="Add">
				</div>
			</div>
		</form>
	</div>
</template>


<script>
    import validate from 'validate.js';
    import Datepicker from 'vuejs-datepicker';
    import moment from "moment";

	export default {
		components: {
			Datepicker,
			moment
		},
		created() {
			var pat_id = this.$route.params.inpatient_id;
            
			axios.get('/api/inPatient/getOrderName', {params: {pat_id: pat_id}})
				.then((response) => {
					this.fullname = response.data.addorder[0].fullname;
					this.inpatient_id = response.data.addorder[0].inpatient_id;
				});
		},
		data() {
			return {
				fullname: '',
				inpatient_id: '',
				transdate: '',
				addorder: {
					discountselect: '',
					discountType: '',
					disc_ref: ''
				},
				additem: {
                    itemcode: '',
                    itemName: '',
                    itemType: '',
                    itemStock: '',
                    quantity: 0,
                    sellPrice: '',
				},
				patientAddItem: [],
				orderedItem: [],
				rowTotal: '',
				display_discount: 0,
				discount: 0,
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
	    		sumtotal: 0,
	    		totalPrice: 0
			}
		},
		mounted() {
			this.$store.dispatch('getpatientOrder');
		},
		computed: {
            patientOrders() {
                return this.$store.getters.patientOrder;
            },
			//getting the total of all order item
			Ordertotal: function() {
                this.totalPrice =  this.patientAddItem.reduce(function(sum, item){
                    return sum + item.sellPrice * item.quantity;
                },0);
                return parseFloat(this.totalPrice).toFixed(2);
            },
            //getting the discounted total
            discounted: function() {
                return this.discount = (this.Ordertotal * this.display_discount).toFixed(2);
            },
            //total ng babayaran
            sumTotal: function() {
                return this.sumtotal = (this.Ordertotal - this.discount).toFixed(2);
            },
		},
		methods: {
			//Date format
            customFormatter(transdate) {
                return this.transdate = moment(transdate).format('MM-DD-YYYY');
            },
            //pag query pag select ng item sa dropdow for order item
            onChange(event) {

               let itemcode = event.target.value.split('-')[0];

               axios.post('/api/inPatient/addItem/'+itemcode)
                   .then((response) => {
                     this.orderedItem = response.data.item;
                   });
            },
            //pag add ng item sa order table
            addItemClick() {
                this.patientAddItem.push(this.orderedItem);
                 this.patientAddItem.forEach((item) => {
                   this.rowTotal = item.sellPrice;
                });
            },
            //pag dagdag ng bilang ng order sa bawat row ng order table
            increment(index) {
              let item = this.patientAddItem[index];
                  item.stock--;
                  item.quantity++;
                  item.itemTotal = (parseFloat(item.sellPrice) * item.quantity).toFixed(2);
            },
            //pag bawas ng bilang ng order sa bawat row ng order table
            decrement(index) {
                let item = this.patientAddItem[index];
                    item.quantity--;
                    item.stock++;
                    item.itemTotal = (parseFloat(item.sellPrice) * item.quantity).toFixed(2);
            },
            //pag delete ng item order sa order table
            removeItem(index) {
                this.patientAddItem.splice(index, 1);
            },
            //format number to 2 decimal places
            formatPrice(value) {
                let val = (value/1).toFixed(2).replace('.', ',')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            },
            //para sa pag select ng discount
            onChangeDiscount(event) {
                this.display_discount = event.target.value;
                this.addorder.discountType = event.target.options[event.target.selectedIndex].attributes['name'].value;
            },
            add() {
            	var transdate = moment(this.transdate).format();
            	var data = {
            		patient_id: this.inpatient_id,
            		pat_info: this.$data.addorder,
            		item: this.$data.patientAddItem,
            		date: transdate,
            		calcu: {
            			totalPrice: this.$data.totalPrice,
            			discount: this.$data.discount,
            			sumtotal: this.$data.sumtotal
            		}
            	}
            	console.log(data);
            	axios.post('/api/inPatient/addOrder', data)
            		.then((response) => {
            			alert('Order save successfully');
            			//this.$router.push(``);
            		})
            		.catch((error) => {
            			alert('Error data not save!');
            		})
            },
            print: function() {
            	$('#addBtn').hide()
            	$('#printBtn').hide()
            	$('#item_details').hide()
            	$('#info').hide()
            	$('table th:eq(8)').hide();
            	$('table tr').find('td:eq(8)').hide();
            	//$('table tr td:eq(8)').hide();
            	window.print();
            	window.close();
            	$('#addBtn').show()
            	$('#printBtn').show()
            	$('#item_details').show()
            	$('#info').show()
            	$('table th:eq(8)').show();
            	$('table tr').find('td:eq(8)').show();
            }
		}
	};
</script>

<style type="text/css">
	@media print {
		@page { 
			size: auto;  
			margin: 1mm;
		}
		#title {
			size: auto;  
			margin: 1mm;
		}
		#order {
			margin-top: 20px;
		}
	}

</style>