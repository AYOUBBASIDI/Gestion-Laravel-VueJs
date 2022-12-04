<template>
    <GuestHeader label="Sign In"></GuestHeader>

    <ParentTransition appear :visibility="true">
        <FormKit type="form" v-model="data" @submit="login_user"
                :submit-attrs="{
                    inputClass: 'hidden',
                }"
                :config="{
                classes: {
                    input: 'focus:ring-0 outline-0 p-2 focus:border-primary dark:focus:border-gray-200 bg-inherit block w-full sm:text-sm border-0 border-b-2 border-gray-300 dark:border-gray-700 dark:text-gray-200',
                    message: 'text-red-500 text-xs',
                },
                }"
                >


                <div class="space-y-6">
            

            <div>
                <BaseLabel>Username</BaseLabel>
                <div class="mt-1">
                    <div>
                        <div class="mt-1">
                            <FormKit
                                type="text"
                                name="username"
                                validation="required"
                            />
                        </div>
                    </div>
                </div>
                <FormError :error="error" />
            </div>
            <div>
                <BaseLabel>Password</BaseLabel>
                <div class="mt-1">
                    <FormKit
                        type="password"
                        name="password"
                        validation="required"
                    />
                </div>
            </div>        
            <div class="flex items-center justify-between">
                <BaseCheckbox name="rememberMe" id="rememberMe" label="Remember Me"></BaseCheckbox>
                <BaseLink to="Password">Forgot Password?</BaseLink>
            </div>
            <BaseButton class="w-full flex justify-center border-none" design="primary" type="submit">
                <FormKit
                type="submit"
                label="Login"
                :classes="{
                    input: 'w-full m-0 p-0',
                }"
            />
            </BaseButton>

            <div class="flex items-center justify-center">
                <BaseLink to="Register">Don't have any account? Register Here</BaseLink>
            </div>
    </div>


        </FormKit>  
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
   
    form:{
      username: '',
      password: '',
    },
    data:null
  }
},
methods:{
    //user login function and api call
    login_user(){

        const options = {
            url: 'http://127.0.0.1:8000/api/v1/login',
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json;charset=UTF-8'
            },
            data: this.data
        };

        axios(options)
        .then(response => {
            console.log(response);
            if(response.status === 200){
                sessionStorage.setItem('id' , response.data.id);
                sessionStorage.setItem('username' , response.data.username);
                sessionStorage.setItem('email' , response.data.email);
                sessionStorage.setItem('name' , response.data.name);
                sessionStorage.setItem('role' , response.data.role);
                this.$router.push({name: 'Dashboard'});
            }
        });

        }
}
  
}
</script>