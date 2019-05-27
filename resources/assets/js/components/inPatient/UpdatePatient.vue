<template>
    <div class="form-group">
        <h3 class="text-danger text-center" id="info"><STRONG>PATIENT INFORMATION</STRONG></h3>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <router-link :to="{name: 'personal-details'}" class="btn">Personal Details</router-link>
            <router-link :to="{name: 'current-record'}" class="btn">Current Record</router-link>
            <router-link :to="{name: 'active-order'}" class="btn">Active OrderSlip</router-link>
            <router-link :to="{name: 'add-order'}" class="btn">Add Order</router-link>
            <router-link :to="{name: 'other-charges'}" class="btn">Other Charges</router-link>
            <router-link :to="{name: 'patient-history'}" class="btn">Patient History</router-link>
            <router-link :to="{name: 'out-patient-history'}" class="btn">Out-Patient History</router-link>
        </nav>
        <br>
        <div>
           <router-view></router-view>
        </div>
    </div>
</template>

<script>

    export default {
        name: 'new',
        
    };
</script>

<style>
.errors {
    background: lightcoral;
    border-radius:5px;
    padding: 21px 0 2px 0;
}
</style>

