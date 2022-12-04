<template>
    <GuestHeader label="Create an Account"></GuestHeader>

    <ParentTransition appear :visibility="true">
        <form v-on:submit.prevent="register_user">
        <div class="space-y-6">
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
               <BaseLabel>Username</BaseLabel>
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

            <div>
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

            <div>
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

            <BaseButton type="submit" block>Register</BaseButton>

            <div class="flex items-center justify-center">
                <BaseLink to="Login">Back to Login</BaseLink>
            </div>
        </div>
    </form>
    </ParentTransition>
</template>

<script setup>
import { useRouter } from "vue-router"

const router = useRouter()
</script>

<script>
import axios from 'axios';

export default {
  data(){
  return {
   
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
methods:{
    //user login function and api call
    register_user(){

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
            console.log(response);
            if(response.status === 200){
                this.$router.push({name: 'Login'});
            }
        });

        }
}
  
}
</script>