<script>
    import { Form, Field, ErrorMessage } from 'vee-validate';
    
    const userId = document.querySelector("meta[name='user-id']").getAttribute('content');
    let projectId = '';

    if (document.querySelector("#projectId") != null)
    {
        projectId = document.querySelector("#projectId").innerHTML;
    }

    export default {
        components: {
            Form,
            Field,
            ErrorMessage
        },
        data() {
            return {
                project: {},
            };
        },
        mounted() {
            axios.get(`/${projectId}`).then((response) => {
                this.project = response.data.data;
            })
        },
        methods: {
            isRequired(value) {
                if (value) {
                    return true;
                }
                return 'This is required';
            },
            saveData() {
                axios.put(`/update/${projectId}`, this.project).then(
                    response => {
                        console.log(response);
                        this.project = {
                            'name': "",
                            'startDate': "",
                            'endDate': "",
                            'value': "",
                            'status': "",
                            'user_id': userId,
                        }
                    }
                )
            },
        }
    }
</script>

<template>
    <div class="container">
        <div class="col-6">
            <h1>Edit Project</h1>
        </div>
        <Form @submit="saveData()">
            <div class="modal-body">
                <input type="hidden" name="user_id" v-model="user_id">
                <div class="form-row form-section">
                    <div class="col-12 mb-3">
                        <label class="form-label form-label-top">Project name</label>
                        <Field name="name" type="text" class="form-control" v-model="project.name" :rules="isRequired"/>
                        <ErrorMessage class="text-danger" name="name"/>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label form-label-top">Value</label>
                        <Field name="value" type="number" step="0.01" class="form-control" v-model="project.value" :rules="isRequired"/>
                        <ErrorMessage class="text-danger" name="value"/>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label form-label-top">Start date</label>
                        <Field name="startDate" type="date" class="form-control" v-model="project.startDate" :rules="isRequired"/>
                        <ErrorMessage class="text-danger" name="startDate"/>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label form-label-top">End date</label>
                        <Field name="endDate" type="date" class="form-control" v-model="project.endDate" :rules="isRequired"/>
                        <ErrorMessage class="text-danger" name="endDate"/>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label form-label-top">Status</label>
                        <br>
                        <Field name="status" as="select" v-model="project.status" class="form-select" aria-label="Default select example" :rules="isRequired">
                            <option value="" selected disabled>Select an option</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </Field>
                        <ErrorMessage class="text-danger" name="status"/>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button class="btn btn-primary m-3" type="submit">
                    Submit
                </button>
                <a :href="'/'" class="btn btn-secondary m-3" type="button">
                    Back
                </a>
            </div>
        </Form>
    </div>
</template>