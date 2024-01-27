<template>
    <div class="form-signin w-100 m-auto">
        <h2 class="h3 mb-3 fw-normal">Please register</h2>
        <div class="form-floating">
            <input type="text" class="form-control" id="floatingName" v-model="registerForm.name" placeholder="Name">
            <label for="floatingName">Name</label>
            <Validation :error-text="getError('name')" />
        </div>
        <div class="form-floating">
            <input type="email" class="form-control" id="floatingInput" v-model="registerForm.email" placeholder="Email">
            <label for="floatingInput">Email address</label>
            <Validation :error-text="getError('email')" />
        </div>
        <div class="form-floating">
            <input type="password" class="form-control" id="floatingPassword" v-model="registerForm.password" placeholder="Password">
            <label for="floatingPassword">Password</label>
            <Validation :error-text="getError('password')" />
        </div>
        <button class="btn btn-primary w-100 py-2 my-3" type="button" @click.prevent="register">Register</button>

        <p class="my-5 text-center">Already have an account?
            <router-link to="/login">Login</router-link>
        </p>
    </div>
</template>

<script>
import {post} from "../../utils/fetchAPI.js";
import {set} from "../../utils/localStorage.js";
import {store} from '../../store.js'
import { mapActions } from 'pinia'
export default {
    name: "Register",
    data() {
        return {
            registerForm: {
                name:'',
                email: '',
                password: '',
            },
            errors: [],
        }
    },
    methods: {
        ...mapActions(store, ['updateLoggedIn']),
        async register() {
            await post('register', this.registerForm).then(res => {
                const {token, user} = res.data.data
                set('token', token)
                set('user', user)
                this.registerForm = {}
                this.updateLoggedIn()
                this.$router.push('/')
            }).catch(errors => {
                this.setError(errors.response.data.data);
            })
        },
        setError(errors) {
            return this.errors = errors;
        },
        getError(key) {
            return !!this.errors && this.errors[key] !== undefined ? this.errors[key][0] : null;
        },
    }
}
</script>

<style scoped>

</style>
