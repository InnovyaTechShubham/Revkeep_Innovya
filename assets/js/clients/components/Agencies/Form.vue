<template>
	<loading-indicator v-if="loading" class="my-5" title="Fetching agency..." />
	<validation-observer v-else v-bind="$attrs" ref="observer" v-slot="{ invalid }">
		<b-form @submit.prevent="save" onsubmit="setTimeout(function(){window.location.reload();},2000);" >
			<b-card no-body>
				<slot name="header"></slot>

				<b-card-body>
					<validation-provider
						vid="name"
						name="Name"
						:rules="{ required: true, min: 2, max: 50 }"
						v-slot="validationContext"
					>
						<b-form-group label="Name" label-for="name" label-cols-lg="4" label-cols-xl="3">
							<b-form-input
								autofocus
								name="name"
								type="text"
								size="lg"
								v-model="entity.name"
								placeholder=""
								:state="getValidationState(validationContext)"
								:disabled="saving"
								required
							/>
							<b-form-invalid-feedback
								v-for="error in validationContext.errors"
								:key="error"
								v-text="error"
							/>
						</b-form-group>
					</validation-provider>

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
							label-cols-xl="3"
							description="Inactive agencies will not show up in dropdown lists."
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
					<validation-provider
						vid="third_party_contractor"
						name="Third Party Contractor"
						:rules="{ required: false }"
						v-slot="validationContext"
					>
						<b-form-group
							label="Third Party Contractor"
							label-for="third_party_contractor"
							label-cols-lg="4"
							label-cols-xl="3"
							description="This agency is a third party contractor."
						>
							<b-form-checkbox
								name="third_party_contractor"
								v-model="entity.third_party_contractor"
								:disabled="saving"
								>Third Party</b-form-checkbox
							>
							<b-form-invalid-feedback
								v-for="error in validationContext.errors"
								:key="error"
								v-text="error"
							/>
						</b-form-group>
					</validation-provider>
				</b-card-body>
				<b-card-body class="mb-4">
					<!-- <h6 class="text-muted">Additional Details</h6> -->
					<!-- <b-card no-body> -->
						<!-- <b-card-header header-tag="header" role="tab" class="p-0">
							<b-button
								block
								v-b-toggle.collapseAddress
								variant="light"
								role="tab"
								class="text-left px-4 py-3 m-0"
								>Address</b-button
							>
						</b-card-header> -->
						<!-- <b-collapse id="collapseAddress" role="tabpanel"> -->
						<b-card>
							<b-card-body>
								<h5 class="h5 mb-4 text-uppercase font-weight-bold">Address</h5>
								<b-form-group
									label="Address"
									label-for="street_address_1"
									label-cols-lg="4"
									label-cols-xl="3"
								>
									<validation-provider
										vid="street_address_1"
										name="Street Address"
										:rules="{ required: false, max: 100 }"
										v-slot="validationContext"
									>
										<b-form-input
											name="street_address_1"
											type="text"
											v-model="entity.street_address_1"
											placeholder=""
											class="rounded-b-0"
											:state="getValidationState(validationContext)"
											:disabled="saving"
										/>
										<b-form-invalid-feedback
											v-for="error in validationContext.errors"
											:key="error"
											v-text="error"
										/>
									</validation-provider>
									<!-- <validation-provider
										vid="street_address_2"
										name="Street Address (Continued)"
										:rules="{ required: false, max: 100 }"
										v-slot="validationContext"
									>
										<b-form-input
											name="street_address_2"
											type="text"
											v-model="entity.street_address_2"
											placeholder=""
											class="rounded-t-0"
											:state="getValidationState(validationContext)"
											:disabled="saving"
										/>
										<b-form-invalid-feedback
											v-for="error in validationContext.errors"
											:key="error"
											v-text="error"
										/>
									</validation-provider> -->
								</b-form-group>

								<validation-provider
									vid="city"
									name="City"
									:rules="{ required: false, max: 50 }"
									v-slot="validationContext"
								>
									<b-form-group label="City" label-for="city" label-cols-lg="4" label-cols-xl="3">
										<b-form-input
											name="city"
											type="text"
											v-model="entity.city"
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
									vid="state"
									name="State"
									:rules="{ required: false, max: 2 }"
									v-slot="validationContext"
								>
									<b-form-group label="State" label-for="state" label-cols-lg="4" label-cols-xl="3">
										<b-form-select
											name="state"
											v-model="entity.state"
											:options="states"
											value-field="abbreviation"
											text-field="name"
											:state="getValidationState(validationContext)"
											:disabled="saving"
										>
											<template #first>
												<option :value="null" />
											</template>
										</b-form-select>
										<b-form-invalid-feedback
											v-for="error in validationContext.errors"
											:key="error"
											v-text="error"
										/>
									</b-form-group>
								</validation-provider>

								<validation-provider
									vid="zip"
									name="Zip"
									:rules="{ required: false, max: 20, alpha_num: true }"
									v-slot="validationContext"
								>
									<b-form-group label="Zip" label-for="zip" label-cols-lg="4" label-cols-xl="3">
										<b-form-input
											name="zip"
											type="text"
											v-model="entity.zip"
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
						</b-card>
						<!-- </b-collapse> -->

						<!-- <b-card-header header-tag="header" role="tab" class="p-0">
							<b-button
								block
								v-b-toggle.collapseContact
								variant="light"
								role="tab"
								class="text-left px-4 py-3 m-0"
								>Contact Person</b-button
							>
						</b-card-header> -->
						<!-- <b-collapse id="collapseContact" role="tabpanel"> -->
						<b-card>
							<b-card-body>
								<h5 class="h5 mb-4 text-uppercase font-weight-bold">Contact Information</h5>
								<!-- <validation-provider
									vid="contact_name"
									name="Name"
									:rules="{ required: false, max: 50 }"
									v-slot="validationContext"
								>
									<b-form-group
										label="Name"
										label-for="contact_name"
										label-cols-lg="4"
										label-cols-xl="3"
									>
										<b-form-input
											name="contact_name"
											type="text"
											v-model="entity.contact_name"
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

								<!-- <validation-provider
									vid="contact_title"
									name="Title"
									:rules="{ required: false, max: 50 }"
									v-slot="validationContext"
								>
									<b-form-group
										label="Title"
										label-for="contact_title"
										label-cols-lg="4"
										label-cols-xl="3"
									>
										<b-form-input
											name="contact_title"
											type="text"
											v-model="entity.contact_title"
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

								<validation-provider
									vid="contact_email"
									name="Email"
									:rules="{ required: false, min: 3, max: 50 }"
									v-slot="validationContext"
								>
									<b-form-group
										label="Email"
										label-for="contact_email"
										label-cols-lg="4"
										label-cols-xl="3"
									>
										<b-form-input
											name="contact_email"
											type="email"
											v-model="entity.contact_email"
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

								<!-- <validation-provider
									vid="contact_phone"
									name="Phone"
									:rules="{ required: false, max: 50 }"
									v-slot="validationContext"
								>
									<b-form-group
										label="Phone"
										label-for="contact_phone"
										label-cols-lg="4"
										label-cols-xl="3"
									>
										<b-form-input
											name="contact_phone"
											type="tel"
											v-model="entity.contact_phone"
											v-mask="'(###) ###-####'"
											:disabled="saving"
											:state="getValidationState(validationContext)"
										/>
										<b-form-invalid-feedback
											v-for="error in validationContext.errors"
											:key="error"
											v-text="error"
										/>
									</b-form-group>
								</validation-provider> -->
								<b-form-group
									label="Phone"
									label-cols-lg="4"
									label-cols-xl="3"
								>
									<b-form-input

									/>
								</b-form-group>
								<b-form-group
									label="Website"
									label-cols-lg="4"
									label-cols-xl="3"
								>
									<b-form-input

									/>
								</b-form-group>

								<validation-provider
									vid="contact_fax"
									name="Fax"
									:rules="{ required: false, max: 50 }"
									v-slot="validationContext"
								>
									<b-form-group
										label="Fax"
										label-for="contact_fax"
										label-cols-lg="4"
										label-cols-xl="3"
									>
										<b-form-input
											name="contact_fax"
											type="tel"
											v-model="entity.contact_fax"
											v-mask="'(###) ###-####'"
											:disabled="saving"
											:state="getValidationState(validationContext)"
										/>
										<b-form-invalid-feedback
											v-for="error in validationContext.errors"
											:key="error"
											v-text="error"
										/>
									</b-form-group>
								</validation-provider>
							</b-card-body>
							<!-- </b-collapse> -->
						</b-card>
					</b-card-body>
						

				<b-card-body>
					<h6 class="text-muted">Outgoing Documents</h6>

					<validation-provider
						vid="outgoing_primary_method"
						name="Primary Delivery Method"
						:rules="{ required: true }"
						v-slot="validationContext"
					>
						<b-form-group
							label="Primary Delivery Method"
							label-for="outgoing_primary_method"
							label-cols-lg="4"
							label-cols-xl="3"
							description="Primary method of delivering response packets to this agency."
						>
							<!-- <b-form-radio-group
								name="outgoing_primary_method"
								v-model="entity.outgoing_primary_method"
								:options="outgoingMethods"
								value-field="value"
								text-field="name"
								:state="getValidationState(validationContext)"
								:disabled="saving"
							/> -->


							<b-form-radio-group
								name="outgoing_primary_method"
								v-model="entity.outgoing_primary_method"
								:options="outgoingMethods"
								value-field="value"
								text-field="name"
								:state="getValidationState(validationContext)"
								:disabled="saving"
								>
								
    						</b-form-radio-group>
							
							
							<b-form-invalid-feedback
								v-for="error in validationContext.errors"
								:key="error"
								v-text="error"
							/>
						</b-form-group>
					</validation-provider>

					<b-card no-body class="mt-4">
						<b-tabs card pills vertical v-model="outgoingMethodsTab" nav-class="px-2 px-lg-3">
							<b-tab title="Manual" id="outgoing_MANUAL" title-link-class="pr-lg-5">
								<b-alert show variant="light">
									<p>
										Outgoing documents that are unable to be automatically sent will be placed in
										the Manual queue.
									</p>
									<p class="mb-0">
										Manually queued documents can be marked as completed to remove them from the
										queue.
									</p>
								</b-alert>
							</b-tab>

							<b-tab title="Email" id="outgoing_EMAIL" title-link-class="pr-lg-5">
								<validation-provider
									vid="outgoing_profile.email"
									name="Email Address"
									:rules="{ required: false, min: 3, max: 50 }"
									v-slot="validationContext"
								>
									<b-form-group
										label="Email Address"
										label-for="outgoing_profile.email"
										label-cols-lg="4"
										label-cols-xl="2"
										description="Email address to send outgoing documents to."
									>
										<b-form-input
											name="outgoing_profile.email"
											type="email"
											v-model="entity.outgoing_profile.email"
											:state="getValidationState(validationContext)"
											:disabled="saving"
											style="max-width: 32rem"
										/>
										<b-form-invalid-feedback
											v-for="error in validationContext.errors"
											:key="error"
											v-text="error"
										/>
									</b-form-group>
								</validation-provider>
							</b-tab>

							<b-tab title="Fax" id="outgoing_FAX" title-link-class="pr-lg-5">
								<validation-provider
									vid="outgoing_profile.fax_number"
									name="Fax Number"
									:rules="{ required: false, max: 50 }"
									v-slot="validationContext"
								>
									<b-form-group
										label="Fax Number"
										label-for="outgoing_profile.fax"
										label-cols-lg="4"
										label-cols-xl="2"
										description="Number where outgoing documents can be faxed to."
									>
										<b-form-input
											name="fax"
											type="tel"
											v-model="entity.outgoing_profile.fax_number"
											v-mask="'(###) ###-####'"
											:disabled="saving"
											:state="getValidationState(validationContext)"
											style="max-width: 24rem"
										/>
										<b-form-invalid-feedback
											v-for="error in validationContext.errors"
											:key="error"
											v-text="error"
										/>
									</b-form-group>
								</validation-provider>
							</b-tab>

							<b-tab title="Website" id="outgoing_WEBSITE" title-link-class="pr-lg-5">
								<b-alert show variant="light">
									<font-awesome-icon icon="info-circle" fixed-width />
									Website-uploaded documents must be manually uploaded by the user processing them.
									{{ appName }} cannot directly upload to third party websites.
								</b-alert>

								<validation-provider
									vid="outgoing_profile.electronic_website"
									name="Website"
									:rules="{ required: false }"
									v-slot="validationContext"
								>
									<b-form-group
										label="Upload URL"
										label-for="outgoing_profile.electronic_website"
										label-cols-lg="4"
										label-cols-xl="2"
										description="Website URL where documents can be submitted/uploaded."
									>
										<b-form-input
											name="outgoing_profile.electronic_website"
											type="text"
											v-model="entity.outgoing_profile.electronic_website"
											:state="getValidationState(validationContext)"
											:disabled="saving"
											style="max-width: 32rem"
										/>
										<b-form-invalid-feedback
											v-for="error in validationContext.errors"
											:key="error"
											v-text="error"
										/>
									</b-form-group>
								</validation-provider>
							</b-tab>

							<!-- <b-tab title="ESMD" id="outgoing_WEBSITE" title-link-class="pr-lg-5">
								

								<validation-provider
									vid="outgoing_profile.electronic_website"
									name="Website"
									:rules="{ required: false }"
									v-slot="validationContext"
								>
									<b-form-group
										label="Upload Gateway URL"
										label-for="outgoing_profile.electronic_website"
										label-cols-lg="4"
										label-cols-xl="2"
										description="Enter the URL for NHIN Gateway"
									>
										<b-form-input
											name="outgoing_profile.electronic_website"
											type="text"
											v-model="entity.outgoing_profile.electronic_website"
											:state="getValidationState(validationContext)"
											:disabled="saving"
											style="max-width: 32rem"
										/>
										<b-form-invalid-feedback
											v-for="error in validationContext.errors"
											:key="error"
											v-text="error"
										/>
									</b-form-group>
									<b-form-group
										label="Upload CMS ID"
										label-for="outgoing_profile.electronic_website"
										label-cols-lg="4"
										label-cols-xl="2"
										description=""
									>
									<b-form-input
											name="outgoing_profile.electronic_website"
											type="text"
											v-model="entity.outgoing_profile.electronic_website"
											:state="getValidationState(validationContext)"
											:disabled="saving"
											style="max-width: 32rem"
										/>
									</b-form-group>
									
								</validation-provider>
							</b-tab> -->


							<b-tab title="Mail" id="outgoing_MAIL" title-link-class="pr-lg-5">
								<b-alert show variant="light">
									<font-awesome-icon icon="info-circle" fixed-width />
									Mailed documents must be manually marked as sent by a user processing them.
									{{ appName }} cannot directly mail outgoing documents.
								</b-alert>

								<validation-provider
									vid="outgoing_profile.mail_to_name"
									name="Name"
									:rules="{ required: false, max: 50 }"
									v-slot="validationContext"
								>
									<b-form-group
										label="Name"
										label-for="outgoing_profile.mail_to_name"
										label-cols-lg="4"
										label-cols-xl="2"
										description="Name of recipient"
									>
										<b-form-input
											name="outgoing_profile.mail_to_name"
											type="text"
											v-model="entity.outgoing_profile.mail_to_name"
											:state="getValidationState(validationContext)"
											:disabled="saving"
											style="max-width: 32rem"
										/>
										<b-form-invalid-feedback
											v-for="error in validationContext.errors"
											:key="error"
											v-text="error"
										/>
									</b-form-group>
								</validation-provider>

								<validation-provider
									vid="outgoing_profile.mail_to_department"
									name="Department"
									:rules="{ required: false, max: 50 }"
									v-slot="validationContext"
								>
									<b-form-group
										label="Department"
										label-for="outgoing_profile.mail_to_department"
										label-cols-lg="4"
										label-cols-xl="2"
										description="Department name to be addressed to"
									>
										<b-form-input
											name="outgoing_profile.mail_to_department"
											type="text"
											v-model="entity.outgoing_profile.mail_to_department"
											:state="getValidationState(validationContext)"
											:disabled="saving"
											style="max-width: 32rem"
										/>
										<b-form-invalid-feedback
											v-for="error in validationContext.errors"
											:key="error"
											v-text="error"
										/>
									</b-form-group>
								</validation-provider>

								<b-form-group
									label="Address"
									label-for="outgoing_profile.mail_to_address_1"
									label-cols-lg="4"
									label-cols-xl="2"
								>
									<validation-provider
										vid="outgoing_profile.mail_to_address_1"
										name="Street Address"
										:rules="{ required: false, max: 50 }"
										v-slot="validationContext"
									>
										<b-form-input
											name="outgoing_profile.mail_to_address_1"
											type="text"
											v-model="entity.outgoing_profile.mail_to_address_1"
											placeholder=""
											class="rounded-b-0"
											:state="getValidationState(validationContext)"
											:disabled="saving"
											style="max-width: 32rem"
										/>
										<b-form-invalid-feedback
											v-for="error in validationContext.errors"
											:key="error"
											v-text="error"
										/>
									</validation-provider>
									<validation-provider
										vid="outgoing_profile.mail_to_address_2"
										name="Street Address (Continued)"
										:rules="{ required: false, max: 50 }"
										v-slot="validationContext"
									>
										<b-form-input
											name="outgoing_profile.mail_to_address_2"
											type="text"
											v-model="entity.outgoing_profile.mail_to_address_2"
											placeholder=""
											class="rounded-t-0"
											:state="getValidationState(validationContext)"
											:disabled="saving"
											style="max-width: 32rem"
										/>
										<b-form-invalid-feedback
											v-for="error in validationContext.errors"
											:key="error"
											v-text="error"
										/>
									</validation-provider>
								</b-form-group>

								<validation-provider
									vid="outgoing_profile.mail_to_city"
									name="City"
									:rules="{ required: false, max: 50 }"
									v-slot="validationContext"
								>
									<b-form-group
										label="City"
										label-for="outgoing_profile.mail_to_city"
										label-cols-lg="4"
										label-cols-xl="2"
									>
										<b-form-input
											name="outgoing_profile.mail_to_city"
											type="text"
											v-model="entity.outgoing_profile.mail_to_city"
											:state="getValidationState(validationContext)"
											:disabled="saving"
											style="max-width: 32rem"
										/>
										<b-form-invalid-feedback
											v-for="error in validationContext.errors"
											:key="error"
											v-text="error"
										/>
									</b-form-group>
								</validation-provider>

								<validation-provider
									vid="outgoing_profile.mail_to_state"
									name="State"
									:rules="{ required: false, max: 2 }"
									v-slot="validationContext"
								>
									<b-form-group
										label="State"
										label-for="outgoing_profile.mail_to_state"
										label-cols-lg="4"
										label-cols-xl="2"
									>
										<b-form-select
											name="outgoing_profile.mail_to_state"
											v-model="entity.outgoing_profile.mail_to_state"
											:options="states"
											value-field="abbreviation"
											text-field="name"
											:state="getValidationState(validationContext)"
											:disabled="saving"
											style="max-width: 32rem"
										>
											<template #first>
												<option :value="null" />
											</template>
										</b-form-select>
										<b-form-invalid-feedback
											v-for="error in validationContext.errors"
											:key="error"
											v-text="error"
										/>
									</b-form-group>
								</validation-provider>

								<validation-provider
									vid="outgoing_profile.mail_to_zip"
									name="Zip"
									:rules="{ required: false, max: 20, alpha_num: true }"
									v-slot="validationContext"
								>
									<b-form-group
										label="Zip"
										label-for="outgoing_profile.mail_to_zip"
										label-cols-lg="4"
										label-cols-xl="2"
									>
										<b-form-input
											name="outgoing_profile.mail_to_zip"
											type="text"
											v-model="entity.outgoing_profile.mail_to_zip"
											:state="getValidationState(validationContext)"
											:disabled="saving"
											style="max-width: 16rem"
										/>
										<b-form-invalid-feedback
											v-for="error in validationContext.errors"
											:key="error"
											v-text="error"
										/>
									</b-form-group>
								</validation-provider>
							</b-tab>

							<b-tab title="Contact Number" id="outgoing_CONTACT" title-link-class="pr-lg-5">
								<validation-provider
									vid="outgoing_profile.contact_number"
									name="Contact Number"
									:rules="{ required: false, max: 50 }"
									v-slot="validationContext"
								>
									<b-form-group
										label="Contact Number"
										label-for="outgoing_profile.fax"
										label-cols-lg="4"
										label-cols-xl="2"
										description="Contact Number where outgoing documents can be sent."
									>
										<b-form-input
											name="contact_number"
											type="tel"
											v-model="entity.outgoing_profile.fax_number"
											v-mask="'(###) ###-####'"
											:disabled="saving"
											:state="getValidationState(validationContext)"
											style="max-width: 24rem"
										/>
										<b-form-invalid-feedback
											v-for="error in validationContext.errors"
											:key="error"
											v-text="error"
										/>
									</b-form-group>
								</validation-provider>
							</b-tab>
						</b-tabs>
					</b-card>



					<!-- <b-card-header header-tag="header" role="tab"  class="text-left px-4 py-3 m-0 p-0">Outgoing Methods</b-card-header>
							<b-card-body>
								<template>
									<div>
										<b-row>
										<b-col md="6">
											<div>
												<h6>Outgoing Emails</h6>
												<b-table v-if="entity && entity.receiving_emails && entity.receiving_emails.length > 0" :items="entity.receiving_emails" :fields="['email', 'description']" striped hover>
												<template slot="cell(email)" slot-scope="info">
													{{ info.value }}
												</template>
												<template slot="cell(description)" slot-scope="info">
													{{ info.value }}
												</template>
												</b-table>
												<empty-result v-else class="small-empty-result">
												<span>No emails added</span>
												</empty-result>
											</div>

											
											<b-button @click="openPopup" variant="primary">
												<font-awesome-icon icon="plus" fixed-width />
											</b-button>

											<b-modal v-model="popupVisible" title="Add Email" hide-footer>
												<b-form @submit.prevent="addEmail">
												<b-form-group label="Email" label-for="email">
													<b-form-input v-model="newEmail.email" id="email" required />
												</b-form-group>
												<b-form-group label="Description" label-for="description">
													<b-form-input v-model="newEmail.description" id="description" />
												</b-form-group>
												<b-button type="submit" variant="primary" class="mx-auto d-block"> Ok</b-button>
												</b-form>
											</b-modal>

											
											<b-button @click="openDeletePopup" variant="danger" v-if="entity.receiving_emails && entity.receiving_emails.length > 0" class="mr-8">
												<font-awesome-icon icon="trash" fixed-width />
											</b-button>

											
											<b-modal v-model="deletePopupVisible" title="Delete Emails" @ok="deleteSelectedEmails" ok-only>
												<b-form>
												<div> 
													<b-table :items="entity.receiving_emails" :fields="['email', 'description']" striped hover>
													<template #cell(email)="info">
														<div class="d-flex align-items-center">
														<b-form-checkbox v-model="selectedEmails" :value="info.item.email" class="mr-2" />
														<span>{{ info.item.email }}</span>
														</div>
													</template>
													<template #cell(description)="info">
														{{ info.value }}
													</template>
													</b-table>
												</div>
												</b-form>
												<template #modal-footer="{ ok }">
												<b-button @click="deleteSelectedEmails" variant="primary" class="mx-auto d-block">OK</b-button>
												</template>
											</b-modal>
											
										</b-col>

										
										<b-col md="6">
											
											<div>
												<h6>Outgoing Faxes</h6>
												<b-table v-if="entity && entity.receiving_faxes && entity.receiving_faxes.length > 0" :items="entity.receiving_faxes" :fields="['fax', 'description']" striped hover>
												<template slot="cell(fax)" slot-scope="info">
													{{ info.value }}
												</template>
												<template slot="cell(description)" slot-scope="info">
													{{ info.value }}
												</template>
												</b-table>
												<empty-result v-else class="small-empty-result">
												<span>No faxes added</span>
												</empty-result>
											</div>

											
											<div class="d-flex justify-content-between">
												
												<b-button @click="openPopupFax" variant="primary">
												<font-awesome-icon icon="plus" fixed-width />
												</b-button>

												
												<b-button @click="openDeleteFaxPopup" variant="danger" v-if="entity.receiving_faxes && entity.receiving_faxes.length > 0" class="mr-8">
												<font-awesome-icon icon="trash" fixed-width />
												</b-button>
											</div>

										
											<b-modal v-model="popupVisibleFax" title="Add Fax" hide-footer>
												<b-form @submit.prevent="addFax">
												<b-form-group label="Fax" label-for="fax">
													<b-form-input v-model="newFax.fax" id="fax" required />
												</b-form-group>
												<b-form-group label="Description" label-for="description">
													<b-form-input v-model="newFax.description" id="description" />
												</b-form-group>
												<b-button type="submit" variant="primary" class="mx-auto d-block"> Ok</b-button>
												</b-form>
											</b-modal>

											
											<b-modal v-model="deletePopupVisibleFax" title="Delete Faxes" @ok="deleteSelectedFaxes" ok-only>
												<b-form>
												<div> 
													<b-table :items="entity.receiving_faxes" :fields="['fax', 'description']" striped hover>
													<template #cell(fax)="info">
														<div class="d-flex align-items-center">
														<b-form-checkbox v-model="selectedFaxes" :value="info.item.fax" class="mr-2" />
														<span>{{ info.item.fax }}</span>
														</div>
													</template>
													<template #cell(description)="info">
														{{ info.value }}
													</template>
													</b-table>
												</div>
												</b-form>
												<template #modal-footer="{ ok }">
												<b-button @click="deleteSelectedFaxes" variant="primary" class="mx-auto d-block">OK</b-button>
												</template>
											</b-modal>
											
										</b-col>
										</b-row>
									</div>
									</template>
							</b-card-body> -->
					<b-card>
						<b-card-body>
							<h5 class="h5 mb-4 text-uppercase font-weight-bold">Outgoing Methods</h5>
							<template>
								<div>
									<b-row>
										<b-col md="6">
											<div>
												<h6>Outgoing Emails</h6>
												<b-table
													v-if="entity && entity.receiving_emails && entity.receiving_emails.length > 0"
													:items="entity.receiving_emails" :fields="['email', 'description']"
													striped hover>
													<template slot="cell(email)" slot-scope="info">
														{{ info.value }}
													</template>
													<template slot="cell(description)" slot-scope="info">
														{{ info.value }}
													</template>
												</b-table>
												<empty-result v-else class="small-empty-result">
													<span>No emails added</span>
												</empty-result>
											</div>


											<b-button @click="openPopup" variant="primary">
												<font-awesome-icon icon="plus" fixed-width />
											</b-button>

											<b-modal v-model="popupVisible" title="Add Email" hide-footer>
												<b-form @submit.prevent="addEmail">
													<b-form-group label="Email" label-for="email">
														<b-form-input v-model="newEmail.email" id="email" required />
													</b-form-group>
													<b-form-group label="Description" label-for="description">
														<b-form-input v-model="newEmail.description" id="description" />
													</b-form-group>
													<b-button type="submit" variant="primary" class="mx-auto d-block">
														Ok</b-button>
												</b-form>
											</b-modal>


											<b-button @click="openDeletePopup" variant="danger"
												v-if="entity.receiving_emails && entity.receiving_emails.length > 0"
												class="mr-8">
												<font-awesome-icon icon="trash" fixed-width />
											</b-button>


											<b-modal v-model="deletePopupVisible" title="Delete Emails"
												@ok="deleteSelectedEmails" ok-only>
												<b-form>
													<div>
														<b-table :items="entity.receiving_emails"
															:fields="['email', 'description']" striped hover>
															<template #cell(email)="info">
																<div class="d-flex align-items-center">
																	<b-form-checkbox v-model="selectedEmails"
																		:value="info.item.email" class="mr-2" />
																	<span>{{ info.item.email }}</span>
																</div>
															</template>
															<template #cell(description)="info">
																{{ info.value }}
															</template>
														</b-table>
													</div>
												</b-form>
												<template #modal-footer="{ ok }">
													<b-button @click="deleteSelectedEmails" variant="primary"
														class="mx-auto d-block">OK</b-button>
												</template>
											</b-modal>

										</b-col>


										<b-col md="6">

											<div>
												<h6>Outgoing Faxes</h6>
												<b-table
													v-if="entity && entity.receiving_faxes && entity.receiving_faxes.length > 0"
													:items="entity.receiving_faxes" :fields="['fax', 'description']" striped
													hover>
													<template slot="cell(fax)" slot-scope="info">
														{{ info.value }}
													</template>
													<template slot="cell(description)" slot-scope="info">
														{{ info.value }}
													</template>
												</b-table>
												<empty-result v-else class="small-empty-result">
													<span>No faxes added</span>
												</empty-result>
											</div>


											<div class="d-flex justify-content-between">

												<b-button @click="openPopupFax" variant="primary">
													<font-awesome-icon icon="plus" fixed-width />
												</b-button>


												<b-button @click="openDeleteFaxPopup" variant="danger"
													v-if="entity.receiving_faxes && entity.receiving_faxes.length > 0"
													class="mr-8">
													<font-awesome-icon icon="trash" fixed-width />
												</b-button>
											</div>


											<b-modal v-model="popupVisibleFax" title="Add Fax" hide-footer>
												<b-form @submit.prevent="addFax">
													<b-form-group label="Fax" label-for="fax">
														<b-form-input v-model="newFax.fax" id="fax" required
															v-mask="'(###) ###-####'" />
													</b-form-group>
													<b-form-group label="Description" label-for="description">
														<b-form-input v-model="newFax.description" id="description" />
													</b-form-group>
													<b-button type="submit" variant="primary" class="mx-auto d-block">
														Ok</b-button>
												</b-form>
											</b-modal>


											<b-modal v-model="deletePopupVisibleFax" title="Delete Faxes"
												@ok="deleteSelectedFaxes" ok-only>
												<b-form>
													<div>
														<b-table :items="entity.receiving_faxes"
															:fields="['fax', 'description']" striped hover>
															<template #cell(fax)="info">
																<div class="d-flex align-items-center">
																	<b-form-checkbox v-model="selectedFaxes"
																		:value="info.item.fax" class="mr-2" />
																	<span>{{ info.item.fax }}</span>
																</div>
															</template>
															<template #cell(description)="info">
																{{ info.value }}
															</template>
														</b-table>
													</div>
												</b-form>
												<template #modal-footer="{ ok }">
													<b-button @click="deleteSelectedFaxes" variant="primary"
														class="mx-auto d-block">OK</b-button>
												</template>
											</b-modal>

										</b-col>
									</b-row>
								</div>
							</template>
						</b-card-body>
					</b-card>
				</b-card-body>

				<b-card-footer>
					<b-row>
						<b-col cols="12" md="6" lg="4" class="mb-4 mb-md-0">
							<b-button block variant="light" type="button" @click.prevent="cancel">Cancel</b-button>
						</b-col>
						<b-col cols="12" md="6" offset-lg="4" lg="4" class="mb-2 mb-md-0">
							<b-button block variant="primary" type="submit" :disabled="saving" >
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
import { save, get } from "@/clients/services/agencies";
import { formatErrors, getValidationState } from "@/validation";

export default {
	name: "AgencyForm",
	components: {},
	props: {
		id: {
			default: null,
		},
	},
	computed: mapGetters({
		appName: "appName",
		states: "states/states",
		outgoingMethods: "outgoingDocuments/availableMethods",
	}),
	data() {
		return {
			loading: true,
			saving: false,
			entity: {
				id: this.id,
				name: "",
				active: true,
				third_party_contractor: true,
				outgoing_primary_method: "MANUAL",
				outgoing_profile: {},
			},
			outgoingMethodsTab: 0,
			outgoingTabs: [
				// Must match order of tabs in template
				"outgoing_MANUAL",
				"outgoing_EMAIL",
				"outgoing_FAX",
				"outgoing_WEBSITE",
				"outgoing_MAIL",
				"outgoing_CONTACT"
			],

			receiving_email: '', // For input
			receiving_emails: [], // For storing multiple emails
			receiving_fax: '', // For input
			receiving_faxes: [], // For storing multiple emails
			outgoing_emails: [],
			displayedEmails: '',
			displayedFaxes: '',
			popupVisible: false,
			popupVisibleFax: false,
			deletePopupVisible: false,
			deletePopupVisibleFax: false,
			MultiAgencyContact: [],

			newEmail: {
				email: '',
				description: '',
			},
			selectedEmails: [],
			newFax: {
				fax: '',
				description: '',
			},
			selectedFaxes: [],
			showDeleteIcon: false,


		};
	},
	mounted() {
		this.MultiAgencyContactList();
		if (this.id) {
			this.refresh();
		} else {
			this.loading = false;
		}
	},
	methods: {

		async MultiAgencyContactList() {
			console.log("started");
			try {
				const url = "/client/multiagencycontactlist";

				// Fetch data from the server
				const response = await axios.get(url, {
					headers: {
						"Accept": "application/json",
					},
				});
				// Clear existing data in receiving_emails and receiving_faxes arrays
				this.entity.receiving_emails = [];
				this.entity.receiving_faxes = [];

				// Filter contacts based on the agency ID
				const filteredContacts = response.data.filter(contact => contact.agency_id === this.id);

				// Iterate over the filtered contacts and populate email and fax arrays
				filteredContacts.forEach(contact => {
					if (contact.agency_email != "NULL" ) {
						this.entity.receiving_emails.push({ email: contact.agency_email, description: contact.desc_email });
					}
					if (contact.agency_fax) {
						this.entity.receiving_faxes.push({ fax: contact.agency_fax, description: contact.desc_fax });
					}
				});
				console.log("fetched");
			} catch (error) {
				console.error("Error fetching multi agency contact:", error);
			}
		},

		openPopupFax() {
			this.popupVisibleFax = true;
		},
		closePopupFax() {
			this.popupVisibleFax = false;
		},

		addFax() {
			// Assuming newFax is a valid object with fax and description properties
			const newFax = { ...this.newFax };
			console.log("new:", newFax);
			console.log("Receiving Faxes:", this.entity.receiving_faxes);

			// Check if receiving_faxes is defined, if not, initialize it as an empty array
			if (!Array.isArray(this.entity.receiving_faxes)) {
				this.$set(this.entity, 'receiving_faxes', []);
			}

			// Add the new fax to the array
			this.entity.receiving_faxes.push(newFax);

			// Clear the newFax object for the next entry
			this.newFax = { fax: '', description: '' };

			// Close the pop-up
			// this.closeFaxPopup();
			this.popupVisibleFax = false;
		},
		openDeleteFaxPopup() {
			// Show checkboxes and delete icon
			this.showDeleteIcon = true;
			this.deletePopupVisibleFax = true;
		},
		closeDeleteFaxPopup() {
			// Hide checkboxes and delete icon
			this.showDeleteIcon = false;
			this.deletePopupVisibleFax = false;
			// Reset selectedFaxes array
			this.selectedFaxes = [];
		},
		deleteSelectedFaxes() {
			// Add logic to delete selected faxes
			console.log("Inside");
			const updatedFaxes = this.entity.receiving_faxes.filter(
				(fax) => !this.selectedFaxes.includes(fax.fax)
			);
			console.log("Deleted:", updatedFaxes);

			// Update the receiving_faxes array with the updatedFaxes
			this.entity.receiving_faxes = updatedFaxes;

			// Reset selectedFaxes array
			this.selectedFaxes = [];

			// Close the delete popup
			this.closeDeleteFaxPopup();
		},
		openPopup() {
			this.popupVisible = true;
		},
		closePopup() {
			this.popupVisible = false;
		},

		async addEmail() {
			// Assuming newEmail is a valid object with email and description properties
			const newEmail = { ...this.newEmail };
			const email = newEmail.email;
			const description = newEmail.description;
			console.log("new:", newEmail);
			console.log("Receiving Emails:", this.entity.receiving_emails);
			// Prepare the data to be sent in the POST request
			// const emailData = {
			// 	email,
			// 	description,
			// 	};
			// console.log("before API", emailData);

			// Check if receiving_emails is defined, if not, initialize it as an empty array
			if (!Array.isArray(this.entity.receiving_emails)) {
				this.$set(this.entity, 'receiving_emails', []);
			}

			// Add the new email to the array
			this.entity.receiving_emails.push(newEmail);

			// Clear the newEmail object for the next entry
			this.newEmail = { email: '', description: '' };

			// Close the pop-up
			// this.closePopup();
			this.popupVisible = false;

			// Prepare the data to be sent in the POST request
			const emailData = {
				email,
				description,
			};
			console.log("before API", emailData);
			// await axios.post('/client/receivingEmails', emailData)
			// 	.then(response => {
			// 		// const responseData = response.data.data;
			// 		console.log("response:", response);
			// 		if (response.data.success) {
			// 			console.log('email saved');
			// 			this.saving = false;
			// 			this.$router.push({
			// 				name: "receivingEmails"
			// 			});
			// 			this.$nextTick(function () {
			// 				this.$store.dispatch("notify", {
			// 					variant: "primary",
			// 					title: "Email Created!",
			// 					message: `New email Created!.`,
			// 				});
			// 			});
			// 			redirect_index()
			// 		} else {
			// 			this.saving = false;
			// 			console.log('email already exists');
			// 			this.errorMessage = response.data.message;
			// 			this.$nextTick(function () {
			// 				this.$store.dispatch("notify", {
			// 					variant: "danger",
			// 					title: "Email Error",
			// 					message: this.errorMessage,
			// 				});
			// 			});
			// 		}
			// 	})
			// 	.catch(error => {
			// 		console.log(error)
			// 		// TODO: FIX IF THERE IS ANY WARNING/ERROR IN RESPONSE BLOCK
			// 		// this.saving = false;
			// 		// this.errorMessage = 'Error creating chain.'; 
			// 		// this.$nextTick(function () {
			// 		// 	this.$store.dispatch("notify", {
			// 		// 		variant: "danger",
			// 		// 		title: "Chain Error",
			// 		// 		message: error,
			// 		// 	});
			// 		// });
			// 	})

		},
		openDeletePopup() {
			// Show checkboxes and delete icon
			this.showDeleteIcon = true;
			this.deletePopupVisible = true;
		},
		closeDeletePopup() {
			// Hide checkboxes and delete icon
			this.showDeleteIcon = false;
			this.deletePopupVisible = false;
			// Reset selectedEmails array
			this.selectedEmails = [];
		},
		deleteSelectedEmails() {
			// Add logic to delete selected emails
			console.log("Inside");
			const updatedEmails = this.entity.receiving_emails.filter(
				(email) => !this.selectedEmails.includes(email.email)
			);
			console.log("Deleted:", updatedEmails);
			// Update the receiving_emails array with the updatedEmails
			this.entity.receiving_emails = updatedEmails;
			// Reset selectedEmails array
			this.selectedEmails = [];
			this.closeDeletePopup();
		},

		getValidationState,
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
				if (!response.outgoing_profile) {
					this.entity.outgoing_profile = {};
				}
				this.$emit("loaded", this.entity);
			} catch (e) {
				this.$store.dispatch("apiError", {
					error: e,
					message: "Error getting agency details",
				});
			} finally {
				this.loading = false;
			}
		},
		// 		async save() {
		// 			try {
		// 				this.saving = true;

		// 				const response = await save(this.entity);
		// 				console.log(response.id);
		// 				this.$emit("saved", response);
		// 				this.$emit("update:id", response.id);
		// 			} catch (e) {
		// 				if (e.response.data.errors) {
		// 					this.$refs.observer.setErrors(formatErrors(e.response.data.errors));
		// 				}

		// 				this.$store.dispatch("apiError", {
		// 					error: e,
		// 					title: "Save Failed",
		// 					message: "Error saving agency details. Please check for errors.",
		// 					variant: "warning",
		// 				});
		// 			} finally {
		// 				this.saving = false;
		// 			}

		// 	// 	try {
		//     //     // Prepare data to be sent to the backend API
		//     //     const data = {
		//     //       id: this.id,
		//     //       name: this.entity.name,
		//     //       emails: this.entity.receiving_emails.map(email => ({
		//     //         email: email.email,
		//     //         description: email.description
		//     //       })),
		//     //       faxes: this.entity.receiving_faxes.map(fax => ({
		//     //         fax: fax.fax,
		//     //         description: fax.description
		//     //       }))
		//     //     };
		// 	// 	console.log("data sent", data);
		//     //     // Call your backend API to save the data
		//     //     const response = await axios.post('/client/multipleagencycontact', data);
		// 	// 	//const response = await axios.post('/client/multiplefacility', data);
		// 	// 	console.log("request sent")
		//     //     // Handle the response as needed
		//     //     console.log("Data sent successfully", response);
		// 	// 	this.$emit("savedWithFacilities", response);
		//     //   } catch (error) {
		//     //     // Handle any errors that occur during the API call
		//     //     console.error('Error saving data:', error);
		//     //     // You may want to show an error message to the user
		//     //   }
		// 	try {

		//     // Prepare data to be sent to the backend API
		//     const data = {
		//         id: this.id,
		//         name: this.entity.name,
		//         contacts: [
		//             ...this.entity.receiving_emails.map(email => ({ type: 'email', value: email.email, description: email.description })),
		//             ...this.entity.receiving_faxes.map(fax => ({ type: 'fax', value: fax.fax, description: fax.description }))
		//         ]
		//     };
		//     console.log("data sent", data);

		//     // Call your backend API to save the data
		//     const response = await axios.post('/client/multipleagencycontact', data);
		//     console.log("request sent");

		//     // Handle the response as needed
		//     console.log("Data sent successfully", response);
		//     this.$emit("savedWithFacilities", response);
		// } catch (error) {
		//     // Handle any errors that occur during the API call
		//     console.error('Error saving data:', error);
		//     // You may want to show an error message to the user
		// }
		//     },

		async save() {
			try {
				this.saving = true;
				const response = await save(this.entity);
				console.log(response.id);
				this.$emit("saved", response);
				this.$emit("update:id", response.id);

				// Call the new async function with the response.id as a parameter
				await this.newAsyncFunction(response.id);

			} catch (e) {
				if (e.response.data.errors) {
					this.$refs.observer.setErrors(formatErrors(e.response.data.errors));
				}

				this.$store.dispatch("apiError", {
					error: e,
					title: "Save Failed",
					message: "Error saving agency details. Please check for errors.",
					variant: "warning",
				});
			} finally {
				this.saving = false;
			}
		},

	


		async newAsyncFunction(id) {
			try {
				// Prepare data to be sent to the backend API
				const data = {
					id: id,
					name: this.entity.name,
					contacts: [
						...this.entity.receiving_emails.map(email => ({ type: 'email', value: email.email, description: email.description })),
						...this.entity.receiving_faxes.map(fax => ({ type: 'fax', value: fax.fax, description: fax.description }))
					]
				};
				console.log("data sent", data);

				// Call your backend API to save the data
				const response = await axios.post('/client/multipleagencycontact', data);
				console.log("request sent");

				// Handle the response as needed
				console.log("Data sent successfully", response);
				this.$emit("savedWithFacilities", response);
			} catch (error) {
				// Handle any errors that occur during the API call
				console.error('Error saving data:', error);
				// You may want to show an error message to the user
			}
		},
	},


	watch: {
		entity: {
			deep: true,
			immediate: true,
			handler(val) {
				const tabIndex = this.outgoingTabs.findIndex(
					(tab) => tab === "outgoing_" + val.outgoing_primary_method
				);
				if (tabIndex > -1) {
					this.outgoingMethodsTab = tabIndex;
				}
			},
		},
	},
};
</script>
