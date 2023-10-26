<script>
    import { Form, Field } from 'vee-validate';
    
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
            removeData() {
                axios.delete(`/delete/${projectId}`, this.project).then(
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
            <h1>Delete Project</h1>
        </div>
        <Form @submit="removeData()">
            <div class="modal-body">
                <input type="hidden" name="user_id" v-model="user_id">
                <div class="form-row form-section">
                    <div class="col-12 mb-3">
                        <label class="form-label form-label-top">Project name</label>
                        <Field name="name" type="text" class="form-control" v-model="project.name" disabled/>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label form-label-top">Value</label>
                        <Field name="value" type="number" step="0.01" class="form-control" v-model="project.value" disabled/>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label form-label-top">Start date</label>
                        <Field name="startDate" type="date" class="form-control" v-model="project.startDate" disabled/>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label form-label-top">End date</label>
                        <Field name="endDate" type="date" class="form-control" v-model="project.endDate" disabled/>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label form-label-top">Status</label>
                        <br>
                        <Field name="status" as="select" v-model="project.status" class="form-select" aria-label="Default select example" disabled>
                            <option value="" selected disabled>Select an option</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </Field>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button class="btn btn-danger m-3" type="submit">
                    Delete
                </button>
                <a :href="'/'" class="btn btn-secondary m-3" type="button">
                    Back
                </a>
            </div>
        </Form>
    </div>
</template>