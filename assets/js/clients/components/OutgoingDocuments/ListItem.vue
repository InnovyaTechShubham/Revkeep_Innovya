<template>
<div>
	<table class="table table-bordered table-hover mb-0">
 
  <tbody>
    <tr>
		<td class="col-md-1 center-both align-middle"   @click="navigateToAppeal">
			<span v-if="value.request_id"> {{ value.request_id }}</span>
			<span v-else>{{ value.appeal_id }}</span>
		</td>
		<td class="col-md-1 center-both align-middle"   @click="navigateToAppeal">
        <b-badge 
		:title="value.status_label"
		pill
		:variant="value.progress_variant"
		>
		<span>{{ value.status_label }}</span>
        </b-badge>
      </td>
  
  <td class="col-md-1 font-weight-bold">
	<span >{{ value.facility_name }}</span>
  </td>

   <td class="col-md-1 center-both align-middle font-weight-bold"   @click="navigateToAppeal">{{ patientName }}</td>

    <td class="col-md-2 center-both align-middle "   @click="navigateToAppeal">
		<div v-if="!hideAgency">
    <p v-if="value.agency" class="text-muted " title="Agency">
        
        <span v-if="value.agency && value.agency.name" class="mb-0">
            {{ value.agency.name }}
        </span>
    </p>
    <p v-else  title="No Agency Provided">
        
        <span class="font-weight-bold">{{ agencyName }}</span>
    </p>
</div>
<div v-else class="text-muted">&mdash;</div>

	  </td> 

	  <td class="col-md-2 center-both align-middle font-weight-bold"   @click="navigateToAppeal" >
		               
			        <span>{{ value.submit_to }}</span>

	  </td>
	  <td class="col-md-1 center-both align-middle "   >
		<h2 v-if="entity.name"
             tag="h3"
             class="h6 mb-0 font-weight-bold"
			 @click="navigateToAppeal"
        >
		<font-awesome-icon icon="envelope" />
		{{ entity.name }} 
	  </h2>
			           <div v-else-if="appealLevel" class="font-weight-bold"  @click="navigateToAppeal">
						<font-awesome-icon icon="envelope-open" />	 {{ appealLevel }}
					   </div>
			
					   <div v-else>
						&mdash;
					   </div>

	  </td>
	  <td class="col-md-1 center-both align-middle"   @click="navigateToAppeal">
		               
			     {{ $filters.formatDate(value.created) }}

	  </td>
	  <td class="col-md-1 center-both align-middle"   @click="handleDeliveryMethodClick">
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
	  <td class="col-md-1 center-both align-middle">
		<b-dropdown right class="mb-0">
						<template #button-content>
							<font-awesome-icon icon="file-download" fixed-width />
						</template>
						<b-dropdown-item
						@click="download" title="Download Packet"
						>
							Download
						</b-dropdown-item>
						<b-dropdown-item
							@click="preview"
						>
						    Preview
					</b-dropdown-item>
					</b-dropdown>
	  </td>
		
	  <!--<td class="col-md-1">
        <b-button @click="download" title="Download Packet" class="ml-2">
          <font-awesome-icon icon="file-download" fixed-width />
        </b-button>
      
      </td>  -->
	  
	  <!-- 
	  <td class="col-md-1">
		<b-button
						variant="primary"
						@click="markDelivered"
						:disabled="isDelivered || isCancelled"
						class="mb-0 ml-1"
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
	  </td> -->
    </tr>
   </tbody>
  
</table>
<b-modal id="manualDeliveryModal"  v-if="modalcount" hide-footer hide-header>
      <div>
		<h5>Manual Delivery Information</h5>
	  <hr>
	  </div>
      <div>
        <p><strong>Mail Notes:</strong> {{ this.storedData.mailNotes }}</p>
        <p><strong>Carrier:</strong> {{ this.storedData.carrier }}</p>
        <p><strong>Tracking:</strong> {{ this.storedData.tracking }}</p>
      </div>
	 
      <button @click="cancelModal" class="btn btn-secondary ">Cancel</button>
    
    </b-modal>
</div>
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
					request_id: null,
					facility_name: null,
					submit_to: null,
					mailNotes: null,
					carrier: null,
					tracking:null,
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
						facility_id: null,
						facility:{
                             id: null,
							 name: null,
						},
					},
					appeal: {
						id: null,
						pdf_url:null,
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
		entity: this.value,
		loading: true,
		error: false,
		storedData: {
      carrier: '',
      tracking: '',
      mailNotes: '',
    },
	 modalcount:false,
		};
	},
	computed: {
		patientName() {
			console.log("value =", this.value);
			console.log("mycase =", this.value.case);
			return this.value.case?.patient?.full_name ?? "(Missing Name)";
		},
		facilityName() {
			return this.value.case?.facility?.name ?? "(Missing Name)";
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
							console.log("Agency found =", this.agencyName);
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
		async refresh() {
			try {
				this.loading = true;
				this.error = false;

				const response = await this.$store.dispatch("caseRequests/get", {
					case_id: this.value.case_id,
					id: this.value.request_id,
				});

				this.entity = response;
			} catch (e) {
				this.error = true;
				this.$store.dispatch("apiError", {
					error: e,
					message: "Failed to find request",
				});
			} finally {
				this.loading = false;
			}
		},
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
				
		},
		navigateToAppeal() {
			if (this.appealLevel) {
        this.$router.push({
          name: 'appeals.view',
          params: { id: this.value.case_id, appeal_id: this.value.appeal_id },
        });
      } else {
      this.$router.push({
    name: 'caseRequests.view',
    params: { id: this.value.case_id, case_request_id: this.value.request_id },
  });
}
},
preview() {
      
      const pdfUrl = this.value.appeal.pdf_url;
      if (pdfUrl) {
        window.open(pdfUrl, "_blank");
      } else {
        console.error("PDF URL is not available");
      }
    },
	
	handleDeliveryMethodClick() {
      if (this.value.delivery_method === "Manual") {
        
		this.storedData.carrier = this.value.carrier;
      this.storedData.tracking = this.value.tracking;
      this.storedData.mailNotes = this.value.mailNotes;
	  
      this.modalcount = true;
	  this.$nextTick(() => {
      this.$bvModal.show('manualDeliveryModal');
    });
      } else {
        // If not "Manual," navigate to appeal
        this.navigateToAppeal();
      }
    },
	cancelModal() {
      // Close the modal by toggling the modalcount property
      this.modalcount = false;
    },

	},
	mounted() {
		this.test();
		this.refresh();
	}
};
</script>

<style>

.center-both {
    align-items: center;
    justify-content: center;
  }
.table{
	cursor: pointer;
}
</style>