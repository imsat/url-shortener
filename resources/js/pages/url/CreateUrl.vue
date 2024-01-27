<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4 class="text-body-emphasis">
                    Create New Short Url
                </h4>
                <div class="card">
                    <div class="card-body">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="formName" placeholder="Write down or paste your url"
                                   v-model="urlForm.url">
                            <label for="formUrl">Write down or paste your url</label>
                            <Validation :error-text="getError('url')"/>
                        </div>
                        <button type="button" @click="createUrl" class="btn btn-primary float-end my-3"> Create Short Url
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {post} from "../../utils/fetchAPI.js";
import {successToast} from "../../utils/swalUtil.js";

export default {
    name: "CreateUrl",
    data() {
        return {
            urlForm: {
                url: '',
            },
            errors: []
        }
    },
    methods: {
        createUrl() {
            post('/urls', this.urlForm).then(res => {
                this.$router.push('/')
                successToast(res?.data?.message)
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
