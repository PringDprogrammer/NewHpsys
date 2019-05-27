<template>
	<div class="container">
	<div class="card">
		<div class="card-header">
			<div class="row">
				<div class="btn-wrapper">
		            <router-link to="/pharmacy/new" class="btn btn-primary">Add walkIn Order</router-link>
		        </div>
			</div>
      <div class="row">
        <input type="search" class="form-control ds-input" placeholder="Search WalkIn Name..." v-model="searchWalkin">
      </div>
		</div>
		
		<div class="card-body">
			<table class="table">
				<thead>
					<th>walkIniD</th>
					<th>Name</th>
          <th>Date</th>
				</thead>
				<tbody>					
          <template v-if="!walkins.length">
              <tr>
                  <td colspan="3" class="text-center">Empty Table</td>
              </tr>
          </template>
          <template v-else>
              <tr v-for="walkin in filteredCustomers" :key="walkin.walkin_id">
                  <td>{{ walkin.walkin_id }}</td>
                  <td>{{ walkin.fullname }}</td>
                  <td>{{ walkin.transdate }}</router-link></td>
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
        name: 'walkin',
        data(){
          return {
            searchWalkin: ''
          };
        },
        mounted() {
            this.$store.dispatch('getWalkin');
        },
        computed: {
            walkins() {
                return this.$store.getters.walkins;
            },
            filteredCustomers:function()
            {
                if(this.searchWalkin) {
                  return this.walkins.filter((name) => {
                    return name.name.startsWith(this.searchWalkin);
                  });
                } else {
                  return this.walkins;
                }
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