<template>
	<div class="container">
	<div class="card">
		<div class="card-header">
			<div class="row">
				<div class="btn-wrapper">
		            <router-link to="/inventory/new" class="btn btn-primary">Add Item</router-link>
		            <router-link to="/inventory/delivery" class="btn btn-primary">Add Delivery</router-link>
		            <router-link to="/inventory/consignor" class="btn btn-primary">Add Consignor</router-link>
		        </div>
			</div>
			<div class="form-group">
		    	<input type="search" class="form-control ds-input" placeholder="Search..." v-model="searchItem">
		    </div>
		</div>
		<div class="card-body">
			<table class="table" style="text-align: center;">
				<thead>
					<th>Item Code</th>
					<th>Item Name</th>
					<th>Item type</th>
					<th>Consignor</th>
					<th>Unit Cost</th>
					<th>Selling Price</th>
					<th>Stock</th>
					<th>Action</th>
				</thead>
				<tbody>					
	                <template v-if="!inventory.length">
	                    <tr>
	                        <td colspan="12" class="text-center">No Item Available</td>
	                    </tr>
	                </template>
	                <template v-else>
	                    <tr v-for="item in filteredItems" :key="item.id">
	                        <td>{{ item.itemcode }}</td>
	                        <td>{{ item.brandName }} {{ item.itemName }}</td>
	                        <td>{{ item.itemType }}</td>
	                        <td>{{ item.consignor }}</td>
	                        <td>{{ formatPrice(item.unit_cost) }}</td>
	                        <td>{{ formatPrice(item.sellPrice) }}</td>
	                        <td>{{ item.quantity }}</td>
	                        <td>
	                        	<router-link :to="`/inventory/${item.itemcode}`">View</router-link>
	                        </td>
	                    </tr>
	                </template>
            	</tbody>
			</table>
		</div>
	</div>
</div>
</template>

<script>
    export default {
        name: 'inventory',
        data() {
        	return {
        		searchItem: '',
        		inventory: {
        			itemcode: '',
        			itemName: '',
        			itemType: '',
        			brandName: '',
        			consignor: '', 
        			unit_cost: '',
        			sellPrice: '',
        			quantity: ''
        		}
        	};
        },
        created() {
	        axios.get('/api/inventory')
	            .then((response)=> {
	                this.inventory = response.data.inventory;
	            })
        },
        computed: {
            filteredItems:function()
            {
                if(this.searchItem) {
                  return this.inventory.filter((name) => {
                    return name.itemName.startsWith(this.searchItem) || name.itemType.startsWith(this.searchItem) || name.consignor.startsWith(this.searchItem) || name.itemcode.startsWith(this.searchItem);
                  });
                } else {
                  return this.inventory;
                }
            }
        },
        methods: {
        	formatPrice(value) {
		        let val = (value/1).toFixed(2).replace('.', ',')
		        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
		    }
        }
    }
</script>

<style scoped>
.btn-wrapper {
    text-align: right;
    margin-bottom: 20px;
}
</style>