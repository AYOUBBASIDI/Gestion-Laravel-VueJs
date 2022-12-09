<template >
            <div v-if="popup" class="bg-zinc-900/50 top-0 absolute w-full h-full" style="left: 0;margin: 0;">
    <div v-if="popup" class="absolute top-0 w-2/5 p-1 bg-white dark:bg-dark-header rounded-2xl flex content-center justify-center pt-5" style="left: 25%; top: 3%;">
            <ParentTransition appear :visibility="true" class="w-4/5">

                <FormKit type="form" v-model="data" @submit="add_Parcelle"
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
                    
                    <h1 class="dark dark:text-gray-400 text-center text-xl font-bold leading-7 sm:text-2xl sm:truncate">Add New Parcelle</h1>

                <div class="flex w-100 justify-between">
                    <div>
                        <BaseLabel>Numéro</BaseLabel>
                        <div class="mt-1">
                            <FormKit
                                v-model="form.numero"
                                type="number"
                                name="numero"
                                validation="required"
                            />
                        </div>

                    </div>
                    <div style="width: 47%;">
                       <BaseLabel>Nom de village</BaseLabel>
                        <div class="mt-1">
                            <FormKit
                                type="select"
                                name="village_id"
                                validation="required"
                                v-model="form.village_id"
                                :validation-messages="{
                                    required: 'Nom de village is required',
                                }"
                                >
                                    <option 
                                        v-for="item in villages" 
                                        :value="item.id"
                                        class="bg-white dark:bg-dark-header"
                                        >
                                        {{item.nom}}
                                    </option>
                                </FormKit>
                                <pre wrap>{{ value }}</pre>
                        </div>
 
                    </div>


                    
                </div> 

                <div>
                    <BaseLabel>Numéro d'identité du propriétaire</BaseLabel>
                    <div class="mt-1">
                        <FormKit
                            type="select"
                            name="proprietaire_id"
                            validation="required"
                            v-model="form.proprietaire_id"
                            :validation-messages="{
                                    required: 'proprietaire is required',
                                }"
                            >
                                <option 
                                    v-for="item in proprietaires" 
                                    :value="item.id"
                                    class="bg-white dark:bg-dark-header"
                                    >
                                    {{item.numero_identite}}
                                </option>
                            </FormKit>
                            <pre wrap>{{ value }}</pre>

                    </div>
                </div> 
                
                

                <div>
                    <BaseLabel>Date de délimitation</BaseLabel>
                    <div class="mt-1">
                        <FormKit
                            v-model="form.date_delimitation"
                            type="date"
                            name="date_delimitation"
                            validation="required"
                        />
                    </div>
                </div>


                <div>
                    <BaseLabel>Signature</BaseLabel>
                    <div class="mt-1">
                        <FormKit
                            v-model="form.signature"
                            type="textarea"
                            name="signature"
                            rows="4" 
                            cols="50" 
                            validation="required"
                            :config="{
                                classes: {
                                input: 'dark dark:text-gray-200 rounded-sm border border-gray-600 focus:ring-0 focus:border-primary dark:focus:border-gray-200 bg-inherit block w-full sm:text-sm border-0 border-b-2 border-gray-300 dark:border-gray-700',
                                message: 'text-red-500 text-xs',
                                }
                            }"
                        />
                    </div>
                </div>

                <div>
                    <BaseLabel>Agent</BaseLabel>
                    <div class="mt-1">
                        <FormKit
                        type="select"
                        name="user_id"
                        validation="required"
                        v-model="form.user_id"
                        >
                            <option 
                                v-for="item in agents" 
                                :value="item.id"
                                class="bg-white dark:bg-dark-header"
                                :validation-messages="{
                                    required: 'Agent is required',
                                }"
                                >
                                {{item.name}}
                            </option>
                        </FormKit>
                        <pre wrap>{{ value }}</pre>
                    </div>
                </div>
                <BaseButton  block>
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
            user:sessionStorage.getItem('id'),
            popup : true,
            villages :[],
            proprietaires:[],
            agents:[],
            agentsOption : [],
            form: {
                user_id : this.user,
                village_id : null,
                proprietaire_id : null,
                numero : null,
                date_delimitation : null,
                signature : ""
            },
            data:null
        }
    },

    mounted(){
        // Get Villages
        let options = {
        url: 'http://127.0.0.1:8000/api/v1/getVillages',
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
            this.agents = response.data
        });
    },

    methods:{
        closePopup(){
            this.popup = false
            this.$router.go();
        },

        add_Parcelle(){
            const options = {
                url: 'http://127.0.0.1:8000/api/v1/newParcelle',
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json;charset=UTF-8'
                },
                data: this.data
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