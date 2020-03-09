<template>
<div class="container">
    <h1>Roles view component: {{$route.params.id}}</h1>
<!--    <h1>Roles view component</h1>-->
</div>
</template>

<script>
    export default {
        name:'roles-view-component',
        data(){
          return {
              role:{}
          }
        },

    }
</script>

<style scoped>

</style>
