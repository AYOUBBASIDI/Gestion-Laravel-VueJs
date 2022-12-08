<template>
    <div class="p-4 space-y-4">
        <PageHeader title="Proprietaires" subtitle="Listing all Records">
            <div class="mt-1 relative">
                <input
                    v-bind="$attrs"
                    placeholder="Chercher..."
                    v-model="keyword"
                    @change="Search"
                    class="focus:ring-0 outline-0 focus:border-primary dark:focus:border-gray-200 bg-inherit block w-full sm:text-sm border-0 border-b-2 border-gray-300 dark:border-gray-700 dark:text-gray-200" style="height:95%"
                />
            </div>
            <BaseButton v-if="role" @click="openPopUpAdd()">Add New Propriétaire</BaseButton>
            
        </PageHeader>

        

        <div class="border-b border-gray-200 dark:border-dark-body">
            <table class="relative rounded-table w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-neutral-700">
                    <tr>
                        <th class="px-6 py-3 text-sm text-gray-500 dark:text-gray-200 text-left" v-for="header in headers">
                            {{header}}
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-dark-header divide-y divide-gray-200 dark:divide-gray-700">
                    <tr v-for="item in dataStore" class="">
                        <td class="table-data" v-html="highlightMatches(item.nom)">
                        </td>
                        <td class="table-data" v-html="highlightMatches(item.prenom)">
                        </td>
                        <td class="table-data">
                            {{item.sexe}}
                        </td>
                        <td class="table-data">
                            {{item.nationalite}}
                        </td>
                        <td class="table-data">
                            {{item.type_identite}}
                        </td>
                        <td class="table-data" v-html="highlightMatches(item.numero_identite)">
                        </td>
                        <td class="table-data" v-if="role">
                            <BaseButton design="info" @click="openPopUpUpdate(item.id)"><i class="fa-solid fa-pen-to-square"></i></BaseButton> | <BaseButton design="danger" v-on:click="DeleteProprietaire(item.id)"><i class="fa-solid fa-trash-can"></i></BaseButton>
                        </td>
                    </tr>
                </tbody>
                <tbody v-if="noData" class="table-data bg-white dark:bg-dark-header divide-y divide-gray-200 dark:divide-gray-700 absolute w-full flex justify-center">
                            No data found
                </tbody>
            </table>
        </div>











            <AddProprietaire v-if="popupAdd"></AddProprietaire>
            <UpdateProprietaire v-if="popupUpdate" :id="proprietaireId"></UpdateProprietaire>

    </div>
</template>

<script>
import axios from 'axios';
export default {
    name: 'Pracelle',

    data(){
        return{
            headers : [
                'Nom',
                'Prémon',
                'Sexe',
                'Nationalité',
                "Type d'identité",
                "Numéro d'identité",
                "Actions"
            ],
            data : [],
            role:true,
            popupAdd : false,
            popupUpdate : false,
            keyword: '',
            dataStore: [],
            proprietaireId : null,
            noData : true
        }
    },

    mounted(){
        if(sessionStorage.getItem("role") == "Agent"){
            this.role = false;
            this.headers = [
                'Nom',
                'Prémon',
                'Sexe',
                'Nationalité',
                "Type d'identité",
                "Numéro d'identité",
            ];
        }
        this.getProprietaires(); 
    },

    methods:{

        getProprietaires(){
            const options = {
            url: 'http://127.0.0.1:8000/api/v1/getProprietaires',
            method: 'GET',
            };

            axios(options)
            .then(response => {
                this.data = response.data;
                this.dataStore = this.data;
                if(this.data.length != 0){
                    this.noData = false ;
                }
            });
        },
        openPopUpAdd(){
            this.popupAdd = true
        },
        openPopUpUpdate(id){
            this.proprietaireId = id;
            this.popupUpdate = true
        },

        DeleteProprietaire(id){
            const options = {
            url: 'http://127.0.0.1:8000/api/v1/deleteProprietaire/'+id,
            method: 'DELETE',
            };

            axios(options)
            .then(response => {
                this.getProprietaires();
            });
        },


        Search(){
            console.log(this.data)
            this.dataStore = this.data.filter(Proprietaire => {
              const nom = Proprietaire.nom.toString().toLowerCase();
              const prenom = Proprietaire.prenom.toString().toLowerCase();
              const numero = Proprietaire.numero_identite.toLowerCase();
              const searchTerm = this.keyword.toLowerCase();
              return (
                nom.includes(searchTerm) || prenom.includes(searchTerm) || (numero + '').includes(searchTerm)
              );
            });
        },
        highlightMatches(text) {
        const matchExists = text.toLowerCase().includes((this.keyword+ '').toLowerCase());
        if (!matchExists) return text;
        const re = new RegExp(this.keyword, "ig");
        return text.replace(re, matchedText => `<strong>${matchedText}</strong>`);
        },
    }
}
</script>

