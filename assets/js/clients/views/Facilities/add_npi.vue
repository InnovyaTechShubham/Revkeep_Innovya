<template>
	<div>
		<page-header>
			<template #title>
				<router-link :to="{ name: 'facilities' }" v-text="`Facilities /`" />
				<span>Add From NPI Registry</span>
			</template>
			<template #buttons>
				<b-button variant="secondary" :to="{ name: 'facilities.add' }" title="Add Facility">
					<font-awesome-icon icon="pencil" fixed-width />
					<span>Manual Create</span>
				</b-button>
			</template>
		</page-header>

		<b-row class="my-4">
			<b-col cols="12" lg="4" xl="3">
				<b-card no-body class="shadow-sm mb-4">
					<b-form @submit.prevent="npiLookup">
						<b-card-body>

							<b-form-group label="Name" label-for="name" label-cols="4" label-cols-lg="12">
								<b-input-group>
								  <b-form-input
								    name="name"
								    type="text"
								    v-model="query.name"
								    
								  />
								</b-input-group>
							    </b-form-group>

							<b-form-group label="State" label-for="state" label-cols="4" label-cols-lg="12">
								<b-form-select
									v-model="query.state"
									name="state"
									:options="states"
									value-field="abbreviation"
									text-field="name"
									
								
								/>
							</b-form-group>

							<b-form-group label="City" label-for="city" label-cols="4" label-cols-lg="12">
								<b-form-input
								  name="city"
								  type="text"
								  v-model="query.city"
								  
								/>
							    </b-form-group>
							    
							    <b-form-group label="Zip" label-for="zip" label-cols="4" label-cols-lg="12">
								<b-form-input
								  name="zip"
								  type="text"
								  v-model="query.zip"
								  
								/>
							    </b-form-group>
							    
							    

						</b-card-body>
						<b-card-footer class="text-right">
							<b-button variant="primary" type="submit"
							:disabled="searching || saving || formInvalid">

								<font-awesome-icon v-if="searching" icon="circle-notch" spin fixed-width />
								<span v-if="searching">Searching...</span>
								<span v-else>Search</span>
							</b-button>
						</b-card-footer>
					</b-form>
				</b-card>
			</b-col>
			<b-col cols="12" lg="8" xl="9">
				<b-card no-body>
					<b-row v-if="!searched">
						<b-col cols="12">
							<empty-result>
								Search NPI
								<template #content>
									Enter state, city, zip code or organization name to search facilities in the NPI registry.
								</template>
							</empty-result>
						</b-col>
					</b-row>
					<b-row v-else-if="hasError">
						<b-col cols="12">
							<error-alert>
								{{ error }}
								<template #content>
									<p class="mb-0">
										The NPI registry is maintained by CMS and may be experiencing technical
										difficulties.
									</p>
									<p class="mb-0">
										Please try again in a few moments, or report this issue to support if the
										problem persists.
									</p>
								</template>
							</error-alert>
						</b-col>
					</b-row>
					<b-row v-else-if="!isEmpty">
						<b-col cols="12">
							<b-card no-body>
								<b-card-header class="d-flex align-items-center">
									<h6 class="mb-0">{{ results.length }} Results</h6>
								</b-card-header>

								<b-list-group flush>
									<b-list-group-item v-for="npiResult in results" :key="npiResult.number">
										<NPIOrganization
											:value="npiResult"
											v-slot="{
												active,
												contactFullName,
												lastUpdated,
												name,
												number,
												fullPrimaryAddress,
												value,
											}"
										>
											<div class="d-flex justify-content-between align-items-start">
												<div class="d-flex justify-content-start align-items-top">
													<b-avatar
														icon
														:variant="active ? 'primary' : 'light'"
														class="mr-3 mt-2"
													>
														<font-awesome-icon icon="building" fixed-width />
													</b-avatar>
													<div>
														<p class="mb-1 small text-muted" title="NPI Number">
															#{{ number }}
														</p>
														<h6 class="h6 font-weight-bold mb-1">{{ name }}</h6>
														<p class="mb-1" title="Primary Address">
															<font-awesome-icon icon="location-dot" fixed-width />
															<span>{{ fullPrimaryAddress }}</span>
														</p>
														<p
															v-if="contactFullName"
															class="mb-0 small text-muted"
															title="Contact Person"
														>
															<font-awesome-icon icon="user" fixed-width />
															<span>{{ contactFullName }}</span>
														</p>

														<p
															v-if="lastUpdated"
															class="mt-1 mb-0 small text-muted"
															title="Last Updated"
														>
															<span>Last updated {{ lastUpdated }}</span>
														</p>

														<div>
															<b-badge
																v-for="identifier in value.identifiers"
																:key="identifier.code"
																pill
																variant="light"
															>
																{{ identifier.identifier }} - {{ identifier.desc }}
															</b-badge>
														</div>

														<div>
															<b-badge
																v-for="taxonomy in value.taxonomies"
																:key="taxonomy.code"
																pill
																variant="light"
															>
																{{ taxonomy.code }} - {{ taxonomy.desc }}
															</b-badge>
														</div>
													</div>
												</div>
												<b-button @click="selectedNpiResult(value)" variant="primary">
													<font-awesome-icon icon="plus" fixed-width />
													Add
												</b-button>
											</div>
										</NPIOrganization>
									</b-list-group-item>
								</b-list-group>
							</b-card>
						</b-col>
					</b-row>
					<b-row v-else-if="!searching && isEmpty">
						<b-col cols="12">
							<empty-result>
								No Results
								<template #content>
									No organizations were found in the NPI Registry matching what you provided.
								</template>
							</empty-result>
						</b-col>
					</b-row>
					<b-row v-else-if="searching">
						<b-col cols="12">
							<loading-indicator class="my-5" title="Searching registry..." />
						</b-col>
					</b-row>
				</b-card>
			</b-col>
		</b-row>
	</div>
</template>

<script>
import { mapGetters } from "vuex";
import NPIOrganization from "@/clients/components/NPI/NPIOrganization.vue";

export default {
	name: "ViewAddFacilityNPI",
	components: {
		NPIOrganization,
	},
	data() {
		return {
			error: "",
			query: {
				name: "",
				state: "",
				zip: "",  
      			city: "",
			},
			results: [],
			saving: false,
			searching: false,
			searched: false,
		};
	},
	computed: {
		formInvalid() {
			const filledFields = Object.values(this.query).filter(value => value !== "").length;
			return filledFields < 2;
		},
		hasError() {
			return this.error && this.error !== "";
		},
		isEmpty() {
			return this.results.length <= 0;
		},
		...mapGetters({
			states: "states/states",
			facilityTypes: "facilityTypes/all",
		}),
	},
	methods: {
		async npiLookup() {
			try {
				this.error = "";
				this.searching = true;
				this.searched = true;

				const response = await this.$store.dispatch("facilities/npiLookup", {
					name: this.query.name,
					state: this.query.state,
					city: this.query.city,
					zip: this.query.zip,
				});

				this.results = response;

				if (this.results.length > 30) {
					// Clear the results array before showing the message box
					this.results = [];

					// this.$bvModal.msgBoxOk('There are more than 20 facilities for your search criteria. Please narrow your search.', {
					// 	title: 'Too Many Results',
					// 	size: 'md',
					// 	buttonSize: 'md',
					// 	centered: true,
					// 	okVariant: 'primary',
					// 	headerBgVariant: 'syne',
					// 	bodyBgVariant: 'lightblue',
					// 	footerBgVariant: 'light',
					// 	okTitle: 'OK',
					// 	cancelTitle: 'Cancel',
					// 	bodyClass: 'text-primary',
					// 	hideHeaderClose: true,
					// 	buttonClass: 'custom-button-class',
					// 	footerClass: 'd-flex justify-content-center', // Use flex utilities to center the buttons
					// }).then(() => {
					// 	this.clearForm();
					// 	// The results array is already cleared, so no need to further manipulate it
					// });


					this.$bvModal.msgBoxOk('There are more than 30 facilities for your search criteria. Please narrow your search.', {
						title: 'Too Many Results',
						size: 'md',
						buttonSize: 'md',
						centered: true,
						okVariant: 'primary',
						headerBgVariant: 'syne',
						bodyBgVariant: 'lightblue',
						footerBgVariant: 'light',
						okTitle: 'OK',
						cancelTitle: 'Cancel',
						bodyClass: 'text-primary body-layout',
						hideHeaderClose: true,
						//buttonClass: 'custom-button-class', // Add your custom class for buttons
						footerClass: 'd-flex justify-content-center',
					}).then(() => {
						//this.clearForm();
						// The results array is already cleared, so no need to further manipulate it
					});


					return;
				}
			} catch (e) {
				this.error = e.response?.data?.message ?? "An error occurred";
			} finally {
				this.searching = false;
			}
		},
		selectedNpiResult(result) {
			if (!result) {
				this.$store.dispatch("apiError", {
					error: e,
					title: "Invalid NPI Result",
					message: "Sorry, there was an issue copying NPI details. Please enter manually.",
					variant: "warning",
					data: result,
				});
				return;
			}

			if (!confirm(`Add facility '${result.name}'?`)) {
				return;
			}
			console.log("Result=",result);

			// Try to set facility type as 'Other'
			// @todo Make this better
			// const facilityTypeId = this.facilityTypes.find((facilityType) => facilityType.name == "Other")?.id ?? 1;

			// const locationAddress = result.addresses.find((address) => address.address_purpose == "LOCATION");
			// if (locationAddress) {
			// 	// Contact
			// 	entity.phone = locationAddress.telephone_number ?? "";
			// 	entity.fax = locationAddress.fax_number ?? "";
			// 	// Address
			// 	entity.street_address_1 = locationAddress.address_1 ?? "";
			// 	entity.street_address_2 = locationAddress.address_2 ?? "";
			// 	entity.city = locationAddress.city ?? "";
			// 	entity.state = locationAddress.state ?? "";
			// 	entity.zip = locationAddress.postal_code ?? "";
			// } else {
			// 	console.warn("Unable to parse location address", locationAddress);
			// }

			// const mailingAddress = result.addresses.find((address) => address.address_purpose == "MAILING");
			// if (mailingAddress) {
			// 	// Contact
			// 	entity.phone = mailingAddress.telephone_number ?? "";
			// 	entity.fax = mailingAddress.fax_number ?? "";
			// 	// Address
			// 	entity.street_address_1 = mailingAddress.address_1 ?? "";
			// 	entity.street_address_2 = mailingAddress.address_2 ?? "";
			// 	entity.city = mailingAddress.city ?? "";
			// 	entity.state = mailingAddress.state ?? "";
			// 	entity.zip = mailingAddress.postal_code ?? "";
			// } else {
			// 	console.warn("Unable to parse mailing address", locationAddress);
			// }
	
		
			// const primaryTaxonomy = result.taxonomies.find((taxonomy) => taxonomy.primary == true);
			// if (primaryTaxonomy) {
			// 	entity.primary_taxonomy = primaryTaxonomy.code ?? "";
			// } else {
			// 	console.warn("Unable to parse primary taxonomy", primaryTaxonomy);
			// }
			
			// var entity = {
			// 	active: true,
			// 	name: result.name,
			// 	facility_type_id: facilityTypeId,
			// 	npi_number: result.number ?? "",
			// 	npi_manual: false,
			// 	address_1:concatenatedAddress,
			// 	address_2:locationAddress,

			// };

				// Try to set facility type as 'Other'
				// @todo Make this better
				const facilityTypeId = this.facilityTypes.find((facilityType) => facilityType.name == "Other")?.id ?? 1;
				
				const address = result.addresses[0];
				const concatenatedAddress = `${address.address_1 ?? ""}, ${address.city ?? ""}, ${address.state ?? ""}, ${address.postal_code ?? ""}, ${address.country_name ?? ""}`;
				const Locaddress = result.addresses[1];
				const LocconcatenatedAddress = `${Locaddress.address_1 ?? ""}, ${Locaddress.city ?? ""}, ${Locaddress.state ?? ""}, ${Locaddress.postal_code ?? ""}, ${Locaddress.country_name ?? ""}`;

				const otherName = result.other_names.length > 0 ? `${result.other_names[0].organization_name ?? ""}`: "NONE";
				const subPart = result.organizational_subpart ? "YES" : "NO";

				//Initialize primaryTaxonomy and additionalTaxonomies arrays
				let primaryTaxonomy = "";
				let additionalTaxonomies = [];

				// Loop through the taxonomies array
				for (const taxonomy of result.taxonomies) {
					if (taxonomy.primary) {
						// If primary taxonomy, concatenate code, desc, and license
						primaryTaxonomy = `${taxonomy.code ?? ""} - ${taxonomy.desc ?? ""}, (License: ${taxonomy.license ?? ""})`;
					} else {
						// If additional taxonomy, concatenate code, desc, and license, and add to additionalTaxonomies array
						const additionalTaxonomy = `${taxonomy.code ?? ""} - ${taxonomy.desc ?? ""}, (License: ${taxonomy.license ?? ""})`;
						additionalTaxonomies.push(additionalTaxonomy);
					}
				}
				var entity = {
				active: result.active,
				name: result.name,
				facility_type_id: facilityTypeId,
				npi_number: result.number ?? "",
				npi_manual: false,
				address_1:LocconcatenatedAddress,
				address_2:concatenatedAddress,
				state: result.addresses[1]?.state ?? "",
				othername: otherName,
				enumeration_type: result.enumeration_type,
				locationPhoneNumber: result.addresses[1]?.telephone_number ?? "NONE",
				mailingPhoneNumber: result.addresses[0]?.telephone_number ?? "NONE",
				primaryTaxonomy: primaryTaxonomy,
				additionalTaxonomies: additionalTaxonomies.join(', ') || "NONE",
				organizational_subpart: subPart,


				};
				console.log("entity=", entity);
			this.createFromResult(entity);
			// this.reset();
		},
		async createFromResult(result) {
			try {
				this.saving = true;
				// // Try to set facility type as 'Other'
				// // @todo Make this better
				
				// const address = result.addresses[0];
				// const concatenatedAddress = `${address.address_1 ?? ""}, ${address.city ?? ""}, ${address.state ?? ""}, ${address.postal_code ?? ""}, ${address.country_name ?? ""}`;
				// const Locaddress = result.addresses[1];
				// const LocconcatenatedAddress = `${Locaddress.address_1 ?? ""}, ${Locaddress.city ?? ""}, ${Locaddress.state ?? ""}, ${Locaddress.postal_code ?? ""}, ${Locaddress.country_name ?? ""}`;

				// const otherName = result.other_names.length > 0 ? `${result.other_names[0].organization_name ?? ""}`: "NONE";
				// const subPart = result.organizational_subpart ? "YES" : "NO";

				// //Initialize primaryTaxonomy and additionalTaxonomies arrays
				// let primaryTaxonomy = "";
				// let additionalTaxonomies = [];

				// // Loop through the taxonomies array
				// for (const taxonomy of result.taxonomies) {
				// 	if (taxonomy.primary) {
				// 		// If primary taxonomy, concatenate code, desc, and license
				// 		primaryTaxonomy = `${taxonomy.code ?? ""} - ${taxonomy.desc ?? ""}, (License: ${taxonomy.license ?? ""})`;
				// 	} else {
				// 		// If additional taxonomy, concatenate code, desc, and license, and add to additionalTaxonomies array
				// 		const additionalTaxonomy = `${taxonomy.code ?? ""} - ${taxonomy.desc ?? ""}, (License: ${taxonomy.license ?? ""})`;
				// 		additionalTaxonomies.push(additionalTaxonomy);
				// 	}
				// }
				// const entity = {
				// active: result.active,
				// name: result.name,
				// facility_type_id: facilityTypeId,
				// npi_number: result.number ?? "",
				// npi_manual: false,
				// address_1:LocconcatenatedAddress,
				// address_2:concatenatedAddress,
				// state: result.addresses[1]?.state ?? "",
				// othername: otherName,
				// enumeration_type: result.enumeration_type,
				// locationPhoneNumber: result.addresses[1]?.telephone_number ?? "NONE",
				// mailingPhoneNumber: result.addresses[0]?.telephone_number ?? "NONE",
				// primaryTaxonomy: primaryTaxonomy,
				// additionalTaxonomies: additionalTaxonomies.join(', ') || "NONE",
				// organizational_subpart: subPart,


				// };

				const newEntity = await this.$store.dispatch("facilities/create", result);
				console.log("New entity=", newEntity);
				this.$router.push({
					name: "facilities.edit",
					params: {
						id: newEntity.id,
					},
				});

				this.$nextTick(function () {
					this.$store.dispatch("notify", {
						title: "Facility Created",
						message: "Facility created from NPI Registry successfully.",
						variant: "primary",
					});
				});
			} catch (e) {
				this.$store.dispatch("apiError", {
					error: e,
					title: "Unable to create facility",
					message: "This facility may have already been created or the name may have been previously used.",
					variant: "warning",
					data: result,
				});
			} finally {
				this.saving = false;
			}
		},
		reset() {
			this.error = "";
			this.results = [];
			this.searched = false;
		},
	},
};
</script>
