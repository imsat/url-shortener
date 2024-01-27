<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4 class="text-body-emphasis">
                    Urls
                    <router-link to="/urls/create" class="btn btn-sm btn-primary float-end">Add New</router-link>
                </h4>
                <div class="card">
                    <div class="card-body">
                        <table class="table text-center" v-if="!isLoading">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th style="width: 45% !important;">Url</th>
                                <th>Short Url</th>
                                <th>Click Count</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(url, i) in urls" :key="i">
                                <th>{{ i + 1 }}</th>
                                <td>{{ url?.original_url }}</td>
                                <td>
                                    <span
                                        role="button"
                                        class="text-primary"
                                        @click="copyURL"
                                        v-clipboard="appUrl + '/r/' + url?.shortened_url"
                                    >
                                        {{ appUrl + '/r/' + url.shortened_url }}
                                    </span>
                                </td>
                                <td>{{ url?.click_count }}</td>
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
import {successToast} from "../../utils/swalUtil.js";

export default {
    name: "Url",
    data() {
        return {
            urls: [],
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
            await get('urls')
                .then(res => {
                    this.urls = res.data.data
                }).catch(errors => {
                    console.log(errors)
                })
                .finally(() => {
                    this.isLoading = false
                })

        },
        copyURL() {
            successToast('Copy to clipboard successfully')
        }
    }
}
</script>

<style scoped>

</style>
