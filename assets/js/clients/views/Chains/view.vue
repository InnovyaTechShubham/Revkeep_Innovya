<template>
	<div>
		<page-header>
			<template #title>
				<router-link :to="{ name: 'chains' }" v-text="`Chains /`" />
				<span>{{ result[0]['chain_name']}}</span>
				<!-- <span>Chains</span> -->
			</template>
			<template #buttons>
                <!-- add edit button route below -->
				<b-button variant="primary" :to="{ name: 'chains.edit', params: { id: $route.params.id } }">
					<font-awesome-icon icon="edit" fixed-width />
					<span>Edit</span>
				</b-button>

				<b-dropdown variant="secondary" right title="More Options">
					<template #button-content>
						<font-awesome-icon icon="cog" fixed-width />
					</template>

					<b-dropdown-item @click="destroy" :disabled="loading || deleting" variant="danger">
						<font-awesome-icon icon="trash" fixed-width />
						<span>Delete</span>
					</b-dropdown-item>
				</b-dropdown>
			</template>
		</page-header>

		<loading-indicator v-if="loading" class="my-5" />
		<div v-else class="my-4">
			<b-row>
				<b-col cols="12" class="mb-2">
					<p class="text-muted mb-0">
					</p>
				</b-col>
				<b-col cols="12" sm="6" lg="6" class="mb-4">
					<b-badge pill variant="primary">{{ result[0]['chain_type']}}</b-badge>
				</b-col>
				<b-col cols="12" sm="6" lg="6" class="mb-4 text-sm-right">
					<p class="small text-muted mb-0">
						<span> Last updated  </span>
						<span >
							by Shubham


						</span>
                        <div>
                        </div>
					</p>
				</b-col>
			</b-row>
			<b-row>
				<b-col cols="12">
					<div>
						<b-tabs content-class="mt-3">
							<b-tab title="Facilities" active>
								<div v-if="!facility_data.length">
									<empty-result>
										No facilities assigned.
										<template #content> No facilities have been assigned this Chain. </template>
									</empty-result>
								</div>
								<template>
									<b-table :items="facility_data" :fields="fields" class="mt-3">
										<template v-slot:cell(id)="data">
										{{ data.value }}
										</template>

										<template v-slot:cell(name)="data">
										<router-link v-if="data.item.facility_type || data.item.facility_type_id" :to="{ name: 'facilities.view', params: { id: data.item.id } }" title="Facility">
											<font-awesome-icon icon="house" /> {{ data.value }}
										</router-link>
										<span v-else title="Service">
											<font-awesome-icon icon="gear" /> {{ data.value }}
										</span>
										</template>
									</b-table>
								</template>
								
							</b-tab>
							<b-tab title="Services">
								<div v-if="!services_data.length">
									<empty-result>
										No Services assigned.
										<template #content> No services have been assigned this Chain. </template>
									</empty-result>
								</div>
								<template>
									<b-table :items="services_data" :fields="fields" class="mt-3">
										<template v-slot:cell(id)="data">
										{{ data.value }}
										</template>

										<template v-slot:cell(name)="data">
										<router-link v-if="data.item.facility_type || data.item.facility_type_id"  title="Facility">
											<font-awesome-icon icon="house" /> {{ data.value }}
										</router-link>
										<router-link v-else :to="{ name: 'services.view', params: { id: data.item.id } }" title="Service">
											<font-awesome-icon icon="gear" /> {{ data.value }}
										</router-link>
										</template>
									</b-table>
								</template>
								
							</b-tab>
						</b-tabs>
					</div>
				</b-col>
			</b-row>
		</div>
	</div>
</template>

<script>
import axios from 'axios';
import { destroy as DeleteService } from "@/clients/services/chain";
import { ref, reactive } from "vue";
import { getIndex } from "@/clients/services/facilities";

import IndexFilters from "@/clients/components/Facilities/Filters.vue";


export default {
	name: "ViewChain",
	components: {},
	data() {
		return {
            result: [], 
			facility_data: [],
			services_data: [],
			id: null,
			loading: true,
			deleting: false,
			entity: {
				id: null,
				chain_name: null,
				chain_type: null,
			},
			fields: ['id', 'name'],
		};
	},
	mounted() {
        this.id = this.$route.params.id
		this.showData();
	},
	methods: {
		// Function to eliminate duplicates based on a specific key
		eliminateDuplicates(arr, key) {
			const uniqueMap = new Map();
			arr.forEach(obj => uniqueMap.set(obj[key], obj));
			return Array.from(uniqueMap.values());
		},
		async showData() {
            console.log('Refreshing...');
            console.log('ID:', this.id);

            await axios.get(`/client/viewChain/${this.id}`)
            .then(response => {
				// alert(JSON.stringify(response.data))
                this.result.push(response.data);
                console.log('result',this.result);
				
				// Assuming facility data is present in response.data.facilities
				const facilities = response.data.chain_organizations.map(item => item.facility);
				const services_data = response.data.chain_organizations.map(item1 => item1.service);
				// alert(services_data)
				// remove duplicate values from services_data: TODO: FIX IT
				const distinct_services_data = this.eliminateDuplicates(services_data, 'id');
				this.facility_data.push(...facilities);
				this.services_data.push(...distinct_services_data);

                // nesting 
            })
            .catch(error => {
                console.error(error);
            })
            .finally(() => {
                this.loading = false;
            });
		},
		async destroy() {
			if (!confirm("Are you sure you want to delete this chain?")) {
				return;
			}

			try {
				this.deleting = true;
				await axios.post(`/client/deleteChain/${this.id}`)
				.then(response => {
					this.$router.push({ name: "chains" });

					this.$nextTick(function () {
						this.$store.dispatch("notify", {
							variant: "primary",
							title: "Chain Deleted",
							message: `Chain was deleted.`,
						});
					});
				})
				.catch(error => {
					console.error(error);
				})
				.finally(() => {
					this.loading = false;
				});
				// const response = await DeleteService(this.id);
				// this.$router.push({ name: "chains" });

				// this.$nextTick(function () {
				// 	this.$store.dispatch("notify", {
				// 		variant: "primary",
				// 		title: "Chain Deleted",
				// 		message: `Chain was deleted.`,
				// 	});
				// });
			} catch (e) {
				this.$store.dispatch("apiError", {
					error: e,
					title: "Delete Failed",
					message: "Failed to delete chain",
				});
			} finally {
				this.deleting = false;
			}
		},
	},
};
</script>
