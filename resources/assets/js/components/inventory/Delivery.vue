<template>
    <div class="inventory-new">
        <form @submit.prevent="add">
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
                        <select class="form-control" v-model="inventory.consignor" required>
                            <option v-for="consign in selectconsignors">
                                {{ consign.alias }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Item List</label>
                <select class="form-control" v-model="inventory.item" required>
                    <option v-for="item in items">
                        {{ consign.alias }}
                    </option>
                </select>
            </div>
            <div align="center">
                <div clas="form-group">
                    <input type="submit" value="Create" class="btn btn-primary col-sm-3">
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
    };
</script>

<style>
.errors {
    background: lightcoral;
    border-radius:5px;
    padding: 21px 0 2px 0;
}
</style>