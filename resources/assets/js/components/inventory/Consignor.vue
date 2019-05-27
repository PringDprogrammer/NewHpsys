<template>
	<div class="new-Consignor">
		<form @submit.prevent="add_consign">
			
			<div class="form-group">
				<label>Consignor Name</label>
				<div class="form-group">
                    <input type="text" class="form-control" v-model="consignor.name" placeholder="Consignor Name" required/>
				</div>
				<div class="form-group">
					<label>Consignor Alias</label>
                    <input type="text" class="form-control" v-model="consignor.alias" placeholder="Consignor Alias" required/>
				</div>
				<div class="form-group">
					<label>Contact No.</label>
                    <input type="text" class="form-control" v-model="consignor.contact" placeholder="Contact No." required/>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-2">
						<router-link to="/inventory" class="btn">Cancel</router-link>
						<input type="submit" class="btn btn-primary" value="Save">
					</div>
				</div>
			</div>
		</form>
		
	</div>
</template>

<script>
	export default {
		name: 'consignor',
		data() {
			return {
				consignor: {
					name: '',
					alias: '',
					contact: ''
				}
			};
		},
		computed: {
            currentUser() {
                return this.$store.getters.currentUser;
            }
        },
        methods: {
            add_consign() {
                axios.post('/api/inventory/consignor', this.$data.consignor)
                    .then((response) => {
                    	//console.log(this.$data.consignor);
                        this.$router.push('/inventory');
                    });
            }
        }
	};
</script>
