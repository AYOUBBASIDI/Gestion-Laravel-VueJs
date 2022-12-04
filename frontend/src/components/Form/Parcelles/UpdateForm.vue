<template >
    <div v-if="popup" class="bg-zinc-900/50 absolute w-full h-full" style="left: 0;margin: 0;">
<div v-if="popup" class="absolute top-0 w-2/5 p-1 bg-white dark:bg-dark-header rounded-2xl flex content-center justify-center pt-5" style="left: 25%; top: 3%;">
    <ParentTransition appear :visibility="true" class="w-4/5">

    <form v-on:submit.prevent="update_Parcelle(id)">
        <div class="space-y-6 flex flex-col gap-y-2 content-center justify-center py-5">
            
            <h1 class="dark dark:text-gray-400 text-center text-xl font-bold leading-7 sm:text-2xl sm:truncate">Update Parcelle {{id}}</h1>

        <div class="flex w-100 justify-between">
            <div>
                <BaseLabel>Numéro</BaseLabel>
                <div class="mt-1">
                    <input
                        type="number" 
                        name="numero" 
                        label="Numéro" 
                        v-model="form.numero"
                        autofocus 
                        class="focus:ring-0 focus:border-primary dark:focus:border-gray-200 bg-inherit block w-full sm:text-sm border-0 border-b-2 border-gray-300 dark:border-gray-700 dark:text-gray-200"
                    />
                </div>
                <FormError :error="error" />
            </div>
            <div>
               <BaseLabel>Nom de village</BaseLabel>
                <div class="mt-1">
                    <select 
                    class="focus:ring-0 focus:border-primary dark:focus:border-gray-200 bg-inherit block w-full sm:text-sm border-0 border-b-2 border-gray-300 dark:border-gray-700 dark:text-gray-200"
                    name="village_id"
                    v-model="form.village_id"
                    >
                        <option hidden selected>Nom de village</option>
                        <option v-for="item in villages" :value='item.id' >{{item.nom}}</option>
                    </select>
                </div>
                <FormError :error="error" /> 
            </div>


            
        </div> 

        <div>
            <BaseLabel>Numéro d'identité du propriétaire</BaseLabel>
            <div class="mt-1">
                <select 
                class="focus:ring-0 focus:border-primary dark:focus:border-gray-200 bg-inherit block w-full sm:text-sm border-0 border-b-2 border-gray-300 dark:border-gray-700 dark:text-gray-200"
                name="proprietaire_id"
                v-model="form.proprietaire_id"
                >
                    <option hidden selected>Numéro d'identité</option>
                    <option v-for="item in proprietaires" :value="item.id">{{item.numero_identite}}</option>
                </select>
            </div>
            <FormError :error="error" />
        </div> 
        
        

        <div>
            <BaseLabel>Date de délimitation</BaseLabel>
            <div class="mt-1">
                <input
                    v-model="form.date_delimitation"
                    type="date" 
                    name="date_delimitation" 
                    autofocus 
                    class="focus:ring-0 focus:border-primary dark:focus:border-gray-200 bg-inherit block w-full sm:text-sm border-0 border-b-2 border-gray-300 dark:border-gray-700 dark:text-gray-200"
                />
            </div>
            <FormError :error="error" />
        </div>


        <div>
            <BaseLabel>Signature</BaseLabel>
            <div class="mt-1">
                <textarea 
                v-model="form.signature"
                class="rounded-sm border border-gray-600 focus:ring-0 focus:border-primary dark:focus:border-gray-200 bg-inherit block w-full sm:text-sm border-0 border-b-2 border-gray-300 dark:border-gray-700 dark:text-gray-200"
                name="signature" 
                rows="4" 
                cols="50" 
                autofocus
                maxlength="200"></textarea>
            </div>
            <FormError :error="error" />
        </div>

        <div :class="{ hidden: !role }">
            <BaseLabel>Agent</BaseLabel>
            <div class="mt-1">
                <select v-if="role" v-model="form.user_id"
                class="focus:ring-0 focus:border-primary dark:focus:border-gray-200 bg-inherit block w-full sm:text-sm border-0 border-b-2 border-gray-300 dark:border-gray-700 dark:text-gray-200"
                name="user_id">
                    <option hidden selected>Agent</option>
                    <option v-for="item in agents" :value="item.id">{{item.name}}</option>
                </select>
                <input v-if="!role" v-model="form.user_id" name="user_id"/>
            </div>
            <FormError :error="error" />
        </div>
        <BaseButton  block>Update</BaseButton>

</div>
    </form>
    </ParentTransition>
    <div v-on:click="closePopup()" class="dark h-0 dark:text-gray-400 cursor-pointer">
        <i class="fa-solid fa-xmark"></i>
    </div>
</div>
</div>
</template>

<script setup>
const props = defineProps({
    id: String,
})
</script>

<script>
import axios from 'axios';
export default {
name: 'Pracelle',

data(){
return{
    role:true,
    user:sessionStorage.getItem('id'),
    popup : true,
    villages :[],
    proprietaires:[],
    agents:[],
    form: {
        user_id : this.user,
        village_id : null,
        proprietaire_id : null,
        numero : null,
        date_delimitation : null,
        signature : ""
    }
}
},

mounted(){
if(sessionStorage.getItem("role") == "Agent"){
    this.role = false
}

// Get Villages
let options = {
url: 'http://127.0.0.1:8000/api/v1/getVillages/',
method: 'GET',
};

axios(options)
.then(response => {
    this.villages = response.data;
});

// Get Proprietaire
options = {
url: 'http://127.0.0.1:8000/api/v1/getProprietaires',
method: 'GET',
};

axios(options)
.then(response => {
    this.proprietaires = response.data;
});

// Get Agents
options = {
url: 'http://127.0.0.1:8000/api/v1/getAgents',
method: 'GET',
};

axios(options)
.then(response => {
    this.agents = response.data;
});
},

methods:{
closePopup(){
    this.popup = false
    this.$router.go();
},

update_Parcelle(id){
    const options = {
        url: 'http://127.0.0.1:8000/api/v1/updateParcelle/'+id,
        method: 'PUT',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json;charset=UTF-8'
        },
        data: this.form
    };

    axios(options)
    .then(response => {
        this.$router.go();
    });

}
}
}
</script>