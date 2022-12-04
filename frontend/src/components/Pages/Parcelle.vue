<template>
    <div class="p-4 space-y-4">
        <PageHeader title="Parcelles" subtitle="Listing all Records">
            <div class="mt-1">
                <input
                    v-bind="$attrs"
                    placeholder="Chercher..."
                    v-model="keyword"
                    @change="Search"
                    class="focus:ring-0 outline-0 focus:border-primary dark:focus:border-gray-200 bg-inherit block w-full sm:text-sm border-0 border-b-2 border-gray-300 dark:border-gray-700 dark:text-gray-200" style="height:95%"
                />
            </div>
            <BaseButton v-if="role" @click="openPopUpAdd()">Add New Parcelle</BaseButton>
            
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
                        <td class="table-data" v-html="highlightMatches(item.numero+'')">
                        </td>
                        <td class="table-data">
                            {{item.proprietaire.nom}} {{item.proprietaire.prenom}}
                        </td>
                        <td class="table-data">
                            {{item.village.nom}}
                        </td>
                        <td class="table-data">
                            {{item.date_delimitation}}
                        </td>
                        <td class="table-data" v-html="highlightMatches(item.user.name)">
                        </td>
                        <td class="table-data" v-if="role">
                            <BaseButton design="info" @click="openPopUpUpdate(item.id)"><i class="fa-solid fa-pen-to-square"></i></BaseButton> | <BaseButton design="danger" v-on:click="DeleteParcelle(item.id)"><i class="fa-solid fa-trash-can"></i></BaseButton>
                        </td>
                        <td class="table-data" v-if="role">
                            <BaseButton design="success" @click="generateDemande(item.id)">Télécharge &nbsp; <i class="fa-solid fa-download"></i></BaseButton>
                        </td>
                    </tr>
                </tbody>
                <tbody v-if="noData" class="table-data bg-white dark:bg-dark-header divide-y divide-gray-200 dark:divide-gray-700 absolute w-full flex justify-center">
                            No data found
                </tbody>
            </table>
        </div>











            <AddParcelle v-if="popupAdd"></AddParcelle>
            <UpdateParcelle v-if="popupUpdate" :id="parcelleId"></UpdateParcelle>

    </div>
</template>

<script>
import axios from 'axios';
export default {
    name: 'Pracelle',

    data(){
        return{
            headers : [
                'Numéro',
                'Propriétaire',
                'Village',
                'Date de délimitation',
                'Agent',
                'Action',
                "Demande d'immatriculation"
            ],
            data : [],
            role:true,
            user:sessionStorage.getItem('id'),
            popupAdd : false,
            popupUpdate : false,
            keyword: '',
            dataStore: [],
            parcelleId : 1,
            noData : true
        }
    },

    mounted(){
        if(sessionStorage.getItem("role") == "Agent"){
            this.role = false;
            this.headers = [
                'Numéro',
                'Propriétaire',
                'Village',
                'Date de délimitation',
                'Agent',
            ];
        }
        this.getParcelles(); 
    },

    methods:{

        getParcelles(){
            const options = {
            url: 'http://127.0.0.1:8000/api/v1/getParcelles',
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
            this.parcelleId = id
            this.popupUpdate = true
        },

        DeleteParcelle(id){
            const options = {
            url: 'http://127.0.0.1:8000/api/v1/deleteParcelle/'+id,
            method: 'DELETE',
            };

            axios(options)
            .then(response => {
                this.getParcelles();
            });
        },


        Search(){
            this.dataStore = this.data.filter(parcelle => {
              const agent = parcelle.user.name.toString().toLowerCase();
              const numero = parcelle.numero;
              const searchTerm = this.keyword.toLowerCase();
              return (
                agent.includes(searchTerm) || (numero + '').includes(searchTerm)
              );
            });
            console.log(this.dataStore);
        },
        highlightMatches(text) {
        const matchExists = text.toLowerCase().includes((this.keyword+ '').toLowerCase());
        if (!matchExists) return text;
        const re = new RegExp(this.keyword, "ig");
        return text.replace(re, matchedText => `<strong>${matchedText}</strong>`);
        },

        generateDemande(id){
            // const options = {
            // url: 'http://127.0.0.1:8000/api/v1/generateDemande/'+id,
            // method: 'GET',
            // };

            // axios(options)
            // .then(response => {
            //     var header = response.headers;
            //     var blob = new Blob([response.data],{type : this.headers['content-types']});
            //     var link = document.createElement('a');
            //     link.href = window.URL.createObjectURL(blob);
            //     link.download = "demande.docx";
            //     link.click();
            //     link.remove();
            // }).catch(error =>{
            //     console.log(error)
            // });

            window.open('http://127.0.0.1:8000/api/v1/generateDemande/'+id);
        }
    }
}
</script>

