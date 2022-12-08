<template>
	<div class="p-4 space-y-4">
		<PageHeader title="Parcelles" subtitle="Listing all Records">
			<div class="mt-1">
				<input
					v-bind="$attrs"
					placeholder="Chercher..."
					v-model="keyword"
					@change="Search"
					class="focus:ring-0 outline-0 focus:border-primary dark:focus:border-gray-200 bg-inherit block w-full sm:text-sm border-0 border-b-2 border-gray-300 dark:border-gray-700 dark:text-gray-200"
					style="height:95%"
				/>
			</div>
			<BaseButton v-if="role" @click="openPopUpAdd()">Add New Parcelle</BaseButton>
		</PageHeader>
		<div
			class="border-b border-gray-200 dark:border-dark-body flex justify-center flex-col items-center gap-2"
		>
			<table
				class="relative rounded-table w-full divide-y divide-gray-200 dark:divide-gray-700"
			>
				<thead class="bg-gray-50 dark:bg-neutral-700">
					<tr>
						<th
							class="px-6 py-3 text-sm text-gray-500 dark:text-gray-200 text-left"
							v-for="header in headers"
						>
							{{ header }}
						</th>
					</tr>
				</thead>
				<tbody
					class="bg-white dark:bg-dark-header divide-y divide-gray-200 dark:divide-gray-700"
				>
					<tr v-for="item in displayedParcelles" class="">
						<td class="table-data" v-html="highlightMatches(item.numero + '')"></td>
						<td class="table-data">
							{{ item.proprietaire.nom }} {{ item.proprietaire.prenom }}
						</td>
						<td class="table-data">
							{{ item.village.nom }}
						</td>
						<td class="table-data">
							{{ item.date_delimitation }}
						</td>
						<td class="table-data" v-html="highlightMatches(item.user.name)"></td>
						<td class="table-data" v-if="role">
							<BaseButton design="info" @click="openPopUpUpdate(item.id)"
								><i class="fa-solid fa-pen-to-square"></i
							></BaseButton>
							|
							<BaseButton design="danger" v-on:click="DeleteParcelle(item.id)"
								><i class="fa-solid fa-trash-can"></i
							></BaseButton>
						</td>
						<td class="table-data" v-if="role">
							<BaseButton design="success" @click="generateDemande(item.id)"
								>Télécharge &nbsp; <i class="fa-solid fa-download"></i
							></BaseButton>
						</td>
					</tr>
				</tbody>
				<tbody
					v-if="noData"
					class="table-data bg-white dark:bg-dark-header divide-y divide-gray-200 dark:divide-gray-700 absolute w-full flex justify-center"
				>
					No data found
				</tbody>
			</table>
			<nav aria-label="Page navigation example">
				<ul class="flex gap-4">
					<li class="page-item">
						<button
							type="button"
							class="inline-flex items-center px-4 py-2 text-sm font-medium border-b border-gray-200 dark:border-dark-body rounded-lg hover:bg-gray-100 hover:text-gray-700 bg-white dark:bg-dark-header text-gray-500 dark:text-gray-200 dark:hover:bg-gray-700 dark:hover:text-white"
							:disabled="page == 1"
							@click="page--"
						>
							Previous
						</button>
					</li>
					<li class="flex gap-2">
						<button
							type="button"
							class="inline-flex items-center px-4 py-2 text-sm font-medium border-b border-gray-200 dark:border-dark-body rounded-lg hover:bg-gray-100 hover:text-gray-700 bg-white dark:bg-dark-header text-gray-500 dark:text-gray-200 dark:hover:bg-gray-700 dark:hover:text-white"
							v-for="pageNumber in pages.slice(page - 1, page + 5)"
							@click="page = pageNumber"
						>
							{{ pageNumber }}
						</button>
					</li>
					<li class="page-item">
						<button
							type="button"
							@click="page++"
							:disabled="page > pages.length - 1"
							class="inline-flex items-center px-4 py-2 text-sm font-medium border-b border-gray-200 dark:border-dark-body rounded-lg hover:bg-gray-100 hover:text-gray-700 bg-white dark:bg-dark-header text-gray-500 dark:text-gray-200 dark:hover:bg-gray-700 dark:hover:text-white"
						>
							Next
						</button>
					</li>
				</ul>
			</nav>
		</div>
		<AddParcelle v-if="popupAdd"></AddParcelle>
		<UpdateParcelle v-if="popupUpdate" :id="parcelleId"></UpdateParcelle>
	</div>
</template>


<script>
import axios from "axios";
export default {
	name: "Pracelle",

	data() {
		return {
			headers: [
				"Numéro",
				"Propriétaire",
				"Village",
				"Date de délimitation",
				"Agent",
				"Action",
				"Demande d'immatriculation"
			],
			data: [],
			role: true,
			user: sessionStorage.getItem("id"),
			popupAdd: false,
			popupUpdate: false,
			keyword: "",
			dataStore: [],
			parcelleId: 1,
			noData: true,
			page: 1,
			perPage: 5,
			pages: []
		};
	},
	mounted() {
		if (sessionStorage.getItem("role") == "Agent") {
			this.role = false;
			this.headers = [
				"Numéro",
				"Propriétaire",
				"Village",
				"Date de délimitation",
				"Agent"
			];
		}
		this.getParcelles();
	},
	methods: {
		getParcelles() {
			const options = {
				url: "http://127.0.0.1:8000/api/v1/getParcelles",
				method: "GET"
			};

			axios(options).then(response => {
				this.data = response.data;
				this.dataStore = this.data;
				if (this.data.length != 0) {
					this.noData = false;
				}
				this.setPages();
			});
		},
		openPopUpAdd() {
			this.popupAdd = true;
		},
		openPopUpUpdate(id) {
			this.parcelleId = id;
			this.popupUpdate = true;
		},

		DeleteParcelle(id) {
			if (confirm("Are You sure you want to delete this Parcelle") == true) {
				const options = {
					url: "http://127.0.0.1:8000/api/v1/deleteParcelle/" + id,
					method: "DELETE"
				};

				axios(options).then(response => {
					this.getParcelles();
				});
			} else {
				text = "You canceled!";
			}
		},
		Search() {
			this.dataStore = this.data.filter(parcelle => {
				const agent = parcelle.user.name.toString().toLowerCase();
				const numero = parcelle.numero;
				const searchTerm = this.keyword.toLowerCase();
				return agent.includes(searchTerm) || (numero + "").includes(searchTerm);
			});
			console.log(this.dataStore);
		},
		highlightMatches(text) {
			const matchExists = text
				.toLowerCase()
				.includes((this.keyword + "").toLowerCase());
			if (!matchExists) return text;
			const re = new RegExp(this.keyword, "ig");
			return text.replace(re, matchedText => `<strong>${matchedText}</strong>`);
		},
		generateDemande(id) {
			window.open("http://127.0.0.1:8000/api/v1/generateDemande/" + id);
		},
		setPages() {
			let numberOfPages = Math.ceil(this.dataStore.length / this.perPage);
			for (let index = 1; index <= numberOfPages; index++) {
				this.pages.push(index);
			}
		},
		paginate(villages) {
			let page = this.page;
			let perPage = this.perPage;
			let from = page * perPage - perPage;
			let to = page * perPage;
			return villages.slice(from, to);
		}
	},
	computed: {
		displayedParcelles() {
			return this.paginate(this.dataStore);
		}
	},
	filters: {
		trimWords(value) {
			return (
				value
					.split(" ")
					.splice(0, 20)
					.join(" ") + "..."
			);
		}
	}
};
</script>


