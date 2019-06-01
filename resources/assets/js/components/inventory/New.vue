
<template>
    <div class="inventory-new">
        <form @submit.prevent="add">
            <table class="table">
                <tr>
                    <th>DR No.</th>
                    <td>
                        <input type="text" class="form-control" v-model="inventory.dr_no" placeholder="DR No."/>
                    </td>
                </tr>
                <tr>
                    <th>Order No.</th>
                    <td>
                        <input type="text" class="form-control" v-model="inventory.or_no" placeholder="Order No."/>
                    </td>
                </tr>
                <tr>
                    <th>Delivery Date</th>
                    <td>
                        <div>
                            <datepicker :bootstrap-styling="true"
                                        v-model="del_date"
                                        format="MM-dd-yyyy"
                                        placeholder="MM-DD-YYYY"
                                        required
                            ></datepicker>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>Item Code</th>
                    <td>
                        <input type="text" class="form-control" v-model="inventory.itemcode" placeholder="Item Code" required />
                    </td>
                </tr>
                <tr>
                    <th>Item Name</th>
                    <td>
                        <input type="text" class="form-control" v-model="inventory.itemName" placeholder="Item Name" required/>
                    </td>
                </tr>
                <tr>
                    <th>Brand Name</th>
                    <td>
                        <input type="text" class="form-control" v-model="inventory.brand" placeholder="Brand Name" />
                    </td>
                </tr>
                <tr>
                    <th>Item type</th>
                    <td>
                        <select class="form-control" v-model="inventory.itemType" >
							<option v-for="item in itemtypes">
								{{ item }}
							</option>
						</select>
                    </td>
                </tr>
                <tr>
                    <th>Consignor</th>
                    <td>
                        <select class="form-control" v-model="inventory.consignor" required>
							<option v-for="consign in selectconsignors">
								{{ consign.alias }}
							</option>
						</select>
                    </td>
                </tr>
                <tr>
                    <th>Purchase Price</th>
                    <td>
                        <input type="text" class="form-control" v-model="inventory.purchasePrice" placeholder="Purchase Price" required/>
                    </td>
                </tr>
                <tr>
                    <th>Selling Price</th>
                    <td>
                        <input type="text" class="form-control" v-model="inventory.sellPrice" placeholder="Selling Price" required/>
                    </td>
                </tr>
                <tr>
                    <th>Quantity</th>
                    <td>
                        <input type="text" class="form-control" v-model="inventory.stock" placeholder="Quantity" required/>
                    </td>
                    <td><input type="hidden" class="form-control" v-model="inventory.quantity" value="0"></td>
                </tr>
                <tr>
                    <td>
                        <router-link to="/inventory" class="btn btn-danger">Cancel</router-link>
                    </td>
                    <td class="text-right">
                        <input type="submit" value="Create" class="btn btn-primary">
                    </td>
                </tr>
            </table>
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
                    itemcode: '',
                    itemName: '',
                    brand: '',
                    itemType: '',
                    consignor: '',
                    purchasePrice: '',
                    sellPrice: '',
                    stock: '',
                    quantity: '0',
                    dr_no: '',
                    or_no: ''
                },
                errors: null,
                itemtypes: ['CS', 'GF']
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
            }
        },
        methods: {
            add() {
                var delDate = moment(this.del_date).format();
                var data = {
                    inv_data : this.inventory,
                    del_date: delDate
                }
                console.log(data);
                axios.post('/api/inventory/new', data)
                    .then((response) => {
                        this.$router.push('/inventory');
                    });
            }
        }
    }
</script>

<style>
.errors {
    background: lightcoral;
    border-radius:5px;
    padding: 21px 0 2px 0;
}
</style>
