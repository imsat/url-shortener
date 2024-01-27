<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4 class="text-body-emphasis">
                    Feedback Form
                    <router-link to="/forms/create" class="btn btn-sm btn-primary float-end">Add New</router-link>
                </h4>
                <div class="card">
                    <div class="card-body">
                        <table class="table text-center" v-if="!isLoading">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Link</th>
                                <th>Description</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(form, i) in forms" :key="i">
                                <th>{{ i + 1 }}</th>
                                <td>{{ form.name }}</td>
                                <td>
                                    <span role="button" class="text-primary">{{appUrl + 'feedbacks/submit/' + form.id}}</span>
                                </td>
                                <td>{{ form.description }}</td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="text-center" v-else>Loading...</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {get} from "../../utils/fetchAPI.js";

export default {
    name: "Form",
    data() {
        return {
            forms: [],
            isLoading: false,
            appUrl: import.meta.env.VITE_APP_URL || 'your_app_url/'
        }
    },
    created() {
        this.getForms()
    },
    methods: {
        async getForms() {
            this.isLoading = true
            await get('forms')
                .then(res => {
                    this.forms = res.data.data
                }).catch(errors => {
                    console.log(errors)
                })
                .finally(() => {
                    this.isLoading = false
                })

        },
    }
}
</script>

<style scoped>

</style>
