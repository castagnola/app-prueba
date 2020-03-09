<template>
    <div class="container">
        <div class="card">
            <div class="card-header text-white bg-dark"><span><i class="fas fa-user-tie"></i> Owner Information</span>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-4 col-form-label">
                            <input type="text" class="form-control"
                                   v-model="owner.first_name +'   '+ owner.second_name" readonly>
                        </div>
                        <label class="col-sm-2 col-form-label">Last Name</label>
                        <div class="col-sm-4 col-form-label">
                            <input type="text" class="form-control" v-model="owner.last_name" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Identification</label>
                        <div class="col-sm-4 col-form-label">
                            <input type="text" class="form-control" v-model="owner.identification_number" readonly>
                        </div>
                        <label class="col-sm-2 col-form-label">Address</label>
                        <div class="col-sm-4 col-form-label">
                            <input type="text" class="form-control" v-model="owner.address" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Phone number</label>
                        <div class="col-sm-4 col-form-label">
                            <input type="text" class="form-control" v-model="owner.phone_number" readonly>
                        </div>
                        <label class="col-sm-2 col-form-label">City</label>
                        <div class="col-sm-4 col-form-label">
                            <input type="text" class="form-control" v-model="owner.city.city_name" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div  v-if="owner.vehicle.length > 0" v-for="(vehicle, index) in owner.vehicle">
                <div class="card-header text-white bg-dark"><span> <i class="fas fa-car"></i> Vehicle Information {{index +1}}</span>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Placa</label>
                            <div class="col-sm-4 col-form-label">
                                <input type="text" class="form-control"
                                       v-model="vehicle.placa" readonly>
                            </div>
                            <label class="col-sm-2 col-form-label">Brand</label>
                            <div class="col-sm-4 col-form-label">
                                <input type="text" class="form-control" v-model="vehicle.brand" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Color</label>
                            <div class="col-sm-4 col-form-label">
                                <input type="text" class="form-control"
                                       v-model="vehicle.color" readonly>
                            </div>
                            <label class="col-sm-2 col-form-label">Tipe of Vehicle</label>
                            <div class="col-sm-4 col-form-label">
                                <input type="text" class="form-control" v-model="vehicle.tipe_vehicle.description" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer bg-transparent border-dark">
                <button type="button" class="btn btn-primary" v-on:click="$router.go(-1)"><i
                    class="fas fa-arrow-circle-left"></i> Back
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "OwnersViewComponent",
        created() {
            this.loadViewOwner();

        },
        data(){
            return {
                owner: [],
            }
        },
        methods:{
        loadViewOwner(){
                let id = this.$route.params.id;
                axios.get(`api/owners/${id}`).then((res) => {
                    this.owner = res.data;
                })
            }
        }
    }
</script>

<style scoped>

</style>
