<script>
    import { Form, Field, ErrorMessage } from 'vee-validate';
    import { ref } from "vue";
    
    const userId = document.querySelector("meta[name='user-id']").getAttribute('content');
    
    const currentPage = ref(1);
    const totalPages = ref();
    const itemsPerPages = ref();
    const list_of_projects = ref([]);
    
    const getProjects = (currentPage) => {
        axios.get(`/list?page=${currentPage}`).then((response) => {
                list_of_projects.value = response.data.data.data;
                totalPages.value = response.data.data.total;
                itemsPerPages.value = response.data.data.per_page;
            })
    };

    export default {
        components: {
            Form,
            Field,
            ErrorMessage,

        },
        data() {
            return {
                'project': {
                    'name': "",
                    'startDate': "",
                    'endDate': "",
                    'value': "",
                    'status': "",
                    'user_id': userId,
                },
                list_of_projects,
                currentPage,
                getProjects,
                totalPages,
                itemsPerPages
            };
        },

        mounted() {
            getProjects();
        }, 

        methods: {
            isRequired(value) {
                if (value) {
                    return true;
                }
                return 'This is required';
            },
            saveData() {
                axios.post('/store', this.project).then(
                    response => {
                        console.log(response);
                        this.list_of_projects.push(response.data.data);
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

<style>
.example-one .pagination-container {
  column-gap: 10px;
}
.example-one .paginate-buttons {
  height: 40px;
  width: 40px;
  border-radius: 20px;
  cursor: pointer;
  background-color: rgb(242, 242, 242);
  border: 1px solid rgb(217, 217, 217);
  color: black;
}
.example-one .paginate-buttons:hover {
  background-color: #d8d8d8;
}
.example-one .active-page {
  background-color: #3498db;
  border: 1px solid #3498db;
  color: white;
}
.example-one .active-page:hover {
  background-color: #2988c8;
}
.example-one .back-button:active,
.example-one .next-button:active {
  background-color: #c4c4c4;
}
</style>

<template>
    <div class="container">
        <div class="row pt-4">
            <div class="col-6">
                <h1>Projects</h1>
            </div>
            <div class="col-6 text-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    New
                </button>
            </div>
        </div>
        <br>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add project</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <Form @submit="saveData()">
                        <div class="modal-body">
                            <input type="hidden" name="user_id" v-model="user_id">
                            <div class="form-row form-section">
                                <div class="col-12 mb-3">
                                    <label class="form-label form-label-top">Project name</label>
                                    <Field name="name" type="text" class="form-control" v-model="project.name" placeholder="Project Name" :rules="isRequired"/>
                                    <ErrorMessage class="text-danger" name="name"/>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label form-label-top">Value</label>
                                    <Field name="value" type="number" step="0.01" class="form-control" v-model="project.value" placeholder="250" :rules="isRequired"/>
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
                            <button class="btn btn-primary" type="submit">
                                Submit
                            </button>
                        </div>
                    </Form>
                </div>
            </div>
        </div>
        <table class="table table-responsive table-bordered text-center">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Value</th>
                    <th scope="col">Start Date</th>
                    <th scope="col">End Date</th>
                    <th scope="col">Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody v-if="list_of_projects.length > 0">
                <tr v-for="project in list_of_projects">
                    <th scope="row">{{ project.name }}</th>
                    <td>{{ project.value }}</td>
                    <td>{{ project.startDate }}</td>
                    <td>{{ project.endDate }}</td>
                    <td>{{ project.status }}</td>
                    <td>
                        <a :href="'edit/' + project.id" class="btn btn-primary m-2">Edit</a>
                        <a :href="'delete/' + project.id" class="btn btn-danger m-2">Delete</a>
                    </td>
                </tr>
            </tbody>
            <tbody v-else class="table-group-divider">
                <td colspan="6" class="text-center p-3">Projects not found...</td>
            </tbody>
        </table>
        <div class="example-one d-flex justify-content-center">
            <vue-awesome-paginate
            :total-items="totalPages"
            :items-per-page="itemsPerPages"
            v-model="currentPage"
            :on-click="getProjects"
            />
        </div>
    </div>
</template>