<template>
	<loading-indicator v-if="loading" class="my-5" title="Fetching physician..." />
	<validation-observer v-else v-bind="$attrs" ref="observer" v-slot="{ invalid }">
		<b-form @submit.prevent="save">
			<b-card no-body>
				<slot name="header"></slot>

				<!--           	TO DO
					
					this section below is for checking licenses if available then only new physician can be added , 
				currently this is commented out with formDisabled function , will have to come back to this later -->

				<!-- <div v-if="licensingEnabled && !loadingLicenses">
					<b-alert v-if="availableLicenses <= 0" show variant="danger" class="m-2 p-4 shadow">
						<b-row class="d-flex justify-content-between align-items-center">
							<b-col cols="12" lg="8" class="text-left text-lg-left mb-4 mb-lg-0">
								<p class="mb-0 font-weight-bold">
									<font-awesome-icon icon="exclamation-triangle" fixed-width class="mr-1" />
									<span>You have no licenses left.</span>
								</p>
								<p class="mb-0">Update your subscription and add more licenses to create physicians.</p>
							</b-col>
							<b-col cols="12" lg="4" class="text-left text-lg-right">
								<b-button :to="{ name: 'subscription' }" variant="primary">
									Update Subscription
								</b-button>
							</b-col>
						</b-row>
					</b-alert>
					<b-alert v-else-if="availableLicenses <= licenseWarnThreshold" show variant="info"
						class="m-2 p-4 shadow">
						<b-row class="d-flex justify-content-between align-items-center">
							<b-col cols="12" lg="8" class="text-left text-lg-left mb-4 mb-lg-0">
								<p class="mb-0 font-weight-bold">
									<font-awesome-icon icon="info-circle" fixed-width class="mr-1" />
									<span>You have {{ availableLicenses }} licenses left.</span>
								</p>
							</b-col>
							<b-col cols="12" lg="4" class="text-left text-lg-right">
								<b-button :to="{ name: 'subscription' }" variant="info"> Update Subscription </b-button>
							</b-col>
						</b-row>
					</b-alert>
				</div> 
			-->

				<b-card-body class="mb-0">
					<validation-provider vid="first_name" name="First Name" :rules="{ required: true, alpha_dash: true }"
						v-slot="validationContext">
						<b-form-group label="First Name" label-for="first_name" label-cols-lg="4">
							<b-form-input autofocus name="first_name" type="text" v-model="entity.first_name"
								required="required" placeholder="Required" :state="getValidationState(validationContext)"
								:disabled="saving || formDisabled || fromNPI" />
							<b-form-invalid-feedback v-for="error in validationContext.errors" :key="error"
								v-text="error" />
						</b-form-group>
					</validation-provider>

					<validation-provider vid="last_name" name="Last Name" :rules="{ required: true, alpha_dash: true }"
						v-slot="validationContext">
						<b-form-group label="Last Name" label-for="last_name" label-cols-lg="4">
							<b-form-input name="last_name" type="text" v-model="entity.last_name" required="required"
								placeholder="Required" :state="getValidationState(validationContext)"
								:disabled="saving || formDisabled || fromNPI" />
							<b-form-invalid-feedback v-for="error in validationContext.errors" :key="error"
								v-text="error" />
						</b-form-group>
					</validation-provider>

					<b-form-group label="Title" label-for="title" label-cols-lg="4">
						<b-form-input name="title" type="text" v-model="entity.title"
							:disabled="saving || formDisabled || fromNPI" />
					</b-form-group>

					<!-- <b-form-group label="Facility" label-for="facility_id" label-cols-lg="4">
						<b-input-group>
							<b-form-input type="text" name="facilitySearch" v-model="facilitySearchTerm"
								:disabled="saving || loadingFacilities || formDisabled"
								placeholder="Search for a facility..." @input="filterFacilities" />
							<b-input-group-append>
								<b-input-group-text>
									<font-awesome-icon icon="search" fixed-width />
								</b-input-group-text>
							</b-input-group-append>
						</b-input-group>
						<div>
							<b-list-group v-if="selectedFacilities.length > 0">
								<b-list-group-item v-for="facility in selectedFacilities" :key="facility.id">
									{{ facility.name }}
									<b-btn @click="deselectFacility(facility)" size="sm" variant="danger">Remove</b-btn>
								</b-list-group-item>
							</b-list-group>
						</div>
						<div v-if="filteredFacilities.length > 0">
							<b-list-group>
								<b-list-group-item v-for="facility in filteredFacilities" :key="facility.id"
									@click="selectFacility(facility)">
									{{ facility.name }}
								</b-list-group-item>
							</b-list-group>
						</div>
					</b-form-group> -->

					<b-form-group label="Facility" label-for="facility_id" label-cols-lg="4">
						<b-input-group>
							<b-form-input type="text" name="facilitySearch" v-model="facilitySearchTerm"
								:disabled="saving || loadingFacilities || formDisabled"
								placeholder="Search for a facility..." @input="filterFacilities" />
							<b-input-group-append>
								<b-input-group-text>
									<font-awesome-icon icon="search" fixed-width />
								</b-input-group-text>
							</b-input-group-append>
						</b-input-group>
						<div>
							<!-- Display selected facilities as pills with a cross -->
							<b-badge v-for="facility in selectedFacilities" :key="facility.id" variant="primary"
								class="mr-1 mb-1">
								{{ facility.name }}
								<span @click="deselectFacility(facility)"
									style="cursor: pointer; margin-left: 4px; color: red;">x</span>
							</b-badge>
						</div>
						<div v-if="filteredFacilities.length > 0">
							<!-- Display filtered facilities for selection -->
							<b-list-group>
								<b-list-group-item v-for="facility in filteredFacilities" :key="facility.id"
									@click="selectFacility(facility)">
									{{ facility.name }}
								</b-list-group-item>
							</b-list-group>
						</div>
					</b-form-group>


					<b-form-group label="State" label-for="state" label-cols-lg="4">
						<b-form-select name="state" v-model="entity.state" :options="states"
							:disabled="saving || formDisabled || fromNPI" value-field="abbreviation" text-field="name" />
					</b-form-group>

					<validation-provider vid="npi_number" name="NPI Number" :rules="{ required: true, numeric: true }"
						v-slot="validationContext">
						<b-form-group label="NPI Number" label-for="npi_number" label-cols-lg="4">
							<b-input-group>
								<b-form-input name="npi_number" type="text" placeholder="Required"
									v-model="entity.npi_number" :disabled="saving || formDisabled || fromNPI"
									:state="getValidationState(validationContext)" />
								<b-form-invalid-feedback v-for="error in validationContext.errors" :key="error"
									v-text="error" />
							</b-input-group>
						</b-form-group>
					</validation-provider>

					<validation-provider vid="active" name="Active" :rules="{ required: false }" v-slot="validationContext">
						<b-form-group label="Active" label-for="active" label-cols-lg="4"
							description="Inactive physicians will not show up in dropdown lists.">
							<b-form-checkbox name="active" v-model="entity.active"
								:disabled="saving">Active</b-form-checkbox>
							<b-form-invalid-feedback v-for="error in validationContext.errors" :key="error"
								v-text="error" />
						</b-form-group>
					</validation-provider>
				</b-card-body>

				<b-card no-body>
					<b-card-header header-tag="header" role="tab" class="p-0">
						<b-button block v-b-toggle.collapseContactInformation variant="light" role="tab"
							class="text-left px-4 py-3 m-0">
							<h6 class="mb-0">Contact Information</h6>
						</b-button>
					</b-card-header>
					<b-collapse id="collapseContactInformation" role="tabpanel">
						<b-card-body>
							<b-form-group label="Email Address" label-for="email" label-cols-lg="4">
								<b-form-input name="email" type="email" v-model="entity.email"
									:disabled="saving || formDisabled" />
							</b-form-group>

							<b-form-group label="Work Phone" label-for="workPhone" label-cols-lg="4">
								<b-form-input name="workPhone" type="tel" v-model="entity.work_phone"
									v-mask="'(###) ###-####'" :disabled="saving || formDisabled" />
							</b-form-group>

							<b-form-group label="Mobile Phone" label-for="mobilePhone" label-cols-lg="4">
								<b-form-input name="mobilePhone" type="tel" v-model="entity.mobile_phone"
									v-mask="'(###) ###-####'" :disabled="saving || formDisabled" />
							</b-form-group>
						</b-card-body>
					</b-collapse>
				</b-card>



				<b-card v-if="fromNPI" no-body class="compact-card">
					<b-card-header header-tag="header" role="tab" class="p-0">
						<b-button block v-b-toggle.collapseNpiInformation variant="light" role="tab"
							class="text-left px-4 py-3 m-0">
							<h6 class="mb-0">NPI Information</h6>
						</b-button>
					</b-card-header>
					<b-collapse id="collapseNpiInformation" role="tabpanel">
						<b-card-body>
							<div class="d-flex">
								<div class="flex-grow-1 pr-3">
									<div class="label-value-row">
										<div class="label-text">Other Name:</div>
										<div class="text">{{ entity.othername }}</div>
									</div>
									<div class="label-value-row">
										<div class="label-text">Enumeration Type:</div>
										<div class="text">{{ entity.enumeration_type }}</div>
									</div>
									<div class="label-value-row">
										<div class="label-text">Gender:</div>
										<div class="text">{{ entity.gender }}</div>
									</div>
									<div class="label-value-row">
										<div class="label-text">Sole Proprietor ?</div>
										<div class="text">{{ entity.proprietor }}</div>
									</div>


									<hr class="my-2">

									<div class="d-flex">
										<div class="flex-grow-1 pr-3">
											<div class="label-value-row">
												<div class="label-text">Location Address:</div>
												<div class="text">{{ entity.address_2 }}</div>
											</div>
											<div class="label-value-row">
												<div class="label-text">Phone Number:</div>
												<div class="text">{{ entity.locationPhoneNumber }}</div>
											</div>
											<hr class="my-1">
											<div class="label-value-row">
												<div class="label-text">Mailing Address:</div>
												<div class="text">{{ entity.address_1 }}</div>
											</div>
											<div class="label-value-row">
												<div class="label-text">Phone Number:</div>
												<div class="text">{{ entity.mailingPhoneNumber }}</div>
											</div>
										</div>
									</div>


									<hr class="my-2">

									<div class="d-flex">
										<div class="flex-grow-1 pr-3">
											<div class="label-value-row">
												<div class="label-text">Primary Taxonomy:</div>
												<div class="text">{{ entity.primaryTaxonomy }}</div>
											</div>
											<hr class="my-2">
											<div class="label-value-row">
												<div class="label-text">Additional Taxonomies:</div>
												<div class="text">{{ entity.additionalTaxonomies }}</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</b-card-body>
					</b-collapse>
				</b-card>

				<b-card-footer>
					<b-row>
						<b-col cols="12" md="6" xl="4" class="mb-4 mb-md-0">
							<b-button block variant="light" type="button" @click.stop="cancel">Cancel</b-button>
						</b-col>
						<b-col cols="12" md="6" xl="4" offset-xl="4" class="mb-2 mb-md-0">
							<b-button block variant="primary" type="submit" :disabled="saving || invalid || formDisabled">
								<font-awesome-icon v-if="saving" icon="circle-notch" spin fixed-width />
								<span>Save</span>
							</b-button>
						</b-col>
					</b-row>
				</b-card-footer>
			</b-card>
		</b-form>
	</validation-observer>
</template>

<script type="text/javascript">
import { mapGetters } from "vuex";
import { formatErrors, getValidationState } from "@/validation";
import axios from 'axios';

export default {
	name: "ClientEmployeeForm",
	components: {},
	props: {
		id: {
			default: null,
		},
		facilityId: {
			default: null,
		},
	},
	data() {
		return {
			MatchingFacility: [],
			selectedFacilityNames: [],
			selectedFacilities: [],
			facilitySearchTerm: '',
			filteredFacilities: [],
			loading: true,
			searchingNpi: null,
			npiResults: [],
			saving: false,
			entity: {
				id: this.id,
				facility_id: this.facilityId,
				first_name: null,
				last_name: null,
				title: null,
				npi_number: null,
				work_phone: null,
				mobile_phone: null,
				email: null,
				state: null,
				active: true,
				gender: null,
				othername: null,
				enumeration_type: null,
				proprietor: null,
				address_1: null,
				address_2: null,
				locationPhoneNumber: null,
				mailingPhoneNumber: null,
				primaryTaxonomy: null,
				additionalTaxonomies: null,
				selectedFacilityIds: [],

			},
			populated: false,
			loadingFacilities: false,
		};
	},
	watch: {
		facilityId(newFacilityId) {
			this.entity.facility_id = newFacilityId;
		},
	},
	computed: {
		enteredName() {
			return this.entity.first_name && this.entity.last_name;
		},
		lookupDisabled() {
			return this.searchingNpi || !this.enteredName || !this.entity.state;
		},
		// formDisabled() {
		// 	if (!this.licensingEnabled) {
		// 		return false;
		// 	}

		// 	return this.entity.id == null && this.availableLicenses <= 0;
		// },
		fromNPI() {
			if (this.entity.id !== null) {
				return true;
			}
		},
		...mapGetters({
			facilities: "facilities/active",
			loadingFacilities: "facilities/loadingActive",
			states: "states/states",
			licensingEnabled: "licenses/enabled",
			availableLicenses: "licenses/available",
			loadingLicenses: "licenses/loading",
			licenseWarnThreshold: "licenses/warnThreshold",
		}),
	},
	mounted() {
		if (!this.id) {
			this.loading = false;
		} else {
			this.refresh();
			this.fetchClientFacilities();
		}

	},
	methods: {
		filterFacilities() {
			// Implement the logic to filter facilities based on the search term
			const searchTerm = this.facilitySearchTerm.toLowerCase();
			this.filteredFacilities = this.facilities.filter((facility) =>
				facility.name.toLowerCase().includes(searchTerm)
			);
		},
		// selectFacility(selectedFacility) {
		// 	console.log('Selected Facility:', selectedFacility);
		// 	// Set the selected facility to the entity
		// 	this.entity.facility_id = selectedFacility.id;
		// 	// Clear the search term and filtered facilities
		// 	this.facilitySearchTerm = '';
		// 	this.filteredFacilities = [];
		// },
		// working for adding only one physician

		selectFacility(selectedFacility) {

			console.log('Selected Facility:', selectedFacility);
			// Check if the facility is not already selected
			if (!this.selectedFacilities.some(facility => facility.id === selectedFacility.id)) {
				// Push the selected facility to the array
				this.selectedFacilities.push(selectedFacility);

				// Update selectedFacilityIds in the entity
				this.entity.selectedFacilityIds = this.selectedFacilities.map(facility => facility.id);

				// Log the IDs of the selected facilities
				console.log('Selected Facility IDs:', this.entity.selectedFacilityIds);
			}

			// Clear the search term and filtered facilities
			this.facilitySearchTerm = '';
			this.filteredFacilities = [];

		},
		// deselectFacility(selectedFacility) {
		// 	// Remove the selected facility from the array
		// 	this.selectedFacilities = this.selectedFacilities.filter(facility => facility.id !== selectedFacility.id);
		// },

		deselectFacility(selectedFacility) {
    // Remove the selected facility from the array
    this.selectedFacilities = this.selectedFacilities.filter(facility => facility.id !== selectedFacility.id);

    // Update selectedFacilityIds in the entity
    this.entity.selectedFacilityIds = this.selectedFacilities.map(facility => facility.id);
},


		getValidationState,
		cancel() {
			this.$emit("cancel");
		},
		async refresh() {
			try {
				this.loading = true;

				const response = await this.$store.dispatch("clientEmployees/get", {
					id: this.id,
				});

				this.entity = response;
				this.$emit("loaded", response);
				console.log(response);
			} catch (e) {
				this.$store.dispatch("apiError", {
					error: e,
					message: "Error getting employee details",
				});
			} finally {
				this.loading = false;
				this.initialLoaded = true;
			}
		},
		async fetchClientFacilities() {
			try {
				const url = "/client/fetchmultiplefacility";

				// Fetch data from the server
				const response = await axios.get(url, {
					headers: {
						"Accept": "application/json",
					},
				});

				console.log("RESPONSE = ", response.data);

				// Filter client facilities based on the route parameter
				this.clientFacilities = response.data.filter(item => item.client_id === this.id);

				// Extract facility IDs directly without cleaning the array
				const matchingFacilityIds = this.clientFacilities.map(item => item.facility_id);

				// Display the matching facility IDs
				console.log("Matching Facility IDs:", matchingFacilityIds);

				// Update MatchingFacility array elements individually to maintain reactivity
				this.MatchingFacility.splice(0, this.MatchingFacility.length, ...matchingFacilityIds);
				console.log(this.MatchingFacility);
				this.selectedFacilities = this.facilities.filter(facility => matchingFacilityIds.includes(facility.id));
			} catch (error) {
				console.error("Error fetching client facilities:", error);
			}
		},


		async save(e) {
			try {
				this.saving = true;

				console.log('Selected Facility IDs:', this.entity.selectedFacilityIds);

				const response = await this.$store.dispatch("clientEmployees/save", this.entity);

				await this.saveWithFacilities(response.id);
				this.$emit("saved", response);
				this.$emit("update:id", response.id);

			} catch (e) {
				if (e.response.data.errors) {
					this.$refs.observer.setErrors(formatErrors(e.response.data.errors));
				}

				this.$store.dispatch("apiError", {
					error: e,
					title: "Save Failed",
					message: "Error saving employee details. Please check for errors.",
					variant: "warning",
				});
			} finally {
				this.saving = false;
			}
		},
		async saveWithFacilities() {
			try {
				// Prepare the data to be sent
				const data = {
					id: this.entity.id,
					selectedFacilityIds: this.entity.selectedFacilityIds,
					selectedFacilityNames: this.selectedFacilities.map(facility => facility.name),
					//selectedFacilities: this.selectedFacilities.map(facility => ({ id: facility.id, name: facility.name })),
				};
				console.log("data", data);
				// Make the axios post request to your CakePHP controller
				const response = await axios.post('/client/multiplefacility', data);
				console.log("request sent")
				// Handle the response as needed
				// console.log(response.data);

				this.$emit("savedWithFacilities", response.data); // Emit event for successful saveWithFacilities

			} catch (e) {
				// Handle errors
				console.error('Error:', e);
				this.$store.dispatch("apiError", {
					error: e,
					title: "Save With Facilities Failed",
					message: "Error saving facilities details. Please check for errors.",
					variant: "warning",
				});

			}
		},

	},
};
</script>
<style scoped>
.compact-card {
	margin-bottom: 0;
}

.label-value-row {
	display: flex;
	justify-content: flex-start;
	align-items: center;
	margin-bottom: 0.2rem;
}

.label-text {
	font-weight: bold;
	display: inline-block;
	width: 150px;
	margin-right: 10px;
}
</style>