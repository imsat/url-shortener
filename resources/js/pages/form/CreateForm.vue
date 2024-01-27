<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4 class="text-body-emphasis">
                    Create Feedback Form
                </h4>
                <div class="card">
                    <div class="card-body">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="formName" placeholder="Name"
                                   v-model="feedbackForm.name">
                            <label for="formName">Name</label>
                            <Validation :error-text="getError('name')"/>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" style="height: 100px" id="formDescription"
                                      placeholder="Description" v-model="feedbackForm.description"></textarea>
                            <label for="formDescription">Description</label>
                        </div>
                        <div class="form-floating mb-3" v-for="(field, index) in feedbackForm.fields" :key="index">
                            <input
                                type="text"
                                class="form-control"
                                v-model="feedbackForm.fields[index].label"
                                :placeholder="'Field ' + (index+1)">
                            <label>Field {{ index + 1 }}</label>
                            <span
                                class="text-danger float-end fw-bold"
                                role="button"
                                title="Remove"
                                @click.stop="removeDynamicField(index)"
                                v-if="index > 0"
                            >X</span>
                            <Validation :error-text="getError('fields')"/>
                        </div>
                        <button type="button" @click="addDynamicField" class="btn btn-sm btn-primary">Add New
                            Field/Question
                        </button>
                        <button type="button" @click="createForm" class="btn btn-primary float-end my-3"> Create Form
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {post} from "../../utils/fetchAPI.js";
import {errorToast, successToast} from "../../utils/swalUtil.js";

export default {
    name: "CreateForm",
    data() {
        return {
            feedbackForm: {
                name: '',
                description: '',
                fields: [
                    {label: ''}
                ],
            },
            errors: []
        }
    },
    methods: {
        addDynamicField() {
            this.feedbackForm.fields.push({label: ''})
        },
        removeDynamicField(index) {
            this.feedbackForm.fields.splice(index, 1)
        },
        createForm() {
            if (this.feedbackForm.fields[0]?.label?.length > 0) {
                post('forms', this.feedbackForm).then(res => {
                    this.$router.push('/forms')
                    successToast(res?.data?.message)
                }).catch(errors => {
                    this.setError(errors.response.data.data);
                })
            } else {
                errorToast('The field is required.')
            }


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
