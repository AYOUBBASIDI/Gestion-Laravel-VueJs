<template>
    <div class="p-4 space-y-4">
        <PageHeader title="Profile" subtitle="Your information">
        </PageHeader>
        <div class="border-b border-gray-200 dark:border-dark-body flex justify-center w-full">
            <BaseCard class="w-full">
                <FormKit type="form" v-model="data" @submit="getUpdatedData"
                submit-label="Save"
                :submit-attrs="{
                    inputClass: 'hidden',
                }"
                :config="{
                classes: {
                    input: 'focus:ring-0 outline-0 p-2 focus:border-primary dark:focus:border-gray-200 bg-inherit block w-full sm:text-sm border-0 border-b-2 border-gray-300 dark:border-gray-700 dark:text-gray-200',
                    help: 'text-xs text-gray-500',
                    message: 'text-red-500 text-xs',
                },
                }"
                >
                    <div class="p-4">
                        <div class="grid grid-cols-3 gap-6">

                            <div class="col-span-3 sm:col-span-1">
                                <h1 class="dark dark:text-gray-400 text-lg font-normal leading-7 sm:truncate">Public Profile</h1>
                            </div>
                            <div class="col-span-3 sm:col-span-1">
                            </div>
                            <div class="col-span-3 sm:col-span-1">
                            </div>

                            <div class="col-span-3 sm:col-span-1">
                                <div>
                                    <BaseLabel v-if="true">Nom</BaseLabel>
                                    <div class="mt-1">
                                        <FormKit
                                            :disabled="!update"
                                            type="text"
                                            name="name"
                                            v-model="infos.name"
                                            validation="required"
                                        />
                                    </div>
                                </div>
                            </div>

                            <div class="col-span-3 sm:col-span-1">
                                <div>
                                    <BaseLabel v-if="true">Identifiant</BaseLabel>
                                    <div class="mt-1">
                                        <FormKit
                                            :disabled="!update"
                                            type="text"
                                            name="username"
                                            v-model="infos.username"
                                            validation="required|length:3,15"
                                        />
                                    </div>
                                    <FormError :error="error" />
                                </div>
                            </div>
                            <div class="col-span-3 sm:col-span-1">
                                <div>
                                    <BaseLabel v-if="true">Email</BaseLabel>
                                    <div class="mt-1">
                                        <FormKit
                                            :disabled="!update"
                                            type="email"
                                            name="email"
                                            v-model="infos.email"
                                            validation="required|email"
                                        />
                                    </div>
                                    <FormError :error="error" />
                                </div>
                            </div>
                            <div class="col-span-3 sm:col-span-1">
                            </div>
                            <div class="col-span-3 sm:col-span-1">
                            </div>
                            <div class="col-span-3 sm:col-span-1">
                            </div>

                            <div class="col-span-3 sm:col-span-1">
                                <h1 class="dark dark:text-gray-400 text-lg font-normal leading-7 sm:truncate" style="width: 215%;">Password and Security <span v-if="update">( If You don't want to update password just leave it )</span></h1>
                            </div>
                            <div class="col-span-3 sm:col-span-1">
                            </div>
                            <div class="col-span-3 sm:col-span-1">
                            </div>
                            <div class="col-span-3 sm:col-span-1" v-if="!update">
                                <div>
                                    <BaseLabel v-if="true">Password</BaseLabel>
                                    <div class="mt-1">
                                        <input
                                        :disabled="!update"
                                            type="password"
                                            value="**************"
                                            class="focus:ring-0 outline-0 p-2 focus:border-primary dark:focus:border-gray-200 bg-inherit block w-full sm:text-sm border-0 border-b-2 border-gray-300 dark:border-gray-700 dark:text-gray-200"
                                        />
                                    </div>
                                    <FormError :error="error" />
                                </div>
                            </div>

                            <div class="col-span-3 sm:col-span-1" v-if="update">
                                <div>
                                    <BaseLabel v-if="true">Old Password</BaseLabel>
                                    <div class="mt-1">
                                        <FormKit
                                            :disabled="!update"
                                            type="password"
                                            name="old_password"
                                            placeholder="Old Password"
                                            v-model="infos.old_password"
                                        />
                                    </div>
                                    <FormError :error="error" />
                                </div>
                            </div>

                            <div class="col-span-3 sm:col-span-1" v-if="update">
                                <div>
                                    <BaseLabel v-if="true">New Password</BaseLabel>
                                    <div class="mt-1">
                                        <FormKit
                                            :disabled="!update"
                                            type="password"
                                            name="password"
                                            placeholder="New Password"
                                            v-model="infos.password"
                                            validation="length:6"
                                        />
                                    </div>
                                    <FormError :error="error" />
                                </div>
                            </div>

                            <div class="col-span-3 sm:col-span-1" v-if="update">
                                <div>
                                    <BaseLabel v-if="true">Password Confirmation</BaseLabel>
                                    <div class="mt-1">
                                        <FormKit
                                            :disabled="!update"
                                            type="password"
                                            name="password_confirm"
                                            placeholder="New Password"
                                            v-model="infos.password_confirmation"
                                            validation="confirm"
                                        />
                                    </div>
                                    <FormError :error="error" />
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 flex justify-between">
                            <div class="flex space-x-4" v-if="!update" @click="Update()">
                                <BaseButton class="hidden sm:block" design="secondary">Update</BaseButton>
                            </div>
                            <div class="space-x-4" v-if="update">
                                <BaseButton design="error" @click="Cancel()">Cancel</BaseButton>
                                <BaseButton design="primary" type="submit">
                                    <FormKit
                                    type="submit"
                                    label="Save"
                                    :config="{
                                    classes: {
                                        input: 'py-0 focus:ring-0 outline-0 p-2 dark:focus:border-gray-200 bg-inherit block w-full sm:text-sm border-0 border-gray-300 dark:border-gray-700 dark:text-gray-200',
                                    },
                                    }"
                                />
                                </BaseButton>
                                
                            </div>
                        </div>
                    </div>
            </FormKit>
        </BaseCard>
        </div>

    </div>
</template>

<script>
import axios from "axios";
export default {
	name: "Pracelle",

	data() {
		return {
			update: false,
			user_id: sessionStorage.getItem("id"),
			infos: {
				name: "",
				username: "",
				email: "",
				old_password: "",
				password: "",
				password_confirmation: ""
			},
			data: null,
			passRequired: false
		};
	},

	mounted() {
		this.getUserInfo();
	},

	methods: {
		Update() {
			this.update = true;
		},
		Cancel() {
			this.update = false;
			this.$router.go();
		},
		getUserInfo() {
			const options = {
				url: "http://127.0.0.1:8000/api/v1/getProfile/" + this.user_id,
				method: "GET"
			};

			axios(options).then(response => {
				console.log(response);
				if (response.status === 200) {
					this.infos = response.data;
					this.infos["old_password"] = "";
					this.infos["password"] = "";
					this.infos["password_confirmation"] = "";
				}
			});
		},
		getUpdatedData() {
			if (this.data.old_password == "") {
				this.data.old_password = "unchanged";
			}

			const options = {
				url: "http://127.0.0.1:8000/api/v1/updateProfile/" + this.user_id,
				method: "PUT",
				headers: {
					Accept: "application/json",
					"Content-Type": "application/json;charset=UTF-8"
				},
				data: this.data
			};

			axios(options).then(response => {
				console.log(response);
				if (response.status === 200) {
					this.$router.go();
				}
			});
		}
	}
};
</script>


