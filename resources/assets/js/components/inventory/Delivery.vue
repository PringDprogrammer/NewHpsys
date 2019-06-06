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
                        <select class="form-control" v-model="inventory.item" @change="itemPick($event)" required>
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
                    <th>Purchase Price</th>
                    <th>Sell Price</th>
                    <th>Unit</th>
                    <th>Unit Cost</th>
                    <th>Total</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    <template v-if="!selectedItem.length">
                            <tr>
                                <td colspan="12" class="text-center">No records found in the database</td>
                            </tr>
                    </template>
                    <template>
                        <tr v-for="(item , k) in selectedItem" :key="k">
                            <td>{{ item.itemcode }}</td>
                            <td>{{ item.itemName }}</td>
                            <td>{{ item.itemType }}</td>
                            <td>{{ item.brandName }}</td>
                            <td>
                                <div class="col-xs-2">
                                    <input type="text" class="form-control" v-model="itemDel.quantity">
                                    <input type="hidden" class="form-control" value="0" v-model="itemDel.quantity2">
                                </div>
                            </td>
                            <td>
                                <div class="col-xs-2">
                                    <input type="text" class="form-control" v-model="itemDel.purchPrice">
                                </div>
                            </td>
                            <td>
                                <div class="col-xs-2">
                                    <input type="text" class="form-control" v-model="itemDel.sellPrice">
                                </div>
                            </td>
                            <td>
                                <div class="col-xs-2">
                                    <input type="text" class="form-control" v-model="itemDel.unit">
                                </div>
                            </td>
                            <td>
                                <div class="col-xs-2">
                                    <input type="text" class="form-control" v-model="itemDel.cost">
                                </div>
                            </td>
                            <td>
                                {{ formatPrice(itemTotal) }}
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
                    item: ''
                },
                itemDel: {
                    quantity: '',
                    quantity1: '',
                    unit: '',
                    cost: '',
                    sellPrice: '',
                    purchPrice: '',
                },
                rowTotal: '',
                invItems: [],
                deliveryItem: [],
                selectedItem: [],
                item_total: [],
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
            itemTotal() {
                var qty = this.itemDel.quantity;
                var cost = this.itemDel.cost;
                return this.item_total = qty * cost ;
            }
        },
        methods: {
            //pag delete ng item order sa order table
            removeItem(index) {
                this.selectedItem.splice(index, 1);
            },
            //format number to 2 decimal places
            formatPrice(value) {
                let val = (value/1).toFixed(2).replace('.', ',')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
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
            //pag generate ng napiling item
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
                 this.selectedItem.forEach((itemDel) => {
                   this.rowTotal = itemDel.quantity;
                });
            },
            addDeliver() {
                var delDate = moment(this.del_date).format();
                var data = {
                    inv_data : this.inventory,
                    itemDel: this.itemDel,
                    others: {
                        item_total: this.item_total
                    },
                    del_date: delDate
                }
                console.log(data);
                // axios.post('/api/inventory/new', data)
                //     .then((response) => {
                //         this.$router.push('/inventory');
                //     });
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