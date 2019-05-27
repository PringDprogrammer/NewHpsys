<template>
	<div class="form-group">
		<h3 class="text-center"><strong>Personal Details</strong></h3>
		<div class="form-group">
	        <label>Patient ID :</label>
	        <input type="text" class="form-control" v-model="inpatient.inpatient_id" v-uppercase disabled />
	    </div>
		<div class="form-group">
	        <label>Patient Name :</label>
	        <input type="text" class="form-control" v-model="inpatient.fullname" v-uppercase/>
	    </div>
	    <div class="row" style="margin-bottom: 2rem;">
	        <div class="col-md-4">
	            <label>Date of Birth : </label>
	            <datepicker :bootstrap-styling="true"
	                        v-model="dob"
	                        format="MM-dd-yyyy"
	            ></datepicker>
	        </div>
	        <div class="col-md-2">
	            <label>Age</label>
	            <input type="text" class="form-control" v-uppercase v-model="inpatient.age">
	        </div>
	        <div class="col-md-2">
	            <label>Gender</label>
	            <input type="text" class="form-control" v-uppercase v-model="inpatient.gender">
	        </div>
	        <div class="col-md-3">
                <label>Marital Status</label>
                <select class="custom-select mr-sm-2" v-model="inpatient.marital">
                    <option v-for="marital in maritalStat">{{ marital }}</option>
                </select>
            </div>
	    </div>
	    <div class="form-group">
	        <label>Home Address</label>
	        <input type="text" class="form-control" v-model="inpatient.address" v-uppercase>
	    </div>
	    <div class="row" style="margin-bottom: 2rem;">
	        <div class="col">
	            <label>Barangay</label>
	            <input type="text" class="form-control" v-model="inpatient.brngy" v-uppercase>
	        </div>
	        <div class="col">
	            <label>Municipality</label>
	            <input type="text" class="form-control" v-model="inpatient.municipal" v-uppercase>
	        </div>
	        <div class="col">
	            <label>Province</label>
	            <input type="text" class="form-control" v-model="inpatient.province" v-uppercase>
	        </div>
	    </div>
	    <div class="row" style="margin-bottom: 2rem;">
	        <div class="col">
	            <label>Telephone No.</label>
	            <input type="number" class="form-control" v-model="inpatient.telNo">
	        </div>
	        <div class="col">
	            <label>Cellphone No.</label>
	            <input type="number" class="form-control" v-model="inpatient.celNo">
	        </div>
	    </div>
	    <div align="center">
	    	<button class="btn btn-primary col-sm-3" @click="updateInfo" :disabled = "status == 'DISCHARGED' " >Update Patient Info</button>
	    </div>
	</div>
</template>

<script>
    import validate from 'validate.js';
    import Datepicker from 'vuejs-datepicker';
    import moment from "moment";

	export default {
		name: 'personal-details',
		components: {
			Datepicker,
			moment
		},
		created() {
			var pat_id = this.$route.params.inpatient_id;
			
			axios.get('/api/inPatient/getPersonal', {params: {pat_id: pat_id}})
				.then((response) => {
					var date_birth = response.data.inpatient[0].dateBirth;
					this.dob = moment(date_birth).format('MM-DD-YYYY');
					this.inpatient = response.data.inpatient[0];
					this.status = response.data.inpatient[0].status;
				});
		},
		data() {
			return {
				status: '',
				dob: null,
				inpatient: {
					inpatient_id: '',
					fullname: '',
					age: '',
					gender: '',
					marital: '',
					address: '',
					brngy: '',
					municipal: '',
					province: '',
					telNo: '',
					celNo: ''
				},
				maritalStat: [
                    '',
                    'SINGLE',
                    'MARRIED',
                    'SEPARATED',
                    'WIDOWED'
                ]
			}
		},
		methods: {
            updateInfo() {
            	var id = this.$route.params.inpatient_id;
            	var date = moment(this.dob).format();
            	var data = {
            		inpatient: this.inpatient,
            		dob: date,
            		pat_id: id 
            	}
            	axios.post('/api/inPatient/updatePersonal', data)
            		.then((response) => {
            			alert('successfully Update');
            		});
            }
		}
	};

</script>