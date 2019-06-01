<template>
	<div class="form-group">
		<div class="form-group">
			<h3 class="text-center"><strong>Other Charges</strong></h3>
		</div>
		<div class="form-group row ">
			<label class="col-sm-2 col-form-label">Room and Board: </label>
			<div class="col-md-3">
				<input type="text" class="form-control" v-model="other.rmNbrd">
			</div>
		</div>
		<div class="form-group row ">
			<label class="col-sm-2 col-form-label">Oxygene: </label>
			<div class="col-md-3">
				<input type="text" class="form-control" v-model="other.oxy">
			</div>
		</div>
		<div class="form-group row ">
			<label class="col-sm-2 col-form-label">Medical/Surgical Supplies </label>
			<div class="col-md-3">
				<input type="text" class="form-control" v-model="other.med_sur_sup">
			</div>
		</div>
		<div class="form-group row ">
			<label class="col-sm-2 col-form-label">Use of Nebulizer </label>
			<div class="col-md-3">
				<input type="text" class="form-control" v-model="other.nebulizer">
			</div>
		</div>
		<div class="form-group">
			<h3><strong>Labaratory Fee</strong></h3>
		</div>
		<div class="form-group row ">
			<label class="col-sm-2 col-form-label">Blood Chemistry </label>
			<div class="col-md-3">
				<input type="text" class="form-control" v-model="other.bl_chem">
			</div>
		</div>
		<div class="form-group row ">
			<label class="col-sm-2 col-form-label">CTB Urinalysis, Facalysis, Widal Test </label>
			<div class="col-md-3">
				<input type="text" class="form-control" v-model="other.ctb">
			</div>
		</div>
		<div class="form-group row ">
			<label class="col-sm-2 col-form-label">CBC Blood typing, Cross Matching </label>
			<div class="col-md-3">
				<input type="text" class="form-control" v-model="other.cbc">
			</div>
		</div>
		<div class="form-group row ">
			<label class="col-sm-2 col-form-label">Hemoglobin HCT, Platelet Count </label>
			<div class="col-md-3">
				<input type="text" class="form-control" v-model="other.hct">
			</div>
		</div>
		<div class="form-group">
			<h3><strong>Radiology Fee</strong></h3>
		</div>
		<div class="form-group row ">
			<label class="col-sm-2 col-form-label">X-Ray </label>
			<div class="col-md-3">
				<input type="text" class="form-control" v-model="other.x_ray">
			</div>
		</div>
		<div class="form-group row ">
			<label class="col-sm-2 col-form-label">ECG </label>
			<div class="col-md-3">
				<input type="text" class="form-control" v-model="other.ecg">
			</div>
		</div>
		<div class="form-group row ">
			<label class="col-sm-2 col-form-label">Operating/Del. Room Fee </label>
			<div class="col-md-3">
				<input type="text" class="form-control" v-model="other.deliv_rm">
			</div>
		</div>
		<div class="form-group row ">
			<label class="col-sm-2 col-form-label">Other Hospital Charges </label>
			<div class="col-md-3">
				<input type="text" class="form-control" v-model="other.other_charge">
			</div>
		</div>
		<div class="form-group">
			<h3><strong>Professional Fees</strong></h3>
		</div>
		<div class="form-group row ">
			<label class="col-sm-2 col-form-label">Daily Visit </label>
			<div class="col-md-3">
				<input type="text" class="form-control" v-model="other.daily_visit">
			</div>
		</div>
		<div class="form-group row ">
			<label class="col-sm-2 col-form-label">Surgical Fees </label>
			<div class="col-md-3">
				<input type="text" class="form-control" v-model="other.surg_fee">
			</div>
		</div>
		<div class="form-group row ">
			<label class="col-sm-2 col-form-label">Anesthesia Fees </label>
			<div class="col-md-3">
				<input type="text" class="form-control" v-model="other.annes_fee">
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-2 col-form-label"><strong>Total</strong></label>
			<div class="col-md-3">
				<input type="text" class="form-control" v-model="other.total">
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				other: {
					rmNbrd : 0,
					oxy : 0,
					med_sur_sup : 0,
					nebulizer : 0,
					bl_chem : 0,
					ctb : 0,
					cbc : 0,
					hct : 0,
					x_ray : 0,
					ecg : 0,
					deliv_rm : 0,
					other_charge : 0,
					daily_visit : 0,
					surg_fee : 0,
					annes_fee : 0
				},
				total: 0
			}
		},
		computed: {
			OtherTotal: function() {
                
            },
		}
	};
</script>