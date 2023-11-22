<template>
	<loading-indicator v-if="loading" class="my-5" />
	<validation-observer v-else v-bind="$attrs" ref="observer" v-slot="{ invalid }">
		<b-form @submit.prevent="save">
			<b-card no-body>
				<slot name="header"></slot>
				<b-card-body>
					<validation-provider
						vid="first_name"
						name="First Name"
						:rules="{ required: true, min: 1, max: 50 }"
						v-slot="validationContext"
					>
						<b-form-group label="First Name" label-for="first_name" label-cols-lg="4">
							<b-form-input
								autofocus
								name="first_name"
								type="text"
								v-model="entity.first_name"
								required="required"
								placeholder="Required"
								:state="getValidationState(validationContext)"
								:disabled="saving"
							/>
							<b-form-invalid-feedback
								v-for="error in validationContext.errors"
								:key="error"
								v-text="error"
							/>
						</b-form-group>
					</validation-provider>
					<validation-provider
						vid="middle_name"
						name="Middle Name"
						:rules="{ required: false, max: 50 }"
						v-slot="validationContext"
					>
						<b-form-group label="Middle Name" label-for="middle_name" label-cols-lg="4">
							<b-form-input
								name="middle_name"
								type="text"
								v-model="entity.middle_name"
								:state="getValidationState(validationContext)"
								:disabled="saving"
							/>
							<b-form-invalid-feedback
								v-for="error in validationContext.errors"
								:key="error"
								v-text="error"
							/>
						</b-form-group>
					</validation-provider>

					<validation-provider
						vid="last_name"
						name="Last Name"
						:rules="{ required: true, min: 1, max: 50 }"
						v-slot="validationContext"
					>
						<b-form-group label="Last Name" label-for="last_name" label-cols-lg="4">
							<b-form-input
								name="last_name"
								type="text"
								v-model="entity.last_name"
								required="required"
								placeholder="Required"
								:state="getValidationState(validationContext)"
								:disabled="saving"
							/>
							<b-form-invalid-feedback
								v-for="error in validationContext.errors"
								:key="error"
								v-text="error"
							/>
						</b-form-group>
					</validation-provider>
					<validation-provider
					vid="professional_degree"
					name="Professional Degree"
					:rules="{ required: false }"
					v-slot="validationContext"
				>
					<b-form-group
						label="Profession Type"
						label-for="professional_degree"
						label-cols-lg="4"
					>
				<b-input-group>
					<b-form-select
						name="professional_degree"
						v-model="entity.professional_degree"
						:state="getValidationState(validationContext)"
						:disabled="saving"
					>
					<b-form-select-option v-for="option in professionTypeOptions" :key="option" :value="option">
        {{ option }}
    </b-form-select-option>
					</b-form-select>
					<template #append>
						<b-button
							variant="primary"
							@click="addingProfessionalDegree = true"
						>
							<font-awesome-icon icon="plus" fixed-width />
						</b-button>
					</template>
				</b-input-group>
						<b-form-invalid-feedback
							v-for="error in validationContext.errors"
							:key="error"
							v-text="error"
						/>
						<div v-if="addingProfessionalDegree" class="mb-4">
    <b-form @submit.prevent="saveProfessionalDegree">
        <b-card no-body>
            <b-card-body>
                <validation-provider
                    vid="new_professional_degree"
                    name="New Professional Degree"
                    :rules="{ required: true, min: 1, max: 50 }"
                    v-slot="validationContext"
                >
                    <b-form-group label="New Profession Type" label-for="new_professional_degree" label-cols-lg="4">
                        <b-form-input
						    id="new_professional_degree"
                            name="new_professional_degree"
                            type="text"
                            v-model="new_professional_degree"
                            required="required"
                            placeholder="Enter New Profession Type"
                            :state="getValidationState(validationContext)"
                            :disabled="saving"
                        />
                        <b-form-invalid-feedback
                            v-for="error in validationContext.errors"
                            :key="error"
                            v-text="error"
                        />
                    </b-form-group>
                </validation-provider>
            </b-card-body>

            <b-card-footer>
                <b-row>
                    <b-col cols="12" md="6" lg="4" class="mb-4 mb-md-0">
                        <b-button block variant="light" @click="cancelAddProfessionalDegree">Cancel</b-button>
                    </b-col>
                    <b-col cols="12" md="6" offset-lg="4" lg="4" class="mb-2 mb-md-0">
                        <b-button block variant="primary" type="submit" :disabled="saving">
                            <font-awesome-icon icon="circle-notch" v-if="saving" spin fixed-width />
                            <span>Save</span>
                        </b-button>
                    </b-col>
                </b-row>
            </b-card-footer>
        </b-card>
    </b-form>
</div>
					</b-form-group>
				</validation-provider>
					<div v-if="addingAgency" class="mb-4">
						<agency-form @cancel="addingAgency = false" @saved="addedNewAgency">
							<template #header>
								<b-card-header>
									<div class="d-flex justify-content-between align-items-center">
										<span class="font-weight-bold">Add New Agency</span>
										<b-button
											variant="secondary"
											size="sm"
											@click="addingAgency = false"
											title="Cancel"
											class="mb-0"
										>
											<font-awesome-icon icon="remove" fixed-width class="my-0 py-0" />
										</b-button>
									</div>
								</b-card-header>
							</template>
						</agency-form>
					</div>
					<div v-else>
						<validation-provider
							vid="agency_id"
							name="Agency"
							:rules="{ required: false }"
							v-slot="validationContext"
						>
							<b-form-group label="Agency" label-for="agency_id" label-cols-lg="4">
								<b-input-group>
									<b-form-select
										name="agency_id"
										v-model="entity.agency_id"
										:disabled="saving"
										:options="agencies"
										value-field="id"
										text-field="name"
										:state="getValidationState(validationContext)"
									/>
									<template #append>
										<b-button
											variant="primary"
											@click="addingAgency = !addingAgency"
											:active="addingAgency"
										>
											<font-awesome-icon icon="plus" fixed-width />
										</b-button>
									</template>
								</b-input-group>
								<b-form-invalid-feedback
									v-for="error in validationContext.errors"
									:key="error"
									v-text="error"
								/>
							</b-form-group>
						</validation-provider> 
					</div>

					<validation-provider
						vid="active"
						name="Active"
						:rules="{ required: false }"
						v-slot="validationContext"
					>
						<b-form-group
							label="Active"
							label-for="active"
							label-cols-lg="4"
							description="Inactive audit reviewers will not show up in dropdown lists."
						>
							<b-form-checkbox name="active" v-model="entity.active" :disabled="saving"
								>Active</b-form-checkbox
							>
							<b-form-invalid-feedback
								v-for="error in validationContext.errors"
								:key="error"
								v-text="error"
							/>
						</b-form-group>
					</validation-provider>
				</b-card-body>

				<b-card-body>
					<h6 class="text-muted">Optional</h6>
					<b-card no-body>
						<b-card-header header-tag="header" role="tab" class="p-0">
						</b-card-header>
						<b-card-header header-tag="header" role="tab" class="p-0">
							<b-button
								block
								v-b-toggle.collapseContact
								variant="light"
								role="tab"
								class="text-left px-4 py-3 m-0"
								>Contact</b-button
							>
						</b-card-header>
						<b-collapse id="collapseContact" role="tabpanel">
							<b-card-body>
								<validation-provider
									vid="phone"
									name="Phone"
									:rules="{ required: false, min: 1, max: 50 }"
									v-slot="validationContext"
								>
									<b-form-group label="Phone" label-for="phone" label-cols-lg="4">
										<b-form-input
											name="phone"
											type="text"
											v-model="entity.phone"
											v-mask="'(###) ###-####'"
											:state="getValidationState(validationContext)"
											:disabled="saving"
										/>
										<b-form-invalid-feedback
											v-for="error in validationContext.errors"
											:key="error"
											v-text="error"
										/>
									</b-form-group>
								</validation-provider>

								<validation-provider
									vid="email"
									name="Email"
									:rules="{ required: false, min: 1, max: 50 }"
									v-slot="validationContext"
								>
									<b-form-group label="Email" label-for="email" label-cols-lg="4">
										<b-form-input
											name="email"
											type="email"
											v-model="entity.email"
											:state="getValidationState(validationContext)"
											:disabled="saving"
										/>
										<b-form-invalid-feedback
											v-for="error in validationContext.errors"
											:key="error"
											v-text="error"
										/>
									</b-form-group>
								</validation-provider>
							</b-card-body>
						</b-collapse>

						<b-card-header header-tag="header" role="tab" class="p-0">
							<b-button
								block
								v-b-toggle.collapseNotes
								variant="light"
								role="tab"
								class="text-left px-4 py-3 m-0"
								>Notes</b-button
							>
						</b-card-header>
						<b-collapse id="collapseNotes" role="tabpanel">
							<b-card-body>
								<validation-provider
									vid="notes"
									name="Notes"
									:rules="{ required: false, min: 1, max: 2000 }"
									v-slot="validationContext"
								>
									<b-form-group label="Notes" label-for="notes" label-cols-lg="4">
										<b-form-textarea
											name="notes"
											rows="8"
											placeholder="General notes about this audit reviewer...."
											v-model="entity.notes"
											:state="getValidationState(validationContext)"
											:disabled="saving"
										/>
										<b-form-invalid-feedback
											v-for="error in validationContext.errors"
											:key="error"
											v-text="error"
										/>
									</b-form-group>
								</validation-provider>
							</b-card-body>
						</b-collapse>
					</b-card>
				</b-card-body>

				<b-card-footer>
					<b-row>
						<b-col cols="12" md="6" lg="4" class="mb-4 mb-md-0">
							<b-button block variant="light" type="button" @click.prevent="cancel">Cancel</b-button>
						</b-col>
						<b-col cols="12" md="6" offset-lg="4" lg="4" class="mb-2 mb-md-0">
							<b-button block variant="primary" type="submit" :disabled="saving">
								<font-awesome-icon icon="circle-notch" v-if="saving" spin fixed-width />
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
import AgencyForm from "@/clients/components/Agencies/Form.vue";
import axios from 'axios';

export default {
	name: "AuditReviewerForm",
	components: {
		AgencyForm,
	},
	props: {
		id: {
			default: null,
		},
	},
	data() {
		return {
			loading: true,
			saving: false,
			entity: {
				id: this.id,
				agency_id: null,
				first_name: "",
				middle_name: "",
				last_name: "",
				title: "",
				phone: null,
				email: null,
				professional_degree: null,
				notes: null,
				active: true,
			},
			addingAgency: false,
			addingProfessionalDegree: false,
			professionTypeOptions: [],
			new_professional_degree: "",
		};
	},
	computed: mapGetters({
		agencies: "agencies/active",	
	}),
	mounted() {
		if (this.id) {
			this.refresh();
		} else {
			this.loading = false;
		}
		this.fetchProfessionTypes();
	},
	methods: {
		getValidationState,
		cancel(e) {
			if (e) {
				e.preventDefault();
			}

			this.$emit("cancel");
		},
		async fetchProfessionTypes() {
			console.log("started");
    try {
      const response = await axios.get('/client/getprofessiontype'); 
      this.professionTypeOptions = response.data.data;
    } catch (error) {
      console.error('Error fetching profession types:', error);
    }
  },
async saveProfessionalDegree() {

console.log("started");
const newType = this.new_professional_degree;
// const insid = this.id;
console.log(newType);
// Check if the new type is not empty
if (newType.trim() === '') {
	return;
}
console.log("outside");
// Send a POST request to your controller to add the new type
axios.post('/client/professiontype',{newType})
	.then((response) => {
		
		// Handle the response, e.g., update the insuranceTypes list
		this.professionTypeOptions.push(response.data);

		 // Hide the add new section
         this.addingProfessionalDegree = false;

		// Clear the input field
		this.new_professional_degree = '';
		console.log("new type", newType);
		console.log("check", response);

		window.location.reload();
	})
	.catch((error) => {
		// Handle any errors, e.g., show an error message
		console.error('Error adding new type:', error);
	});
},
	cancelAddProfessionalDegree() {
        // Cancel the add new operation and hide the add new section
        this.addingProfessionalDegree = false;
    },

		async refresh() {
			try {
				this.loading = true;

				const response = await this.$store.dispatch("auditReviewers/get", {
					id: this.id,
				});

				this.entity = response;
				this.$emit("loaded", response);
			} catch (e) {
				this.$store.dispatch("apiError", {
					error: e,
					message: "Error getting audit reviewer details",
				});
			} finally {
				this.loading = false;
			}
		},
		async save() {
			try {
				this.saving = true;

				const response = await this.$store.dispatch("auditReviewers/save", this.entity);
				this.$emit("saved", response);
				this.$emit("update:id", response.id);
			} catch (e) {
				if (e.response.data.errors) {
					this.$refs.observer.setErrors(formatErrors(e.response.data.errors));
				}

				this.$store.dispatch("apiError", {
					error: e,
					title: "Save Failed",
					message: "Error saving audit reviewer details. Please check for errors.",
					variant: "warning",
				});
			} finally {
				this.saving = false;
			}
		},
		async addedNewAgency(agency) {
			this.$store.dispatch("agencies/getActive");
			this.addingAgency = false;
			this.entity.agency_id = agency.id;
			//this.currentAgency = agency;
		},
	},
};
</script>