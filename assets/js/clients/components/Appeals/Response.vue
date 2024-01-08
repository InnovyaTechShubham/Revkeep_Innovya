<template>
	<b-tabs card pills v-model="tabIndex">
		<b-tab no-body>
			<template #title>Packet</template>
			<b-card-body>
				<b-row v-if="allFiles.length <= 0">
					<b-col cols="12">
						<b-alert show variant="info" class="mb-0 p-4">
							<font-awesome-icon icon="info-circle" fixed-width class="mr-2" />
							Select PDF files from case and appeal documents to combine into a packet for outgoing
							submission.
						</b-alert>
					</b-col>
				</b-row>
				<b-row v-else>
					<b-col cols="12">
						<p class="text-muted">
							Drag and drop to reorder PDFs. Any existing packet file will be overwritten.
						</p>
						<b-list-group>
							<draggable v-model="orderedList">
								<b-list-group-item
									:disabled="generating"
									v-for="file in orderedList"
									:key="file.key"
									class="cursor-grabbable"
									:variant="file.valid ? '' : 'light'"
								>
									<div class="d-flex justify-content-start align-items-top">
										<b-avatar icon variant="light" class="mr-2">
											<font-awesome-icon icon="sort" fixed-width />
										</b-avatar>
										<div class="flex-fill d-flex justify-content-between align-items-top">
											<div>
												<p class="mb-0">{{ file.basename || file.file }}</p>
												<p v-if="file.extension" class="mb-0">
													<b-badge pill variant="light">
														{{ file.source }}
													</b-badge>

													<span class="small text-muted">{{ file.extension }}</span>
													<b-badge v-if="!file.valid" variant="warning" class="mb-0">
														<font-awesome-icon icon="exclamation-triangle" fixed-width />
														This file type is not supported for merging.
													</b-badge>
												</p>
											</div>
											<div>
												<b-button
													variant="danger"
													@click="removeFile(file)"
													title="Remove File"
												>
													<font-awesome-icon icon="remove" fixed-width />
												</b-button>
											</div>
										</div>
									</div>
								</b-list-group-item>
							</draggable>
						</b-list-group>
					</b-col>
				</b-row>
			</b-card-body>
			<b-card-footer>
				<b-row>
					<b-col cols="12" class="text-right">
						<b-button
							variant="primary"
							@click="generate"
							:disabled="generating || !hasFiles || hasInvalidFiles"
						>
							<span v-if="!generating">Create Packet</span>
							<span v-else>
								<font-awesome-icon icon="circle-notch" spin />
								Generating...
							</span>
						</b-button>
					</b-col>
				</b-row>
			</b-card-footer>
		</b-tab>
		<b-tab no-body lazy :disabled="!exists">
			<template #title>Preview</template>
			<b-card-body>
				<b-row>
					<b-col cols="12" class="text-right">
						<b-button variant="secondary" @click="download" :disabled="generating || !exists">
							Download
						</b-button>
					</b-col>
				</b-row>
			</b-card-body>
			<div class="overflow-y-auto" style="max-height: 40rem">
				<pdf-frame v-show="value.pdf_url" :url="value.pdf_url" />
			</div>
		</b-tab>
		<b-tab no-body lazy :disabled="!exists">
			<template #title>Submit</template>

			<transition name="fade" mode="out-in">
				<b-card-body v-if="submitted">
					<b-alert show variant="success" class="p-4 mb-0">
						<h6 class="h6 font-weight-bold">
							<font-awesome-icon icon="check-circle" fixed-width class="mr-2" />
							Response Submitted!
						</h6>
						<p class="mb-0">Your appeal response packet has been queued for outgoing delivery.</p>
					</b-alert>
				</b-card-body>
				<b-card-body v-else>
					<div v-if="agency">
						<!-- <h6>Submit to Agency</h6>

						<div class="p-4 mb-4 d-flex justify-start align-items-top shadow-sm">
							<b-avatar
								rounded
								:variant="agency.active ? 'primary' : 'light'"
								class="mr-3 px-0 text-center"
							>
								<font-awesome-icon icon="building" class="px-0 mx-0" />
							</b-avatar>
							<b-row class="flex-fill">
								<b-col cols="12" class="text-left">
									<h6 class="h6 font-weight-bold mb-1 text-break">
										{{ agency.name }}
									</h6>
									<p v-if="agency.full_address" class="small mb-1 text-muted" title="Facility">
										<font-awesome-icon icon="location-dot" fixed-width class="d-none d-sm-inline" />
										{{ agency.full_address }}
									</p>
									<div>
										<b-badge variant="light" v-if="agency.third_party_contractor">
											3rd Party
										</b-badge>
										<b-badge pill variant="light" v-if="!agency.active"> Inactive </b-badge>
									</div>
								</b-col>
							</b-row>
						</div> -->

						<!-- <b-alert show v-if="!outgoingProfile" variant="warning">
							No delivery settings have been configured for this agency. Outgoing documents will be queued
							for manual delivery.
						</b-alert> -->
						<b-alert show v-if="!outgoingProfile" variant="warning">
							
						</b-alert>
						<div v-else>
							<!-- <h6>Primary Method: {{ agency.outgoing_primary_method_label }}</h6> -->
							<b-list-group>

<!-- <b-list-group-item v-if="outgoingProfile.full_mail_to_address">

	<b-form-checkbox class="mr-3"

		name="Mail"

		v-model="localValue.mail"

		:disabled="busy"

	>

		Mail

	</b-form-checkbox>

	<p v-if="outgoingProfile.mail_to_name" class="mb-0">

		{{ outgoingProfile.mail_to_name }}

	</p>

	<p v-if="outgoingProfile.mail_to_department" class="mb-0">

		{{ outgoingProfile.mail_to_department }}

	</p>

	<p v-if="outgoingProfile.full_mail_to_address" class="mb-0">

		{{ outgoingProfile.full_mail_to_address }}

	</p>

	

</b-list-group-item> -->

<!-- <b-list-group-item class="clearfix" v-if="outgoingProfile.email">

	

	<b-form-checkbox class="mr-3"

		name="Email"

		v-model="localValue.email"

		:disabled="busy"

	>

		Email

	</b-form-checkbox>

	<p class="mb-0">

		{{ outgoingProfile.email }}

	</p>

   

</b-list-group-item> -->

<!-- <b-list-group-item v-if="outgoingProfile.fax_number">

	

	<b-form-checkbox class="mr-3"

		name="Fax"

		v-model="localValue.fax"

		:disabled="busy"

	>

		Fax

	</b-form-checkbox>

	<p class="mb-0">

		{{ outgoingProfile.fax_number }}

	</p>

   

</b-list-group-item> -->

<!-- <b-list-group-item v-if="outgoingProfile.electronic_website">

	<b-form-checkbox class="mr-3"

		name="Website"

		v-model="localValue.website"

		:disabled="busy"

	>

		Website

	</b-form-checkbox>

	<p class="mb-0">

		{{ outgoingProfile.electronic_website }}

	</p>

	

   

</b-list-group-item> -->



</b-list-group>
						</div>
					</div>
					<!-- <empty-result v-else icon="question-circle">
						No submit settings
						<template #content>
							<p class="font-weight-bold mb-0">
								No delivery settings could be found based on this appeal.
							</p>
							<p class="mb-0">
								Provide an Audit Reviewer to this appeal with an associated Agency to set up delivery.
							</p>
							<p class="mb-0">
								Submitting will place this appeal packet in the outgoing queue for manual delivery.
							</p>
						</template>
					</empty-result> -->
					<!-- Add Search Bar -->
					<!-- <b-form-input v-model="searchText" placeholder="Search agency" class="mt-2"></b-form-input> -->
					
					<!-- Add Search Button -->
					<!-- <b-col cols="12" class="text-right">
						<b-button variant="primary">
							Search
						</b-button>
					</b-col> -->
					<!-- <b-button @click="delivery" variant="primary" class="text-right">Search</b-button> -->
					<b-form-group label="Delivery Method"  label-cols-lg="4">
						<b-form-select label=" Delivery Method " v-model="selectedOptionMethod" class="mt-2" @change="handleDeliveryMethodChange">
							<option value="Email">Email</option>
							<option value="Fax">Fax</option>
							<option value="Website">Website Portal</option>
							<option value="Contact Number">Contact Number</option>
							<option value="Mail">Mail</option>
							<option value="FTP">FTP</option>
							<option value="ESMD">ESMD</option>
						</b-form-select>
					</b-form-group>
					<b-row>
						<b-col cols="12" >

							<b-form-input v-if="selectedOptionMethod && !selectedOptionMethodMail && !selectedOptionMethodFtp && !selectedOptionMethodEsmd" v-model="searchText"  :placeholder="selectedOptionText" class="mt-2"  @input="handleInputChange"></b-form-input>
							 <p v-for="(result, index) in matchFound"
									:key="index"
									@click="selectResult(result)">
									<span class="result-span">{{ result }}</span>
							</p>

							<!-- for displaying the mail opetions when mail is selected as delivery method -->
							<!-- <b-form-group label="Services" v-if="selectedOptionMethodMail">
								<b-form-radio-group v-model="mailServices">
									<b-form-radio value="UPS">UPS</b-form-radio>
									<b-form-radio value="FedEX">FedEX</b-form-radio>
									<b-form-radio value="USPS">USPS</b-form-radio>
									<b-form-radio value="Others">Others</b-form-radio>
								</b-form-radio-group>
							</b-form-group>
							<b-form-group label="Tracking ID" v-if="selectedOptionMethodMail">
								<b-form-input v-model="mailTrackingID" class="mt-2"></b-form-input>
							</b-form-group>
							<b-form-group label="Expected Delivery Date" v-if="selectedOptionMethodMail">
								<b-form-input type="date" v-model="mailExpectedDeliveryDate" class="mt-2"></b-form-input>
							</b-form-group> -->
							<b-form-group  v-if="selectedOptionMethodMail">
								<b-form-checkbox v-model="packageSentViaSnailMail">Package Sent via Snail Mail</b-form-checkbox>
							</b-form-group> 
							<!-- <b-form-checkbox v-model="packageSentViaSnailMail" v-if="selectedOptionMethodMail">Package Sent via Snail Mail</b-form-checkbox> -->
							<b-form-group label="Notes" v-if="selectedOptionMethodMail">
								<b-form-input type="text" v-model="mailNotes" class="mt-2"></b-form-input>
							</b-form-group>

							<!-- For rendering FTP Input -->
							
							<b-form-group label="FTP Portal URL" v-if="selectedOptionMethodFtp">
								<b-form-input type="text" v-model="config.portalUrlFtp" class="mt-2"></b-form-input>
							</b-form-group>
							<b-form-group label="Username" v-if="selectedOptionMethodFtp">
								<b-form-input type="text" v-model="config.usernameFtp" class="mt-2"></b-form-input>
							</b-form-group>
							<b-form-group label="Password" v-if="selectedOptionMethodFtp">
								<b-form-input type="password" v-model="config.passwordFtp" class="mt-2"></b-form-input>
							</b-form-group>


							<!-- For rendering ESMD Input -->
							<b-form-group label="Select Agency" v-if="selectedOptionMethodEsmd">
								<b-form-select v-model="selectedAgency" :options="agencyList" value-field="id" text-field="name"></b-form-select>
							</b-form-group>
							<b-form-group label="ESMD Portal URL" v-if="selectedOptionMethodEsmd">
								<b-form-input type="text" v-model="portalUrlEsmd" class="mt-2"></b-form-input>
							</b-form-group>
							<b-form-group label="Username" v-if="selectedOptionMethodEsmd">
								<b-form-input type="text" v-model="usernameEsmd" class="mt-2"></b-form-input>
							</b-form-group>
							<b-form-group label="Password" v-if="selectedOptionMethodEsmd">
								<b-form-input type="text" v-model="passwordEsmd" class="mt-2"></b-form-input>
							</b-form-group>
							



							<!-- <b-dropdown v-if="matchFound.length > 0" no-caret>
								
								<b-dropdown-item
									v-for="(result, index) in matchFound"
									:key="index"
									@click="selectResult(result)"
								>
									{{ result }}
								</b-dropdown-item>
							</b-dropdown> -->

							<!-- <b-dropdown v-b-toggle.myDropdown no-caret>
								<b-dropdown-item
									v-for="(result, index) in matchFound"
									:key="index"
									@click="selectResult(result)"
								>
									{{ result }}
								</b-dropdown-item>
							</b-dropdown> -->




						</b-col>
						<!-- Add Search Button -->
						<!-- <b-col cols="2" class="text-right mt-2">
							<b-button variant="primary">
								Search
							</b-button>
						</b-col> -->
						<!-- <b-col cols="10">
							<ul>
								<li v-for="option,i in matchFound" :key="i">{{ option }}</li>
							</ul>
						</b-col> -->
						<!-- <div class="d-flex justify-content-between align-items-center">
							<div>
								<span v-for="option,i in matchFound" :key="i" class="mb-0">
									
									<div class="small text-muted">
										<span >{{ option }}</span>
									</div>
								</span>
								
							</div> -->

							<!-- <div v-if="data.age != null && data.age != undefined">
								<font-awesome-icon icon="birthday-cake" fixed-width class="text-muted" />
								<span class="font-weight-bold">{{ data.age }}</span>
							</div> -->
					 	<!-- </div> -->
					</b-row>
					<b-row>
						<!-- <div class="d-flex justify-content-between align-items-center">
							<div>
								<span v-for="option,i in matchFound" :key="i" class="mb-0">
									
									<div class="small text-muted">
										<span >{{ option }}</span>
									</div>
								</span>
								
							</div> -->

							<!-- <div v-if="data.age != null && data.age != undefined">
								<font-awesome-icon icon="birthday-cake" fixed-width class="text-muted" />
								<span class="font-weight-bold">{{ data.age }}</span>
							</div> -->
					 	<!-- </div> -->
						 <!-- <b-col cols="12" >
							<div  class="suggestions">
								
									<div v-for="option,i in matchFound" :key="i" class="d-flex justify-content-between align-items-center suggestion-item">
									<b-card-body>
										<span  class="mb-0">
										{{ option }}
										</span>
									</b-card-body>
									</div>
								
							</div>
						</b-col> -->
					</b-row>
					<!-- <b-row>
								<b-col cols="6">
									<b-dropdown  variant="btn btn-secondary"  class="dropdown-container">
										<template #button-content>
											<span>Delivery Method</span> -->
											<!-- <span v-if="selectedOptionL1 && appeal.appeal_level.order_number==1">: {{ selectedOptionL1 }}</span>
											<span v-if="selectedOptionL2 && appeal.appeal_level.order_number==2">: {{ selectedOptionL2 }}</span>
											<span v-if="selectedOptionL3 && appeal.appeal_level.order_number==3">: {{ selectedOptionL3 }}</span>
											<span v-if="selectedOptionL4 && appeal.appeal_level.order_number==4">: {{ selectedOptionL4 }}</span>
											<span v-if="selectedOptionL5 && appeal.appeal_level.order_number==5">: {{ selectedOptionL5 }}</span>
											<span v-if="selectedOptionL6 && appeal.appeal_level.order_number==6">: {{ selectedOptionL6 }}</span>-->
											<!-- <span >: {{ selectedOption}}</span> 
										</template> -->
										<!-- <b-dropdown-item @click="updateStatus('Issues')" >Issues</b-dropdown-item> -->
										<!-- <b-dropdown-item @click="updateStatus('Email')">Email</b-dropdown-item>
										<b-dropdown-item @click="updateStatus('Fax')">Fax</b-dropdown-item>
										<b-dropdown-item @click="updateStatus('Website')">Website</b-dropdown-item>
										<b-dropdown-item @click="updateStatus('Contact Number')">Contact Number</b-dropdown-item>
										<b-dropdown-item @click="updateStatus('Mail')">Mail</b-dropdown-item>
									</b-dropdown>
								</b-col>
								
								<b-col cols="6" class="dropdown-container">
									<input
										type="text"
										v-model="searchQuery"
										placeholder="Search..."
									/>
								</b-col> -->

									<!-- Display filtered results based on the search query -->
								<!-- <b-col cols="12">
									<ul>
										<li v-for="option in filteredOptions" :key="option">{{ option }}</li>
									</ul>
								</b-col>
							</b-row> -->
				</b-card-body>
			</transition>
			<b-card-footer>
				<b-row>
					<b-col cols="12" class="text-right">
						<b-button v-if="!submitted" variant="primary" @click="submitPacket" :disabled="submitting">
							Submit Packet
						</b-button>
						<b-button v-else variant="info" :to="{ name: 'outgoingDocuments' }">
							View Outgoing Documents
							<font-awesome-icon icon="chevron-right" fixed-width />
						</b-button>
					</b-col>
					
				</b-row>
			</b-card-footer>
		</b-tab>
	</b-tabs>
</template>

<style scoped>
.result-span {
	display: flex;
  align-items: center; /* Center vertically */
  justify-content: center; /* Center horizontally */
  border: 0.5px solid #000; /* Add your desired border styles here */
  padding: 1px; /* Adjust padding as needed */
  font-size: inherit; /* Inherit the font size from the parent (input) */
  width: 100%; /* Take the maximum available width */
  height: 100%; /* Take the maximum available height */
  box-sizing: border-box; /* Include border and padding in the width and height calculation */
}
</style>

<script type="text/javascript">
import { mapGetters } from "vuex";
import { getExtension, getBasename, extensionMergesIntoPdf } from "@/shared/helpers/fileHelper";
import draggable from "vuedraggable";
import PdfFrame from "@/shared/components/PdfFrame.vue";
import axios from "axios";

export default {
	name: "AppealResponse",
	components: {
		PdfFrame,
		draggable,
	},
	props: {
		value: {
			type: Object,
			default: () => {
				return {
					id: this.id,
					case_id: null,
					appeal_level: {
						id: null,
						name: null,
					},
					appeal_type: {
						id: null,
						name: null,
					},
					is_overdue: null,
					is_finished: null,
					can_cance: null,
					can_close: null,
					can_delete: null,
					can_reopen: null,
					can_submit: null,
					pdf_title: null,
					pdf_url: null,
				};
			},
		},
		disabled: {
			type: Boolean,
			default: false,
		},
		appealFiles: {
			type: Array,
			default: () => [],
		},
		showCaseFiles: {
			type: Boolean,
			default: false,
		},
		caseFiles: {
			type: Array,
			default: () => [],
		},
	},
	computed: {
		localValue: {
			get() {
				return this.value;
			},
			set(val) {
				this.$emit("input", val);
			},
		},
		allFiles() {
			return [
				...this.caseFiles.map((caseFile) => {
					const extension = getExtension(caseFile);

					return {
						key: "c_" + caseFile, // for v-for
						source: "Case",
						file: caseFile,
						basename: getBasename(caseFile),
						extension: extension,
						valid: extensionMergesIntoPdf(extension),
					};
				}),
				...this.appealFiles.map((appealFile) => {
					const extension = getExtension(appealFile);

					return {
						key: "a_" + appealFile, // for v-for
						source: "Appeal",
						file: appealFile,
						basename: getBasename(appealFile),
						extension: getExtension(appealFile),
						valid: extensionMergesIntoPdf(extension),
					};
				}),
			];
		},
		hasFiles() {
			return this.allFiles.length > 0;
		},
		hasInvalidFiles() {
			return this.allFiles.some((file) => file.valid == false);
		},
		canSubmit() {
			return this.value.can_submit;
		},
		agency() {
			return this.value?.audit_reviewer?.agency ?? false;
		},
		outgoingProfile() {
			return this.value?.audit_reviewer?.agency?.outgoing_profile ?? false;
		},
		filteredOptions() {
			if (!this.selectedOption) {
				return [];
			}
			const lowerSearchQuery = this.searchQuery.toLowerCase();
			return this.selectedOption.filter(option =>
				option.toLowerCase().includes(lowerSearchQuery)
			);
    	},
		
	},
	data() {
		return {
			tabIndex: 1,
			exists: false,
			downloading: false,
			generating: false,
			submitting: false,
			submitted: false,
			orderedList: this.allFiles,
			selectedOption:null,
			searchQuery: '',
			selectedOptionMethod: null,
			email: [
				'example1@example.com',
				'example2@example.com',
				'example3@example.com',
				'test@gmail.com',
				'check@gmail.com',
				// Add more email values as needed
			],
			selectedOptionText:'',
         	matchFound: [],
			mail:['abcd','efgh','1234'],
			selectedOptionMethodMail:null,
			contact_no:['1234','5678','8910'],
			website:['revkeep.com', 'revkeep.innovyatech.com'],
			fax:['1234567890','23456787788'],
			searchText:null,
			deliveryMethodDetails : null,
			mailServices:null,
			mailTrackingID:null,
			mailExpectedDeliveryDate:null,
			selectedOptionMethodMail:null,
			mailNotes:null,
			packageSentViaSnailMail:null,
			config: {
			portalUrlFtp:"",
			usernameFtp:"",
			passwordFtp:"",
			},
			selectedOptionMethodFtp:false,
			selectedOptionMethodEsmd:false,
			portalUrlEsmd:null,
			usernameEsmd:null,
			passwordEsmd:null,
			agencyList:[],
			selectedAgency:null,
			emailData:null,
			faxData:null,
			websiteData:null,
			contactNumberData:null,

		};
	},
	mounted() {
		this.checkExists();
		this.test();
	},
	methods: {
		removeFile(file) {
			this.$emit("remove", file);
		},
		async checkExists() {
			const response = await this.$store.dispatch("appealPackets/exists", {
				id: this.value.id,
			});

			this.exists = response.exists || false;
		},
		async download() {
			try {
				this.downloading = true;

				await this.$store.dispatch("appealPackets/download", {
					id: this.value.id,
				});
			} finally {
				this.downloading = false;
			}
		},
		async generate() {
			try {
				this.generating = true;

				const response = await this.$store.dispatch("appealPackets/generate", {
					id: this.value.id,
					case_files: this.caseFiles,
					appeal_files: this.appealFiles,
					ordered_list: this.orderedList,
				});

				this.$emit("generated", response);

				this.$store.dispatch("notify", {
					variant: "primary",
					title: "Packet Created",
					message: `Appeal packet PDF has been generated. You may now preview and submit it.`,
				});

				await this.checkExists();
				this.tabIndex++;
			} catch (e) {
				this.$store.dispatch("apiError", {
					error: e,
					title: "Packet Generation Failed",
					message:
						"Error attempting to create packet. Please ensure selected files are valid PDFs. Contact support if the issue persists.",
					variant: "warning",
				});
			} finally {
				this.generating = false;
			}
		},
//         async upload() {
// 		const insid=this.value.id;
// 		console.log("appeal id", insid);
			
//   try {
//     // Use Axios to make a request to your PHP backend
// 	console.log("ftpuload initiated");
//     const resp = await axios.post("/client/ftpp", {
// 		insid,
// 		ftpPortalUrl: this.config.portalUrlFtp,
// 		ftpUsername: this.config.usernameFtp,
// 		ftpPassword: this.config.passwordFtp,
//     });

// 	this.$bvToast.toast('File successfully uploaded!', {
//             title: 'Success',
//             variant: 'success',
//             autoHideDelay: 5000,
//         });
// 	console.log("yes", resp);
//   } catch (e) {
// 	console.log(e);
//   } finally {
//     console.log(1);
//   }
// },

		async submitPacket() {
			try {
				this.submitting = true;

				const response = await this.$store.dispatch("appealPackets/submit", {
					id: this.value.id,
				});

				this.$emit("submitted", response);
				this.submitted = true;

				this.$store.dispatch("notify", {
					variant: "primary",
					title: "Packet Submitted",
					message: `Appeal packet has been submitted.`,
				});

				this.$store.dispatch("outgoingDocuments/count");

				//Todo : do a post request for sending data to the controller for sending the outgoing details

			} catch (e) {
				this.$store.dispatch("apiError", {
					error: e,
					title: "Submission Failed",
					message: "Unable to submit packet.",
				});
			} finally {
				this.submitting = false;

				const postData = {
					packageSentViaSnailMail:this.packageSentViaSnailMail,
					mailNotes:this.mailNotes,
					ftpPortalUrl:this.portalUrlFtp,
					ftpUsername:this.usernameFtp,
					ftpPassword:this.passwordFtp,
					EsmdPortalUrl:this.portalUrlEsmd,
					EsmdUsername:this.usernameEsmd,
					EsmdPassword:this.passwordEsmd,
					email:this.emailData,
					fax:this.faxData,
					website:this.websiteData,
					contactNumber:this.contactNumberData,
					agency_id:this.selectedAgency,
					delivery_method:this.selectedOptionMethod,
				};
				axios.post('/client/outgoingDetails', postData)
				.then(response => {
				// Handle the successful response here
				console.log('Success:', response.data);
				})
				.catch(error => {
				// Handle any errors that occur during the request
				console.error('Error:', error);
				});
				// For FTP UPLOAD
				const insid=this.value.id;
				console.log("appeal id", insid);
			
		try {
			// Use Axios to make a request to your PHP backend
			console.log("ftpuload initiated");
			const resp = await axios.post("/client/ftpp", {
				insid,
				ftpPortalUrl: this.config.portalUrlFtp,
				ftpUsername: this.config.usernameFtp,
				ftpPassword: this.config.passwordFtp,
			});

			this.$bvToast.toast('File successfully uploaded!', {
					title: 'Success',
					variant: 'success',
					autoHideDelay: 5000,
				});
			console.log("yes", resp);
		} catch (e) {
			console.log(e);
		} finally {
			console.log(1);
		}
     	}
	    },
		updateStatus(selectedStatus) 
		{
        // Call your function with the selected status and appealId
        // For example, you can make an API request here or update the local data
        console.log(`Selected status: ${selectedStatus}`);
		this.selectedOption = selectedStatus;
		// if(appealOrder==1)
		// {
		// 	this.selectedOptionL1=selectedStatus;
		// }
		// else if(appealOrder==2){
		// 	this.selectedOptionL2=selectedStatus;
		// }
		// else if(appealOrder==3){
		// 	this.selectedOptionL3=selectedStatus;
		// }
		// else if(appealOrder==4){
		// 	this.selectedOptionL4=selectedStatus;
		// }
		// else if(appealOrder==5){
		// 	this.selectedOptionL5=selectedStatus;
		// }
		// else if(appealOrder==6){
		// 	this.selectedOptionL6=selectedStatus;
		// }
		// else if(appealOrder==7){
		// 	this.selectedOptionL7=selectedStatus;
		// }
		
        // Call your function with the selectedStatus and appealId as arguments
        // e.g., this.yourFunction(selectedStatus, appealId);
        },
		async test(){
			try{
				let url = "/client/outgoing";
				const response = await axios.get(url, {
				headers: {
					"Accept": "application/json",
				},
				});
				console.log("RESPONSE = ",response);

				// for fetching agency details from agency table
				url = "/client/agencyList";
				const responseAgency = await axios.get(url, {
				headers: {
					"Accept": "application/json",
				},
				});
				//for storing agency list for rendering
				responseAgency.data.forEach((item,index)=> {
					this.agencyList.push({id:item.id , name:item.name })
				});
				console.log("RESPONSE Agency = ",this.agencyList);
				try{
					response.data.forEach((item,index)=> {
						if(item.email !=null){
							this.email.push(item.email);
						}
					})
				}
				catch(error){

				}
			}
			catch (error){
				console.log(error);
			}
		},
		handleDeliveryMethodChange() {
		// This function is called when the selected option changes
		console.log('Selected delivery method:', this.selectedOptionMethod);

		//for rendering mail options after mail is selected as delivery method
		this.selectedOptionText = "Search "+this.selectedOptionMethod;
		if (this.selectedOptionMethod == 'Mail'){
			this.selectedOptionMethodMail = true;
		}
		else{
			this.selectedOptionMethodMail = false;
		}
		if(this.selectedOptionMethod == 'FTP'){
			this.selectedOptionMethodFtp=true;
		}
		else{
			this.selectedOptionMethodFtp=false;
		}
		
		if(this.selectedOptionMethod == 'ESMD'){
			this.selectedOptionMethodEsmd=true;
		}
		else{
			this.selectedOptionMethodEsmd=false;
		}
		
		},
		handleInputChange() {
      		// This method is called whenever the input changes

      		console.log('Text entered:', this.searchText);
			this.matchFound = [];

			//for filtering email values
			if(this.selectedOptionMethod=='Email'){
			for (const emailValue of this.email)
			{   if(this.searchText==''){
				break;
			}
				if (emailValue.includes(this.searchText)) 
				{
					this.matchFound.push(emailValue);
					console.log("match found = " , this.matchFound);
					this.emailData=null;
					// Exit the loop if a match is found
				}
				else{
					this.emailData=this.searchText;
					console.log("EMAIL = ", this.emailData);
				}
		   	 }
			}

			//for filtering FAX values
			if(this.selectedOptionMethod=='Fax'){
			for (const faxValue of this.fax)
			{   if(this.searchText==''){
				break;
			}
				if (faxValue.includes(this.searchText)) 
				{
					this.matchFound.push(faxValue);
					console.log("match found = " , this.matchFound);
					this.faxData=null;
					// Exit the loop if a match is found
				}
				else{
					this.faxData=this.searchText;
				}
		   	 }
			}

			//for filtering Website values
			if(this.selectedOptionMethod=='Website'){
			for (const websiteValue of this.website)
			{   if(this.searchText==''){
				break;
			}
				if (websiteValue.includes(this.searchText)) 
				{
					this.matchFound.push(websiteValue);
					console.log("match found = " , this.matchFound);
					this.websiteData=null;
					// Exit the loop if a match is found
				}
				else{
					this.websiteData=this.searchText;
				}
		   	 }
			}

			//for filtering contact number values
			if(this.selectedOptionMethod=='Contact Number'){
			for (const contact_noValue of this.contact_no)
			{   if(this.searchText==''){
				break;
			}
				if (contact_noValue.includes(this.searchText)) 
				{
					this.matchFound.push(contact_noValue);
					console.log("match found = " , this.matchFound);
					this.contactNoData=null;
					// Exit the loop if a match is found
				}
				else{
					this.contactNoData=this.searchText;
				}
		   	 }
			}

			//for filtering MAIL values
			if(this.selectedOptionMethod=='Mail'){
			for (const mailValue of this.mail)
			{   if(this.searchText==''){
				break;
			}
				if (mailValue.includes(this.searchText)) 
				{
					this.matchFound.push(mailValue);
					console.log("match found = " , this.matchFound);
					this.mailData=null;
					// Exit the loop if a match is found
				}
				else{
					this.mailData=this.searchText;
				}
		   	 }
			}
    	},
		selectResult(result) {
      // Handle the selection of a result, e.g., update the input field
      this.searchText = result;
      this.matchFound = []; // Hide the dropdown
	  console.log("Delivery method =", this.selectedOptionMethod);
	  console.log("Delivery details = ", result);
	  console.log("Services =", this.mailServices );
	  console.log("Tracking ID =", this.mailTrackingID);
	  console.log("Exp Dlv Date =",this.mailExpectedDeliveryDate);
	  console.log("Package send through mail" , this.packageSentViaSnailMail);
	  console.log("Notes =", this.mailNotes);
	  console.log("Selected agency =", this.selectedAgency);
	  this.deliveryMethodDetails = result;

	  if(this.selectedOptionMethod=='Email' && this.emailData==null){
		this.emailData = this.deliveryMethodDetails;
	  }
	  else if(this.selectedOptionMethod=='Fax'){
		this.faxData = this.deliveryMethodDetails;
	  }
	  else if(this.selectedOptionMethod=='Website'){
		this.websiteData = this.deliveryMethodDetails;
	  }
	  else if(this.selectedOptionMethod=='Contact Number'){
		this.contactNumberData = this.deliveryMethodDetails;
	  }
	  //if Mail is selected then this.packageSentViaSnailMail this.mailNotes 
	  // if FTP is selected then this.portalUrlFtp this.usernameFtp this.passwordFtp
	  // if ESMD is selected then this.selectedAgency this.portalUrlEsmd this.usernameEsmd this.passwordEsmd
	  
    },
	
	},
	watch: {
		allFiles(newVal, oldVal) {
			this.orderedList = newVal;
		},
	},
};
</script>
