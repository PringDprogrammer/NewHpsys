<template>
    <div class="inventory-new">
        <form @submit.prevent="">
            <div class="form-group">    
                <div class="row">
                    <div class="col-sm-6">
                        <label class="">DR No.</label>
                        <div class="">
                            <input type="text" class="form-control" v-model="inventory.dr_no" placeholder="DR No.">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label class="">Consignment Order No.</label>
                        <div class="">
                            <input type="text" class="form-control" v-model="inventory.or_no" placeholder="Consignment Order No.">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-6">
                    <label>Delivery Date</label>
                        <datepicker :bootstrap-styling="true"
                                    v-model="del_date"
                                    format="MM-dd-yyyy"
                                    placeholder="MM-DD-YYYY"
                                    required
                        ></datepicker>
                    </div>
                    <div class="col-sm-6">
                    <label>Consignor</label>
                        <select class="form-control" v-model="inventory.consignor" @change="ItemGenerate" required>
                            <option v-for="consign in selectconsignors">
                                {{ consign.alias }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Item List</label>
                <div class="row">
                    <div class="col-sm-9">
                        <select class="form-control" v-model="inventory.item_med" @change="itemPick($event)" required>
                            <option v-for="select in invItems">
                                {{ select.itemcode }} - {{select.brandName}} {{select.itemName}} ({{select.itemType}})
                            </option>
                        </select>
                    </div>
                    <button class="btn btn-primary col-sm-2" @click="addItemClick">Add Item </button>
                </div>
            </div>

            <h3 id="order">Item Table</h3>
            <table class="table" id="table_order" style="text-align: center;">
                <thead>
                    <th>Item Code</th>
                    <th>Item Name</th>
                    <th>Item Type</th>
                    <th>Brand Name</th>
                    <th>Quantity</th>
                    <th>Unit Cost</th>
                    <!-- <th>Purchase Price</th> -->
                    <th>Sell Price</th>
                    <th>Unit</th>
                    <th>Total</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    <template v-if="!selectedItem.length">
                            <tr>
                                <td colspan="12" class="text-center">No records found in the database</td>
                            </tr>
                    </template>
                    <template v-if="selectedItem.length">
                        <tr v-for="(item, k) in selectedItem" :key="k">
                            <td>{{ item.itemcode }}</td>
                            <td>{{ item.itemName }}</td>
                            <td>{{ item.itemType }}</td>
                            <td>{{ item.brandName }}</td>
                            <td>
                                <div class="col-xs-2">
                                    <input type="text" class="form-control" 
                                    v-model="selectedItem[k].quantity"> 
                                </div>
                            </td>
                            <td>
                                <div class="col-xs-2">
                                    <input type="text" class="form-control" 
                                    v-model="selectedItem[k].unit_cost" @change = "itemTotal(k)">
                                </div>
                            </td>
                            <!-- <td>
                                <div class="col-xs-2">
                                    <input type="text" class="form-control" v-model="selectedItem[k].purchPrice">
                                </div>
                            </td> -->
                            <td>
                                <div class="col-xs-2">
                                    <input type="text" class="form-control" v-model="selectedItem[k].sellprice">
                                </div>
                            </td>
                            <td>
                                <div class="col-xs-2">
                                    <input type="text" class="form-control" v-model="selectedItem[k].unit" v-uppercase>
                                </div>
                            </td>
                            <td>
                                {{ formatPrice(selectedItem[k].item_total ? selectedItem[k].item_total: '0.00') }}
                            </td>
                            <td>
                                <button class="btn" type="button" name="button" @click="removeItem(k, item)">X</button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>

            <div align="center">
                <div clas="form-group">
                    <input type="submit" value="Create" class="btn btn-primary col-sm-3" @click="addDeliver">
                </div><br>
                <div class="form-group">
                    <router-link to="/inventory" class="btn btn-danger col-sm-3">Cancel</router-link>
                </div>
            </div>
        </form>
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
    export default {
        name: 'new',
        components: {
            Datepicker,
            moment
        },
        data() {
            return {
                del_date: '',
                inventory: {
                    consignor: '',
                    dr_no: '',
                    or_no: '',
                    item_med: ''
                },
                invItems: [],
                deliveryItem: [],
                selectedItem: [],
                errors: null,
            };
        },
        mounted() {
            this.$store.dispatch('pickConsignor');

        },
        computed: {
            currentUser() {
                return this.$store.getters.currentUser;
            },
            selectconsignors() {
                return this.$store.getters.consignor;
            },
        },
        methods: {
            //pag delete ng item sa order table
            removeItem(index) {
                this.selectedItem.splice(index, 1);
            },
            //pagkuha ng itemTotal per row
            itemTotal(index) {
                let item = this.selectedItem[index];
                this.selectedItem[index].item_total = item.quantity * item.unit_cost;
            },
            //format number to 2 decimal places
            formatPrice(value) {
                let val = (value/1).toFixed(2).replace(',', '.')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            },
            ItemGenerate() {
                var consign = {
                  consignor: this.inventory.consignor
                } 

                axios.post('/api/inventory/itemChange', consign)
                    .then((response) => {
                        this.invItems = response.data.invItem;
                    });
            },
            //pag kuha ng napiling item
            itemPick(event) {
                let itemcode = event.target.value.split('-')[0];

                axios.post('/api/inventory/itemPick/'+itemcode)
                   .then((response) => {
                     this.deliveryItem = response.data.item;

                   });
            },
            //pag add ng item sa item table
            addItemClick() {
                this.selectedItem.push(this.deliveryItem);
            },
            addDeliver() {
                var delDate = moment(this.del_date).format();
                var data = {
                    inv_data : this.inventory,
                    order_item: this.selectedItem,
                    del_date: delDate
                }
                console.log(data);
                axios.post('/api/inventory/addDelivery', data)
                    .then((response) => {
                        alert('New Delivery Saved!');
                        this.$router.push('/inventory');
                    });
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