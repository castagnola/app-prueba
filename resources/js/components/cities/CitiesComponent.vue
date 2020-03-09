<template>
    <div class="container">
        <div class="row mt-5">
            <div style="margin-top: 10px" class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-city"></i> Cities List</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-block btn-outline-success"
                                    v-on:click="newModal()">Add
                                new
                                <i class="fas fa-city"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>City Name</th>
                                <th>Departament</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="city in cities.data" :key="city.id">
                                <td>{{city.city_name}}</td>
                                <td>{{city.departament.departament_name}}</td>
                                <td>{{city.status === 1 ? 'Activo' : 'Desactivo'}}</td>
                                <td>
                                    <button v-if="city.status" type="button" class="btn btn-primary btn-sm"
                                            v-on:click="editModal(city)">
                                        <i class="fa fa-edit blue"></i>
                                    </button>
                                    <button v-if="city.status" type="button" class="btn btn-danger btn-sm"
                                            v-on:click="deleteCity(city.id)">
                                        <i class="fa fa-trash red"></i>
                                    </button>
                                    <button v-if="!city.status" type="button" class="btn btn-warning btn-sm"
                                            v-on:click="activeCity(city.id)">
                                        <i class="fas fa-exclamation"></i>
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- pagination --->
                    <div class="card-footer">
                        <pagination :data="cities" @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
            </div>
        </div>

        <!--Modal -->
        <div class="modal fade" id="addOwners" tabindex="-1" role="dialog" aria-labelledby="addOwnersLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="!editmode" id="addOwnersLabel">Add New <i
                            class="fas fa-city"></i>
                        </h5>
                        <h5 class="modal-title" v-show="editmode" id="addOwnersLabel">Update City <i
                            class="fas fa-city"></i></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? update() : create()">
                        <div class="modal-body">
                            <div class="form-group">
                                <input v-model="form.city_name" type="text" name="city_name"
                                       placeholder="City Name"
                                       class="form-control"
                                       :class="{ 'is-invalid': form.errors.has('city_name') }">
                                <has-error :form="form" field="city_name"></has-error>
                            </div>
                            <div class="form-group">
                                <select name="departament_id" v-model="form.departament_id" id="departament_id"
                                        class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('departament_id') }">
                                    <option value="" disabled selected>Select Departament</option>
                                    <option v-for="(departament,key) in departaments" :value="departament.id">
                                        {{departament.departament_name}}
                                    </option>
                                </select>
                                <has-error :form="form" field="departament_id"></has-error>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i
                                class="fas fa-times"></i></button>

                            <button v-show="editmode" type="submit" class="btn btn-success">Save <i
                                class="fas fa-check"></i></button>
                            <button v-show="!editmode" type="submit" class="btn btn-success">Create <i
                                class="fas fa-plus"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "CitiesComponent",
        data() {
            return {
                cities: {},
                departaments: [],
                editmode: false,
                form: new Form({
                    id: '',
                    city_name: '',
                    departament_id: '',
                    departament: [],
                    status: ''
                })
            }
        },

        methods: {
            getResults(page = 1) {
                axios.get('api/get-city-paginate?page=' + page)
                    .then(response => {
                        this.cities = response.data;
                    });
            },

            /**
             * Load all Departments
             */
            loadDepartaments() {
                axios.get(`api/department`).then((res) => {
                    this.departaments = res.data
                })

            },

            /**
             * Show modal to create new city
             */
            newModal() {
                this.editmode = false;
                this.form.reset();
                this.form.clear();
                $('#addOwners').modal('show');
            },

            /**
             * Create a new City
             */
            create() {
                this.editmode = false;
                this.form.post('api/city')
                    .then((res) => {
                        console.log(res);
                        vm.$emit('afterCreate');
                        $('#addOwners').modal('hide')
                        toast.fire('Success!', res.data.message, 'success');
                    })
                    .catch(() => {
                        toast.fire('Uops!', 'Complete all fields!', 'warning');
                    })
            },

            /**
             * Update  City
             */
            update() {
                this.form.put('api/city/' + this.form.id)
                    .then((res) => {
                        // success
                        $('#addOwners').modal('hide');
                        toast.fire('Updated!', res.data.message, 'success');
                        vm.$emit('afterUpdate', res.data);
                    }).catch((error) => {
                    toast.fire('Error!', error.response.data.message, 'error')
                });
            },

            /**
             * Delete City
             * @param id
             */
            deleteCity(id) {
                swal.fire({
                    title: 'Do you want to continue?',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Delete',
                    reverseButtons: true
                }).then((result) => {
                    // Send request to the server
                    if (result.value) {
                        this.form.delete('api/city/' + id).then((res) => {
                            toast.fire('Success!', res.data.message, 'success');
                            console.log(res);
                            vm.$emit('afterUpdate', res.data);
                        }).catch((error) => {
                            console.log(error.response.data);
                            toast.fire('Error!', error.response.data.message, 'error');
                        });
                    }
                })
            },

            /**
             * Active de row of city
             * @param id
             */
            activeCity(id) {
                swal.fire({
                    title: 'Do you want to continue?',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Confirm',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        axios.get(`api/city/${id}/edit`)
                            .then((res) => {
                                // toast.fire('Actived!', 'City: ' + res.data.city_name.toUpperCase() + ' has been actived.', 'success')
                                toast.fire('Actived!', res.data.message, 'success')
                                vm.$emit('afterUpdate', res.data);
                            }).catch((error) => {
                            toast.fire('Error!', error.response.message, 'error')
                        });
                    }
                });
            },

            /**
             * Show and complete city info
             * @param data
             */
            editModal(data) {
                this.editmode = true;
                this.form.reset();
                this.form.clear();
                $('#addOwners').modal('show');
                this.form.fill(data);
            },

            /**
             * Show modal to create new city
             */
            newModal() {
                this.editmode = false;
                this.form.reset();
                this.form.clear();
                $('#addOwners').modal('show');
            },
        },

        /**
         * Methods first charge
         */
        created() {
            this.getResults();
            this.loadDepartaments();
            //event

            vm.$on('afterCreate', () => {
                this.getResults();
            });
            vm.$on('afterUpdate', (res) => {
                console.log(res.data);
                for (var i = 0; i < this.cities.data.length; i++) {
                    if (this.cities.data[i].id === res.data.id) {
                        this.cities.data[i].city_name = res.data.city_name;
                        this.cities.data[i].departament.departament_name = res.data.departament.departament_name;
                        this.cities.data[i].status = res.data.status;
                        break;
                    }
                }
            })
        }


    }
</script>

<style scoped>

</style>
