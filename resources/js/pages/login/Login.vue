<template>
    <div class="form-signin w-100 m-auto">
        <h2 class="h3 mb-3 fw-normal">Please sign in</h2>
        <div class="form-floating">
            <input type="email" class="form-control" id="floatingInput" v-model="loginForm.email" placeholder="Email">
            <label for="floatingInput">Email address</label>
            <Validation :error-text="getError('email')" />
        </div>
        <div class="form-floating">
            <input type="password" class="form-control" id="floatingPassword" v-model="loginForm.password"
                   placeholder="Password">
            <label for="floatingPassword">Password</label>
            <Validation :error-text="getError('password')" />
        </div>
        <button type="button" class="btn btn-primary w-100 py-2 my-3" @click.prevent="signIn">Sign in</button>

        <p class="my-5 text-center">New member?
            <router-link to="/register">Register</router-link>
        </p>
    </div>
</template>

<script>
import {post} from "../../utils/fetchAPI.js";
import {set} from "../../utils/localStorage.js";
import {store} from '../../store.js'
import {mapActions} from 'pinia'
import { ref, computed } from "vue"

export default {
    name: "Login",
    data() {
        return {
            loginForm: {
                email: '',
                password: '',
            },
            errors: [],
        }
    },
    methods: {
        ...mapActions(store, ['updateLoggedIn']),
        async signIn() {
            await post('login', this.loginForm).then(res => {
                const {token, user} = res.data.data
                set('token', token)
                set('user', user)
                this.loginForm = {}
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
