<template>
	<loading-indicator v-if="loading" class="my-5" title="Fetching notes..." />
	<validation-observer v-else v-bind="$attrs" ref="observer" v-slot="{ invalid }">
		<div>
		</div>
		<b-form @submit.prevent="$route.params.id ? editChain() : save()" onsubmit="setTimeout(function(){window.location.reload();},2000);">
			<b-card no-body>
				<slot name="header"></slot>

				<b-card-body>
					<validation-provider
						vid="Chain Name"
						name="Chain Name"
						:rules="{ required: true, min: 2, max: 60 }"
						v-slot="validationContext"
					>
						<b-form-group label="Chain Name" label-for="Chain Name" label-cols-lg="2">
							<b-form-input
								autofocus
								name="Chain Name"
								type="text"
								size="lg"
								v-model="entity.chain_name"
								required
								placeholder="Required"
								:state="getValidationState(validationContext)"
								:disabled="saving"
								
							/>
							<b-form-invalid-feedback v-if="errorMessage">
								{{ errorMessage }}
							</b-form-invalid-feedback>
						</b-form-group>
					</validation-provider>

					<!-- <validation-provider
						vid="Chain Type"
						name="Chain Type"
						:rules="{ required: false, max: 255 }"
						v-slot="validationContext"
					>
						<b-form-group label="Chain Type" label-for="Chain Type" label-cols-lg="2">
							<b-form-input
								name="Chain Type"
								type="text"
								v-model="entity.chain_type"
                                required
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
					</validation-provider> -->
					<!-- showing facilities and services -->

					<!-- <validation-provider
					vid="Facilities And Services"
					name="Facilities And Services"
					:rules="{ required: false, max: 255 }"
					v-slot="validationContext"
					>
					<b-form-group
						label="Facilities And Services"
						label-for="Facilities And Services"
						label-cols-lg="4"
					>
						<b-form-select
						id="FacilitiesAndServices"
						v-model="facilities_services"
						:options="flatFacilitiesServicesArr"
						placeholder="Select Facilities And Services"
						:disabled="saving"
						value-field="name"
						text-field="name"
						filter
						></b-form-select>
						<b-form-invalid-feedback
						v-for="error in validationContext.errors"
						:key="error"
						v-text="error"
						/>
					</b-form-group>
					</validation-provider> -->


					<template>
						<div>
							<validation-provider
							vid="Facilities And Services"
							name="Facilities And Services"
							:rules="{ required: false, max: 255 }"
							v-slot="validationContext"
							>
							<b-form-group
								label="Facilities And Services"
								label-for="FacilitiesAndServices"
								label-cols-lg="2"
							>
								<!-- Custom input box for search -->
								<input
								id="FacilitiesAndServices"
								v-model="searchText"
								placeholder="Search for a Facility/Service"
								:disabled="saving"
								@input="filterOptions"
								style="width: 100%;padding: 8px;"
								class="custom-rounded-border"
								/>

								<!-- Display filtered options in a list -->
								<div>
									<div class="custom-dropdown-option" v-if="filteredOptions.length > 0 && searchText !== ''">
									<b-row v-for="item in filteredOptions" :key="item.id" @click="selectOption(item)">
										<b-col class="custom-option-col">
										<div class="option-content">	
											<!-- Content for the option -->
											
											<p>
												<span v-if="item.facility_type" title="Facility">
													<font-awesome-icon icon="house" />  {{ item.name }}
												</span>
												<span v-else title="Service">
													<font-awesome-icon icon="gear" />  {{ item.name }}
												</span>
											</p>
										</div>
										</b-col>
									</b-row>
									</div>
								</div>
								<b-form-invalid-feedback
								v-for="error in validationContext.errors"
								:key="error"
								v-text="error"
								/>
							</b-form-group>
							</validation-provider>
						</div>
					</template>

					<!-- new facilites and services blcok test stsrts here -->

					<!--Dialogue Box: box to added facility to the current chain -->
					<template>
						<div>
							<b-row>
							<!-- <b-col sm="4"></b-col> -->
							<!-- Facilities -->
							<b-col sm="6" lg="6">
								<div class="selected-item">
								<div v-if="!selectedItems.length">
									<empty-result>
									No facilities added.
									</empty-result>
								</div>
								<div v-else>
									<h6 class="border_bottom" style="padding-bottom: 16px;">
										Facility
										<span style="float: right;">
											<font-awesome-icon icon="trash" @click.stop="toggleDeleteMode" style="cursor: pointer;" />
										</span>
									</h6>
									<div v-for="(selectedItem, index) in selectedItems" :key="index" class="border_bottom">
										<p>
										<input type="checkbox" v-if="deleteFacilityMode" v-model="selectedItem.checked" />
										<span v-if="selectedItem.facility_type || selectedItem.facility_type_id" title="Facility">
											<font-awesome-icon icon="house" /> {{ selectedItem.name }}
										</span>
										<span v-else title="Service">
											<font-awesome-icon icon="gear" /> {{ selectedItem.name }}
										</span>
										</p>
									</div>
									<div v-if="deleteFacilityMode" style="display: flex; justify-content: space-between; margin-top: 5px;">
										<button @click="cancelFacilityDeleteMode" class="btn btn-secondary btn-sm">Cancel</button>
										<button @click="removeSelectedItems" class="btn btn-danger btn-sm">Remove</button>
									</div>
								</div>
								</div>
							</b-col>

							<!-- Services -->
							<b-col sm="6" lg="6">
								<div class="selected-item">
									<div v-if="!serviceItems.length">
										<empty-result>
										No Services added.
										</empty-result>
									</div>
									<div v-else>
										<h6 class="border_bottom" style="padding-bottom: 16px;">
											Services
											<span style="float: right;">
											<font-awesome-icon icon="trash" @click.stop="toggleServiceDeleteMode" style="cursor: pointer;" />
											</span>
										</h6>
										<div v-for="(selectedItem, index) in serviceItems" :key="index" class="border_bottom">
											<p style="margin-bottom: 5px;">
											<input type="checkbox" v-if="deleteServiceMode" v-model="selectedItem.checked" />
											<span v-if="selectedItem.facility_type" title="Facility" style="margin-bottom: 5px;">
												<font-awesome-icon icon="house" /> {{ selectedItem.name }}
											</span>
											<span v-else title="Service" style="margin-bottom: 5px;">
												<font-awesome-icon icon="gear" /> {{ selectedItem.name }}
											</span>
											</p>
										</div>
										<div v-if="deleteServiceMode" style="display: flex; justify-content: space-between; margin-top: 5px;">
											<button @click="cancelServiceDeleteMode" class="btn btn-secondary btn-sm">Cancel</button>
											<button @click="removeSerivceItems" class="btn btn-danger btn-sm">Remove</button>
										</div>
									</div>
								</div>
							</b-col>
							</b-row>
						</div>
					</template>

				</b-card-body>
				<!-- select option for facilities and services -->
				<!-- Use a template element for conditional rendering -->
				<!-- <template v-if="!flatFacilitiesServicesArr.length">
					<empty-result>
					No facilities and services available
					</empty-result>
				</template> -->

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
<style scoped>
.selected-item {
  border: 1px solid #ccc;
  padding: 8px;
  margin: 8px 0;
  width:100%;
}
.border_bottom {
  /* padding: 10px; */
  border-bottom: 1px solid #ddd;
  transition: border-color 0.3s;
  margin-top:5px;
}

.border_bottom:hover {
  border-color: #007bff; /* Change border color on hover */
}
.custom-dropdown-option {
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 10px;
  margin-bottom: 10px;
  background-color: #fff;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}
.custom-rounded-border {
  border: 1px solid #007bff; /* Set your desired border color and thickness */
  border-radius: 5px; /* Set your desired border radius */
}

.custom-dropdown-option {
  position: absolute;
  top: 100%; /* Position the dropdown below the input */
  left: 0;
  width: 100%; /* Make the dropdown full-width */
  background-color: #fff;
  border: 1px solid #ddd;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  overflow: hidden; /* Hide overflow content */
  z-index: 1000;
}

.custom-option-col {
  margin-left: 10px;
  cursor: pointer;
  transition: background-color 0.3s, color 0.3s;
}

.custom-option-col:hover {
  background-color: #f5f5f5;
  color: #9bb8d7;
}
.option-content{
	margin-top: 2px;
	margin-bottom: 2px;
}



</style>
<script type="text/javascript">
import { mapGetters } from "vuex";
import { save} from "@/clients/services/chain";
import { formatErrors, getValidationState } from "@/validation";
import axios from "axios";
import { BFormSelect, BFormInvalidFeedback } from 'bootstrap-vue';


export default {
	name: "ChainForm",
	components: {
		'b-form-select': BFormSelect,
		'b-form-invalid-feedback': BFormInvalidFeedback,
		// ... other components
	},
	props: {
		id: {
			default: null,
		},
	},
	computed: {
		...mapGetters({
			facilities: "facilities/active",
			services: "services/all",
			loadingServices: "services/loadingAll",
			loadingFacilities: "facilities/loadingAll",
		}),
		flatFacilitiesServicesArr() {
			// Flatten the array of arrays and create a new array with only 'name' property
			return (
			(this.facilities_services_arr || []).flatMap((innerArr) =>
				innerArr.map((item) => ({ 
					id: item.id, 
					name: item.name, 
					facility_type: (item.facility_type && typeof item.facility_type === 'object') ? item.facility_type : null,
				}))
			) || []
			);
		},
		filteredOptions() {
			const searchTerm = this.searchText.toLowerCase();
			return (this.extractedFacilitesAndServices || []).flatMap((innerArr) =>
				innerArr.map((item) =>
				item.name.toLowerCase().includes(searchTerm) ? {
					id: item.id,
					name: item.name,
					facility_type: (item.facility_type && typeof item.facility_type === 'object') ? item.facility_type : null,
				} : null
				)
			).filter(Boolean); // Filter out null values
		},
	},
	data() {
		return {
			chain_id: null,
			chain_data:[],
			loading: true,
			saving: false,
			entity: {
				id: this.id,
				chain_name: "",
				//chain_type: "",
				active: true,
				client_owned: true,
				facilities: [],
				services: {
					_ids: [],
				},
			},
			facility_ids: [],
            servicesData: [],
            dropdownData: [],   // To store the data fetched from the database
            selectedItem: null,  // To store the selected item ID
			facilities_services_arr: [],
			extractedFacilitesAndServices: [],
			searchText: '',
			facilities_services: null,
			selectedItems: [],
			serviceItems: [],
			filteredOptions: [],
			selectedItem: null,
			deleteFacilityMode: false,
			deleteServiceMode: false,
			errorMessage: null,
		};
	},
	watch: {
		// searchText(newVal){
		// 	this.selectedItems.push(newVal);
		// },
		// facilities_services(newVal) {
		// // Update the selectedItems array
		// this.selectedItems.push(newVal);
		// },
	},
	mounted() {
		if(this.$route.params.id){
			this.chain_id = this.$route.params.id;
			this.getChainDataForEdit();
		}
		
        this.getServices();
		this.getFacilities();
		

		if (this.id) {
			alert('no id found..')
			this.refresh();
		} else {
			this.loading = false;
			console.log('facilites_services_arr:-')
			console.log(this.facilities_services_arr)
			console.log('extracted data as:-')
			console.log(this.extractedFacilitesAndServices)
		}

		

		// Make the API call
		const params = {};
		
		getAll(params)
		.then((data) => {
			// Handle the response data
			this.dropdownData = data;
			console.log('data');
			console.log(data);
		})
		.catch((error) => {
			// Handle errors
			console.error("Error fetching data:", error);
		});
	},
	methods: {
		toggleDeleteMode() {
			this.deleteFacilityMode = !this.deleteFacilityMode;
		},
		toggleServiceDeleteMode(){
			this.deleteServiceMode = !this.deleteServiceMode;
			console.log('Delete Service Mode:', this.deleteServiceMode);
		},
		removeSelectedItems() {
			this.selectedItems = this.selectedItems.filter((item) => !item.checked);
			this.deleteFacilityMode = false; // Turn off delete mode after removing items
		},
		removeSerivceItems(){
			this.serviceItems = this.serviceItems.filter((item) => !item.checked);
      		this.deleteServiceMode = false; 
		},
		cancelFacilityDeleteMode(){
			this.selectedItems.forEach((item) => (item.checked = false));
			this.deleteFacilityMode = false;
		},
		cancelServiceDeleteMode(){
			 // Reset checked status and turn off delete mode
			this.serviceItems.forEach((item) => (item.checked = false));
      		this.deleteServiceMode = false;
		},
		// method to show dropdown options for Facilities/services
		filterOptions() {
			if(this.searchText.length == ''){
				this.filteredOptions = [];
			}
			const searchTerm = this.searchText.toLowerCase();
			this.filteredOptions = this.flatFacilitiesServicesArr.filter(
				(item) => item.name.toLowerCase().includes(searchTerm)
			);
		},
		selectOption(item) {
			this.selectedItem = item;
			if(item.facility_type){
				this.selectedItems.push(item);
			}else{
				this.serviceItems.push(item)
			}
			
			this.searchText = '';
			this.filteredOptions = [];
		},
		
		getValidationState,
		async getServices() {
			await this.$store.dispatch("services/getAll");
			const services = await this.$store.dispatch("services/getAll");
			this.facilities_services_arr.push(services);
			console.log(this.extractDataFromOptions(services));
			this.extractedFacilitesAndServices.push(this.extractDataFromOptions(services));
		},
		async getFacilities() {
			await this.$store.dispatch("facilities/getAll");
			const facilities = await this.$store.dispatch("facilities/getAll");
			this.facilities_services_arr.push(facilities);
			console.log(this.extractDataFromOptions(facilities));
			this.extractedFacilitesAndServices.push(this.extractDataFromOptions(facilities));
		},
		extractDataFromOptions(options) {
			return options.map(option => ({ id: option.id, name: option.name }));
		},
		cancel(e) {
			if (e) {
				e.preventDefault();
			}

			this.$emit("cancel");
		},
		async refresh() {
			try {
				this.loading = true;
				const response = await get(this.id);

				this.entity = response;
				this.facility_ids = response.facilities.map((facility) => facility.id);

				this.$emit("loaded", this.entity);
			} catch (e) {
				this.$store.dispatch("apiError", {
					error: e,
					message: "Error getting service details",
				});
			} finally {
				this.loading = false;
			}
		},

		async save() {
			// Set saving to true to disable the button during the request
			this.saving = true;
			// Extract the required data
			// chain_type removed for now
			// const { chain_name, chain_type } = this.entity;
			const { chain_name } = this.entity;

			// Prepare the data to be sent in the POST request
			const chainData = {
				chain_name,
				// chain_type, chain_type removed from here for now
				Facility_data: this.selectedItems,
				Service_data: this.serviceItems
			};
			await axios.post('/client/chains', chainData)
				.then(response => {
					const responseData = response.data.data;
					
					if(response.data.success){
						console.log('chain saved')
						this.saving = false;
						this.$router.push({
							name: "chains"
						});
						this.$nextTick(function () {
							this.$store.dispatch("notify", {
								variant: "primary",
								title: "Chain Created!",
								message: `New Chain Created!.`,
							});
						});
						redirect_index()
					}else{
						this.saving = false;
						console.log('chain already exists');
						this.errorMessage = response.data.message; 
						this.$nextTick(function () {
							this.$store.dispatch("notify", {
								variant: "danger",
								title: "Chain Error",
								message: this.errorMessage,
							});
						});
					}
				})
				.catch(error => {
					console.log(error)
					// TODO: FIX IF THERE IS ANY WARNING/ERROR IN RESPONSE BLOCK
					// this.saving = false;
					// this.errorMessage = 'Error creating chain.'; 
					// this.$nextTick(function () {
					// 	this.$store.dispatch("notify", {
					// 		variant: "danger",
					// 		title: "Chain Error",
					// 		message: error,
					// 	});
					// });
				})
				// .finally(() => {
					
					
					
					
				// });

				// redirect_index()
		},
		async editChain(){
			// alert('inside editchain');
			this.saving = true;
			// Extract the required data
			// chain_type removed from below axios call
			// const {chain_name, chain_type } = this.entity;
			const {chain_name } = this.entity;

			// Prepare the data to be sent in the POST request
			// const chainData = {
			// 	chain_name,
			// 	chain_type,
			// };

			const chainData = {
				chain_name,
				// chain_type, removed from here also
				Facility_data: this.selectedItems,
				Service_data: this.serviceItems
			};
			// alert(JSON.stringify(chainData))
			await axios.post(`/client/editChain/${this.$route.params.id}`, chainData)
			.then(response => {

			})
			.catch(error => {
			console.error(error);

			})
			.finally(() => {
				this.saving = false;
				this.$router.push({
					name: "chains"
				});
				this.$nextTick(function () {
					this.$store.dispatch("notify", {
						variant: "primary",
						title: "Chain Updated!",
						message: `Edit Saved!.`,
					});
				});
			});

			redirect_index()

		},
		redirect_index(){
			this.$router.push({
				name: "chains"
			});

			this.$nextTick(function () {
				this.$store.dispatch("notify", {
					variant: "primary",
					title: "Chain Updated!",
					message: `Edit Saved!.`,
				});
			});
		},
		// Function to eliminate duplicates based on a specific key
		eliminateDuplicates(arr, key) {
			const uniqueMap = new Map();
			arr.forEach(obj => uniqueMap.set(obj[key], obj));
			return Array.from(uniqueMap.values());
		},
		async getChainDataForEdit() {
			// alert('inside getChainDataForEdit');
            console.log('Refreshing...');
            console.log('ID:', this.chain_id);

            await axios.get(`/client/viewChain/${this.chain_id}`)
            .then(response => {
				// alert('success block')
				// alert(JSON.stringify(response.data))
				// alert('success block4')
                this.chain_data.push(response.data);
				this.entity.chain_name = this.chain_data[0]['chain_name'];
				// chain_type is removed from being auto_populated on edit page
				// this.entity.chain_type = this.chain_data[0]['chain_type'];
				// TODO: PUSH FACILITY DATA TO BELOW FACILITY AND SERVICES ARRAY
				const chainOrganizations = response.data['chain_organizations'];
				chainOrganizations.forEach(chainOrg => {
					if (chainOrg.desc == 'Facility') {
						// Check if it's a facility and add it to the facilities array
						this.selectedItems.push(chainOrg['facility']);
					}

					if (chainOrg.desc == 'Service') {
						// Check if it's a service and add it to the services array
						this.serviceItems.push(chainOrg['service']);
					}
				});
                // nesting 
            })
            .catch(error => {
                console.error(error);
            })
            .finally(() => {
                this.loading = false;
            });
		},

	},
};
</script>

