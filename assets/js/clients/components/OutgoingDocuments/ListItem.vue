<template>

	<table class="table ">
 
  <tbody>
    <tr >
      <td class="col-md-2">
        <h2 class="h6 mb-0 font-weight-bold d-inline">{{ patientName }}</h2>
		<div>
								
								<p class="small text-muted mb-0">
									Updated {{ $filters.fromNow(value.modified) }}
									<span v-if="value.modified_by_user"
										>by {{ value.modified_by_user.full_name }}</span
									>
								</p>
							</div>
      </td>
	  <td class="col-md-2">
		                    <p v-if="value.delivery_method" class="text-muted mb-0" title="Delivery Method">
								<font-awesome-icon
									v-if="value.delivery_method_icon"
									:icon="value.delivery_method_icon"
									fixed-width
								/>
								<span v-if="value.delivery_method && value.delivery_method_label" class="mb-0">
									{{ value.delivery_method }}
								</span>
							</p>
	  </td>
	  <td class="col-md-2">
        <b-progress max="100" class="mb-0" :title="value.status_label">
          <b-progress-bar
            :animated="value.progress_indeterminate"
            :value="value.progress_percent"
            :variant="value.progress_variant"
          >
            <span>{{ value.status_label }}</span>
          </b-progress-bar>
        </b-progress>
      </td>
	  <td class="col-md-2">
		<div v-if="!hideAgency">
    <p v-if="value.agency" class="text-muted mb-0" title="Agency">
        <font-awesome-icon icon="building" fixed-width />
        <span v-if="value.agency && value.agency.name" class="mb-0">
            {{ value.agency.name }}
        </span>
    </p>
    <p v-else class="text-warning font-weight-bold font-italic mb-0" title="No Agency Provided">
        <font-awesome-icon icon="building" fixed-width />
        <span class="mb-0">{{ agencyName }}</span>
    </p>
</div>
<div v-else class="text-muted">&mdash;</div>

	  </td>
      
      <td class="col-md-1">
        <b-button @click="download" title="Download Packet">
          <font-awesome-icon icon="file-download" fixed-width />
        </b-button>
      
      </td>
	  <td class="col-md-1">
		               <h3 v-if="appealLevel" class="h6 mb-0">
										{{ appealLevel }}
									</h3>
			           <div v-else class="text-muted">&mdash;</div>

	  </td>
	  <td class="col-md-6">
		<b-button
						variant="primary"
						@click="markDelivered"
						:disabled="isDelivered || isCancelled"
						class="mb-0"
					>
						<span v-if="isDelivered">Delivered</span>
						<span v-else>Mark Delivered</span>
					</b-button>
		                <b-dropdown right class="mb-0">
						<template #button-content>
							<font-awesome-icon icon="cog" />
						</template>
						<b-dropdown-item
							v-if="!hideViewAppeal"
							:to="{
								name: 'appeals.view',
								params: { id: value.case_id, appeal_id: value.appeal_id },
							}"
						>
							View Appeal
						</b-dropdown-item>
						<b-dropdown-item
							v-if="value.agency_id && !hideAgency"
							:to="{
								name: 'agencies.view',
								params: { id: value.agency_id },
							}"
						>
							View Agency
						</b-dropdown-item>

						<b-dropdown-divider v-if="!(hideAgency && hideViewAppeal)" />

						<b-dropdown-item @click="retry" :disabled="!value.can_retry"> Retry </b-dropdown-item>
						<b-dropdown-item @click="cancel" :disabled="!value.can_cancel"> Cancel </b-dropdown-item>
					</b-dropdown>
	  </td>
    </tr>
   </tbody>
  
</table>
</template>

<script>
import axios from "axios";
export default {
	name: "OutgoingDocumentListItem",
	props: {
		value: {
			type: Object,
			default: () => {
				return {
					id: null,
					case_id: null,
					appeal_id: null,
					agency_id: null,
					delivery_method: null,
					delivery_method_label: "",
					delivery_method_icon: "",
					status_message: "",
					can_cancel: false,
					can_retry: false,
					progress_indeterminate: false,
					progress_percent: 0,
					progress_variant: "",
					agency: {
						id: null,
						name: null,
					},
					case: {
						id: null,
						patient_id: null,
						patient: {
							id: null,
							full_name: null,
						},
					},
					appeal: {
						id: null,
						appeal_level_id: null,
						appeal_level: {
							id: null,
							name: null,
						},
					},
					created_by_user: {
						id: null,
						full_name: null,
					},
				};
			},
		},
		hideViewAppeal: {
			type: Boolean,
			default: false,
		},
		hideAgency: {
			type: Boolean,
			default: false,
		},
	},
	data() 
	{

		return {
		outgoingList:[],
		appealLevelName:'',
		appealList:[],
		agencyList:[],
		agencyName:null,

		};
	},
	computed: {
		patientName() {
			console.log("value =", this.value);
			
			return this.value.case?.patient?.full_name ?? "(Missing Name)";
		},
		appealLevel() {
			this.outgoingList.forEach((item, index)=>{
				try{
				if(item.id ==this.value.appeal.insurance_appeal_id){
					console.log("match found =", item.label);
					this.appealLevelName = item.label;
				}
				}
				catch (err) {
					console.log(err);
				}
			});
			// return this.value.appeal?.appeal_level?.name ?? "(Missing Level)";
			//below code for rendering agency 
			this.appealList.forEach((item, index)=>{
				if(this.value.appeal_id == item.id){
					this.agencyList.forEach((agency , indexAgency ) => {
						if(item.agency_id == agency.id){
							this.agencyName = agency.name;
							console.log("Agency found =", agency.name);
						}
					});
				}
			});

			return this.appealLevelName;
		},
		isDelivered() {
			return this.value.status_message == "DELIVERED";
		},
		isCancelled() {
			return this.value.status_message == "CANCELLED";
		},
	},
	methods: {
		async markDelivered() {
			const response = await this.$store.dispatch("outgoingDocuments/delivered", {
				id: this.value.id,
			});

			this.$store.dispatch("notify", {
				variant: "primary",
				title: "Documents Delivered",
				message: `Document for ${this.patientName} has been marked as delivered`,
			});

			this.$emit("updated", response);
		},
		async cancel() {
			const response = await this.$store.dispatch("outgoingDocuments/cancel", {
				id: this.value.id,
			});

			this.$store.dispatch("notify", {
				variant: "warning",
				title: "Documents Cancelled",
				message: `Document for ${this.patientName} has been marked as cancelled`,
			});

			this.$emit("updated", response);
		},
		async retry() {
			const response = await this.$store.dispatch("outgoingDocuments/retry", {
				id: this.value.id,
			});

			this.$store.dispatch("notify", {
				variant: "primary",
				title: "Documents Requeued",
				message: `Document for ${this.patientName} has been marked as new and requeued for sending`,
			});

			this.$emit("updated", response);
		},
		async download() {
			return await this.$store.dispatch("outgoingDocuments/download", {
				id: this.value.id,
			});
		},
		async test(){
			const url = "/client/insuranceappeal";
				
				const response = await axios.get(url, {
				headers: {
					"Accept": "application/json",
					// You can add other headers here if needed
				},
				});
				console.log("Response =", response);
				this.outgoingList = response.data;
			
			const appealListUrl = '/client/appealList';
			const appealListResponse = await axios.get(appealListUrl, {
				headers: {
					"Accept": "application/json",
					// You can add other headers here if needed
				},
				});
				console.log("Appeal Response =", appealListResponse);
				this.appealList = appealListResponse.data;

				const agencyListUrl = '/client/agencyList';
			const agencyListResponse = await axios.get(agencyListUrl, {
				headers: {
					"Accept": "application/json",
					// You can add other headers here if needed
				},
				});
				console.log("Agency Response =", agencyListResponse);
				this.agencyList = agencyListResponse.data;
				
		}
	},
	mounted() {
		this.test();
	}
};
</script>
