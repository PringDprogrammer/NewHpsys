<template>
	<div class="container">
	<div class="card">
		<div class="card-header">
			<div class="row">
				<div class="btn-wrapper">
		      <router-link to="/inPatient/new" class="btn btn-primary">Add Patient</router-link>
          <router-link to="/inPatient/newdoctor" class="btn btn-primary">Add Doctor</router-link>
		    </div>
			</div>
      <div class="row">
        <input type="search" class="form-control ds-input" placeholder="Search In-Patient Name..." v-model="searchinPatient">
      </div>
		</div>

		<div class="card-body">
			<table class="table">
				<thead>
					<th>inPatientID</th>
					<th>Name</th>
          <th>Type/Status</th>
          <th>Action</th>
				</thead>
				<tbody>
          <template v-if="!inpatients.length">
              <tr>
                  <td colspan="3" class="text-center">Empty Table</td>
              </tr>
          </template>
          <template v-else>
              <tr v-for="inpatient in filteredCustomers" :key="inpatient.inpatient_id">
                  <td>{{ inpatient.inpatient_id }}</td>
                  <td>{{ inpatient.fullname }}</td>
                  <td>{{ inpatient.pat_type }}</td>
                  <td><router-link :to="`/inPatient/${inpatient.inpatient_id}`">View</router-link></td>
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
        name: 'inpatient',
        data(){
          return {
            searchinPatient: ''
          };
        },
        mounted() {
            this.$store.dispatch('getinPatient');
        },
        computed: {
            inpatients() {
                return this.$store.getters.inpatients;
            },
            filteredCustomers:function()
            {
                if(this.searchinPatient) {
                  return this.inpatients.filter((name) => {
                    return name.fullname.startsWith(this.searchinPatient) || name.inpatient_id.startsWith(this.searchinPatient) ;
                  });
                } else {
                  return this.inpatients;
                }
            }
        }
    };
</script>

<style scoped>
.btn-wrapper {
    text-align: right;
    margin-bottom: 20px;
  }
</style>
