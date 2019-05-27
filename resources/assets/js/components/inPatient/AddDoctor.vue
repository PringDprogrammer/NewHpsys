<template>
	<div class="new-doctor">
		<form @submit.prevent="add">
			<p v-if="errors.length">
			    <b>Please Fill up the following field(s):</b>
			    <ul>
			      <li v-for="error in errors">
			      	{{ error }}
			      </li>
			    </ul>
		  	</p>
			<div class="form-group">
				<label>Name</label>
				<div class="row" style="margin-bottom: 2rem;">
					<div class="col">
                        <input type="text" class="form-control" v-model="doctor.fname" placeholder="First Name" required/>
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" v-model="doctor.mname" placeholder="Middle Initial"/>
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" v-model="doctor.lname" placeholder="Last Name" required/>
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" v-model="doctor.suffix" placeholder="Jr./Sr."/>
                    </div>
				</div>
				<div class="form-group">
					<label>License #</label>
					<input type="text" class="form-control" v-model="doctor.lcno" placeholder="License no." required/>
				</div>
				<div class="form-group">
					<label>Specialization</label>
					<input type="text" class="form-control" v-model="doctor.specialty" placeholder="Specialization" required/>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-2">
						<router-link to="/inPatient" class="btn">Cancel</router-link>
						<input type="submit" class="btn btn-primary" value="Save">
					</div>
				</div>
			</div>
		</form>
		
	</div>
</template>

<script>
import validate from 'validate.js';
	export default {
		name: 'newdoctor',
		data() {
			return {
				doctor: {
					fname: null,
					mname: '',
					lname: null,
					suffix: '',
					lcno: null,
					specialty: null
				},
				errors: []
			};
		},
		computed: {
            currentUser() {
                return this.$store.getters.currentUser;
            }
        },
        methods: {
            add() {
                axios.post('/api/inPatient/newdoctor', this.$data.doctor)
                    .then((response) => {
                        this.$router.push('/inPatient');
                    });
            },
        }
	};
</script>
