import VueRouter from 'vue-router';
import Vue from 'vue'

Vue.use(VueRouter)

export default new VueRouter({
    routes: [
        {
            path: '/',
            component: require('./components/DashboardComponent').default
        },
        {
            path: '/dashboard',
            component: require('./components/DashboardComponent').default
        },
        {
            path: '/users',
            component: require('./components/users/UsersComponent').default
        },
        {
            path: '/drivers/:id',
            name: 'driverView',
            component: require('./components/drivers/DriversViewComponent.vue').default,
            props: true
        },
        {
            path: '/roles',
            component: require('./components/roles/RolesComponent').default
        },
        {
            path: '/profile',
            component: require('./components/profile/ProfileComponent').default
        },
        {
            path: '/drivers',
            component: require('./components/drivers/DriversComponent').default
        },
        {
            path: '/owners',
            component: require('./components/owners/OwnersComponent').default
        },
        {
            path:'/owner/:id',
            name:'ownerView',
            component: require('./components/owners/OwnersViewComponent').default

        },
        {
            path: '/vehicles',
            component: require('./components/vehicles/VehiclesComponent').default
        },

        {
            path: '/cities',
            component: require('./components/cities/CitiesComponent').default
        },
        {
          path:'/routes',
          component: require('./components/routes/RoutesComponent').default
        },
        {
            path: '*',
            component: require('./views/404').default,
        },
    ],
    // mode: 'history' //evita que aparezca #/ en las rutas
})

