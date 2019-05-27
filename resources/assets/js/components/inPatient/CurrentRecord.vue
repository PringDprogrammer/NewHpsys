<template>
	<div class="form-group">
		<br>
		<h3 class=" text-center"><strong>ADMISSION DETAILS</strong></h3>
		<div class="form-group row">
            <label class="col-sm-2 col-form-label">Referrence No.</label>
            <div class="col">
	            <input type="text" v-model="adDetails.ref_num" class="form-control" disabled>
            </div>
		</div>
		<div class="form-group row">
            <label class="col-sm-2 col-form-label">Patient ID</label>
            <div class="col">
	            <input type="text" v-model="adDetails.inpatient_id" class="form-control" disabled>
            </div>
		</div>
		<div class="form-group row">
			<label class="col-sm-2 col-form-label">Patient Name</label>
			<div class="col">
				<input type="text" v-model="adDetails.fullname" class="form-control" disabled>
			</div>
		</div>
		<div class="form-group row">
            <label class="col-sm-2 col-form-label">Date Admitted</label>
            <div class="col">
	            <datepicker :bootstrap-styling="true"
	                        v-model="date_admit"
	                        :format="customFormatter"
	                        placeholder="MM-DD-YYYY"
	            ></datepicker>
            </div>
		</div>

		<div class="text-center">
            <h3><STRONG>VITAL SIGNS</STRONG></h3>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Temperature</label>
            <div class="col">
	            <input type="text" class="form-control" v-model="adDetails.temp" placeholder="TEMPERATURE">
            </div>
		</div>
		<div class="form-group row">
            <label class="col-sm-2 col-form-label">Blood Pressure</label>
            <div class="col">
	            <input type="text" class="form-control" v-model="adDetails.bp" placeholder="BLOOD PRESSURE" v-uppercase>
            </div>
		</div>
		<div class="form-group row">
            <label class="col-sm-2 col-form-label">Pulse Rate</label>
            <div class="col">
	            <input type="text" class="form-control" v-model="adDetails.pulse_rate" placeholder="PULSE RATE" v-uppercase>
            </div>
		</div>
        
        <div class="text-center">
            <h3><strong>OTHER INFO</strong></h3>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Status</label>
            <div class="col">
	            <select class="form-control" v-model="adDetails.p_type">
                	<option v-for = "ptype in ptypes" >{{ ptype }}</option>
            	</select>
            </div>
		</div>
		<div class="form-group row">
            <label class="col-sm-2 col-form-label">Patient Classification</label>
            <div class="col">
	            <select class="form-control" v-model="adDetails.p_clasif">
                	<option v-for = "classif in classification" >{{ classif }}</option>
            	</select>
            </div>
		</div>
		<div class="form-group row">
            <label class="col-sm-2 col-form-label">Assigned Doctor</label>
            <div class="col">
	            <input type="text" class="form-control" v-model="adDetails.doctor" placeholder="ASSIGNED DOCTOR" v-uppercase>
            </div>
		</div>
		<div class="form-group row">
            <label class="col-sm-2 col-form-label">Room Assignment</label>
            <div class="col">
	            <input type="text" class="form-control" v-model="adDetails.room" placeholder="ROOM ASSIGNMENT" v-uppercase>
            </div>
		</div>
		<div class="form-group row">
            <label class="col-sm-2 col-form-label">Initial Remarks</label>
            <div class="col">
	            <input type="text" class="form-control" v-model="adDetails.remarks" placeholder="INITIAL REMARKS" v-uppercase>
            </div>
		</div>

        <div class="text-center">
            <h3><strong>GUARDIAN</strong></h3>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Name</label>
            <div class="col">
	            <input type="text" class="form-control" v-model="adDetails.gname" placeholder="NAME" v-uppercase>
            </div>
		</div>
		<div class="form-group row">
            <label class="col-sm-2 col-form-label">Relationship to Patient</label>
            <div class="col">
	            <input type="text" class="form-control" v-model="adDetails.grelation" placeholder="RELATIONSHIP TO PATIENT" v-uppercase>
            </div>
		</div>
		<div class="form-group row">
            <label class="col-sm-2 col-form-label">Contact No.</label>
            <div class="col">
	            <input type="text" class="form-control" v-model="adDetails.gcontact" placeholder="CONTACT NO." v-uppercase>
            </div>
		</div>
		<div class="form-group row">
            <label class="col-sm-2 col-form-label">Address</label>
            <div class="col">
	            <input type="text" class="form-control" v-model="adDetails.gaddress" placeholder="ADDRESS" v-uppercase>
            </div>
		</div>
 
		<div class="form-group">
			<h3 class="text-center"><strong>FINAL ACTION</strong></h3>
		</div>
		<div class="form-group">
			<div class="form-group row">
	            <label class="col-sm-2 col-form-label">Final Diagnosis</label>
	            <div class="col">
		            <input type="text" class="form-control" v-model="final.finaldiagnosis" placeholder="Final Diagnosis" v-uppercase>
	            </div>
			</div>
			<div class="form-group row">
	            <label class="col-sm-2 col-form-label">Date Release</label>
	            <div class="col">
		            <datepicker :bootstrap-styling="true"
		                        v-model="releasedDate"
                                format = "MM-DD-YYYY"
		                        placeholder="MM-DD-YYYY"
		            ></datepicker>
	            </div>
			</div>
			<div class="form-group row">
	            <label class="col-sm-2 col-form-label">Status</label>
	            <div class="col">
		            <select class="form-control" v-model="final.status">
		            	<option v-for="(status, i) in statuses" :key='i' :name="status.name" :value='status.value'>{{ status.name }}</option>
		            </select>
	            </div>
			</div>
		</div>
        <div align="center">
            <button class="btn btn-primary col-sm-3" @click="updateRec" :disabled = "final.status == 'DISCHARGED' ">Update Patient Record</button>
        </div>
	</div>
</template>

<script>
	import validate from 'validate.js';
    import Datepicker from 'vuejs-datepicker';
    import moment from "moment";

    export default {
    	name: 'current-record',
    	components: {
    		Datepicker,
    		moment
    	},
        created() {
            var pat_id = this.$route.params.inpatient_id;
            
            axios.get('/api/inPatient/getCurrent', {params: {pat_id: pat_id}})
                .then((response) => {
                    var dateAdmit = response.data.adDetails[0].created_at;
                    this.date_admit = moment(dateAdmit).format('MM-DD-YYYY');

                    var released = response.data.adDetails[0].releasedDate;
                    this.releasedDate = moment(released).format('MM-DD-YYYY');

                    this.adDetails = response.data.adDetails[0];
                    this.final.finaldiagnosis = response.data.adDetails[0].finaldiagnosis;
                    this.final.status = response.data.adDetails[0].status;
                    this.adDetails.ref_num = response.data.adDetails[0].transaction_no;
                    this.adDetails.p_type = response.data.adDetails[0].pat_type;
                    this.adDetails.p_clasif = response.data.adDetails[0].pat_categ;
                });
        },
    	data() {
    		return {
    			releasedDate: null,
    			date_admit: '',
    			adDetails: {
    				fullname: '',
    				inpatient_id: '',
    				temp: '',
    				bp: '',
    				pulse_rate: '',
    				p_type: '',
    				p_clasif: '',
    				doctor: '',
    				room: '',
    				remarks: '',
    				gname: '',
    				grelation: '',
    				gaddress: '',
    				gcontact: '',
    				ref_num: '',
    			},
                final: {
                    finaldiagnosis: '',
                    status: '',
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
                ],
                statuses: [
                	{
                		name: '',
                		value: ''
                	},
                	{
                		name: 'DISCHARGED',
                		value: 'DISCHARGED'
                	}
                ],
                msg: '',
    		}
    	},
    	methods: {
    		//Date format
            customFormatter(date_admit) {
                return this.date_admit = moment(date_admit).format('MM-DD-YYYY');
            },
            updateRec() {
                var id = this.$route.params.inpatient_id;
                var date_admit = moment(this.date_admit).format();
                var date_release = moment(this.releasedDate).format();

                var data = {
                    details: this.adDetails,
                    finals: this.final,
                    admit: date_admit,
                    released: date_release,
                    pat_id: id 
                }
                axios.post('/api/inPatient/updateRecord', data)
                    .then((response) => {
                        alert('successfully Update!');
                    })
                    .catch((error) => {
                        this.msg = 'Data Not save!';
                        alert(this.msg);
                    })
            }
    	}
    };
</script>