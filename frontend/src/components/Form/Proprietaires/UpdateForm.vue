<template >
    <div v-if="popup" class="bg-zinc-900/50 top-0 absolute w-full h-full" style="left: 0;margin: 0;">
<div v-if="popup" class="absolute top-0 w-2/5 p-1 bg-white dark:bg-dark-header rounded-2xl flex content-center justify-center pt-5" style="left: 25%; top: 3%;">
    <ParentTransition appear :visibility="true" class="w-4/5">

    <form v-on:submit.prevent="update_Proprietaire(id)">
        <div class="space-y-6 flex flex-col gap-y-2 content-center justify-center py-5">
            
            <h1 class="dark dark:text-gray-400 text-center text-xl font-bold leading-7 sm:text-2xl sm:truncate">Update Propriétaire</h1>

        <div class="flex w-100 justify-between">
            <div>
                <BaseLabel>Nom</BaseLabel>
                <div class="mt-1">
                    <input
                        type="text" 
                        name="nom" 
                        v-model="form.nom"
                        autofocus 
                        class="focus:ring-0 focus:border-primary dark:focus:border-gray-200 bg-inherit block w-full sm:text-sm border-0 border-b-2 border-gray-300 dark:border-gray-700 dark:text-gray-200"
                    />
                </div>
                <FormError :error="error" />
            </div>
            <div>
               <BaseLabel>Prénom</BaseLabel>
                <div class="mt-1">
                    <input
                        type="text" 
                        name="prenom" 
                        v-model="form.prenom"
                        autofocus 
                        class="focus:ring-0 focus:border-primary dark:focus:border-gray-200 bg-inherit block w-full sm:text-sm border-0 border-b-2 border-gray-300 dark:border-gray-700 dark:text-gray-200"
                    />
                </div>
                <FormError :error="error" />
            </div>


            
        </div> 

        <div class="flex w-100 justify-between">
            <div>
                <BaseLabel>Sexe</BaseLabel>
            <div class="mt-1">
                <label for="sexe" class="dark dark:text-gray-400">
                    <input
                        type="radio" 
                        name="sexe" 
                        v-model="form.sexe"
                        autofocus 
                        value="Homme"
                        style="width: 6px;height: 6px;color: #ffffff;outline: auto; cursor: pointer;"
                    /> Homme
                    </label>
                    &nbsp;
                    <label for="sexe" class="dark dark:text-gray-400">
                    <input
                        type="radio" 
                        name="sexe" 
                        v-model="form.sexe"
                        autofocus 
                        value="Femme"
                        style="width: 6px;height: 6px;color: #ffffff;outline: auto; cursor: pointer;"
                    /> Femme
                </label>
            </div>
            <FormError :error="error" />
            </div>
            
            <div>
                <BaseLabel>Nationnalité</BaseLabel>
            <div class="mt-1">
                <input
                    v-model="form.nationalite"
                    type="text" 
                    name="Nationnalité" 
                    autofocus 
                    class="focus:ring-0 focus:border-primary dark:focus:border-gray-200 bg-inherit block w-full sm:text-sm border-0 border-b-2 border-gray-300 dark:border-gray-700 dark:text-gray-200"
                />
            </div>
            <FormError :error="error" />
            </div>
            

        </div> 

        <div class="flex w-100 justify-between">


                    <div style="width: 47%;">
                       <BaseLabel>Type d'identité</BaseLabel>
                        <div class="mt-1">
                            <select 
                            class="focus:ring-0 focus:border-primary dark:focus:border-gray-200 bg-inherit block w-full sm:text-sm border-0 border-b-2 border-gray-300 dark:border-gray-700 dark:text-gray-200"
                            name="type_identite"
                            v-model="form.type_identite"
                            >
                                <option v-for="item in types" :value='item' >{{item}}</option>
                            </select>
                        </div>
                        <FormError :error="error" /> 
                    </div>

                    <div>
                        <BaseLabel>Numéro d'identité</BaseLabel>
                        <div class="mt-1">
                            <input
                                type="text" 
                                name="numero_identite" 
                                v-model="form.numero_identite"
                                autofocus 
                                class="focus:ring-0 focus:border-primary dark:focus:border-gray-200 bg-inherit block w-full sm:text-sm border-0 border-b-2 border-gray-300 dark:border-gray-700 dark:text-gray-200"
                            />
                        </div>
                        <FormError :error="error" />
                    </div>                    
                </div> 

        <div>
            <BaseLabel>Photos de la pièce d'identité</BaseLabel>
            <div class="mt-1">
                <input
                    type="file" 
                    name="src" 
                    autofocus 
                    class="focus:ring-0 focus:border-primary dark:focus:border-gray-200 bg-inherit block w-full sm:text-sm border-0 border-b-2 border-gray-300 dark:border-gray-700 dark:text-gray-200"
                />
            </div>
            <FormError :error="error" />
        </div>

        <div>
            <BaseLabel>Adresse</BaseLabel>
            <div class="mt-1">
                <input
                    type="text" 
                    name="adresse" 
                    autofocus 
                    v-model="form.adresse"
                    class="focus:ring-0 focus:border-primary dark:focus:border-gray-200 bg-inherit block w-full sm:text-sm border-0 border-b-2 border-gray-300 dark:border-gray-700 dark:text-gray-200"
                />
            </div>
            <FormError :error="error" />
        </div>
        <BaseButton block>Update</BaseButton>

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
    popup : true,
    form: {
        nom : null,
        prenom : null,
        sexe : null,
        nationalite : null,
        type_identite : null,
        numero_identite : null,
        adresse : null,
        src : "/images/id1128"
    },
    types:["CIN","Passeport","Permis","Carte de resident"]
}
},

mounted(){
},

methods:{
closePopup(){
    this.popup = false
    this.$router.go();
},

update_Proprietaire(id){
    const options = {
        url: 'http://127.0.0.1:8000/api/v1/updateProprietaire/'+id,
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