<template>
    <div class="inventory-view" v-if="inventory">
        <!-- <div class="user-img">
            <img src="https://www.scottsdaleazestateplanning.com/wp-content/uploads/2018/01/user.png" alt="">
        </div> -->
        <div class="user-info">
            <table class="table">
                <tr>
                    <th>Item Code</th>
                    <td>{{ inventory.itemcode }}</td>
                </tr>
                <tr>
                    <th>Item Name</th>
                    <td>{{ inventory.itemName }}</td>
                </tr>
                <tr>
                    <th>Item Type</th>
                    <td>{{ inventory.itemType }}</td>
                </tr>
                <tr>
                    <th>Consignor</th>
                    <td>{{ inventory.consignor }}</td>
                </tr>
                <tr>
                    <th>Quantity</th>
                    <td>{{ inventory.quantity }}</td>
                </tr>
                <tr>
                    <th>Purchase Price</th>
                    <td>{{ inventory.purchasePrice }}</td>
                </tr>
                <tr>
                    <th>Selling Price</th>
                    <td>{{ inventory.sellPrice }}</td>
                </tr>
            </table>
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
                inventory: null
            };
        },
        computed: {
            currentUser() {
                return this.$store.getters.currentUser;
            },
            inventories() {
                return this.$store.getters.inventory;
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
