<template>
    <div class="inventory-view" v-if="inventory">
        <!-- <div class="user-img">
            <img src="https://www.scottsdaleazestateplanning.com/wp-content/uploads/2018/01/user.png" alt="">
        </div> -->
        <div class="user-info">
            <table class="table">
                <tr>
                    <th>Item Code</th>
                    <td>
                        <input type="text" class="form-control" v-model="inventory.itemcode"/>
                    </td>
                </tr>
                <tr>
                    <th>Item Name</th>
                    <td>
                        <input type="text" class="form-control" v-model="inventory.itemName"/>
                    </td>
                </tr>
                <tr>
                    <th>Item type</th>
                    <td>
                        <select class="form-control" v-model="inventory.itemType">
                            <option v-for="consign in consignee">
                                {{ consign }}
                            </option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>Consignor</th>
                    <td>
                        <select class="form-control" v-model="inventory.consignor">
                            <option v-for="consignor in selectconsignors">
                                {{ consignor.alias }}
                            </option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>Stock</th>
                    <td>
                        <input type="text" class="form-control" v-model="inventory.stock"/>
                    </td>
                </tr>
                <tr>
                    <th>Purchase Price</th>
                    <td>
                        <input type="text" class="form-control" v-model="inventory.purchasePrice" />
                    </td>
                </tr>
                <tr>
                    <th>Selling Price</th>
                    <td>
                        <input type="text" class="form-control" v-model="inventory.sellPrice"/>
                    </td>
                </tr>
            </table>
            <div class="row">
                <div class="col-1">
                    <button class="btn btn-primary" @click="itemUpdate()">Update</button>
                </div>
                <div class="col-10">
                    <button class="btn btn-danger" @click="itemDelete(inventory)">Delete</button>
                </div>
            </div>
            <router-link to="/inventory">Back to all customers</router-link>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'viewing',
        created() {
            if (this.inventories.length) {
                this.inventory = this.inventories.find((inventory) => inventory.itemcode == this.$route.params.itemcode);
            } else {
                axios.get(`/api/inventory/${this.$route.params.itemcode}`)
                    .then((response) => {
                        this.inventory = response.data.inventory
                    });
            }
        },
        data() {
            return {
                inventory: {
                    itemcode: '',
                    itemName: '',
                    itemType: '',
                    consignor: '',
                    stock: '',
                    sellPrice: '',
                    purchasePrice: ''
                },
                consignee: ['CS', 'GF']
            };
        },
        mounted() {
            this.$store.dispatch('getItems'); 
            this.$store.dispatch('pickConsignor'); 
        },
        computed: {
            currentUser() {
                return this.$store.getters.currentUser;
            },
            inventories() {
                return this.$store.getters.inventory;
            },
            selectconsignors() {
                return this.$store.getters.consignor;
            }
        },
        methods: {
            formatPrice(value) {
                let val = (value/1).toFixed(2).replace('.', ',')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            },
            itemUpdate() {
                let itemcodes = this.$route.params.itemcode
                axios.post(`/api/inventory/update/`+itemcodes, this.inventory)
                    .then((response)=>{
                        this.$router.push('/inventory');
                    });
            },
            itemDelete(itemcode) {
                let itemcodes = this.$route.params.itemcode;
                axios.delete('/api/inventory/delete/'+itemcodes, this.inventory)
                    .then(response => {
                        this.$router.push('/inventory');
                    });
            } 
        }
    }
</script>

<style scoped>
.inventory-view {
    display: flex;
    align-items: center;
}
.user-img {
    flex: 1;
}
.user-img img {
    max-width: 160px;
}
.user-info {
    flex: 3;
    overflow-x: scroll;
}
</style>
