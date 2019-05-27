<template>
    <form @submit.prevent="add">
        <h2 class="text-danger">ADMISSION DETAILS</h2>
		<div class="form-group row">
			<div class="col">
				<label>Patient Name</label>
				<input type="text" v-model="fullname" class="form-control" disabled>
			</div>
            <div class="col">
                <label>Patient ID</label>
                <input type="text" v-model="inpatient_id" class="form-control" disabled>
            </div>
		</div>
		<div class="text-center">
            <h3><STRONG>VITAL SIGNS</STRONG></h3>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" v-model="adDetails.temp" placeholder="TEMPERATURE" v-uppercase><br>
            <input type="text" class="form-control" v-model="adDetails.bp" placeholder="BLOOD PRESSURE" v-uppercase><br>
            <input type="text" class="form-control" v-model="adDetails.pulse_rate" placeholder="PULSE RATE" v-uppercase>
        </div>
        <div class="text-center">
            <h3><strong>OTHER INFO</strong></h3>
        </div>
        <div class="form-group">
            <select class="form-control" v-model="adDetails.p_type">
                <option v-for = "ptype in ptypes" >{{ ptype }}</option>
            </select><br>
            <select class="form-control" v-model="adDetails.p_clasif">
                <option v-for = "classif in classification" >{{ classif }}</option>
            </select><br>
            <input type="text" class="form-control" v-model="adDetails.doctor" placeholder="ASSIGNED DOCTOR" v-uppercase><br>
            <input type="text" class="form-control" v-model="adDetails.room" placeholder="ROOM ASSIGNMENT" v-uppercase><br>
            <input type="text" class="form-control" v-model="adDetails.remark" placeholder="INITIAL REMARKS" v-uppercase>
        </div>
        <div class="text-center">
            <h3><strong>GUARDIAN</strong></h3>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" v-model="adDetails.g_name" placeholder="NAME" v-uppercase><br>
            <input type="text" class="form-control" v-model="adDetails.g_relation" placeholder="RELATIONSHIP TO PATIENT" v-uppercase><br>
            <input type="text" class="form-control" v-model="adDetails.g_contact" placeholder="CONTACT NO." v-uppercase><br>
            <input type="text" class="form-control" v-model="adDetails.g_address" placeholder="ADDRESS" v-uppercase>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Admit Patient">
        </div>
	</form>
</template>

<script>
	import validate from 'validate.js';
    import Datepicker from 'vuejs-datepicker';
    import moment from "moment";

    export default {
    	name: 'Addmission-details',
    	created() {
            axios.get('/api/inPatient/getPatienInfo')
                .then((response) => {
                    this.inpatient_id = response.data.inPatients.inpatient_id;
                    this.fullname = response.data.inPatients.fullname;
                });
        },
    	data() {
    	   return {
                inpatient_id: '',
                fullname: '',
                adDetails: {
                    temp: '',
                    bp: '',
                    pulse_rate: '',
                    p_type: '',
                    p_clasif: '',
                    doctor: '',
                    room: '',
                    remark: '',
                    g_name: '',
                    g_relation: '',
                    g_contact: '',
                    g_address: ''
                },
                ptypes: [
                    '',
                    'IN-PATIENT',
                    'OUT-PATIENT'
                ],
                classification: [
                    '',
                    'NOT-SET',
                    'PHILNBB'
                ]
           };
    	},
    	components: {
    		Datepicker
    	},
    	computed: {
    		currentUser() {
                return this.$store.getters.currentUser;
            }
    	},
    	methods: {
    		//Date format
            customFormatter(transdate) {
                return this.transdate = moment(transdate).format('MM-DD-YYYY');
            },
            add() {
                var dataForm = {
                    inpatient_id: this.inpatient_id,
                    details : this.adDetails
                }
                axios.post('/api/inPatient/admissionDetails', dataForm)
                    .then((response) => {
                        alert('Successfully Admitted');
                        this.$router.push('/inPatient');
                    });
            }
    	}
    };
</script>