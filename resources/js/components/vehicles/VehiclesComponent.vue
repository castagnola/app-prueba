<template>
    <div class="container">
        <div class="row mt-5">
            <div style="margin-top: 10px" class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-car"></i> Vehicles List</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-block btn-outline-success"
                                    v-on:click="newModal()">Add
                                new
                                <i class="fas fa-car"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Placa</th>
                                <th>Color</th>
                                <th>Brand</th>
                                <th>Tipe Vehicle</th>
                                <th>Owner</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="vehicle in vehicles.data" :key="vehicle.id">
                                <td>{{vehicle.placa}}</td>
                                <td>{{vehicle.color}}</td>
                                <td>{{vehicle.brand}}</td>
                                <td>{{vehicle.tipe_vehicle.description}}</td>
                                <td>{{vehicle.owner.identification_number}}</td>
                                <td>{{vehicle.status === 1 ? 'Activo' : 'Desactivo'}}</td>
                                <td>
                                    <button v-if="vehicle.status" type="button" class="btn btn-primary btn-sm"
                                            v-on:click="editModal(vehicle)">
                                        <i class="fa fa-edit blue"></i>
                                    </button>
                                    <button v-if="vehicle.status"type="button" class="btn btn-danger btn-sm"
                                            v-on:click="deleteVehicle(vehicle.id)">
                                        <i class="fa fa-trash red"></i>
                                    </button>
                                    <button v-if="!vehicle.status" type="button" class="btn btn-warning btn-sm"
                                            v-on:click="activeVehicle(vehicle.id)">
                                        <i class="fas fa-exclamation"></i>
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- pagination --->
                    <div class="card-footer">
                        <pagination :data="vehicles" @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="addUserLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="!editmode" id="addUserLabel">Add New <i class="fas fa-user"></i>
                        </h5>
                        <h5 class="modal-title" v-show="editmode" id="addUserLabel">Update User <i
                                class="fas fa-user"></i></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? update() : create()">
                        <div class="modal-body">
                            <div class="form-group">
                                <input v-model="form.placa" type="text" name="placa"
                                       placeholder="Placa"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('placa') }">
                                <has-error :form="form" field="placa"></has-error>
                            </div>
                            <div class="form-group">
                                <input v-model="form.color" type="text" name="color"
                                       placeholder="Color"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('color') }">
                                <has-error :form="form" field="color"></has-error>
                            </div>

                            <div class="form-group">
                                <input v-model="form.brand" type="text" name="brand"
                                       placeholder="Brand"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('brand') }">
                                <has-error :form="form" field="brand"></has-error>
                            </div>
                            <div class="form-group">
                                <select name="tipe_id" v-model="form.tipe_id" id="tipe_id" class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('tipe_id') }">
                                    <option value="" disabled selected>Select Type Vehicle</option>
                                    <option v-for="(tipe,key) in tipes" :value="tipe.id">
                                        {{tipe.description}}
                                    </option>
                                </select>
                                <has-error :form="form" field="tipe_id"></has-error>
                            </div>

                            <div class="form-group">
                                <select name="role_id" v-model="form.owner_id" id="owner_id" class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('owner_id') }">
                                    <option value="" disabled selected>Select Owner</option>
                                    <option v-for="(owner,key) in owners" :value="owner.id">
                                        {{owner.identification_number +' - '+owner.first_name +' '+ owner.last_name}}
                                    </option>
                                </select>
                                <has-error :form="form" field="owner_id"></has-error>
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
        name: "VehiclesComponent",
        data() {
            return {

                editmode: false,
                vehicles: {},
                owners: [],
                tipes: [],
                form: new Form({
                    id: '',
                    color: '',
                    placa: '',
                    brand: '',
                    tipe_vehicle: '',
                    owner_id: '',
                    tipe_id: '',
                })
            }
        },
        methods: {
            /**
             * Load paginate vehicles
             */
            getResults(page = 1) {
                axios.get(`api/get-vehicle-paginate?=page=${page}`)
                    .then(res => {
                        this.vehicles = res.data;
                    })

            },
            /**
             *Create user
             */
            create() {
                this.editmode = false;
                this.form.post('api/vehicle')
                    .then((res) => {
                        vm.$emit('afterCreate');
                        $('#addUser').modal('hide');
                        toast.fire('Success!', res.data.message, 'success');
                    })
                    .catch((error) => {
                        toast.fire('Uops!', error.response.message, 'warning');
                    })
            },

            /**
             * update informatio vehicle
             */
            update() {
                console.log(this.form);
                // console.log('Editing data');
                this.form.put('api/vehicle/' + this.form.id)
                    .then((res) => {
                        // success
                        $('#addUser').modal('hide');
                        toast.fire('Updated!', res.data.message, 'success');
                        vm.$emit('afterUpdate', res.data);
                    })
                    .catch((error) => {
                        toast.fire('Error!', error.response.message, 'error')
                    });
            },

            /**
             * Change status user
             * @param id
             */
            deleteVehicle(id) {
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
                        this.form.delete('api/vehicle/' + id).then((res) => {
                            toast.fire('Success!', res.data.message, 'success');
                            vm.$emit('afterUpdate', res.data);
                        }).catch((error) => {
                            toast.fire('Error!', error.response.data.message, 'error');
                        });
                    }
                })
            },

            /**
             *Active status of driver
             */
            activeVehicle(id) {
                swal.fire({
                    title: 'Do you want to continue?',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Confirm',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        axios.get(`api/vehicle/${id}/edit`)
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
             * Show and complete user info
             * @param user
             */
            editModal(user) {
                this.editmode = true;
                this.form.reset();
                this.form.clear();
                $('#addUser').modal('show');
                this.form.fill(user);
            },

            /**
             * Show modal to create new user
             */
            newModal() {
                this.editmode = false;
                this.form.reset();
                this.form.clear();
                $('#addUser').modal('show');
            },

            /**
             * Show all Vehicles
             */
            loadVehicles() {
                axios.get(`api/tipe-vehicles`)
                    .then((res) => {
                        this.tipes = res.data
                    })

            },

            /**
             * Load all owners
             */
            loadOwners() {
                axios.get(`api/owners`)
                    .then((res) => {
                        this.owners = res.data
                    })
            },
        },

        /**
         * Methods first charge
         */
        created() {
            this.getResults();
            this.loadVehicles();
            this.loadOwners();
            vm.$on('afterCreate', () => {
                this.loadVehicles();
            });
            //event
            vm.$on('afterUpdate', (res) => {
                // const index = this.vehicles.findIndex(itemSearch => itemSearch.id === res.data.id);
                // this.vehicles[index].color = res.data.color;
                // this.vehicles[index].placa = res.data.placa;
                for (var i = 0; i < this.vehicles.data.length; i++) {
                    if (this.vehicles.data[i].id === res.data.id) {
                        this.vehicles.data[i].color = res.data.color;
                        this.vehicles.data[i].placa = res.data.placa;
                        this.vehicles.data[i].tipe_vehicle.description = res.data.tipe_vehicle.description;
                        this.vehicles.data[i].owner.identification_number = res.data.owner.identification_number;
                        this.vehicles.data[i].status = res.data.status;
                        break;
                    }
                }
            })
        }
    }
</script>
<style scoped>

</style>
