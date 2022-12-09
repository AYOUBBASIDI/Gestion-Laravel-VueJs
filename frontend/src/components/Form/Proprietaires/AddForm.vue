<template >
    <div v-if="popup" class="bg-zinc-900/50 top-0 absolute w-full h-full" style="left: 0;margin: 0;">
<div v-if="popup" class="absolute top-0 w-2/5 p-1 bg-white dark:bg-dark-header rounded-2xl flex content-center justify-center pt-5" style="left: 25%; top: 3%;">
    <ParentTransition appear :visibility="true" class="w-4/5">

        <FormKit type="form" v-model="data" @submit="add_Proprietaire"
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
            
            <h1 class="dark dark:text-gray-400 text-center text-xl font-bold leading-7 sm:text-2xl sm:truncate">Add Propriétaire</h1>

        <div class="flex w-100 justify-between">
            <div>
                <BaseLabel>Nom</BaseLabel>
                <div class="mt-1">
                    <FormKit
                        v-model="form.nom"
                        type="text"
                        name="nom"
                        validation="required"
                    />
                </div>
            </div>
            <div>
               <BaseLabel>Prénom</BaseLabel>
                <div class="mt-1">
                    <FormKit
                        v-model="form.prenom"
                        type="text"
                        name="prenom"
                        validation="required"
                    />
                </div>

            </div>


            
        </div> 

        <div class="flex w-100 justify-between">
            <div>
                <BaseLabel>Sexe</BaseLabel>
            <div class="mt-1  dark dark:text-gray-400">
                <FormKit
                    type="radio"
                    name="sexe"
                    v-model="form.sexe"
                    :options="['Homme', 'Femme']"
                    validation="required"
                    :config="{
                        classes: {
                            input: 'w-2.5 h-2.5 flex flex-column',
                            message: 'text-red-500 text-xs',
                        }
                    }"
                    />
            </div>
            </div>
            
            <div>
                <BaseLabel>Nationnalité</BaseLabel>
            <div class="mt-1">
                <FormKit
                    v-model="form.nationalite"
                    type="text"
                    name="nationalite"
                    validation="required"
                />
            </div>
            </div>
            

        </div> 

        <div class="flex w-100 justify-between">


                    <div style="width: 47%;">
                       <BaseLabel>Type d'identité</BaseLabel>
                        <div class="mt-1">
                            <FormKit
                                type="select"
                                name="type_identite"
                                validation="required"
                                v-model="form.type_identite"
                                :validation-messages="{
                                    required: 'Type d’identite is required',
                                }"
                            >
                                <option 
                                    v-for="item in types" 
                                    :value="item"
                                    class="bg-white dark:bg-dark-header"
                                    >
                                    {{item}}
                                </option>
                            </FormKit>
                            <pre wrap>{{ value }}</pre>
                        </div>
                    </div>

                    <div>
                        <BaseLabel>Numéro d'identité</BaseLabel>
                        <div class="mt-1">
                            <FormKit
                                v-model="form.numero_identite"
                                type="text"
                                name="numero_identite"
                                validation="required"
                            />
                        </div>
        
                    </div>                    
                </div> 
        <div>
            <BaseLabel>Photos de la pièce d'identité</BaseLabel>
            <div class="mt-1">
                <FormKit
                    type="file"
                    name="src"
                    ref="file"
                    accept=".png,.jpg,.jpeg"
                    @change="checkFile($event)"
                    validation="required"
                    style="width: 32%;"
                    :validation-messages="{
                        required: 'Pièce d’identite is required',
                    }"
                    :config="{
                        classes: {
                            input: 'dark dark:text-gray-400 file:mr-5 file:py-2 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:cursor-pointer hover:file:bg-amber-50 hover:file:text-amber-700',
                            message: 'text-red-500 text-xs',
                        }
                    }"
                    multiple
                />
        
            </div>
        </div>

        <div>
            <BaseLabel>Adresse</BaseLabel>
            <div class="mt-1">
                <FormKit
                    v-model="form.adresse"
                    type="text"
                    name="adresse"
                    validation="required"
                />
            </div>
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
        src : null
    },
    types:["CIN","Passeport","Permis","Carte de resident"],
    data:null
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
    var formData = new FormData();
    formData.append("nom", this.form.nom);
    formData.append("prenom", this.form.prenom);
    formData.append("sexe", this.form.sexe);
    formData.append("nationalite", this.form.nationalite);
    formData.append("type_identite", this.form.type_identite);
    formData.append("adresse", this.form.adresse);
    formData.append("numero_identite", this.form.numero_identite);
    formData.append("src", this.form.src);
    axios.post('http://127.0.0.1:8000/api/v1/newProprietaire', formData, {
        headers: {
        'Content-Type': 'multipart/form-data'
        }
    })
    .then(response => {
        this.$router.go();
    }).catch((error) => {
        var message = Object.values(error.response.data.message)[0][0];
        alert(message);
    });
},

checkFile(e){
    this.form.src = e.target.files[0];
    const type = this.form.src.type;
    const size = this.form.src.size;
    if(type != "image/png" && type != "image/jpg" && type != "image/jpeg"){
        alert('File Not accepted');
        this.$refs.file.value = ''
        this.src = null
    }
    else if(size > 1024000){
        alert('Size of This File is Big than 1024 Ko');
        this.$refs.file.value = ''
        this.src = null 
    }
},

}
}
</script>