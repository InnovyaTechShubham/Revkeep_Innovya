<template>
	<b-list-group-item>
		<b-row @click="toggleCollapse" style="cursor: pointer">
			<b-col cols="5" md="12" lg="6" class="mb-4 mb-md-0 text-left">
				<b-row>
					<b-col cols="12">
						<span class="font-weight-bold">
							<span v-if="caseEntity.admit_date">
								<!-- {{ $filters.formatDate(caseEntity.admit_date) }} -->
								{{ formattedDate(caseEntity.admit_date) }}
							</span>
							<span v-if="caseEntity.admit_date && caseEntity.discharge_date" class="text-muted">
								&mdash;
							</span>
							<span v-if="caseEntity.discharge_date">
								<!-- {{ $filters.formatDate(caseEntity.discharge_date) }} -->
								{{  formattedDate(caseEntity.discharge_date) }}
							</span>
						</span>
					</b-col>
				</b-row>
				<b-row>
					<b-col cols="12">
						<case-status-label :value="caseEntity" />
						<b-badge :variant="primary">{{ lastAppealStatus() }}</b-badge>
					</b-col>
				</b-row>

				<!-- <p v-if="caseTypeName" class="small text-muted mb-0" title="Case Type">
					<span>{{ caseTypeName }}</span>
				</p>
				<p v-if="clientEmployeeName" class="small text-muted mb-0" title="Physician">
					<font-awesome-icon icon="user-md" fixed-width />
					<span>{{ clientEmployeeName }}</span>
				</p>
				<p v-if="facilityName" class="small text-muted mb-0" title="Facility">
					<font-awesome-icon icon="building" fixed-width />
					<span>{{ facilityName }}</span>
				</p> -->
				<p v-if="facilityName" class="small text-muted mb-0" title="Facility">
					<font-awesome-icon icon="building" fixed-width />
					<span>{{ facilityName }}</span>
				</p>

				<p v-if="caseEntity.insurance_provider.name" class="small text-muted mb-0" title="Insurance Provider">
					<!-- <font-awesome-icon icon="hospital-o" fixed-width /> -->
					<span>{{ caseEntity.insurance_provider.name }}</span>
				</p>

				<p v-if="clientEmployeeName" class="small text-muted mb-0" title="Physician">
					<font-awesome-icon icon="user-md" fixed-width />
					<span>{{ clientEmployeeName }}</span>
				</p>
			</b-col>
			<b-col cols="7" md="12" lg="6" class="mb-4 mb-md-0 text-right">
				<b-button v-if="isCollapsed && !hasOpenAppeal" @click="
			addingAppeal = true;
		addingRequest = false;
		" variant="primary" class="shadow">
					<font-awesome-icon icon="plus" fixed-width />
					<span>Appeal</span>
				</b-button>
				<b-dropdown right menu-class="shadow" variant="secondary">
					<template #button-content>
						<font-awesome-icon icon="cog" fixed-width />
					</template>
					<b-dropdown-item :to="{ name: 'cases.view', params: { id: caseEntity.id } }">
						<font-awesome-icon icon="eye" fixed-width />
						<span>View Case</span>
					</b-dropdown-item>

					<b-dropdown-divider />

					<b-dropdown-item :to="{ name: 'cases.edit', params: { id: caseEntity.id } }">
						<font-awesome-icon icon="edit" fixed-width />
						<span>Edit Case</span>
					</b-dropdown-item>
				</b-dropdown>

				<b-dropdown v-if="isCollapsed" split right @click="attachToCase(caseEntity, { redirect: false })"
					:disabled="attaching" variant="primary">
					<template #button-content>
						<font-awesome-icon icon="paperclip" fixed-width />
						<!-- <span>Attach</span> -->
					</template>
					<b-dropdown-item-button @click="attachToCase(caseEntity, { redirect: true })" :disabled="attaching"
						title="Attach and view appeal">
						<div>Attach &amp; View</div>
						<small class="text-muted"> Attach document and view appeal after. </small>
					</b-dropdown-item-button>
				</b-dropdown>
			</b-col>
		</b-row>

		<b-row v-if="addingAppeal" class="my-2">
			<b-col cols="12">
				<appeal-form :case-entity="caseEntity" @saved="addedAppeal" @cancel="addingAppeal = false"
					class="shadow">
					<template #header>
						<b-card-header>
							<div class="d-flex justify-content-between align-items-center">
								<span class="font-weight-bold">Add New Appeal</span>
								<b-button variant="secondary" size="sm" @click="addingAppeal = false" title="Cancel"
									class="mb-0">
									<font-awesome-icon icon="remove" fixed-width class="my-0 py-0" />
								</b-button>
							</div>
						</b-card-header>
					</template>
				</appeal-form>
			</b-col>
		</b-row>
		<b-row v-else-if="addingRequest" class="my-2">
			<b-col cols="12">
				<case-request-form :case-entity="caseEntity" @saved="addedRequest" @cancel="addingRequest = false">
					<template #header>
						<b-card-header>
							<div class="d-flex justify-content-between align-items-center">
								<span class="font-weight-bold">Add New Request</span>
								<b-button variant="secondary" size="sm" @click="addingRequest = false" title="Cancel"
									class="mb-0">
									<font-awesome-icon icon="remove" fixed-width class="my-0 py-0" />
								</b-button>
							</div>
						</b-card-header>
					</template>
				</case-request-form>
			</b-col>
		</b-row>

		<div v-else-if="hasAppeals || hasRequests" class="my-2">
			<!-- <div v-if="hasRequests">
				<b-card no-body>
					<b-card-header>Requests</b-card-header>
					<b-list-group flush>
						<b-list-group-item v-for="caseRequest in requests" :key="caseRequest.id" class="shadow-sm">
							<p class="font-weight-bold mb-0">
								<span v-if="caseRequest.name">
									{{ caseRequest.name }}
								</span>
							</p>
							<p class="mb-0 text-muted">
								<span v-if="caseRequest.type_label"> {{ caseRequest.type_label }} Request </span>
							</p>
							<p v-if="caseRequest.status_label !== 'Closed'" class="mb-0">
								<span
									v-if="caseRequest.due_date"
									class="small"
									:class="caseRequest.is_overdue ? 'text-danger font-weight-bold' : 'text-muted'"
								>
									Due on {{ $filters.formatDate(caseRequest.due_date) }}
								</span>
							</p>
						</b-list-group-item>
					</b-list-group>
				</b-card>
			</div> -->
			<b-collapse v-model="isCollapsed">
				<div v-if="hasAppeals">
					<b-card no-body>
						<!-- <b-card-header>Appeals</b-card-header> -->
						<b-list-group flush>
							<b-list-group-item v-for="(appeal, i) in appeals" :key="appeal.id" class="shadow-sm">
								<b-row>
									<b-col cols="8" md="6" lg="12" xl="6" class="text-left mb-2 mb-md-0">
										<p class="mb-0">
											<!-- <span v-if="appeal.appeal_level && appeal.appeal_level.name">
											{{ appealLevelNames[i] }}
										</span> -->

											<span v-if="true" class="font-weight-bold">
												{{ appealLevelNames[i] }}
											</span>
											<span v-else class="text-danger"> Missing Level </span><br>
											<span v-if="appeal.appeal_level && appeal.appeal_type" class="text-muted">
												&mdash;
											</span>
											<span v-if="appeal.appeal_type && appeal.appeal_type.name"
												class="text-muted">
												{{ appeal.appeal_type.name }}
											</span>
											<span v-else class="text-muted"> Post-Payment </span><br>
											<b-badge :variant="appeal.appeal_status === 'Closed' ? 'dark' : 'primary'">{{ appeal.appeal_status }}</b-badge>
											 -  <b-badge :variant="badgeVariant(appeal.appeal_decision)">{{ appeal.appeal_decision }}</b-badge>
										</p>
										<p v-if="appeal.appeal_status !== 'Closed'" class="mb-0">
											<span v-if="appeal.due_date" class="small" :class="appeal.is_overdue ? 'text-danger font-weight-bold' : 'text-muted'
			">
												Due on {{ $filters.formatDate(appeal.due_date) }}
											</span>
										</p>
										<!-- <p v-if="appeal.modified" class="small text-muted mb-0">
										Last updated {{ $filters.formatTimestamp(appeal.modified) }}
									</p> -->
									</b-col>

									<b-col cols="4" md="6" lg="12" xl="6" class="text-right">
										<b-button @click="
			addingRequest = true;
		addingAppeal = false;
		" variant="primary" class="shadow">
											<font-awesome-icon icon="plus" fixed-width />
											<span>Requests</span>
										</b-button>

										<b-dropdown split right @click="attachToAppeal(appeal, { redirect: false })"
											:disabled="attaching" variant="primary">
											<template #button-content>
												<font-awesome-icon icon="paperclip" fixed-width />
												<!-- <span>Attach</span> -->
											</template>
											<b-dropdown-item-button @click="attachToAppeal(appeal, { redirect: true })"
												:disabled="attaching" title="Attach and view appeal">
												<div>Attach &amp; View</div>
												<small class="text-muted">
													Attach document and view appeal after.
												</small>
											</b-dropdown-item-button>
										</b-dropdown>
									</b-col>
								</b-row>
								<!-- For rendering requests for every appeal -->
								<!-- use appeal_level_id for rendering -->

								<!-- <b-card no-body>
									<b-card-header @click="toggleCollapseRequests" 
										style="cursor: pointer; background-color: lightgreen; font-weight: bold; padding: 0.5rem 1rem;"
										class="text-black">
										Requests <span style="float: right; font-size: smaller;">{{ collapseRequests ?
			'▲' : '▼'
											}}</span>
									</b-card-header>
									<b-collapse v-model="collapseRequests">
										<div v-for="(request, j) in request_list" :key="request.id"
											v-if="request.case_id === appeal.case_id && request.appeal_level == i">
											<b-row class="py-2">
												<b-col cols="8" md="6" lg="12" xl="6" class="text-left mb-0 mb-md-0">
													<p class="mb-0 custom-padding"><span class="font-weight-bold">{{
			request.name }}</span> <span class="text-muted">{{
			request.type_label }} Request</span></p>
													<p v-if="request.status_label !== 'Closed'"
														class="mb-0 custom-padding">
														<span v-if="request.due_date" class="small"
															:class="request.is_overdue ? 'text-danger font-weight-bold' : 'text-muted'">
															Due on {{ $filters.formatDate(request.due_date) }}
														</span>
													</p>
													<label class="ml-4">
														Response Received
														<input type="checkbox" v-model="responseReceived[j]"
															class="response-checkbox">
														<span class="checkmark"></span>
													</label>
												</b-col>
												<b-col cols="8" md="6" lg="12" xl="6" class="text-right">
													<b-dropdown split right
														@click="attachToAppeal(appeal, { redirect: false })"
														:disabled="attaching" variant="primary">

														<template #button-content>
															<font-awesome-icon icon="paperclip" fixed-width />
														</template>
														<b-dropdown-item-button
															@click="attachToAppeal(appeal, { redirect: true })"
															:disabled="attaching" title="Attach and view appeal">
															Attach &amp; View
															<small class="text-muted">Attach document and view
																appeal
																after.</small>
														</b-dropdown-item-button>
													</b-dropdown>
												</b-col>
											</b-row>
										</div>
									</b-collapse>
								</b-card> -->

								<!-- <b-row>
								<b-col cols="12">
									<b-dropdown :id="'dropdown-' + appeal.id" variant="btn btn-secondary"  class="dropdown-container">
										<template #button-content>
											<span>Decision</span>
											<span v-if="selectedOptionL1 && appeal.appeal_level.order_number==1">: {{ selectedOptionL1 }}</span>
											<span v-if="selectedOptionL2 && appeal.appeal_level.order_number==2">: {{ selectedOptionL2 }}</span>
											<span v-if="selectedOptionL3 && appeal.appeal_level.order_number==3">: {{ selectedOptionL3 }}</span>
											<span v-if="selectedOptionL4 && appeal.appeal_level.order_number==4">: {{ selectedOptionL4 }}</span>
											<span v-if="selectedOptionL5 && appeal.appeal_level.order_number==5">: {{ selectedOptionL5 }}</span>
											<span v-if="selectedOptionL6 && appeal.appeal_level.order_number==6">: {{ selectedOptionL6 }}</span>
											<span v-if="selectedOptionL7 && appeal.appeal_level.order_number==7">: {{ selectedOptionL7 }}</span>
										</template>
										<b-dropdown-item @click="updateStatus('Issues', appeal.appeal_level.order_number)" v-if="appeal.appeal_level.order_number==1">Issues</b-dropdown-item>
										<b-dropdown-item @click="updateStatus('No Findings', appeal.appeal_level.order_number)" v-if="appeal.appeal_level.order_number==1" >No Findings</b-dropdown-item>
										<b-dropdown-item @click="updateStatus('Favorable', appeal.appeal_level.order_number)" v-if="appeal.appeal_level.order_number !==1" >Favorable</b-dropdown-item>
										<b-dropdown-item @click="updateStatus('Not Favorable', appeal.appeal_level.order_number)" v-if="appeal.appeal_level.order_number !==1" >Non Favorable</b-dropdown-item>
										<b-dropdown-item @click="updateStatus('Partially Favorable', appeal.appeal_level.order_number)" v-if="appeal.appeal_level.order_number !==1 && appeal.appeal_level.order_number !==2" >Partially Favorable</b-dropdown-item>
									</b-dropdown>
								</b-col>
							</b-row> -->

								<!-- <b-row>
									<b-col cols="12" md="6" lg="12" xl="12" class="text-left mb-8 relative">
										<b-form-group label="Decision Options" label-cols-lg="5"
											class="mb-4 flex items-center">
											<b-form-select v-model="decisionOptionsList[i]"
												:options="decisionOptionsListMethod(appeal)"
												class="mt-2"></b-form-select>
										</b-form-group>
									 Removed condition to show Amount v-if="decisionOptionsList[i] == 'Partially Favorable'" 
										<b-form-group 
											label="Amount" label-cols-lg="5" class="mb-4">
											<b-form-input></b-form-input>
										</b-form-group>
									</b-col>
								</b-row> -->

								<div v-if="hasRequestForAppeal(appeal, i)" class="mt-2"
									style="background-color: #f2f2f2; padding: 10px; border-radius: 5px">
									<div @click="toggleCollapseRequests" style="cursor: pointer" class="text-black">
										Requests
										<span style="float: right; font-size: smaller">{{
			collapseRequests ? "▲" : "▼"
		}}</span>
									</div>
									<div v-show="!collapseRequests">
										<div v-for="(request, j) in request_list" :key="request.id"
											v-if="request.case_id === appeal.case_id && request.appeal_level == i"
											style="
												background-color: #f9f9f9;
												border-radius: 5px;
												padding: 10px;
												margin-bottom: 10px;
											">
											<div class="row align-items-center">
												<div class="col-md-8">
													<div class="text-left mb-0 mb-md-0">
														<p class="mb-0 custom-padding">
															<span class="font-weight-bold">{{ request.name
																}}</span><span v-if="request.due_date" class="small"
																:class="request.is_overdue
			? 'text-danger font-weight-bold'
			: 'text-muted'
			">
																Due on {{ $filters.formatDate(request.due_date) }}
															</span>
														</p>
														<p v-if="request.status_label !== 'Closed'"
															class="mb-0 custom-padding">
															<span class="text-muted">{{ request.type_label }}
																Request</span>
														</p>
														<label class="mb-0 custom-padding">
															Response Received
															<input type="checkbox" v-model="responseReceived[j]"
																class="response-checkbox" />
															<span class="checkmark"></span>
														</label>
													</div>
												</div>
												<div class="col-md-4 text-right">
													<b-dropdown split right :disabled="attaching" variant="primary">
														<template #button-content>
															<font-awesome-icon icon="paperclip" fixed-width />
														</template>
														<b-dropdown-item-button
															@click="attachToAppeal(appeal, { redirect: true })"
															:disabled="attaching" title="Attach and view appeal">
															Attach &amp; View
															<small class="text-muted">Attach document and view appeal
																after.</small>
														</b-dropdown-item-button>
													</b-dropdown>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!-- <b-row class="mb-8">
									<b-col cols="12" md="6" lg="6" xl="6" class="text-left relative mb-4">
										<b-form-group :label="`${appealLevelNames[i]} Decision Options`" label-cols-lg="5" class="mb-0">
											<b-form-select
												v-model="decisionOptionsList[i]"
												:options="decisionOptionsListMethod(appeal)"
												class="mt-2"
											></b-form-select>
										</b-form-group>
									</b-col>
									<b-col cols="12" md="6" lg="6" xl="6" class="text-left relative">
										<b-form-group label="At Risk Amount" label-cols-lg="5" class="mb-0" v-if="decisionOptionsList[i] !== 'Favorable'">
											<b-form-input class="mt-2"></b-form-input>
										</b-form-group>
									</b-col>
								</b-row> -->
								<b-row class="mb-8">
									<b-col cols="12" md="6" lg="6" xl="6" class="text-left relative mb-4">
										<b-form-group :label="`${appealLevelNames[i]} Decision Options`"
											label-cols-lg="5" class="mb-0">
											<b-form-select v-model="dynamicDecisionOptions[i]"
												:options="decisionOptionsListMethod(appeal)"
												class="mt-2"
												@shown="dropdownOpened = true"
												@hidden="dropdownOpened = false"
												@change="handleSelection">
												></b-form-select>
										</b-form-group>
									</b-col>
									<b-col cols="12" md="6" lg="6" xl="6" class="text-left relative">
										<b-form-group label="New At Risk Amount" label-cols-lg="5" class="mb-0"
										v-if="dynamicDecisionOptions[i] !== 'Favorable' && dynamicDecisionOptions[i] !== 'Not Favorable'">
											<b-form-input class="mt-2" v-model="riskAmount[i]"></b-form-input>
										</b-form-group>
									</b-col>
								</b-row>

								<b-row v-if="showButtons">
									<b-col cols="12" class="text-center">
										<b-button variant="success"
											@click="updateDecisionOption(appeal.id, dynamicDecisionOptions[i], riskAmount[i])"
											class="mr-2">
											<i class="fas fa-check"></i> <!-- Bootstrap icon for check -->
											Save
										</b-button>
										<b-button variant="danger" @click="sendCrossRequest">
											<i class="fas fa-times"></i> <!-- Bootstrap icon for cross -->
											Cancel
										</b-button>
									</b-col>
								</b-row>
							</b-list-group-item>
						</b-list-group>
					</b-card>
				</div>
			</b-collapse>
		</div>
		<div v-else-if="false">
			<b-alert show variant="info" class="my-2">
				<font-awesome-icon icon="exclamation-triangle" fixed-width />
				No appeals or requests have been created for this case.
			</b-alert>
		</div>
	</b-list-group-item>
</template>

<style>
.dropdown-container {
	margin-top: 20px;
}

.custom-padding {
	padding-left: 20px;
	/* Adjust the value as needed */
}

.upper-space {
	margin-top: 5px;
}
</style>

<script>
import AppealForm from "@/clients/components/Appeals/Form.vue";
import AppealStatusLabel from "@/clients/components/Appeals/StatusLabel.vue";
import CaseStatusLabel from "@/clients/components/Cases/StatusLabel.vue";
import CaseRequestForm from "@/clients/components/CaseRequests/Form.vue";
import axios from "axios";

export default {
	name: "AttachCaseListItem",
	components: {
		AppealForm,
		AppealStatusLabel,
		CaseStatusLabel,
		CaseRequestForm,
	},
	props: {
		patient: {
			required: true,
			type: Object,
			default: () => {
				return {
					id: null,
					first_name: null,
					last_name: null,
					full_name: null,
					list_name: null,
				};
			},
		},
		caseEntity: {
			type: Object,
			default: () => {
				return {
					id: null,
					appeals: [],
					case_requests: [],
					case_type: {
						id: null,
						name: null,
					},
					facility: {
						id: null,
						name: null,
					},
				};
			},
		},
		document: {
			required: true,
			type: Object,
			default: () => {
				return {
					id: null,
					created: null,
					appeal_id: null,
					case_id: null,
				};
			},
		},
	},

	data() {
		return {
			document: this.document,
			addingAppeal: false,
			appeals: this.caseEntity.appeals || [],

			addingRequest: false,
			requests: this.caseEntity.requests || [],

			loading: false,
			attaching: false,
			request_list: null,
			request_list_length: false,
			selectedOptionL1: null,
			selectedOptionL2: null,
			selectedOptionL3: null,
			selectedOptionL4: null,
			selectedOptionL5: null,
			selectedOptionL6: null,
			selectedOptionL7: null,
			responseReceived: [],
			responseReceivedList: [], //for tracking partially favourable responses
			appealLevelNames: [],
			appealLevelNamesObj: [],
			showRequest: false,
			decisionOptions: null,
			decisionOptionsList: [],
			dynamicDecisionOptions: [],
			insuranceResponse: [],
			isCollapsed: false,
			collapseRequests: false,
			riskAmount: [], // Stores the value of the At Risk Amount input
			showButtons: false,
			dropdownOpened: false,
		};
	},
	computed: {
		hasOpenAppeal() {
			let hasOpen = false;
			for (let i = 0; i < this.appeals.length; i++) {
				if (this.appeals[i].appeal_status !== 'Closed' && this.appeals[i].appeal_status === 'Open') {
					hasOpen = true;
					break;
				}
			}
			return hasOpen;
		},
		caseTypeName() {
			return this.caseEntity.case_type?.name ?? "";
		},
		clientEmployeeName() {
			return this.caseEntity.client_employee?.full_name ?? "";
		},
		facilityName() {
			return this.caseEntity.facility?.name ?? "";
		},
		hasAppeals() {
			return this.appeals.length > 0;
		},
		hasRequests() {
			return this.requests.length > 0;
		},
	},
	methods: {
		badgeVariant(decision) {
			console.log('color is:-');
			console.log(decision);
			switch (decision) {
				case 'Favorable':
				return 'success'; // Green color
				case 'Not Favorable':
				return 'danger'; // Red color
				case 'Partially Favorable':
				return 'warning'; // Orange color
				default:
				return 'secondary';
			}
		},
		formattedDate(value) {
			console.log('inside formattedDate:-')
			const date = new Date(value);
			const year = String(date.getFullYear()).slice(-2);
			const month = String(date.getMonth() + 1).padStart(2, '0');
			const day = String(date.getDate()).padStart(2, '0');
			console.log('year is :-');
			console.log(`${year}`);
			return `${day}/${month}/${year}`;
		},
		handleSelection() {
			// Set showButtons to true when an option is selected and the dropdown has been manually opened
			if (this.dropdownOpened && this.dynamicDecisionOptions.length > 0) {
				this.showButtons = true;
			}
		},
		sendCrossRequest() {
			this.showButtons = false;
		},
		lastAppealStatus() {
			console.log('this.appealLevelNames:-')
			console.log(JSON.stringify(this.appealLevelNames));
			// Get the last appeal
			const lastAppeal = this.appeals[this.appeals.length - 1];

			// Return the appeal_status if lastAppeal exists, otherwise return an empty string or some default value
			// return lastAppeal ? lastAppeal.appeal_type.name : '';
			return lastAppeal ? this.appealLevelNames[this.appeals.length - 1] : '';
		},
		hasRequestForAppeal(appeal, levelIndex) {
			for (let j = 0; j < this.request_list.length; j++) {
				const request = this.request_list[j];
				if (request.case_id === appeal.case_id && request.appeal_level === levelIndex) {
					return true; // Return true if there's a matching request
				}
			}
			return false; // Return false if no matching request is found
		},
		// async updateDecisionOption(appealId) {
		// 	try {
		// 		this.showButtons= false;
		// 		// Check if decisionOptionsList is populated and contains elements
		// 		if (this.dynamicDecisionOptions && this.dynamicDecisionOptions.length > 0) {
		// 			let decisionOption = this.dynamicDecisionOptions[0];
		// 			console.log("Decision option selected is", decisionOption);
		// 			console.log("Appeal", appealId);
		// 			// Make a POST request using Axios
		// 			const response = await axios.post('/client/savedecisionoption', {
		// 				appealId: appealId,
		// 				decisionOption: decisionOption
		// 			});
		// 			console.log("Request sent");

		// 			// Handle the response as needed
		// 			console.log("Data sent successfully", response.data);
		// 			// You may want to emit an event or perform other actions based on the response
		// 		} else {
		// 			console.error('Decision options list is empty or not yet populated.');
		// 		}
		// 	} catch (error) {
		// 		// Handle any errors that occur during the API call
		// 		console.error('Error updating decision option:', error);
		// 		// You may want to show an error message to the user
		// 	}
		// },

		async updateDecisionOption(appealId, decisionOption, riskAmountValue) {
			try {
				this.showButtons = false;

				console.log("Decision options are", decisionOption);
				console.log("Risk amount is", riskAmountValue);
				console.log("Appeal", appealId);

				const response = await axios.post('/client/savedecisionoption', {
					appealId: appealId,
					decisionOption: decisionOption,
					riskAmount: riskAmountValue
				});

				console.log("Request sent");
				console.log("Data sent successfully", response.data);

			} catch (error) {
				console.error('Error updating decision option:', error);
			}
		},

		toggleCollapseRequests() {
			this.collapseRequests = !this.collapseRequests;
		},
		toggleCollapse() {
			this.isCollapsed = !this.isCollapsed;
		},
		addedAppeal(appeal) {
			this.addingAppeal = false;
			this.appeals.push(appeal);

			this.$emit("added-appeal", appeal);
			this.test();
		},
		addedRequest(request) {
			this.addingRequest = false;
			this.requests.push(request);

			this.$emit("added-request", request);
			this.test();
		},
		async attachToAppeal(appeal, options = {}) {
			try {
				this.attaching = true;

				const response = await this.$store.dispatch("incomingDocuments/attachAppeal", {
					id: this.document.id,
					case_id: appeal.case_id,
					appeal_id: appeal.id,
				});

				this.$emit("attached", response);

				if (options.redirect && options.redirect === true) {
					this.$router.push({
						name: "appeals.view",
						params: {
							id: appeal.case_id,
							appeal_id: appeal.id,
						},
					});
				}
			} catch (e) {
				this.$store.dispatch("apiError", {
					error: e,
					title: "Attach Failed",
					message: "An error occurred when attempting to attach to appeal.",
				});
			} finally {
				this.attaching = false;
			}
			const dateCreated = this.$filters.formatTimestamp(document.created);

			// var message = `Document from ${dateCreated} was attached to case #${document.case_id}.`;

			if (document.appeal_id) {
				const appealLevelName = "#" + document.appeal_id;
				message = `Document from ${dateCreated} was attached to appeal ${appealLevelName} in case #${document.case_id}.`;
			}
			if (document.request_id) {
				message = `Document from ${dateCreated} was attached to request #${document.request_id}.`;
			}

			this.$store.dispatch("notify", {
				variant: "primary",
				title: "Document Attached",
				message: message,
			});

			this.$emit("attached", document);
			this.$store.dispatch("updateState");
			this.refresh();
		},
		async attachToCase(caseEntity, options = {}) {
			try {
				const response = await this.$store.dispatch("incomingDocuments/attachCase", {
					id: this.document.id,
					case_id: caseEntity.id,
				});

				this.$emit("attached-case", response);
				console.log("options=", options);
				if (options.redirect && options.redirect === true) {
					console.log("inside case redirect");
					this.$router.push({
						name: "cases.view",
						params: {
							id: caseEntity.id,
						},
					});
				}
			} catch (e) {
				this.$store.dispatch("apiError", {
					error: e,
					title: "Attach Failed",
					message: "An error occurred when attempting to attach to case.",
				});
			} finally {
				const dateCreated = this.$filters.formatTimestamp(document.created);
				var message = `Document from ${dateCreated} was attached to case #${caseEntity.id}.`;
				this.$store.dispatch("notify", {
					variant: "primary",
					title: "Document Attached To Case",
					message: message,
				});
				if (options.redirect === false) {
					console.log("inside test env");
					this.$emit("attached", document);
					this.$store.dispatch("updateState");
					// this.refresh();
				}
				this.$emit("refresh");
			}
		},

		async test() {
			try {
				const url = "/client/request";

				const response = await axios.get(url, {
					headers: {
						Accept: "application/json",
						// You can add other headers here if needed
					},
				});
				const urlInsurance = "/client/insuranceappeal";

				const responseInsurance = await axios.get(urlInsurance, {
					headers: {
						Accept: "application/json",
						// You can add other headers here if needed
					},
				});
				// Handle the response data here
				this.request_list = [];
				// this.request_list = response.data;
				this.request_list = [...this.request_list, ...response.data];
				console.log("request list updated  = ", this.request_list);
				console.log("appeals =", this.appeals);
				console.log("case entity = ", this.caseEntity);
				this.insuranceResponse = responseInsurance.data;
				console.log("insurance response = ", responseInsurance.data);
				this.appealLevelNames = [];
				this.appealLevelNamesObj = [];
				this.appeals.forEach((item, index) => {
					console.log(`Element at index ${index}:`, item);
					console.log("appeal level id = ", item.appeal_level_id);
					responseInsurance.data.forEach((value, i) => {
						if (this.caseEntity.insurance_provider_id == value.insurance_provider_id) {
							console.log("insurance =", value);
							if (index == 0) {
								// this.appealLevelNames.push(value.label);
								console.log("value of index = ", index);
								this.appealLevelNamesObj.push({ label: value.label, id: value.id });
							}
						}
					});
					return;
				});
				this.appealLevelNamesObj.sort((a, b) => a.id - b.id);
				this.appealLevelNamesObj.forEach((item, index) => {
					this.appealLevelNames.push(item.label);
				});
				console.log("details  = ", this.appealLevelNames);
				console.log("details obj updated = ", this.appealLevelNamesObj);
			} catch (error) {
				console.error(error);
			}
		},
		updateStatus(selectedStatus, appealOrder) {
			// Call your function with the selected status and appealId
			// For example, you can make an API request here or update the local data
			console.log(`Selected status: ${selectedStatus}, Appeal ID: ${appealOrder}`);
			if (appealOrder == 1) {
				this.selectedOptionL1 = selectedStatus;
			} else if (appealOrder == 2) {
				this.selectedOptionL2 = selectedStatus;
			} else if (appealOrder == 3) {
				this.selectedOptionL3 = selectedStatus;
			} else if (appealOrder == 4) {
				this.selectedOptionL4 = selectedStatus;
			} else if (appealOrder == 5) {
				this.selectedOptionL5 = selectedStatus;
			} else if (appealOrder == 6) {
				this.selectedOptionL6 = selectedStatus;
			} else if (appealOrder == 7) {
				this.selectedOptionL7 = selectedStatus;
			}

			// Call your function with the selectedStatus and appealId as arguments
			// e.g., this.yourFunction(selectedStatus, appealId);
		},
		checkRequest() {
			this.showRequest = true;
		},

		decisionOptionsListMethod(appeal) {
			console.log("output =", appeal);
			console.log("DECISON LIST=", this.decisionOptionsList);

			let outputArr = [];
			this.insuranceResponse.forEach((item, index) => {
				if (appeal.insurance_appeal_id == item.id) {
					console.log("DEcision opt =", item.decision_options);
					if (item.decision_options == 1) {
						outputArr.push("No Findings");
						outputArr.push("Issues");
					} else if (item.decision_options == 2) {
						outputArr.push("Reversed");
						outputArr.push("Held");
					} else if (item.decision_options == 3) {
						outputArr.push("Not Favorable");
						outputArr.push("Partially Favorable");
						outputArr.push("Favorable");
					}
				}
			});


			return outputArr;
		},
	},
	mounted() {
		this.test();
		this.dynamicDecisionOptions = this.appeals.map(appeal => {
			return appeal.appeal_decision ? appeal.appeal_decision : this.decisionOptionsList[appeal.id];
		});
		this.riskAmount = this.appeals.map(appeal => {
			return appeal.disputed_amount !== null ? appeal.disputed_amount : 0;
		});
		this.showButtons = false;
	},
	watch: {
		// Watch for changes in the dynamicDecisionOptions and riskAmount
		dynamicDecisionOptions: {
			handler: function (newVal, oldVal) {
				console.log("inside watcher");
				// Check if the new value is different from the old value
				// Update the showButtons flag only if the dynamicDecisionOptions has changed
				this.showButtons = true;
				// Reset showButtons if there are no selected options
				if (newVal.length === 0) {
					this.showButtons = false;
				}
				console.log("showbutton value changed firi dec");

			},
			deep: true // Enable deep watching to detect changes in nested properties of dynamicDecisionOptions
		},
		riskAmount: {
			handler: function(newVal, oldVal) {
				console.log("inside risk watcher");
				// Check if the new value is different from the old value
				// Update the showButtons flag only if the dynamicDecisionOptions has changed
				// this.showButtons = true;
				console.log("showbutton value changed for risk");

			},
			deep: true
		}
	}
};
</script>
