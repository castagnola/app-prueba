<template>
    <div class="container">
        <div class="card">
            <div class="card-header text-white bg-dark"><span><i
                class="fas fa-user-alt-slash"></i> Driver Information</span></div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-4 col-form-label">
                            <input type="text" class="form-control"
                                   v-model="driver.first_name +'   '+ driver.second_name" readonly>
                        </div>
                        <label class="col-sm-2 col-form-label">Last Name</label>
                        <div class="col-sm-4 col-form-label">
                            <input type="text" class="form-control" v-model="driver.last_name" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Identification</label>
                        <div class="col-sm-4 col-form-label">
                            <input type="text" class="form-control" v-model="driver.identification_number" readonly>
                        </div>
                        <label class="col-sm-2 col-form-label">Address</label>
                        <div class="col-sm-4 col-form-label">
                            <input type="text" class="form-control" v-model="driver.address" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Phone number</label>
                        <div class="col-sm-4 col-form-label">
                            <input type="text" class="form-control" v-model="driver.phone_number" readonly>
                        </div>
                        <label class="col-sm-2 col-form-label">City</label>
                        <div class="col-sm-4 col-form-label">
                            <input type="text" class="form-control" v-model="driver.city.city_name" readonly>
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
        name: "DriversViewComponent",
        created() {
            this.loadViewDriver();
        },
        data() {
            return {
                driver: [],
            }
        },
        methods: {
            loadViewDriver() {
                console.log(this.$router);
                let id = this.$route.params.id
                axios.get(`api/drivers/${id}`).then((res) => {
                    this.driver = res.data;
                })

            },
        },

    }
</script>

<style scoped>

</style>
