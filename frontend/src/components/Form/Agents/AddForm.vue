<template >
    <div v-if="popup" class="bg-zinc-900/50 top-0 absolute w-full h-full" style="left: 0;margin: 0;">
<div v-if="popup" class="absolute top-0 w-2/5 p-1 bg-white dark:bg-dark-header rounded-2xl flex content-center justify-center pt-5" style="left: 25%; top: 3%;">
    <ParentTransition appear :visibility="true" class="w-4/5">

    <form v-on:submit.prevent="add_Proprietaire">
        <div class="space-y-6 flex flex-col gap-y-2 content-center justify-center py-5">
            
            <h1 class="dark dark:text-gray-400 text-center text-xl font-bold leading-7 sm:text-2xl sm:truncate">Add User</h1>

        <div class="flex w-100 justify-between">
            <div>
                <BaseLabel>Name</BaseLabel>
                <div class="mt-1">
                    <input
                        type="text" 
                        name="name" 
                        v-model="form.name"
                        autofocus 
                        class="focus:ring-0 focus:border-primary dark:focus:border-gray-200 bg-inherit block w-full sm:text-sm border-0 border-b-2 border-gray-300 dark:border-gray-700 dark:text-gray-200"
                    />
                </div>
                <FormError :error="error" />
            </div>
            <div>
               <BaseLabel>Identifiant/Username</BaseLabel>
                <div class="mt-1">
                    <input
                        type="text" 
                        name="username" 
                        v-model="form.username"
                        autofocus 
                        class="focus:ring-0 focus:border-primary dark:focus:border-gray-200 bg-inherit block w-full sm:text-sm border-0 border-b-2 border-gray-300 dark:border-gray-700 dark:text-gray-200"
                    />
                </div>
                <FormError :error="error" />
            </div>


            
        </div> 

        <div class="flex w-100 justify-between">
            <div>
                <BaseLabel>Email</BaseLabel>
                <div class="mt-1">
                    <input
                            type="email" 
                            name="email" 
                            v-model="form.email"
                            autofocus 
                            class="focus:ring-0 focus:border-primary dark:focus:border-gray-200 bg-inherit block w-full sm:text-sm border-0 border-b-2 border-gray-300 dark:border-gray-700 dark:text-gray-200"
                        />
                </div>
                <FormError :error="error" />
            </div>
            
            <div style="width: 47%;">
                <BaseLabel>Role</BaseLabel>
                <div class="mt-1">
                    <select 
                    class="focus:ring-0 focus:border-primary dark:focus:border-gray-200 bg-inherit block w-full sm:text-sm border-0 border-b-2 border-gray-300 dark:border-gray-700 dark:text-gray-200"
                    name="role"
                    v-model="form.role"
                    >
                        <option v-for="item in roles" :value='item' >{{item}}</option>
                    </select>
                </div>
                <FormError :error="error" />
            </div>
            

        </div> 

        <div class="flex w-100 justify-between">


                    <div style="width: 47%;">
                       <BaseLabel>Password</BaseLabel>
                        <div class="mt-1">
                            <input
                                type="password" 
                                name="password" 
                                v-model="form.password"
                                autofocus 
                                class="focus:ring-0 focus:border-primary dark:focus:border-gray-200 bg-inherit block w-full sm:text-sm border-0 border-b-2 border-gray-300 dark:border-gray-700 dark:text-gray-200"
                            />
                        </div>
                        <FormError :error="error" /> 
                    </div>

                    <div>
                        <BaseLabel>Password Confirmation</BaseLabel>
                        <div class="mt-1">
                            <input
                                type="password" 
                                name="password_confirmation" 
                                v-model="form.password_confirmation"
                                autofocus 
                                class="focus:ring-0 focus:border-primary dark:focus:border-gray-200 bg-inherit block w-full sm:text-sm border-0 border-b-2 border-gray-300 dark:border-gray-700 dark:text-gray-200"
                            />
                        </div>
                        <FormError :error="error" />
                    </div>                    
                </div> 

        <BaseButton block>Save</BaseButton>

</div>
    </form>
    </ParentTransition>
    <div v-on:click="closePopup()" class="dark h-0 dark:text-gray-400 cursor-pointer">
        <i class="fa-solid fa-xmark"></i>
    </div>
</div>
</div>
</template>

<script>
import axios from 'axios';
export default {
name: 'Pracelle',

data(){
return{
    popup : true,
    form: {
        name : null,
        username : null,
        email : null,
        role : null,
        password : null,
        password_confirmation : null
    },
    roles:["Agent","Admin"]
}
},

mounted(){

},

methods:{
closePopup(){
    this.popup = false
    this.$router.go();
},

add_Proprietaire(){
    const options = {
        url: 'http://127.0.0.1:8000/api/v1/register',
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json;charset=UTF-8'
        },
        data: this.form
    };

    axios(options)
    .then(response => {
        this.$router.go();
    }).catch((error) => {
        var message = Object.values(error.response.data.message)[0][0];
        alert(message);
    });
}
}
}
</script>