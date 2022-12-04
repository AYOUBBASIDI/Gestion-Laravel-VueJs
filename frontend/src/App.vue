<template>
    <router-view />
</template>
<script>
    export default {

        mounted(){
            if(sessionStorage.getItem("username") === null){
                this.$router.push({name: 'Login'});
            }
        },

        data(){
        return {
        
            form:{
            username: '',
            password: '',
            }
        }
        },

  
}
</script>