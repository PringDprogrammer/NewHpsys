<template>
    <div class="login row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Registerasda</div>
                <div class="card-body">
                    <form @submit.prevent="register">
                        <div class="form-group row">
                            <label for="name">Name:</label>
                            <input type="text" v-model="form.name" class="form-control" placeholder="Name" required>
                        </div>
                        <div class="form-group row">
                            <label for="email">Username:</label>
                            <input type="text" v-model="form.email" class="form-control" placeholder="Username" required>
                        </div>
                        <div class="form-group row">
                            <label for="password">Password:</label>
                            <input type="password" v-model="form.password" class="form-control" placeholder="Password">
                        </div>
                        
                        <div class="form-group row">
                            <input type="submit" value="Register" class="btn btn-primary">
                            <router-link to="/login" class="btn btn-link">Cancel</router-link>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { register } from '../../helpers/auth';

    export default {
        name: "register",
        data() {
            return {
                form: {
                    name: '',
                    email: '',
                    password: ''
                },
                errors: null               
            };
        },
        methods: {
            register() {
                this.$store.dispatch('register');
                register(this.$data.form)
                    .then((res) => {
                        this.$store.commit("registerSuccess", res);
                        this.$router.push({path: '/'});
                    })
                    .catch((error) => {
                        this.$store.commit("registerFailed", {error});
                    });
            }
        }
    }
</script>

<style scoped>
.error {
    text-align: center;
    color: red;
}
</style>