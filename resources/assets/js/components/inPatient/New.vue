<template>
    <div class="inPatient-new">
        <form @submit.prevent="add">
            <div class="form-group">
                <label>Name :</label>
                <div class="row" style="margin-bottom: 2rem;">
                    <div class="col">
                        <input type="text" class="form-control" v-model="inpatient.fname" placeholder="First Name" v-uppercase required />
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" v-model="inpatient.mname" placeholder="Midlle Initial" v-uppercase required/>
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" v-model="inpatient.lname" placeholder="Last Name" v-uppercase required/>
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" v-model="inpatient.suffix" placeholder="Suffix" v-uppercase/>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-bottom: 2rem;">
                <div class="col-md-4">
                    <label>Date of Birth : </label>
                    <datepicker :bootstrap-styling="true"
                                v-model="dob"
                                :format="customFormatter"
                                placeholder="MM-DD-YYYY"
                                required
                    ></datepicker>
                </div>
                <div class="col-md-2">
                    <label>Age</label>
                    <input type="text" placeholder="Age" class="form-control" v-uppercase v-model="inpatient.age">
                </div>
                <div class="col-md-2">
                    <label>Gender</label>
                    <input type="text" placeholder="Gender" class="form-control" v-uppercase v-model="inpatient.gender">
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
                <input type="text" placeholder="Home Address" class="form-control" v-model="inpatient.address" v-uppercase>
            </div>
            <div class="row" style="margin-bottom: 2rem;">
                <div class="col">
                    <label>Barangay</label>
                    <input type="text" placeholder="Barangay" class="form-control" v-model="inpatient.barangay" v-uppercase>
                </div>
                <div class="col">
                    <label>Municipality</label>
                    <input type="text" placeholder="Municipality" class="form-control" v-model="inpatient.municipal" v-uppercase>
                </div>
                <div class="col">
                    <label>Province</label>
                    <input type="text" placeholder="Province" class="form-control" v-model="inpatient.province" v-uppercase>
                </div>
            </div>
            <div class="row" style="margin-bottom: 2rem;">
                <div class="col">
                    <label>Telephone No.</label>
                    <input type="number" placeholder="Telephone No." class="form-control" v-model="inpatient.telNo">
                </div>
                <div class="col">
                    <label>Cellphone No.</label>
                    <input type="number" placeholder="Cellphone No." class="form-control" v-model="inpatient.celNo">
                </div>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Proceed to Admitting Page" >
            </div>
            <router-link to="/inPatient" class="btn btn-danger">Cancel</router-link>
        </form>
    </div>
</template>

<script>
    import validate from 'validate.js';
    import Datepicker from 'vuejs-datepicker';
    import moment from "moment";
    export default {
        name: 'new',
        data() {
            return {
                dob: null,
                inpatient: {
                    fname: '',
                    mname: '',
                    lname: '',
                    suffix: '',
                    gender: '',
                    age: '',
                    marital: '',
                    address: '',
                    barangay: '',
                    municipal: '',
                    province: '',
                    telNo: '',
                    celNo: '',
                },
                maritalStat: [
                    '',
                    'SINGLE',
                    'MARRIED',
                    'SEPARATED',
                    'WIDOWED'
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
            customFormatter(dob) {
                return this.dob = moment(dob).format('MM-DD-YYYY');
            },
            add() {
                var filterDate = moment(this.$data.dob).format();
                var dataForm = {
                    inpatient : this.inpatient,
                    dob : filterDate
                }
                axios.post('/api/inPatient/new', dataForm)
                    .then((response) => {
                        if(response.data.error) {
                            alert('Patient Name Already Exist...');
                            this.$router.push('/inPatient')
                        } else {
                            this.$router.push('/inPatient/admission');
                        }
                    });
            }
        }
    };
</script>

<style>
.errors {
    background: lightcoral;
    border-radius:5px;
    padding: 21px 0 2px 0;
}
</style>