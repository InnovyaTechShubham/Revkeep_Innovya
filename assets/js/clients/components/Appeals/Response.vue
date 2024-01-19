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
					</b-form-group> -->

					<b-form-group label="Submit To" label-cols-lg="4">
						<b-form-select label=" Submit To " v-model="selectedSubmitTo" class="mt-2"
							@change="handleSubmitToChange">
							<option value="facility">Facility</option>
							<option value="agency">Agency</option>
							<option value="user">User</option>
						</b-form-select>
					</b-form-group>

					<!-- <div v-if="selectedSubmitTo === 'user'">
						<b-form-group label="Select User" label-cols-lg="4">
							<b-form-select v-model="selectedUser" :options="userList"></b-form-select>
						</b-form-group>
					</div> -->

					<!-- <div v-if="selectedSubmitTo === 'user'">
						<b-form-group label="Select User" label-cols-lg="4">
							<b-input-group>
								<b-form-select v-model="selectedUser" :options="filteredUserList"
									class="mb-0"></b-form-select>
								<b-input-group-append>
									<b-input-group-text>
										<font-awesome-icon icon="search" />
									</b-input-group-text>
								</b-input-group-append>
							</b-input-group>
						</b-form-group>
					</div> -->
					<div v-if="selectedSubmitTo === 'user'">
						<b-form-group label="Search User" label-cols-lg="4">
							<div class="position-relative">
								<b-form-input v-model="searchUser" @input="handleUserSearch"
									placeholder="Search user..."></b-form-input>
								<!-- <b-button variant="outline-secondary" class="position-absolute"
									style="top: 50%; right: 10px; transform: translateY(-50%);" @click="clearUserSearch">
								</b-button> -->
							</div>

							<b-list-group v-if="searchResults.length > 0" class="search-results">
								<b-list-group-item v-for="(user, index) in searchResults" :key="index"
									@click="selectUser(user)">
									{{ user.text }}
								</b-list-group-item>
							</b-list-group>
						</b-form-group>
					</div>

					<!-- Inside the "Facility" block where you have the delivery method dropdown -->
					<div v-if="selectedSubmitTo === 'facility'">
						<b-form-group label="Delivery Method" label-cols-lg="4">
							<b-form-select label="deliveryMethod" v-model="selectedDeliveryMethod" class="mt-2"
								:disabled="isFacilitySelected" @change="handleSubmitToChange">
								<option value="Fax">Fax</option>
								<option value="Email">Email</option>
								<option value="Manual">Manual</option>
							</b-form-select>
						</b-form-group>

						<b-form-group v-if="isFacilitySelected">
							<b-alert show variant="warning">
								No facility is selected. Please choose a facility.
							</b-alert>
						</b-form-group>

						<!-- Dropdown for Fax -->
						<b-form-group v-if="selectedDeliveryMethod === 'Fax' && receivingFaxDetails.length > 0"
							label="Select Fax" label-cols-lg="4">
							<b-form-select v-model="selectedFax" :options="receivingFaxDetails" value-field="fax"
								text-field="fax"></b-form-select>
						</b-form-group>

						<!-- Dropdown for Email -->
						<b-form-group v-if="selectedDeliveryMethod === 'Email' && receivingEmailDetails.length > 0"
							label="Select Email" label-cols-lg="4">
							<b-form-select v-model="selectedEmail" :options="receivingEmailDetails" value-field="email"
								text-field="email"></b-form-select>
						</b-form-group>
					</div>

					<b-form-group
						v-if="selectedSubmitTo === 'facility' && selectedDeliveryMethod === 'Email' && isEmailIdsEmpty">
						<b-alert show variant="warning">
							No email IDs are available for the facility. Please provide valid email IDs.
						</b-alert>
					</b-form-group>

					<b-form-group
						v-if="selectedSubmitTo === 'facility' && selectedDeliveryMethod === 'Fax' && isFaxIdsEmpty">
						<b-alert show variant="warning">
							No fax IDs are available for the facility. Please provide valid fax IDs.
						</b-alert>
					</b-form-group>


					<div v-if="selectedSubmitTo === 'agency'">
						<b-form-group label="Delivery Method" label-cols-lg="4">
							<b-form-select label="deliveryMethod" v-model="selectedDeliveryMethod" class="mt-2"
							:disabled="isAgencyNotSelected" @change="handleDeliveryMethodChange">
								<option value="Fax">Fax</option>
								<option value="Email">Email</option>
								<option value="Manual">Manual</option>
							</b-form-select>
						</b-form-group>

						<b-form-group v-if="isAgencyNotSelected">
							<b-alert show variant="warning">
								Please select an agency before submitting.
							</b-alert>
						</b-form-group>

						<div v-if="selectedDeliveryMethod === 'Email'">
							<b-form-group label="Agency Email">
								<b-form-input type="text" v-model="selectedAgencyEmail" disabled></b-form-input>
							</b-form-group>
						</div>

						<div v-if="selectedDeliveryMethod === 'Fax'">
							<b-form-group label="Agency Fax">
								<b-form-input type="text" v-model="selectedAgencyFax" disabled></b-form-input>
							</b-form-group>
						</div>
					</div>

					<div v-if="selectedDeliveryMethod === 'Manual'" class="manual-delivery-fields">
						<!-- Render fields for User -->
						<div class="row">
							<!-- Carrier dropdown -->
							<div class="col-md-6 form-group">
								<label for="carrier">Carrier:</label>
								<div class="input-group">
									<select class="form-control" v-model="carrier">
										<option value="FedEx">FedEx</option>
										<option value="UPS">UPS</option>
										<option value="USPS">USPS</option>
									</select>
								</div>
							</div>

							<!-- Tracking# input -->
							<div class="col-md-6 form-group">
								<label for="trackingNumber">Tracking#:</label>
								<input type="text" class="form-control" v-model="trackingNumber" />
							</div>
						</div>

						<!-- Add more fields as needed -->

						<div class="form-group">
							<label for="notes">Notes:</label>
							<textarea class="form-control" v-model="notes"></textarea>
						</div>
					</div>


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
.manual-delivery-fields .form-group {
	margin-bottom: 10px;
}

.manual-delivery-fields .form-group label {
	display: block;
	margin-bottom: 5px;
}

.manual-delivery-fields .form-group .input-group {
	display: flex;
	align-items: center;
	margin-bottom: 10px;
}

.manual-delivery-fields .form-group .form-control {
	margin-left: 10px;
	/* Adjust the margin as needed */
}

.manual-delivery-fields .form-group textarea {
	resize: vertical;
	/* Allow vertical resizing of the textarea */
}

.result-span {
	display: flex;

	align-items: center;
	/* Center vertically */
	justify-content: center;
	/* Center horizontally */
	border: 0.5px solid #000;
	/* Add your desired border styles here */
	padding: 1px;
	/* Adjust padding as needed */
	font-size: inherit;
	/* Inherit the font size from the parent (input) */
	width: 100%;
	/* Take the maximum available width */
	height: 100%;
	/* Take the maximum available height */
	box-sizing: border-box;
	/* Include border and padding in the width and height calculation */
}

/* Style for Submit To dropdown */
.b-form-select {
	width: 100%;
	/* Take the maximum available width */
}

/* Style for carrier, tracking, and notes */
label {
	margin-top: 10px;
	/* Add some top margin for better spacing */
	display: block;
	/* Make labels block-level for proper alignment */
}

input[type="text"],
textarea {
	width: 100%;
	/* Take the maximum available width */
	padding: 8px;
	/* Adjust padding as needed */
	box-sizing: border-box;
	/* Include padding in the width calculation */
	margin-bottom: 10px;
	/* Add some bottom margin for better spacing */
}

/* Add more styles as needed */

/* Style for mailNotes (example) */
.b-form-input[type="text"] {
	width: 100%;
	/* Take the maximum available width */
	padding: 8px;
	/* Adjust padding as needed */
	box-sizing: border-box;
	/* Include padding in the width calculation */
	margin-bottom: 10px;
	/* Add some bottom margin for better spacing */
}

.search-results {
	position: absolute;
	width: 100%;
	max-height: 150px;
	overflow-y: auto;
	border: 1px solid #ced4da;
	border-top: none;
	border-radius: 0 0 5px 5px;
	z-index: 1000;

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
		
		isFacilitySelected() {
			return this.selectedSubmitTo === 'facility' && this.facility_id === null;
		},
		isEmailIdsEmpty() {
			return this.emailIds.length === 0;
		},
		isFaxIdsEmpty() {
			return this.faxIds.length === 0;
		},
		localValue: {
			get() {
				return this.value;
			},
			set(val) {
				this.$emit("input", val);
			},
		},
		filteredUserList() {
			const regex = new RegExp(this.searchQuery, 'i');
			return this.userList
				.filter(user => regex.test(user.full_name))
				.map(user => user.full_name);
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
			selectedOptionMethodFtp: false,
			selectedOptionMethodEsmd: false,
			portalUrlEsmd: null,
			usernameEsmd: null,
			passwordEsmd: null,
			agencyList: [],
			selectedAgency: null,
			emailData: null,
			faxData: null,
			websiteData: null,
			contactNumberData: null,
			selectedSubmitTo: 'facility',
			selectedDeliveryMethod: 'fax',
			carrier: '',
			trackingNumber: '',
			notes: '',
			userList: [], // Array to store the full_name of users
			selectedUser: null, // Selected user from the list
			searchQuery: '',
			searchUser: '',
			searchResults: [],
			appealList: [], // Assuming you have appeal data
			agencyList: [], // Assuming you have agency data
			selectedAgencyEmail: "", // Variable to store selected agency email
			selectedAgencyFax: "", // Variable to store selected agency fax
			facility_id: null,
			emailIds: [],
			faxIds: [],
			emailList: [],
			faxList: [],
			extractedEmails: [],
			extractedFaxes: [],
			agencyid: null,

		};

	},
	mounted() {
		this.checkExists();
		this.test();
		this.fetchuserlist();
		this.AgencyList();
		this.AppealList();
		this.CaseList();
		this.facilityemailList();
		this.facilityfaxList();
		this.FacilityReceivingList();

	},
	methods: {
		async CaseList() {
			try {
				const url = "/client/caselist";

				// Fetch data from the server
				const response = await axios.get(url, {
					headers: {
						"Accept": "application/json",
					},
				});

				// Extract case_id from your component
				const case_id = this.value.case_id;
				console.log("Case ID from your component:", case_id);

				// Find the matching case in the response data
				const matchingCase = response.data.find((caseData) => caseData.id === case_id);

				if (matchingCase) {
					this.facility_id = matchingCase.facility_id;
					console.log("Matched Facility ID:", this.facility_id);
					// Now you have the facility_id for the matched case_id
				} else {
					console.log("No matching case found for the provided case_id");
				}

				console.log("RESPONSE cases = ", response.data);
			} catch (error) {
				console.error("Error fetching client facilities:", error);
			}
		},

		async facilityemailList() {
			try {
				const url = "/client/facilityemaillist";

				// Fetch data from the server
				const response = await axios.get(url, {
					headers: {
						"Accept": "application/json",
					},
				});
				this.emailList = response.data;
				console.log("RESPONSE email facility = ", response.data);
			} catch (error) {
				console.error("Error fetching client facilities:", error);
			}
		},
		async facilityfaxList() {
			try {
				const url = "/client/facilityfaxlist";

				// Fetch data from the server
				const response = await axios.get(url, {
					headers: {
						"Accept": "application/json",
					},
				});
				this.faxList = response.data;
				console.log("RESPONSE fax facility = ", response.data);
			} catch (error) {
				console.error("Error fetching client facilities:", error);
			}
		},
		async FacilityReceivingList() {
			try {
				const url = "/client/facilityreceivinglist";

				// Fetch data from the server
				const response = await axios.get(url, {
					headers: {
						"Accept": "application/json",
					},
				});

				console.log("RESPONSE facility receiving = ", response.data);

				// Check if this.facility_id is present in the response data
				const facilityReceivingData = response.data.find(item => item.facility_id === this.facility_id);

				if (facilityReceivingData) {
					// Extract email and fax IDs associated with the facility_id
					this.emailIds = response.data
						.filter(item => item.facility_id === this.facility_id)
						.map(item => item.receiving_email_id);

					this.faxIds = response.data
						.filter(item => item.facility_id === this.facility_id)
						.map(item => item.receiving_fax_id);

					// Now emailIds and faxIds contain the IDs associated with the facility_id
					console.log("Email IDs:", this.emailIds);
					console.log("Fax IDs:", this.faxIds);

					// Get fax numbers for the IDs inside faxIds array
					this.receivingFaxDetails = this.faxList
						.filter(item => this.faxIds.includes(item.id))
						.map(item => item.fax);

					// Get email addresses for the IDs inside emailIds array
					this.receivingEmailDetails = this.emailList
						.filter(item => this.emailIds.includes(item.id))
						.map(item => item.email);

					// Log the details for verification
					console.log("Receiving Email Details:", this.receivingEmailDetails);
					console.log("Receiving Fax Details:", this.receivingFaxDetails);
				} else {
					console.log("No data found for the provided facility_id");
				}
			} catch (error) {
				console.error("Error fetching facility receiving data:", error);
			}
		},



		async AgencyList() {
			try {
				const url = "/client/agencyList";

				// Fetch data from the server
				const response = await axios.get(url, {
					headers: {
						"Accept": "application/json",
					},
				});
				this.agencyList = response.data;
				console.log("RESPONSE agencies = ", response.data);
			} catch (error) {
				console.error("Error fetching client facilities:", error);
			}
		},
		async AppealList() {
			try {
				const url = "/client/appealList";

				// Fetch data from the server
				const response = await axios.get(url, {
					headers: {
						"Accept": "application/json",
					},
				});

				const insid = this.value.id;
				console.log("appeal id", insid);

				// Find the appeal with matching id
				let selectedAppeal = response.data.find(appeal => appeal.id === insid);
				console.log("checking selected Appeal", selectedAppeal)

				if (selectedAppeal) {
					// Find agency with matching id
					const selectedAgency = this.agencyList.find(agency => agency.id === selectedAppeal.agency_id);
					this.agencyid = this.agencyList.find(agency => agency.id === selectedAppeal.agency_id);
					console.log("agency id ",this.agencyid.id);
					if (selectedAgency) {
						// Update selected agency email and fax
						this.selectedAgencyEmail = selectedAgency.contact_email;
						this.selectedAgencyFax = selectedAgency.contact_fax;
					}
				}

				console.log("RESPONSE appeal = ", response.data);
				console.log("Selected Agency Email:", this.selectedAgencyEmail);
				console.log("Selected Agency Fax:", this.selectedAgencyFax);
			} catch (error) {
				console.error("Error fetching client facilities:", error);
			}
		},
		handleUserSearch() {
			// Implement search logic here and update searchResults
			this.searchResults = this.userList.filter(user => user.text.toLowerCase().includes(this.searchUser.toLowerCase()));
		},
		clearUserSearch() {
			this.searchUser = '';
			this.searchResults = [];
		},
		selectUser(user) {
			this.selectedUser = user.value; // Set the selected user ID or value
			this.searchUser = user.text; // Set the search bar value
			this.searchResults = []; // Clear the search results
			console.log("selected user id", this.selectedUser);
		},

		async fetchuserlist() {
			try {
				const url = "/client/userslist";

				// Fetch data from the server
				const response = await axios.get(url, {
					headers: {
						"Accept": "application/json",
					},
				});

				this.userList = response.data.map(user => ({
					value: user.id,
					text: user.full_name,
				}));

				console.log("userList = ", this.userList);

			} catch (error) {
				console.error("Error fetching client facilities:", error);
			}
		},


		handleSubmitToChange() {
			// Handle any logic when the "Submit To" dropdown changes
			// For example, you might want to reset some fields based on the selected option
			if (this.selectedSubmitTo === 'user') {
				this.selectedDeliveryMethod = ''; // Reset the selected delivery method
				// Reset other fields as needed
			} else {
				// Handle other cases if needed
			}
		},
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
				console.log('Send email initiated');
				const data = { 'id': this.selectedUser }

				// Use Axios to make the request to the controller for sending user_id 
				console.log(data);
				const resp = await axios.post('/client/sendoutgoingemail', data);
				console.log(resp);
			} catch (e) {
				console.log(e)
			}
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
					packageSentViaSnailMail: this.packageSentViaSnailMail,
					mailNotes: this.notes,
					ftpPortalUrl: this.portalUrlFtp,
					ftpUsername: this.usernameFtp,
					ftpPassword: this.passwordFtp,
					EsmdPortalUrl: this.portalUrlEsmd,
					EsmdUsername: this.usernameEsmd,
					EsmdPassword: this.passwordEsmd,
					email: this.emailData,
					fax: this.faxData,
					website: this.websiteData,
					contactNumber: this.contactNumberData,
					agency_id: this.selectedAgency,
					delivery_method: this.selectedDeliveryMethod,
					carrier: this.carrier,
					tracking: this.trackingNumber,
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
			//this.selectedAgency = null;
			// This function is called when the selected option changes
			console.log('Selected delivery method:', this.selectedOptionMethod);

			//for rendering mail options after mail is selected as delivery method
			this.selectedOptionText = "Search " + this.selectedOptionMethod;
			if (this.selectedOptionMethod == 'Mail') {
				this.selectedOptionMethodMail = true;
			}
			else {
				this.selectedOptionMethodMail = false;
			}
			if (this.selectedOptionMethod == 'FTP') {
				this.selectedOptionMethodFtp = true;
			}
			else {
				this.selectedOptionMethodFtp = false;
			}

			if (this.selectedOptionMethod == 'ESMD') {
				this.selectedOptionMethodEsmd = true;
			}
			else {
				this.selectedOptionMethodEsmd = false;
			}
			// Check if the selected delivery method is Email
			if (this.selectedDeliveryMethod === 'email') {
				// Update the form fields with the agency's email
				if (this.selectedSubmitTo === 'agency' && this.selectedAgencyEmail) {
					// Assuming you have a field to store the email value, update accordingly
					this.emailData = this.selectedAgencyEmail;
				}
			}
			// Check if the selected delivery method is Fax
			if (this.selectedDeliveryMethod === 'fax') {
				// Update the form fields with the agency's fax
				if (this.selectedSubmitTo === 'agency' && this.selectedAgencyFax) {
					// Assuming you have a field to store the fax value, update accordingly
					this.faxData = this.selectedAgencyFax;
				}
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
