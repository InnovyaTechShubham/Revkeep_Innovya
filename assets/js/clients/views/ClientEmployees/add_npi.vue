<template>
	<div>
		<page-header>
			<template #title>
				<router-link :to="{ name: 'clientEmployees' }" v-text="`Physicians /`" />
				<span>Add From NPI Registry</span>
			</template>
			
			<!-- current requirement does not allow manually addition of physician if in future requirement changes uncomment the below code 
				rest all the functionalities are untouched
				
				<template #buttons>
				<b-button variant="secondary" :to="{ name: 'clientEmployees.add' }" title="Add Physician">
					<font-awesome-icon icon="pencil" fixed-width />
					<span>Manual Create</span>
				</b-button>
			</template> -->

		</page-header>

		<b-row class="my-4">
			<b-col cols="12" lg="4" xl="3">
				<b-card no-body class="shadow-sm mb-4">
					<b-form @submit.prevent="npiLookup">
						<b-card-body>
							<b-form-group label="Npi Number" label-for="npi_number" label-cols="4" label-cols-lg="12">
								<b-input-group>
									<b-form-input name="npi_number" type="number" v-model="query.npi_number"
										:disabled="saving || searching" />
								</b-input-group>
							</b-form-group>

							<b-form-group label="First Name" label-for="first_name" label-cols="4" label-cols-lg="12">
								<b-input-group>
									<b-form-input name="first_name" type="text" v-model="query.first_name"
										:disabled="saving || searching" />
								</b-input-group>
							</b-form-group>

							<b-form-group label="Last Name" label-for="last_name" label-cols="4" label-cols-lg="12">
								<b-input-group>
									<b-form-input name="last_name" type="text" v-model="query.last_name"
										:disabled="saving || searching" />
								</b-input-group>
							</b-form-group>

							<!-- <b-form-group label="Name" label-for="name" label-cols="4" label-cols-lg="12">
								<b-input-group>
								  <b-form-input
								    name="name"
								    type="text"
								    v-model="query.name"
								    :disabled="saving || searching"
								    
								  />
								</b-input-group>
							    </b-form-group> -->

							<b-form-group label="State" label-for="state" label-cols="4" label-cols-lg="12">
								<b-form-select v-model="query.state" name="state" :options="states"
									value-field="abbreviation" text-field="name" :disabled="saving || searching" />
							</b-form-group>

							<b-form-group label="City" label-for="city" label-cols="4" label-cols-lg="12">
								<b-form-input name="city" type="text" v-model="query.city"
									:disabled="saving || searching" />
							</b-form-group>

							<b-form-group label="Zip Code" label-for="zip" label-cols="4" label-cols-lg="12">
								<b-form-input name="zip" type="text" v-model="query.zip" :disabled="saving || searching" />
							</b-form-group>

							<!-- <b-form-group label="State" label-for="state" label-cols="4" label-cols-lg="12">
								<b-form-select
									autofocus
									name="state"
									v-model="query.state"
									:options="states"
									value-field="abbreviation"
									text-field="name"
									:disabled="saving || searching"
								>
								</b-form-select>
							</b-form-group>
 
                             **add 'required' to make it compulsory as in the below example**

							<b-form-group label="First Name" label-for="first_name" label-cols="4" label-cols-lg="12">
								<b-input-group>
									<b-form-input
										name="first_name"
										type="text"
										v-model="query.first_name"
										:disabled="saving || searching"
										required
										placeholder="Required"
									/>
								</b-input-group>
							</b-form-group>

							<b-form-group label="Last Name" label-for="last_name" label-cols="4" label-cols-lg="12">
								<b-input-group>
									<b-form-input
										name="last_name"
										type="text"
										v-model="query.last_name"
										:disabled="saving || searching"
										required
										placeholder="Required"
									/>
								</b-input-group>
							</b-form-group> -->

						</b-card-body>
						<b-card-footer class="text-right">
							<b-row>
								<b-col cols="10" md="6" xl="4" class="mb-4 mb-md-0">
									<b-button variant="transparent" @click="clearFields" :disabled="searching || saving">
										Clear
									</b-button>
								</b-col>
								<b-col cols="11" md="4" offset-xl="3" xl="2">
									<b-button variant="primary" type="submit"
										:disabled="searching || saving || formInvalid">
										<span v-if="searching">Searching...</span>
										<span v-else>Search</span>
									</b-button>
								</b-col>
							</b-row>
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
									Enter a state and name to search individual providers in the NPI registry.
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
							<b-card-header class="d-flex align-items-right">
								<h6 class="mb2">{{ results.length }} Results</h6>
							</b-card-header>
							<b-list-group>
								<b-list-group-item v-for="(result, index) in results.slice(0, 50)" :key="index">
									<NPIIndividual :value="result"
										v-slot="{ active, name, number, fullPrimaryAddress, value }">
										<div class="d-flex justify-content-between align-items-start">
											<div class="d-flex justify-content-start align-items-top">
												<b-avatar icon :variant="active ? 'primary' : 'light'" class="mr-3">
													<font-awesome-icon icon="building" fixed-width />
												</b-avatar>
												<div>
													<h6 class="mb-1">{{ name }}</h6>
													<p class="mb-0 small text-muted" title="Primary Address">
														<font-awesome-icon icon="location-dot" fixed-width />
														<span>{{ fullPrimaryAddress }}</span>
													</p>
													<p class="mb-0 small text-muted" title="NPI Number">
														<font-awesome-icon icon="id-card" fixed-width />
														{{ number }}
													</p>
												</div>
											</div>
											<b-button @click="selectedResult(value)" variant="primary">
												<font-awesome-icon icon="plus" fixed-width />
												Add
											</b-button>
										</div>
									</NPIIndividual>
								</b-list-group-item>
							</b-list-group>
							<div v-if="results.length > 50" class="mt-3">
								<p class="text-muted">More than 50 results found. Please narrow your search.</p>
							</div>
						</b-col>
					</b-row>
					<b-row v-else-if="!searching && isEmpty">
						<b-col cols="12">
							<empty-result>
								No Results
								<template #content>
									No individuals were found in the NPI Registry matching what you provided.
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
import NPIIndividual from "@/clients/components/NPI/NPIIndividual.vue";

export default {
	name: "ViewAddClientEmployeeNPI",
	components: {
		NPIIndividual,
	},
	data() {
		return {
			error: "",
			query: {
				npi_number: "",
				first_name: "",
				last_name: "",
				state: "",
				city: "",
				zip: ""
			},
			results: [],
			saving: false,
			searching: false,
			searched: false,
		};
	},
	computed: {
		formInvalid() {
			if (
				this.query.npi_number === "" &&
				this.query.first_name === "" &&
				this.query.last_name === "" &&
				// this.query.state === "" &&
				this.query.city === "" &&
				this.query.zip === ""
			) {
				return true;
			}
			return false;
		},
		hasError() {
			return this.error && this.error !== "";
		},
		isEmpty() {
			return this.results.length <= 0;
		},

		...mapGetters({
			states: "states/states",
		}),
	},
	methods: {
		clearFields() {
			this.query.npi_number = "";
			this.query.first_name = "";
			this.query.last_name = "";
			this.query.state = "";
			this.query.city = "";
			this.query.zip = "";
		},

		async npiLookup() {
			try {
				this.error = "";
				this.searching = true;
				this.searched = true;
				console.log("zip:", this.query.zip);
				const response = await this.$store.dispatch("clientEmployees/lookup", {
					npi_number: this.query.npi_number,
					first_name: this.query.first_name,
					last_name: this.query.last_name,
					state: this.query.state,
					city: this.query.city,
					zip: this.query.zip,
					exact: true,

				});

				this.results = response;
				console.log("check", response);
				console.log("zip:", this.query.zip);

			} catch (e) {
				this.error = e.response?.data?.message ?? "An error occurred";
			} finally {
				this.searching = false;
			}
		},
		selectedResult(result) {
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

			if (!confirm(`Add physician '${result.name}'?`)) {
				return;
			}

			this.createFromResult(result);
		},
		async createFromResult(result) {
			try {
				this.saving = true;
				const address = result.addresses[0];
				const concatenatedAddress = `${address.address_1 ?? ""}, ${address.city ?? ""}, ${address.state ?? ""}, ${address.postal_code ?? ""}, ${address.country_name ?? ""}`;
				const Locaddress = result.addresses[1];
				const LocconcatenatedAddress = `${Locaddress.address_1 ?? ""}, ${Locaddress.city ?? ""}, ${Locaddress.state ?? ""}, ${Locaddress.postal_code ?? ""}, ${Locaddress.country_name ?? ""}`;
				const proprietorValue = result.sole_proprietor ? "YES" : "NO";
				const genderValue = result.gender === "M" ? "Male" : (result.gender === "F" ? "Female" : "");
				const otherName = result.other_names.length > 0
					? `${result.other_names[0].first_name ?? ""} ${result.other_names[0].middle_name ?? ""} ${result.other_names[0].last_name ?? ""}`.trim() || "NONE"
					: "NONE";

				// Initialize primaryTaxonomy and additionalTaxonomies arrays
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
				console.log("Attempting to create physician from ", result);
				console.log("address", concatenatedAddress);
				const entity = {
					first_name: result.first_name,
					last_name: result.last_name,
					title: result.credential,
					npi_number: result.number,
					active: result.active,
					state: result.addresses[0]?.state ?? "",
					gender: genderValue,
					othername: otherName,
					proprietor: proprietorValue,
					enumeration_type: result.enumeration_type,
					address_1: concatenatedAddress,
					address_2: LocconcatenatedAddress,
					locationPhoneNumber: result.addresses[0]?.telephone_number ?? "NONE",
					mailingPhoneNumber: result.addresses[1]?.telephone_number ?? "NONE",
					primaryTaxonomy: primaryTaxonomy,
					additionalTaxonomies: additionalTaxonomies.join(', ') || "NONE",
				};

				const newEntity = await this.$store.dispatch("clientEmployees/create", entity);

				this.$router.push({
					name: "clientEmployees.edit",
					params: {
						id: newEntity.id,
					},
				});

				this.$nextTick(function () {
					this.$store.dispatch("notify", {
						title: "Physician Created",
						message: "Physician created from NPI Registry successfully.",
						variant: "primary",
					});
				});
			} catch (e) {
				this.$store.dispatch("apiError", {
					error: e,
					title: "Unable to create physician",
					message: "This physician may have already been created or the name may have been previously used.",
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
