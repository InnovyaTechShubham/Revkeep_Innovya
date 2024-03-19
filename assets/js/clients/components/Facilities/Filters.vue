<template>
	<b-row>
		<b-col cols="12" sm="6" lg="6" xl="4">
			<b-form-group label="Active" label-for="active" label-cols-lg="4">
				<b-form-select
					name="active"
					v-model="filters.facility_status"
					@change="handleFilterChange"
					:disabled="disabled"
					:options="activeOptions"
					value-field="value"
					text-field="name"
					:class="{ 'selection_background': filters.facility_status !== null }"
				>
					<template #first>
						<option :value="null">(All)</option>
					</template>
				</b-form-select>
			</b-form-group>
		</b-col>
		<b-col cols="12" sm="6" lg="6" xl="4">
			<b-form-group label="Type" label-for="facility_type_id" label-cols-lg="4">
				<b-form-select
					name="facility_type_id"
					v-model="filters.facility_type_id"
					:disabled="disabled"
					:options="facilityTypes"
					value-field="id"
					text-field="name"
					:class="{ 'selection_background': filters.facility_type_id !== null }"
				>
					<template #first>
						<option :value="null">(All)</option>
					</template>
				</b-form-select>
			</b-form-group>
		</b-col>
		<b-col cols="12" sm="6" lg="6" xl="4">
			<b-form-group label="State" label-for="state" label-cols-lg="4">
				<b-form-select
					name="state"
					v-model="filters.state"
					:disabled="disabled"
					:options="states"
					value-field="abbreviation"
					text-field="name"
					:class="{ 'selection_background': filters.state !== null }"
				>
					<template #first>
						<option :value="null">(All)</option>
					</template>
				</b-form-select>
			</b-form-group>
		</b-col>
		<b-col cols="12" sm="6" lg="6" xl="4">
			<b-form-group label="Owned" label-for="client_owned" label-cols-lg="4">
				<b-form-select
					name="client_owned"
					v-model="filters.client_owned"
					:disabled="disabled"
					:options="ownedOptions"
					value-field="value"
					text-field="name"
					:class="{ 'selection_background': filters.client_owned !== null }"
				>
					<template #first>
						<option :value="null">(All)</option>
					</template>
				</b-form-select>
			</b-form-group>
		</b-col>
		<b-col cols="12" sm="6" lg="6" xl="4">
			<b-form-group label="Has Contract" label-for="has_contract" label-cols-lg="4">
				<b-form-select
					name="has_contract"
					v-model="filters.has_contract"
					:disabled="disabled"
					:options="hasContractOptions"
					value-field="value"
					text-field="name"
					:class="{ 'selection_background': filters.has_contract !== null }"
				>
					<template #first>
						<option :value="null">(All)</option>
					</template>
				</b-form-select>
				<!-- Show tick mark if selected value is not null -->
				<!-- <span v-if="filters.has_contract !== null">✔️</span> -->
			</b-form-group>
		</b-col>
		<b-col cols="12" sm="6" lg="6" xl="4">
			<b-form-group label="Is Encore" label-for="is_encore" label-cols-lg="4">
				<b-form-select
					name="Is Encore"
					v-model="filters.is_encore"
					:disabled="disabled"
					:options="isEncoreOptions"
					value-field="value"
					text-field="name"
					:class="{ 'selection_background': filters.is_encore !== null }"
				>
					<template #first>
						<option :value="null">(All)</option>
					</template>
				</b-form-select>
			</b-form-group>
		</b-col>
	</b-row>
</template>

<script type="text/javascript">
import { mapGetters } from "vuex";
import axios from "axios";

export default {
	name: "FacilityFilters",
	props: {
		value: {
			type: Object,
			default: () => {
				return {
					facility_status: null,
					facility_type_id: null,
					state: null,
					owned: null,
				};
			},
		},
		disabled: {
			type: Boolean,
			default: false,
		},
	},
	computed: {
		filters: {
			get() {
				return this.value;
			},
			set(val) {
				this.$emit("input", val);
			},
		},
		...mapGetters({
			states: "states/states",
			// facilityTypes: "facilityTypes/all",
		}),
	},
	methods:{
		async fetchFacilityType(){
			try
						{
							const url = "/client/api/facilitytypes";
								
								const response = await axios.get(url, {
								headers: {
									"Accept": "application/json",
									// You can add other headers here if needed
								},
								});
								
							console.log("on facility Filters/vue page, facility type listed :-");
							console.log(JSON.stringify(response));
							response.data.forEach((item)=>{
								this.facilityTypes.push({'id':item.id, 'name':item.name});
							});
							console.log('facility type options =' , this.facilityTypes);
						}
					catch (error) 
					{
						console.error("Error fetching data:", error.message);
					}
		},
	},
	data() {
		return {
			activeOptions: [
				{
					value: 'Active',
					name: "Active",
				},
				{
					value: 'Inactive',
					name: "Inactive",
				},
				{
					value: 'Pending Term',
					name: "Pending Term",
				},
			],
			ownedOptions: [
				{
					value: 1,
					name: "Owned",
				},
				{
					value: 0,
					name: "Not Owned",
				},
			],
			hasContractOptions: [
				{
					value: 1,
					name: "Yes",
				},
				{
					value: 0,
					name: "No",
				},
			],
			isEncoreOptions: [
				{
					value: 1,
					name: "Yes",
				},
				{
					value: 0,
					name: "No",
				},
			],
			facilityTypes:[],
		};
	},

	mounted() {
    // Call the method here
    	this.fetchFacilityType();
  },
};
</script>
<style>
.selection_background {
    background-color: #d7e1f7; /* Change the color as needed */
}
</style>
