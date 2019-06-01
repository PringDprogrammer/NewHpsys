<template>
    <div class="container" >
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-default" id="divCont">
                    <div class="card-header">In-Patient</div>

                    <div class="card-body">
                        <router-view></router-view>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'inPatient-main'
    }
</script>