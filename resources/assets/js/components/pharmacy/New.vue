<template>
    <div class="walkin-new">
        <form @submit.prevent="">
            <div class="form-group">
                <label>Name :</label>
                <div class="row" style="margin-bottom: 2rem;">
                    <div class="col">
                        <input type="text" class="form-control" v-model="walkin.fname" placeholder="First Name"/>
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" v-model="walkin.mname" placeholder="Midlle Initial"/>
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" v-model="walkin.lname" placeholder="Last Name"/>
                    </div>
                </div>
                <div class="row" style="margin-bottom: 2rem;">
                    <div class="col">
                        <label>Transaction Date : </label>
                        <datepicker :bootstrap-styling="true"
                                    v-model="transdate"
                                    :format="customFormatter"
                                    placeholder="MM-DD-YYYY"
                                    required
                        ></datepicker>
                    </div>
                </div>
                <div class="form-group">
                    <label>Item List :</label>
                    <div class="row">
                        <div class="col">
                            <select class="custom-select mr-sm-2" @change="onChange($event)" v-model="additem" v-bind:value="additem.itemcode">
                                <option v-for="walkinOrder in walkinOrders" >
                                    {{ walkinOrder.itemcode }} - {{walkinOrder.itemName}} ({{walkinOrder.itemType}}) - ({{ walkinOrder.stock }}) - {{ formatPrice(walkinOrder.sellPrice) }}
                                </option>
                            </select>
                        </div>
                        <div class="col">
                            <button class="btn btn-primary" @click="addItemClick">Add Item </button>
                        </div>
                    </div>
                </div>
                <h3>Order Table</h3>
                <table class="table">
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
                        <template v-if="!walkinAddItem.length">
                                <tr>
                                    <td colspan="12" class="text-center">No records found in the database</td>
                                </tr>
                        </template>
                        <template>
                            <tr v-for="(item , k) in walkinAddItem" :key="k">
                                <td>{{ item.itemcode }}</td>
                                <td>{{ item.itemName }}</td>
                                <td>{{ item.itemType }}</td>
                                <td>{{ item.consignor }}</td>
                                <td>{{ item.stock }}</td>
                                <td><span class="qty">{{ item.quantity ? item.quantity : '0' }}</span></td>
                                <td>{{ formatPrice(item.sellPrice) }}</td>
                                <td>{{ item.itemTotal ? item.itemTotal : '0.00' }}</td>
                                <td>
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
                    <h3>Discount </h3>
                    <div class="row">
                        <div class="col">
                            <select class="custom-select col-sm-3" v-model="walkin.discountselect" @change="onChangeDiscount($event)">
                                <option v-for="(discount,i) in discounts" :key="i" :name="discount.name" :value="discount.value">{{ discount.name }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <h3>Payment</h3>
                <div >
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
                            <td><input type="text" class="form-control col-sm-5" v-model="walkin.cash"></td>
                            <td><input type="text" class="form-control col-sm-7" v-model="walkin.cashref"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th>Coupon </th>
                            <td><input type="text" class="form-control col-sm-5" v-model="walkin.coupon"></td>
                            <td><input type="text" class="form-control col-sm-7" v-model="walkin.couponref"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th>(PHIC)PhilHealth </th>
                            <td><input type="text" class="form-control col-sm-5" v-model="walkin.phic"></td>
                            <td><input type="text" class="form-control col-sm-7" v-model="walkin.phicref"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th>Others </th>
                            <td><input type="text" class="form-control col-sm-5" v-model="walkin.othersamount"></td>
                            <td><input type="text" class="form-control col-sm-7" v-model="walkin.othersref"></td>
                            <td>
                                <div class="row">
                                    <div class="col">
                                        <select class="custom-select col-sm-10" v-model="walkin.others">
                                            <option v-for="other in others">{{ other }}</option>
                                        </select>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
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

                <div class="form-group">
                    <div class="row">
                        <div class="col">

                        </div>
                        <div class="col-2">
                            <router-link to="/pharmacy" class="btn">Cancel</router-link>
                            <input type="submit" @click="getFormData()" value="Submit" :disabled="grandTotal > 0 || grandTotal < 0" class="btn btn-primary">
                        </div>
                    </div>
                </div>
            <div class="errors" v-if="errors">
                <ul>
                    <li v-for="(fieldsError, fieldName) in errors" :key="fieldName">
                        <strong>{{ fieldName }}</strong> {{ fieldsError.join('\n') }}
                    </li>
                </ul>
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
        name: 'new',
        data() {
            return {
                transdate: null,
                walkin: {
                    fname: '',
                    mname: '',
                    lname: '',
                    cash: '0',
                    cashref: '',
                    coupon: 0,
                    couponref: '',
                    phic: 0,
                    phicref: '',
                    others: '',
                    othersref: '',
                    othersamount: 0,
                    discountselect: 0,
                    discountType: ''
                },
                payment_total: 0,
                errors: '',
                additem: {
                    itemcode: '',
                    itemName: '',
                    itemType: '',
                    itemStock: '',
                    quantity: 0,
                    sellPrice: '',
                },
                display_discount: 0,
                discounts: [
                    {
                        name: '',
                        value: ''
                    },
                    {
                        name:'PWD',
                        value: '0.20'
                    },
                    {
                        name:'SC',
                        value: '0.20'
                    }
                ],
                walkinAddItem: [],
                orderedItem: [],
                others: [
                    'PN(Promi Note)',
                    'Sample',
                    'Sample1'
                ],
                grandtotal: '',
                totalPrice: 0,
                discount: 0,
                sumtotal: 0,
                rowTotal: ''
            };
        },
        components: {
            Datepicker
        },
        mounted() {
            this.$store.dispatch('getwalkinOrder');
        },
        computed: {
            currentUser() {
                return this.$store.getters.currentUser;
            },
            walkinOrders() {
                return this.$store.getters.walkinOrder;
            },
            walkinOrderselecteds() {
                return this.$store.getters.additem;
            },
            //getting the total of all order item
            Ordertotal: function() {
                this.totalPrice =  this.walkinAddItem.reduce(function(sum, item){
                    return sum + item.sellPrice * item.quantity;
                },0);
                return parseFloat(this.totalPrice).toFixed(2);
            },
            //getting the payment total
            paymentTotal:function() {
                var cash = this.walkin.cash;
                var coupon = this.walkin.coupon;
                var phic = this.walkin.phic;
                var othersamount = this.walkin.othersamount;
                return this.payment_total = (parseFloat(cash) + parseFloat(coupon) + parseFloat(phic) + parseFloat(othersamount)).toFixed(2);
            },
            //getting the discounted total
            discounted: function() {
                return this.discount = (this.Ordertotal * this.display_discount).toFixed(2);
            },
            //total ng babayaran
            sumTotal: function() {
                return this.sumtotal = (this.Ordertotal - this.discount).toFixed(2);
            },
            //pagkuha ng pangkalahatang total
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
            //Date format
            customFormatter(transdate) {
                return this.transdate = moment(transdate).format('MM-DD-YYYY');
            },
            //pag query pag select ng item sa dropdow for order item
            onChange(event) {
               let itemcode = event.target.value.split('-')[0];
               axios.post('/api/pharmacy/addItem/'+itemcode)
                   .then((response) => {
                     this.orderedItem = response.data.item;
                   });
            },
            //para sa pag select ng discount
            onChangeDiscount(event) {
                this.display_discount = event.target.value;
                this.walkin.discountType = event.target.options[event.target.selectedIndex].attributes['name'].value;
            },
            //pag add ng item sa order table
            addItemClick() {
                this.walkinAddItem.push(this.orderedItem);
                 this.walkinAddItem.forEach((item) => {
                   this.rowTotal = item.sellPrice;
                });
            },
            //pag dagdag ng bilang ng order sa bawat row ng order table
            increment(index) {
              let item = this.walkinAddItem[index];
                  item.stock--;
                  item.quantity++;
                  item.itemTotal = (parseFloat(item.sellPrice) * item.quantity).toFixed(2);
            },
            //pag bawas ng bilang ng order sa bawat row ng order table
            decrement(index) {
                let item = this.walkinAddItem[index];
                    item.quantity--;
                    item.stock++;
                    item.itemTotal = (parseFloat(item.sellPrice) * item.quantity).toFixed(2);
            },
            //pag delete ng item order sa order table
            removeItem(index) {
                this.walkinAddItem.splice(index, 1);
            },
            getFormData() {
                // transform collected data into one single object
                var filterDate = moment(this.$data.transdate).format();
                const walkFormData = {
                    customer: this.$data.walkin,
                    orders: this.$data.walkinAddItem,
                    bills: {
                        discount: this.$data.discount,
                        sumtotal: this.$data.sumtotal,
                        paymentTotal: this.$data.payment_total,
                        totalPrice: this.$data.totalPrice
                    },
                    transdate: filterDate
                }
                // perform axios on saving the form
                axios.post('/api/pharmacy/new', walkFormData)
                    .then((response) => {
                        this.$router.push('/pharmacy');
                    });
                console.log(walkFormData);
            }
        }
    };
</script>

<style>
.errors {
    background: lightcoral;
    border-radius:5px;
    padding: 21px 0 2px 0;
}
</style>
