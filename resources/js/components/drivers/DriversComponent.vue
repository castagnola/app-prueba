<template>
    <div class="container">
        <div class="row mt-5">
            <div style="margin-top: 10px" class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-user-alt-slash"></i> Driver List</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-block btn-outline-success"
                                    v-on:click="newModal()">Add new
                                <i class="fas fa-user-plus"></i>
                            </button>
                        </div>
                        <div class="card-tools" style="margin-right:10px">
                            <button type="button" class="btn btn-block btn-danger"
                                    v-on:click="downloadPdf()">
                                <i class="fas fa-file-pdf"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Identification Number</th>
                                <th>First Name</th>
                                <th>Last name</th>
                                <th>City</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="driver in drivers.data" :key="driver.id">
                                <td>{{driver.identification_number}}</td>
                                <td>{{driver.first_name}}</td>
                                <td>{{driver.last_name}}</td>
                                <td>{{driver.city.city_name}}</td>
                                <td>{{driver.status === 1 ? 'Activo' : 'Desactivo'}}</td>
                                <td>
                                    <button v-if="driver.status" type="button" class="btn btn-primary btn-sm"
                                            v-on:click="editModal(driver)">
                                        <i class="fa fa-edit blue"></i>
                                    </button>
                                    <button v-if="driver.status" type="button" class="btn btn-danger btn-sm"
                                            v-on:click="deleteDriver(driver.id)">
                                        <i class="fa fa-trash red"></i>
                                    </button>
                                    <button v-if="!driver.status" type="button" class="btn btn-warning btn-sm"
                                            v-on:click="activeDriver(driver.id)">
                                        <i class="fas fa-exclamation"></i>
                                    </button>
                                    <router-link :to="{name:'driverView',params:{id:driver.id}}">
                                        <button v-if="driver.status" type="button" class="btn btn-success btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </router-link>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- pagination --->
                    <div class="card-footer">
                        <pagination :data="drivers" @pagination-change-page="getResults"></pagination>
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
                            class="fas fa-user"></i>
                        </h5>
                        <h5 class="modal-title" v-show="editmode" id="addOwnersLabel">Update Owner <i
                            class="fas fa-user"></i></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? update() : create()">
                        <div class="modal-body">
                            <div class="form-group">
                                <input v-model="form.identification_number" type="text" name="identification_number"
                                       placeholder="Identification"
                                       class="form-control"
                                       :class="{ 'is-invalid': form.errors.has('identification_number') }">
                                <has-error :form="form" field="identification_number"></has-error>
                            </div>

                            <div class="form-group">
                                <input v-model="form.first_name" type="text" name="first_name"
                                       placeholder="First Name"
                                       class="form-control"
                                       :class="{ 'is-invalid': form.errors.has('first_name') }">
                                <has-error :form="form" field="first_name"></has-error>
                            </div>

                            <div class="form-group">
                                <input v-model="form.second_name" type="text" name="second_name"
                                       placeholder="Second name"
                                       class="form-control"
                                       :class="{ 'is-invalid': form.errors.has('second_name') }">
                                <has-error :form="form" field="second_name"></has-error>
                            </div>

                            <div class="form-group">
                                <input v-model="form.last_name" type="text" name="last_name"
                                       placeholder="Last name"
                                       class="form-control"
                                       :class="{ 'is-invalid': form.errors.has('last_name') }">
                                <has-error :form="form" field="last_name"></has-error>
                            </div>

                            <div class="form-group">
                                <input v-model="form.address" type="text" name="address"
                                       placeholder="address"
                                       class="form-control"
                                       :class="{ 'is-invalid': form.errors.has('address') }">
                                <has-error :form="form" field="address"></has-error>
                            </div>
                            <div class="form-group">
                                <input v-model="form.phone_number" type="text" name="phone_number"
                                       placeholder="Phone number"
                                       class="form-control"
                                       :class="{ 'is-invalid': form.errors.has('phone_number') }">
                                <has-error :form="form" field="phone_number"></has-error>
                            </div>

                            <div class="form-group">
                                <select name="city_id" v-model="form.city_id" id="city_id" class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('city_id') }">
                                    <option value="" disabled selected>Select City</option>
                                    <option v-for="(city,key) in cities" :value="city.id">
                                        {{city.city_name}}
                                    </option>
                                </select>
                                <has-error :form="form" field="city_id"></has-error>
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
    import driversViewComponent from '../drivers/DriversViewComponent'

    export default {
        name: "DriversComponent",
        components: {
            driversViewComponent
        },
        data() {
            return {
                drivers: {},
                cities: [],
                editmode: false,
                form: new Form({
                    id: '',
                    identification_number: '',
                    first_name: '',
                    second_name: '',
                    last_name: '',
                    address: '',
                    phone_number: '',
                    city_id: '',
                    city: [],
                })
            }
        },
        methods: {
            async downloadPdf() {
                axios({
                    url: '/driver-pdf',
                    method: 'GET',
                    responseType: 'blob', // important
                }).then((response) => {
                    const url = window.URL.createObjectURL(new Blob([response.data]));
                    const link = document.createElement('a');
                    link.href = url;
                    link.setAttribute('download', 'drivers.pdf');
                    document.body.appendChild(link);
                    link.click();
                });
            },
            /**
             * Load Paginate drivers
             */
            getResults(page = 1) {
                axios.get(`api/get-driver-paginate?=page=${page}`)
                    .then((res) => {
                        this.drivers = res.data
                    });
            },
            /**
             * Load all cities
             */
            loadCities() {
                axios.get(`api/city`)
                    .then((res) => {
                        this.cities = res.data
                    })
            },

            /**
             * Show modal to create new driver
             */
            newModal() {
                this.editmode = false;
                this.form.reset();
                this.form.clear();
                $('#addOwners').modal('show');
            },

            /**
             * Create a new Owner
             */
            create() {
                this.editmode = false;
                this.form.post('api/drivers')
                    .then((res) => {
                        this.getResults();
                        $('#addOwners').modal('hide')
                        toast.fire('Success!', res.data.message, 'success');
                    })
                    .catch((error) => {
                        toast.fire('Uops!', error.response.message, 'warning');
                    })
            },

            /**
             * Update  Driver
             */
            update() {
                this.form.put('api/drivers/' + this.form.id)
                    .then((res) => {
                        $('#addOwners').modal('hide');
                        toast.fire('Updated!', res.data.message, 'success');
                        vm.$emit('afterUpdate', res.data);
                    }).catch((error) => {
                    toast.fire('Error!', error.response.message, 'error')
                });
            },

            /**
             * Delete Driver
             * @param id
             */
            deleteDriver(id) {
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
                        this.form.delete(`api/drivers/${id}`)
                            .then((res) => {
                                toast.fire('Success!', res.data.message, 'success');
                                vm.$emit('afterUpdate', res.data);
                            }).catch(error => {
                            toast.fire('Error!', error.response.data.message, 'error');
                        });
                    }
                })
            },

            /**
             *Active status of driver
             */
            activeDriver(id) {
                swal.fire({
                    title: 'Do you want to continue?',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Confirm',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        axios.get(`api/drivers/${id}/edit`)
                            .then((res) => {
                                toast.fire('Success', res.data.message, 'success');
                                vm.$emit('afterUpdate', res.data);
                            }).catch((error) => {
                            toast.fire('Error!', error.response.message, 'error')
                        })
                    }
                })
            },

            /**
             * Show and complete driver info
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
             * Show modal to create new driver
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
            this.loadCities();
            //event
            vm.$on('afterUpdate', (res) => {
                for (var i = 0; i < this.drivers.data.length; i++) {
                    if (this.drivers.data[i].id === res.data.id) {
                        this.drivers.data[i].identification_number = res.data.identification_number;
                        this.drivers.data[i].first_name = res.data.first_name;
                        this.drivers.data[i].last_name = res.data.last_name;
                        this.drivers.data[i].phone_number = res.data.phone_number;
                        this.drivers.data[i].second_name = res.data.second_name;
                        this.drivers.data[i].address = res.data.address;
                        this.drivers.data[i].status = res.data.status;
                        this.drivers.data[i].city.city_name = res.data.city.city_name;
                        break;
                    }
                }

            })
        }

    }
</script>

<style scoped>

</style>
