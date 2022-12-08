<template >
    <div v-if="popup" class="bg-zinc-900/50 absolute top-0 w-full h-full" style="left: 0;margin: 0;">
<div v-if="popup" class="absolute top-0 w-2/5 p-1 bg-white dark:bg-dark-header rounded-2xl flex content-center justify-center pt-5" style="left: 25%; top: 3%;">
    <ParentTransition appear :visibility="true" class="w-4/5">

        <FormKit type="form" v-model="data" @submit="add_Village"
                submit-label="Save"
                :submit-attrs="{
                    inputClass: 'hidden',
                }"
                :config="{
                        classes: {
                            input: 'focus:ring-0 focus:border-primary dark:focus:border-gray-200 bg-inherit block w-full sm:text-sm border-0 border-b-2 border-gray-300 dark:border-gray-700 dark:text-gray-200',
                            help: 'text-xs text-gray-500',
                            message: 'text-red-500 text-xs',
                        },
                        }"
                
                >
        <div class="space-y-6 flex flex-col gap-y-2 content-center justify-center py-5">
            
            <h1 class="dark dark:text-gray-400 text-center text-xl font-bold leading-7 sm:text-2xl sm:truncate">Add New Village</h1>

        <div>
                <BaseLabel>Nom</BaseLabel>
                <div class="mt-1 w-full">
                    <FormKit
                        type="text"
                        name="nom"
                        validation="required"
                        v-model="form.nom"
                        :config="{
                        classes: {
                            input: 'focus:ring-0 focus:border-primary dark:focus:border-gray-200 bg-inherit block w-full sm:text-sm border-0 border-b-2 border-gray-300 dark:border-gray-700 dark:text-gray-200',
                            help: 'text-xs text-gray-500',
                            message: 'text-red-500 text-xs',
                        },
                        }"
                    />
                    
                </div>
                <FormError :error="error" />
        </div>

        <BaseButton block>
            <FormKit
                type="submit"
                label="Save"
                :classes="{
                    input: 'w-full m-0 p-0',
                }"
            />
        </BaseButton>
</div>
        </FormKit>
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
    },
    data:null
}
},

mounted(){
    this.getOldData(this.id);
},

methods:{
closePopup(){
    this.popup = false
    this.$router.go();
},

update_Village(id){
    const options = {
        url: 'http://127.0.0.1:8000/api/v1/updateVillage/'+id,
        method: 'PUT',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json;charset=UTF-8'
        },
        data: this.data
    };

    axios(options)
    .then(response => {
        this.$router.go();
    });

},

getOldData(id){
    const options = {
        url: 'http://127.0.0.1:8000/api/v1/getVillage/'+id,
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json;charset=UTF-8'
        },
    };

    axios(options)
    .then(response => {
        this.form.nom = response.data.nom;
    });
}

}
}
</script>