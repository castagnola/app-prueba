<template>
    <div class="container">
        <div class="row mt-5">
            <div style="margin-top: 10px" class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-road"></i> Routes List</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-block btn-outline-success" v-on:click="newModal()">Add new
                                <i class="fas fa-road"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Starting</th>
                                <th>Destination</th>
                                <th>Type Route</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="route in routes.data" :key="route.id">
                                <td>{{route.starting_city.city_name}}</td>
                                <td>{{route.destination_city.city_name}}</td>
                                <td>{{route.tipe_route ? 'REGRESO' : 'IDA'}}</td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm"
                                            v-on:click="editModal(route)">
                                        <i class="fa fa-edit blue"></i>
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- pagination --->
                    <div class="card-footer">
                        <pagination :data="routes" @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
            </div>
        </div>
        <!--Modal -->
        <div class="modal fade" id="addRoute" tabindex="-1" role="dialog" aria-labelledby="addRouteLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="!editmode" id="addRouteLabel">Add New <i class="fas fa-road"></i>
                        </h5>
                        <h5 class="modal-title" v-show="editmode" id="addRouteLabel">Update City <i class="fas fa-road"></i></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? update() : create()">
                        <div class="modal-body">
                            <div class="form-group">
                                <select name="departament_id" v-model="form.starting_city_id" id="starting_city_id" v-on:change="onChange($event)"
                                        class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('starting_city_id') }">
                                    <option value="" disabled selected>Select Starting</option>
                                    <option v-for="(city,key) in cities" :value="city.id">
                                        {{city.city_name +' - '+city.departament.departament_name}}
                                    </option>
                                </select>
                                <has-error :form="form" field="departament_id"></has-error>
                            </div>
                            <div class="form-group">
                                <select name="departament_id" v-model="form.destination_city_id"
                                        id="destination_city_id"
                                        class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('destination_city_id') }">
                                    <option value="" disabled selected>Select Destination</option>
                                    <option v-for="(city,key) in cities" :value="city.id">
                                        {{city.city_name +' - '+city.departament.departament_name}}
                                    </option>
                                </select>
                                <has-error :form="form" field="departament_id"></has-error>
                            </div>
                            <div class="form-group">
                                <select name="tipe_route" v-model="form.tipe_route"
                                        id="tipe_route"
                                        class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('tipe_route') }">
                                    <option value="" disabled selected>Select Type of Route</option>
                                    <option v-for="(tipe_route,key) in tipe_routes" :value="key">
                                        {{tipe_routes[key]}}
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
        name: "RoutesComponent",
        data() {
            return {
                editmode: false,
                cities: [],
                tipe_routes: [
                    'IDA',
                    'REGRESO'
                ],
                routes:{},
                form: new Form({
                    id: '',
                    starting_city_id: '',
                    destination_city_id: '',
                    tipe_route: '',
                })

            }

        },
        methods:{
            /**
             * Load paginate owners
             */
            getResults(page = 1) {
                axios.get(`api/get-route-paginate?=page=${page}`)
                    .then(res => {
                        console.log(res.data);
                        this.routes = res.data;
                    })

            },
            /**
             * Show modal to create new routes
             */
            newModal() {
                this.editmode = false;
                this.form.reset();
                this.form.clear();
                $('#addRoute').modal('show');
            },

            /**
             * Load all cities
             */
            loadCities() {
                axios.get(`api/city`)
                    .then((res) => {
                        this.cities = res.data;
                    })
            },

            /**
             * Create a new Route
             */
            create() {
                this.editmode = false;
                this.form.post('api/route')
                    .then((res) => {
                        console.log(res);
                        vm.$emit('afterCreate');
                        $('#addOwners').modal('hide');
                        toast.fire('Success!', res.data.message, 'success');
                    })
                    .catch((error) => {
                        toast.fire('Error!', error.response.message, 'error');
                    })
            },
            /**
             * Update  Owner
             */
            update() {
                this.form.put('api/route/' + this.form.id)
                    .then((res) => {
                        // success
                        $('#addRoute').modal('hide');
                        toast.fire('Updated!', res.data.message, 'success');
                        vm.$emit('afterUpdate', res.data);
                    }).catch((error) => {
                    toast.fire('Error!', error.response.message, 'error')
                });
            },

            /**
             * @param data
             */
            editModal(data) {
                this.editmode = true;
                this.form.reset();
                this.form.clear();
                $('#addRoute').modal('show');
                this.form.fill(data);
            },
           // onChange(event){
             //   console.log(event.target.value);
               // const elem = this.cities.findIndex(itemSearch => itemSearch.id === event.target.value);
                //console.log(elem);
//            }
        },
        created() {
            this.loadCities();
            this.getResults();
            vm.$on('afterCreate', () => {
                this.getResults();
            });
            //event
            vm.$on('afterUpdate', (res) => {
                for (var i = 0; i < this.routes.data.length; i++) {
                    if (this.routes.data[i].id === res.data.id) {
                        this.routes.data[i].destination_city.city_name = res.data.destination_city.city_name;
                        this.routes.data[i].starting_city.city_name = res.data.starting_city.city_name;
                        this.routes.data[i].tipe_route = res.data.tipe_route;
                    }
                }
            })
        },


    }
</script>

<style scoped>

</style>
