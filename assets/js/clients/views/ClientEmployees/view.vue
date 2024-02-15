<template>
	<div>
		<page-header>
			<template #title>
				<router-link :to="{ name: 'clientEmployees' }" v-text="`Physicians /`" />
				<span>{{ entity.full_name }}</span>
			</template>
			<template #buttons>
				<b-button
					variant="primary"
					:to="{ name: 'clientEmployees.edit', params: { id: $route.params.id } }"
					title="Edit"
				>
					<font-awesome-icon icon="edit" fixed-width />
					<span>Edit</span>
				</b-button>

				<b-dropdown variant="secondary" right title="More Options">
					<template #button-content>
						<font-awesome-icon icon="cog" fixed-width />
					</template>

					<b-dropdown-item :to="{ name: 'cases.add', query: { physician_id: $route.params.id } }">
						<font-awesome-icon icon="plus" fixed-width />
						<span>New Case</span>
					</b-dropdown-item>

					<b-dropdown-divider />

					<b-dropdown-item @click="destroy" :disabled="loading" variant="danger">
						<font-awesome-icon icon="trash" fixed-width />
						<span>Delete</span>
					</b-dropdown-item>
				</b-dropdown>
			</template>
		</page-header>

		<loading-indicator v-if="showLoading" class="my-5" />
		<div v-else class="my-4">
			<b-row>
				<b-col cols="12" sm="6" lg="6" class="mb-2">
					<b-badge pill variant="primary" v-if="entity.active">Active</b-badge>
					<b-badge pill variant="secondary" v-else>Inactive</b-badge>
				</b-col>
				<b-col cols="12" sm="6" lg="6" class="mb-2 text-sm-right">
					<p class="small text-muted">
						<span> Last updated {{ $filters.fromNow(entity.modified) }} </span>
						<span v-if="entity.modified_by_user?.full_name">
							by {{ entity.modified_by_user.full_name }}
						</span>
					</p>
				</b-col>
			</b-row>

			<b-card no-body class="shadow-sm">
				<b-tabs card active-nav-item-class="font-weight-bold">
					<b-tab  no-body active lazy>
						<template #title>Details</template>

						<!-- <div class="row mt-4">
							<dt class="col text-muted h6 small ml-3">Facility</dt>
							<dd class="col-8">
								<span v-if="entity.facility && entity.facility.name">
									<router-link
										:to="{
											name: 'facilities.view',
											params: {
												id: entity.facility_id,
											},
										}"
									>
										{{ entity.facility.name }}
									</router-link>
								</span>
								<span v-else class="text-muted"> &mdash; </span>
							</dd>
						</div>  -->

						<div class="row mt-4">
							<dt class="col text-muted h6 small ml-3">Facility</dt>
							<dd class="col-8 d-flex flex-wrap align-items-center">
								<template v-if="MatchingFacility.length > 0">
									<div v-for="(facilityName, index) in MatchingFacility" :key="index" class="mb-1">
										<b-badge pill variant="primary" class="ml-1">{{ facilityName }}</b-badge>
									</div>
								</template>
								<template v-else>
									<span class="text-muted">No matching facilities found.</span>
								</template>
							</dd>
						</div>

						<div class="row ">
							<dt class="col text-muted h6 small ml-3">NPI Number</dt>
							<dd class="col-8">
								<span v-if="entity.npi_number"> {{ entity.npi_number }} </span>
								<span v-else class="text-muted"> &mdash; </span>
							</dd>
						</div>

						<div class="row">
							<dt class="col text-muted h6 small ml-3">Work Phone</dt>
							<dd class="col-8">
								<span v-if="entity.work_phone"> {{ entity.work_phone }} </span>
								<span v-else class="text-muted"> &mdash; </span>
							</dd>
						</div>

						<div class="row">
							<dt class="col text-muted h6 small ml-3">Mobile Phone</dt>
							<dd class="col-8">
								<span v-if="entity.mobile_phone"> {{ entity.mobile_phone }} </span>
								<span v-else class="text-muted"> &mdash; </span>
							</dd>
						</div>

						<div class="row">
							<dt class="col text-muted h6 small ml-3">Email</dt>
							<dd class="col-8">
								<span v-if="entity.email"> {{ entity.email }} </span>
								<span v-else class="text-muted"> &mdash; </span>
							</dd>
						</div>

						<div class="row pb-3">
							<dt class="col text-muted h6 small ml-3">Added</dt>
							<dd class="col-8">
								<span v-if="entity.created">
									{{ $filters.fromNow(entity.created) }} on
									{{ $filters.formatDate(entity.created) }}
								</span>
								<span v-else class="text-muted"> &mdash; </span>
							</dd>
						</div>
					</b-tab>
					<b-tab no-body  lazy>
						<template #title>Cases</template>
						<case-index
							ref="caseList"
							hide-client-employee
							:filters="caseFilters"
							@clicked="viewCase"
							empty-description="No cases have been created for this physician."
						/>
					</b-tab>
					<b-tab no-body lazy>
						<template #title>Add Case</template>
						<case-form flush :client-employee-id="$route.params.id" />
					</b-tab>
				</b-tabs>
			</b-card>
		</div>
	</div>
</template>

<script type="text/javascript">
import { get as GetClientEmployee, destroy as DeleteClientEmployee } from "@/clients/services/clientEmployees";

import CaseForm from "@/clients/components/Cases/Form.vue";
import CaseIndex from "@/clients/components/Cases/Index.vue";
import axios from "axios";

export default {
	name: "ClientEmployeeView",
	components: {
		CaseForm,
		CaseIndex,
	},
	data() {
		return {
			loading: true,
			MatchingFacility: [],
			clientFacilities: [],
			entity: {
				id: null,
				created: null,
				modified: null,
				facility_id: null,
				first_name: null,
				last_name: null,
				title: null,
				work_phone: null,
				mobile_phone: null,
				email: null,
				npi_number: null,
				state: null,
				active: null,
				facility: null,
				full_name: null,
				list_name: null,
			},
		};
	},
	computed: {
		caseFilters() {
			return {
				client_employee_id: this.$route.params.id,
			};
		},
		showLoading() {
			return this.loading && (!this.entity.id || this.entity.id == null);
		},
	},
	mounted() {
		this.refresh();
		this.fetchClientFacilities();
		this.FacilitiesList();
	},
	methods: {
		async refresh() {
			try {
				this.loading = true;
				const responses = await GetClientEmployee(this.$route.params.id);
				this.entity = responses;
				console.log("requirement", responses);
				this.$emit("loaded", responses);
			} catch (e) {
				this.$router.push({ name: "clientEmployees" });
			} finally {
				this.loading = false;
			}
		},
		async fetchClientFacilities() {
			try {
				const url = "/client/fetchmultiplefacility";

				
				const response = await axios.get(url, {
					headers: {
						"Accept": "application/json",
					},
				});

				console.log("RESPONSE = ", response.data);

				
				this.clientFacilities = response.data.filter(item => item.client_id === this.$route.params.id);

				// Extract facility IDs directly without cleaning the array
				let matchingFacilityIds = this.clientFacilities.map(item => item.facility_id);

				// Display the matching facility IDs
				console.log("Matching Facility IDs:", matchingFacilityIds);

				this.MatchingFacility = [...this.MatchingFacility, ...matchingFacilityIds];
				console.log(this.MatchingFacility);
			} catch (error) {
				console.error("Error fetching client facilities:", error);
			}
		},
		
		async FacilitiesList() {
			try {
				const url = "/client/facilityList";

				// Fetch data from the server
				const response = await axios.get(url, {
					headers: {
						"Accept": "application/json",
					},
				});

				console.log("RESPONSE = ", response.data);

				// Extract facility names based on their IDs
				let facilityNames = this.MatchingFacility.map(facilityId => {
					const facility = response.data.find(item => item.id === facilityId);
					return facility ? facility.name : null;
				});

				// Display the facility names
				console.log("Facility names", facilityNames);

				// Update MatchingFacility array with facility names
				this.MatchingFacility = facilityNames.filter(name => name !== null);
				console.log("final", this.MatchingFacility);
			} catch (error) {
				console.error("Error fetching client facilities:", error);
			}
		},
		async destroy() {
			if (!confirm("Are you sure you want to delete this physician?")) {
				return;
			}

			try {
				this.deleting = true;
				const response = await DeleteClientEmployee(this.$route.params.id);
				this.$store.dispatch("clientEmployees/getActive");
				this.$router.push({ name: "clientEmployees" });

				this.$nextTick(function () {
					this.$store.dispatch("notify", {
						variant: "primary",
						title: "Physician Deleted",
						message: `Physician ${response.data.full_name} was deleted.`,
					});
				});
			} catch (e) {
				this.$store.dispatch("apiError", {
					error: e,
					title: "Delete Failed",
					message: "Failed to delete physician",
				});
			} finally {
				this.deleting = false;
			}
		},
		viewCase(caseEntity) {
			this.$router.push({
				name: "cases.view",
				params: {
					id: caseEntity.id,
				},
			});
		},
	},
	watch: {
		"$route.params.id": {
			handler(val) {
				this.entity = {
					id: null,
					first_name: null,
					last_name: null,
					full_name: null,
				};

				this.refresh();
			},
		},
	},
};
</script>