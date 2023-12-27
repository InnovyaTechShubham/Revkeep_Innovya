<template>
	<loading-indicator v-if="loading" class="my-5" />
	<validation-observer v-else v-bind="$attrs" ref="observer" v-slot="{ invalid }">
		<b-form @submit.prevent="save" >
			<b-card no-body>
				<slot name="header"></slot>

				<b-card-body>
					<validation-provider
						vid="name"
						name="Name"
						:rules="{ required: true, min: 2, max: 50 }"
						v-slot="validationContext"
					>
						<b-form-group label="Name" label-for="name" label-cols-lg="4">
							<b-input-group>
								<b-form-input
									autofocus
									name="name"
									size="lg"
									type="text"
									v-model="entity.name"
									:state="getValidationState(validationContext)"
									:disabled="saving"
									:readonly=true
								/>
								<!-- <b-input-group-append>
									<b-button
										variant="primary"
										@click="npiLookup"
										:disabled="npiLookingUp || !entity.name"
										>NPI Search</b-button
									>
								</b-input-group-append> -->
								<b-form-invalid-feedback
									v-for="error in validationContext.errors"
									:key="error"
									v-text="error"
								/>
							</b-input-group>
						</b-form-group>
					</validation-provider>

					<!-- <b-list-group v-if="npiResults.length > 0">
						<div v-for="npiResult in npiResults" :key="npiResult.number">
							<NPIOrganization :value="npiResult" v-slot="{ name, number, primaryAddress, value }">
								<b-list-group-item>
									<div class="d-flex justify-content-between align-items-top">
										<div>
											<h6 class="h6">{{ name }}</h6>
											<p class="text-muted">{{ number }}</p>
											<div v-if="primaryAddress">
												<div v-if="primaryAddress.address_1">
													{{ primaryAddress.address_1 }}
												</div>
												<div v-if="primaryAddress.address_2">
													{{ primaryAddress.address_2 }}
												</div>
												<div>
													<span v-if="primaryAddress.city">{{ primaryAddress.city }}</span>
													<span v-if="primaryAddress.state"
														>, {{ primaryAddress.state }}</span
													>
													<span v-if="primaryAddress.postal_code">
														{{ primaryAddress.postal_code }}</span
													>
												</div>
											</div>
										</div>
										<div>
											<b-button @click="selectedNpiResult(value)">Select</b-button>
										</div>
									</div>
								</b-list-group-item>
							</NPIOrganization>
						</div>
					</b-list-group> -->
					<!-- <empty-result v-else-if="npiSearched && npiResults.length <= 0">
						No Results
						<template #content>
							No organizations were found in the NPI Registry matching what you provided.
						</template>
					</empty-result>
					<loading-indicator v-else-if="npiLookingUp" /> -->
				</b-card-body>
                
				<b-card-body>

					<validation-provider
						vid="disp_name"
						name="display_name"
						:rules="{ required: false, max: 60 }"
						v-slot="validationContext"
					>
						<b-form-group label="Display Name1" label-for="disp_name" label-cols-lg="4">
							<b-form-input
								name="display_name"
								type="text"
								v-model="entity.display_name"
								:state="getValidationState(validationContext)"
								
							/>
							<b-form-invalid-feedback
								v-for="error in validationContext.errors"
								:key="error"
								v-text="error"
							/>
						</b-form-group>
					</validation-provider>

					<validation-provider
						vid="facility_type_id"
						name="Facility Type"
						:rules="{ required: true }"
						v-slot="validationContext"
					>
						<b-form-group label="Main Type" label-for="facility_type_id" label-cols-lg="4">
							<b-form-select
								name="facility_type_id"
								v-model="entity.facility_type_id"
								:state="getValidationState(validationContext)"
								:options="facilityTypes"
								:disabled="saving || loadingFacilityTypes"
								required="required"
								value-field="id"
								text-field="name"
							/>
							<b-form-invalid-feedback
								v-for="error in validationContext.errors"
								:key="error"
								v-text="error"
							/>
						</b-form-group>
					</validation-provider>

					<validation-provider
						vid="street_address_1"
						name="Street Address"
						:rules="{ required: false, max: 50 }"
						v-slot="validationContext"
					>
						<b-form-group label="Location Address" label-for="street_address_1" label-cols-lg="4">
							<b-form-input
								name="street_address_1"
								type="text"
								v-model="entity.street_address_1"
								placeholder=""
								class="rounded-b-0"
								:state="getValidationState(validationContext)"
								:disabled="saving"
								:readonly=true
							/>
							<b-form-invalid-feedback
								v-for="error in validationContext.errors"
								:key="error"
								v-text="error"
							/>
						</b-form-group>
					</validation-provider>

					<validation-provider
						vid="city"
						name="City"
						:rules="{ required: false, max: 50 }"
						v-slot="validationContext"
					>
						<b-form-group label="City" label-for="city" label-cols-lg="4">
							<b-form-input
								name="city"
								type="text"
								v-model="entity.city"
								:state="getValidationState(validationContext)"
								:disabled="saving"
								:readonly=true
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
						<b-form-group label="State" label-for="state" label-cols-lg="4">
							<b-form-select
								name="state"
								v-model="entity.state"
								:options="states"
								value-field="abbreviation"
								text-field="name"
								:state="getValidationState(validationContext)"
								:disabled=true
								
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
						<b-form-group label="Zip" label-for="zip" label-cols-lg="4">
							<b-form-input
								name="zip"
								type="text"
								v-model="entity.zip"
								:state="getValidationState(validationContext)"
								:disabled="saving"
								:readonly=true
							/>
							<b-form-invalid-feedback
								v-for="error in validationContext.errors"
								:key="error"
								v-text="error"
							/>
						</b-form-group>
					</validation-provider>

					<!-- <validation-provider
						vid="area_name"
						name="Area"
						:rules="{ required: false, max: 60 }"
						v-slot="validationContext"
					>
						<b-form-group label="Location Address" label-for="area_name" label-cols-lg="4">
							<b-form-input
								name="area_name"
								type="text"
								v-model="entity.area_name"
								:state="getValidationState(validationContext)"
								:disabled="saving|| fromnNPI"
							/>
							<b-form-invalid-feedback
								v-for="error in validationContext.errors"
								:key="error"
								v-text="error"
							/>
						</b-form-group>
					</validation-provider>

					<validation-provider
						vid="city"
						name="City"
						:rules="{ required: false, max: 50 }"
						v-slot="validationContext"
					>
						<b-form-group label="City" label-for="city" label-cols-lg="4">
							<b-form-input
								name="city"
								type="text"
								v-model="entity.city"
								:state="getValidationState(validationContext)"
								:disabled="saving|| fromnNPI"
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
						<b-form-group label="State" label-for="state" label-cols-lg="4">
							<b-form-select
								name="state"
								v-model="entity.state"
								:options="states"
								value-field="abbreviation"
								text-field="name"
								:state="getValidationState(validationContext)"
								:disabled="saving|| fromnNPI"
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
						<b-form-group label="Zip" label-for="zip" label-cols-lg="4">
							<b-form-input
								name="zip"
								type="text"
								v-model="entity.zip"
								:state="getValidationState(validationContext)"
								:disabled="saving|| fromnNPI"
							/>
							<b-form-invalid-feedback
								v-for="error in validationContext.errors"
								:key="error"
								v-text="error"
							/>
						</b-form-group>
					</validation-provider>

					<validation-provider
						vid="ou_number"
						name="OU Number"
						:rules="{ required: false, max: 60 }"
						v-slot="validationContext"
					>
						<b-form-group label="OU Number" label-for="ou_number" label-cols-lg="4">
							<b-form-input
								name="ou_number"
								type="text"
								v-model="entity.ou_number"
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
						vid="territory"
						name="Territory"
						:rules="{ required: false, max: 60 }"
						v-slot="validationContext"
					>
						<b-form-group label="Territory" label-for="territory" label-cols-lg="4">
							<b-form-input
								name="territory"
								type="text"
								v-model="entity.territory"
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
						vid="rvp_name"
						name="RVP"
						:rules="{ required: false, max: 60 }"
						v-slot="validationContext"
					>
						<b-form-group label="RVP" label-for="rvp_name" label-cols-lg="4">
							<b-form-input
								name="rvp_name"
								type="text"
								v-model="entity.rvp_name"
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
						vid="active"
						name="Active"
						:rules="{ required: false }"
						v-slot="validationContext"
					>
						<b-form-group
							label="Active"
							label-for="active"
							label-cols-lg="4"
							description="Inactive facilities will not show up in dropdown lists."
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
						vid="client_owned"
						name="Owned"
						:rules="{ required: false }"
						v-slot="validationContext"
					>
						<b-form-group
							label="Owned"
							label-for="client_owned"
							label-cols-lg="4"
							description="Facility is owned/provided by client."
						>
							<b-form-checkbox name="client_owned" v-model="entity.client_owned" :disabled="saving"
								>Owned</b-form-checkbox
							>
							<b-form-invalid-feedback
								v-for="error in validationContext.errors"
								:key="error"
								v-text="error"
							/>
						</b-form-group>
					</validation-provider>
					
					<validation-provider
						vid="chain_name"
						name="Chain"
						:rules="{ required: false, max: 250 }"
						v-slot="validationContext"
					>
						<b-form-group label="Chain" label-for="chain_name" label-cols-lg="4">
							<b-form-input
								name="chain_name"
								type="text"
								v-model="entity.chain_name"
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

				<!-- <b-card-body> -->
				<!--	<h6 class="text-muted">Optional</h6>  -->
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
						<!-- <b-collapse id="collapseAddress" role="tabpanel">
							<b-card-body>
								<b-form-group label="Address" label-for="street_address_1" label-cols-lg="4">
									<validation-provider
										vid="street_address_1"
										name="Street Address"
										:rules="{ required: false, max: 50 }"
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
									
									<validation-provider
										vid="street_address_2"
										name="Street Address (Continued)"
										:rules="{ required: false, max: 50 }"
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
									</validation-provider>
								</b-form-group>

								<validation-provider
									vid="city"
									name="City"
									:rules="{ required: false, max: 50 }"
									v-slot="validationContext"
								>
									<b-form-group label="City" label-for="city" label-cols-lg="4">
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
									<b-form-group label="State" label-for="state" label-cols-lg="4">
										<b-form-select
											name="state"
											v-model="entity.state"
											:options="states"
											value-field="abbreviation"
											text-field="name"
											:state="getValidationState(validationContext)"
											:disabled=true
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
									<b-form-group label="Zip" label-for="zip" label-cols-lg="4">
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
						</b-collapse> -->

						<!-- <b-card-header header-tag="header" role="tab" class="p-0">
							<b-button
								block
								v-b-toggle.collapseContact
								variant="light"
								role="tab"
								class="text-left px-4 py-3 m-0"
								>Contact</b-button
							>
						</b-card-header> -->
						<!-- <b-collapse id="collapseContact" role="tabpanel">
							<b-card-body>
								<validation-provider
									vid="phone"
									name="Phone"
									:rules="{ required: false }"
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
									vid="fax"
									name="Fax"
									:rules="{ required: false }"
									v-slot="validationContext"
								>
									<b-form-group label="Fax" label-for="fax" label-cols-lg="4">
										<b-form-input
											name="fax"
											type="text"
											v-model="entity.fax"
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
									:rules="{ required: false }"
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
						</b-collapse> -->

						<!-- <b-card-header header-tag="header" role="tab" class="p-0">
							<b-button
								block
								v-b-toggle.collapseContract
								variant="light"
								role="tab"
								class="text-left px-4 py-3 m-0"
								>Contract</b-button
							>
						</b-card-header> -->
						<!-- <b-collapse id="collapseContract" role="tabpanel">
							<b-card-body>
								<validation-provider
									vid="client_owned"
									name="Owned"
									:rules="{ required: false }"
									v-slot="validationContext"
								>
									<b-form-group
										label="Owned"
										label-for="client_owned"
										label-cols-lg="4"
										description="Your organization owns this facility."
									>
										<b-form-checkbox
											name="client_owned"
											v-model="entity.client_owned"
											:disabled="saving"
											:state="getValidationState(validationContext)"
										>
											Owned
										</b-form-checkbox>
										<b-form-invalid-feedback
											v-for="error in validationContext.errors"
											:key="error"
											v-text="error"
										/>
									</b-form-group>
								</validation-provider>

								<validation-provider
									vid="has_contract"
									name="Contract"
									:rules="{ required: false }"
									v-slot="validationContext"
								>
									<b-form-group
										label="Contract"
										label-for="has_contract"
										label-cols-lg="4"
										description="This facility is contracted."
									>
										<b-form-checkbox
											name="has_contract"
											v-model="entity.has_contract"
											:disabled="saving"
											:state="getValidationState(validationContext)"
										>
											Has Contract
										</b-form-checkbox>
										<b-form-invalid-feedback
											v-for="error in validationContext.errors"
											:key="error"
											v-text="error"
										/>
									</b-form-group>
								</validation-provider>

								<validation-provider
									vid="contract_start_date"
									name="Contract Start Date"
									:rules="{ required: false }"
									v-slot="validationContext"
								>
									<b-form-group label="Start Date" label-for="contract_start_date" label-cols-lg="4">
										<b-form-input
											type="date"
											v-model="entity.contract_start_date"
											name="contract_start_date"
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

								<validation-provider
									vid="contract_end_date"
									name="Contract End Date"
									:rules="{ required: false }"
									v-slot="validationContext"
								>
									<b-form-group label="End Date" label-for="contract_end_date" label-cols-lg="4">
										<b-form-input
											type="date"
											v-model="entity.contract_end_date"
											name="contract_end_date"
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

								<validation-provider
									vid="indemnification_days"
									name="Indemnification Days"
									:rules="{ required: false, min: 0, max: 365 }"
									v-slot="validationContext"
								>
									<b-form-group
										label="Indemnification Days"
										label-for="indemnification_days"
										label-cols-lg="4"
										description="Days exceeded for Indemnification"
									>
										<b-form-input
											name="indemnification_days"
											type="number"
											step="1"
											min="0"
											max="365"
											default="30"
											v-model="entity.indemnification_days"
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

								<validation-provider
									vid="max_return_work_days"
									name="Max Return Days"
									:rules="{ required: false, min: 0, max: 365 }"
									v-slot="validationContext"
								>
									<b-form-group
										label="Max Return Days"
										label-for="max_return_work_days"
										label-cols-lg="4"
										description="Maximum days to return work to facility"
									>
										<b-form-input
											name="max_return_work_days"
											type="number"
											step="1"
											min="0"
											max="365"
											default="30"
											v-model="entity.max_return_work_days"
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
						</b-collapse> -->

						<!-- <b-card-header header-tag="header" role="tab" class="p-0">
							<b-button
								block
								v-b-toggle.collapseServices
								variant="light"
								role="tab"
								class="text-left px-4 py-3 m-0"
								>Services</b-button
							>
						</b-card-header> -->
						<!-- <b-collapse id="collapseServices" role="tabpanel">
							<b-card-body>
								<b-form-group label="Assigned Services" label-for="services_ids" label-cols-lg="4">
									<loading-indicator v-if="loadingServices && services.length <= 0" />
									<b-form-checkbox-group
										v-else-if="services.length > 0"
										stacked
										name="services_ids"
										v-model="entity.services._ids"
										:options="services"
										:disabled="saving || loadingServices"
										value-field="id"
										text-field="name"
									/>
									<empty-result v-else>
										No services added
										<template #content> Create services to assign to this facility. </template>
									</empty-result>
								</b-form-group>
							</b-card-body>
						</b-collapse> -->
					<!-- </b-card>
				</b-card-body> -->

				<b-card-body>
					<!-- <h6 class="text-muted">Optional</h6> -->
					<b-card no-body>
						<b-card-header header-tag="header" role="tab" class="p-0">
							<b-button
								block
								v-b-toggle.collapseAdditional
								variant="light"
								role="tab"
								class="text-left px-4 py-3 m-0"
								>Details</b-button
							>
						</b-card-header>
						<b-collapse id="collapseAdditional" role="tabpanel">
							<b-card-body>
								<!-- <validation-provider
									vid="chain_name"
									name="Chain"
									:rules="{ required: false, max: 250 }"
									v-slot="validationContext"
								>
									<b-form-group label="Chain" label-for="chain_name" label-cols-lg="4">
										<b-form-input
											name="chain_name"
											type="text"
											v-model="entity.chain_name"
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
									vid="division"
									name="Division"
									:rules="{ required: false, max: 60 }"
									v-slot="validationContext"
								>
									<b-form-group label="Division" label-for="division" label-cols-lg="4">
										<b-form-input
											name="division"
											type="text"
											v-model="entity.division"
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
									vid="region"
									name="Region"
									:rules="{ required: false, max: 60 }"
									v-slot="validationContext"
								>
									<b-form-group label="Region" label-for="region" label-cols-lg="4">
										<b-form-input
											name="region"
											type="text"
											v-model="entity.region"
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
									vid="territory"
									name="Territory"
									:rules="{ required: false, max: 60 }"
									v-slot="validationContext"
								>
									<b-form-group label="Territory" label-for="territory" label-cols-lg="4">
										<b-form-input
											name="territory"
											type="text"
											v-model="entity.territory"
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
									vid="area_name"
									name="Area"
									:rules="{ required: false, max: 60 }"
									v-slot="validationContext"
								>
									<b-form-group label="Area" label-for="area_name" label-cols-lg="4">
										<b-form-input
											name="area_name"
											type="text"
											v-model="entity.area_name"
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
									vid="ou_number"
									name="OU Number"
									:rules="{ required: false, max: 60 }"
									v-slot="validationContext"
								>
									<b-form-group label="OU Number" label-for="ou_number" label-cols-lg="4">
										<b-form-input
											name="ou_number"
											type="text"
											v-model="entity.ou_number"
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
									vid="rvp_name"
									name="RVP"
									:rules="{ required: false, max: 60 }"
									v-slot="validationContext"
								>
									<b-form-group label="RVP" label-for="rvp_name" label-cols-lg="4">
										<b-form-input
											name="rvp_name"
											type="text"
											v-model="entity.rvp_name"
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
							</b-card-body>
						</b-collapse>
						<b-card-header header-tag="header" role="tab" class="p-0">
							<b-button
								block
								v-b-toggle.collapseContact
								variant="light"
								role="tab"
								class="text-left px-4 py-3 m-0"
								>Contacts</b-button
							>
						</b-card-header>
						<b-collapse id="collapseContact" role="tabpanel">
							<b-card-body>
								<validation-provider
									vid="phone"
									name="Phone"
									:rules="{ required: false }"
									v-slot="validationContext"
								>
									<b-form-group label="Main Phone" label-for="phone" label-cols-lg="4">
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
									vid="fax"
									name="Fax"
									:rules="{ required: false }"
									v-slot="validationContext"
								>
									<b-form-group label="Main Fax" label-for="fax" label-cols-lg="4">
										<b-form-input
											name="fax"
											type="text"
											v-model="entity.fax"
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
									:rules="{ required: false }"
									v-slot="validationContext"
								>
									<b-form-group label="Main Email" label-for="email" label-cols-lg="4">
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
								<validation-provider
									vid="website"
									name="Website"
									:rules="{ required: false }"
									v-slot="validationContext"
								>
									<b-form-group label="Main Website" label-for="website" label-cols-lg="4">
										<b-form-input
											name="website"
											type="url"
											v-model="entity.website"
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

							
							 <b-input-group-append>
                                     <b-button variant="primary" class="mb-1"  v-b-toggle.collapseOpenForm>
				                 	<font-awesome-icon icon="plus" fixed-width />
				                 	<span>Add Contact</span>
			                            	</b-button>
                                    </b-input-group-append>
               
					
						<b-collapse id="collapseOpenForm">
					 <b-card body>
					  <validation-provider
									vid="f_name"
									name="First_Name"
									:rules="{ required: false }"
									v-slot="validationContext"
								>
									<b-form-group label="First Name" label-for="f_name" label-cols-lg="4">
										<b-form-input
											name="f_name"
											type="text"
											v-model="entity.f_name"
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
									vid="l_name"
									name="Last_Name"
									:rules="{ required: false }"
									v-slot="validationContext"
								>
									<b-form-group label="Last Name" label-for="l_name" label-cols-lg="4">
										<b-form-input
											name="l_name"
											type="text"
											v-model="entity.l_name"
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
								vid="title_id"
								name="Main_Title"
								:rules="{ required: false, numeric: true }"
								v-slot="validationContext"
							>
								<b-form-group
									label="Title"
									label-for="title_id"
									label-cols-lg="4"
								>
									<b-input-group>
										<b-form-select
											name="title_id"
											v-model="entity.title_id"
											:options="titlename"
											:disabled="saving || loadingtitlename"
											:state="getValidationState(validationContext)"
											value-field="id"
											text-field="full_name"
											
										>
											<!-- <template #first>
												<option disabled v-if="!hastitlename" :value="null">
												   data not fetch from 
												   base
												</option>
											</template> -->
										</b-form-select>
										<template #append>
											<b-button
												variant="primary"
												@click="openCustomTitle"
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
							<template>
  <div>
    <!-- Add BootstrapVue grid classes to create a row -->
    <b-row>
      <!-- Column for the dropdown and input field -->
      <b-col md="4">
        <validation-provider vid="phone" name="Phone" :rules="{ required: false }" v-slot="validationContext">
          <b-form-group label="Contact Type" label-for="type">
            <!-- Wrapper for select and input fields -->
            <div class="d-flex align-items-end" v-for="(field, index) in inputFields" :key="index">
              <!-- Dropdown (select) field -->
              <label :for="'contacType' + index"></label>
              <select v-model="field.selectedContactType" :name="'contactType' + index" class="form-control mb-3">
                <option value="phone">Phone</option>
                <option value="landline">Landline</option>
              </select>
			  </div>
		  </b-form-group>
		  </validation-provider>
			</b-col>
			<b-col md="8">
        <validation-provider vid="phone" name="Phone" :rules="{ required: false }" v-slot="validationContext">
          <b-form-group label="Contact Number" label-for="phone">
            <b-input-group v-for="(inputField, index) in inputFields" :key="index" class="mb-3">
              <b-form-input
                :name="'phone' + index"
                type="text"
                v-model="inputField.phone"
                v-mask="'(###) ###-####'"
                :state="getValidationState(validationContext)"
                :disabled="saving"
              ></b-form-input>

              <!-- Button inside the input group to remove the corresponding field -->
              <b-input-group-append>
                <b-button @click="removeInputField(index)" v-if="inputFields.length > 1">
                  <font-awesome-icon icon="times" fixed-width />
                </b-button>
				 <!-- Button to add a new input field -->
				<b-button variant="primary" @click="addInputField">
            		<font-awesome-icon icon="plus" fixed-width />
          		</b-button>
              </b-input-group-append>
            </b-input-group>

            <b-form-invalid-feedback
              v-for="error in validationContext.errors"
              :key="error"
              v-text="error"
            ></b-form-invalid-feedback>
          </b-form-group>
         
        </validation-provider>
      </b-col>
    </b-row>
  </div>
</template>
               								

								<validation-provider
									vid="email"
									name="Email"
									:rules="{ required: false }"
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
					</b-card>
				</b-collapse>
							</b-card-body>
						</b-collapse>
			  
  <b-modal id="customTitle" title="Add Custom Title " @ok="addCustomTitleName">
    <b-form-input
      id="newCustomName"
      name="newCustomeTitleName"
      type="text"
      v-model="newAuditType"
      placeholder="Add custom Title"
      :disabled="saving"
    />
  </b-modal>
						<b-card-header header-tag="header" role="tab" class="p-0">
							<b-button
								block
								v-b-toggle.collapseContract
								variant="light"
								role="tab"
								class="text-left px-4 py-3 m-0"
								>Contract</b-button
							>
						</b-card-header>
						<b-collapse id="collapseContract" role="tabpanel">
							<b-card-body>
								<validation-provider
									vid="client_owned"
									name="Owned"
									:rules="{ required: false }"
									v-slot="validationContext"
								>
									<b-form-group
										label="Owned"
										label-for="client_owned"
										label-cols-lg="4"
										description="Your organization owns this facility."
									>
										<b-form-checkbox
											name="client_owned"
											v-model="entity.client_owned"
											:disabled="saving"
											:state="getValidationState(validationContext)"
										>
											Owned
										</b-form-checkbox>
										<b-form-invalid-feedback
											v-for="error in validationContext.errors"
											:key="error"
											v-text="error"
										/>
									</b-form-group>
								</validation-provider>

								<validation-provider
									vid="has_contract"
									name="Contract"
									:rules="{ required: false }"
									v-slot="validationContext"
								>
									<b-form-group
										label="Contract"
										label-for="has_contract"
										label-cols-lg="4"
										description="This facility is contracted."
									>
										<b-form-checkbox
											name="has_contract"
											v-model="entity.has_contract"
											:disabled="saving"
											:state="getValidationState(validationContext)"
										>
											Has Contract
										</b-form-checkbox>
										<b-form-invalid-feedback
											v-for="error in validationContext.errors"
											:key="error"
											v-text="error"
										/>
									</b-form-group>
								</validation-provider>

								<validation-provider
									vid="contract_start_date"
									name="Contract Start Date"
									:rules="{ required: false }"
									v-slot="validationContext"
								>
									<b-form-group label="Start Date" label-for="contract_start_date" label-cols-lg="4">
										<b-form-input
											type="date"
											v-model="entity.contract_start_date"
											name="contract_start_date"
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

								<validation-provider
									vid="contract_end_date"
									name="Contract End Date"
									:rules="{ required: false }"
									v-slot="validationContext"
								>
									<b-form-group label="End Date" label-for="contract_end_date" label-cols-lg="4">
										<b-form-input
											type="date"
											v-model="entity.contract_end_date"
											name="contract_end_date"
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

								<validation-provider
									vid="indemnification_days"
									name="Indemnification Days"
									:rules="{ required: false, min: 0, max: 365 }"
									v-slot="validationContext"
								>
									<b-form-group
										label="Indemnification Days"
										label-for="indemnification_days"
										label-cols-lg="4"
										description="Days exceeded for Indemnification"
									>
										<b-form-input
											name="indemnification_days"
											type="number"
											step="1"
											min="0"
											max="365"
											default="30"
											v-model="entity.indemnification_days"
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

								<validation-provider
									vid="max_return_work_days"
									name="Max Return Days"
									:rules="{ required: false, min: 0, max: 365 }"
									v-slot="validationContext"
								>
									<b-form-group
										label="Max Return Days"
										label-for="max_return_work_days"
										label-cols-lg="4"
										description="Maximum days to return work to facility"
									>
										<b-form-input
											name="max_return_work_days"
											type="number"
											step="1"
											min="0"
											max="365"
											default="30"
											v-model="entity.max_return_work_days"
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
						</b-collapse>

						<b-card-header header-tag="header" role="tab" class="p-0">
							<b-button
								block
								v-b-toggle.collapseServices
								variant="light"
								role="tab"
								class="text-left px-4 py-3 m-0"
								>Services</b-button
							>
						</b-card-header>
						<b-collapse id="collapseServices" role="tabpanel">
							<b-card-body>
								<!-- <b-form-group label="Assigned Services" label-for="services_ids" label-cols-lg="4">
									<loading-indicator v-if="loadingServices && services.length <= 0" />
									<b-form-checkbox-group
										v-else-if="services.length > 0"
										stacked
										name="services_ids"
										v-model="entity.services._ids"
										:options="services"
										:disabled="saving || loadingServices"
										value-field="id"
										text-field="name"
									/>
									<empty-result v-else>
										No services added
										<template #content> Create services to assign to this facility. </template>
									</empty-result>
								</b-form-group> -->

								<!-- <b-form-group
										label="Assigned Services"
										label-for="entity.services._ids"
										label-cols-lg="4"
										
									>
										<services-search-multi
											name="denial_reasons"
											v-model="currentDenialReasons"
											@add="addingDenialReason = true"
											:disabled="saving"
										/>
									</b-form-group> -->

									<b-form-group label="Assigned Services" label-for="services_ids" label-cols-lg="4">
									<loading-indicator v-if="loadingServices && services.length <= 0" />
									<b-input-group>
										<b-form-input type="text" name="serviceSearch" v-model="searchQuery"
											:disabled="saving || loadingServices || formDisabled"
											placeholder="Search for a Service..." @input="filterServices" />
										<b-input-group-append>
											<b-input-group-text>
												<font-awesome-icon icon="search" fixed-width />
											</b-input-group-text>
										</b-input-group-append>
									</b-input-group>
									<div>
										<!-- <b-list-group v-if="selectedServices.length > 0">
											<b-list-group-item v-for="service in selectedServices" :key="service.id">
												{{ service.name }}
												<b-btn @click="deselectService(service)" size="sm" variant="danger">Remove</b-btn>
											</b-list-group-item>
										</b-list-group> -->
										<b-list-group v-if="selectedServices.length > 0">
											<b-list-group-item v-for="service in selectedServices" :key="service.id">
												<div class="d-flex justify-content-between align-items-center">
													<div>{{ service.name }}</div>
													<b-btn @click="deselectService(service)" size="sm">
														<!-- <b-icon icon="x"></b-icon> -->
														<font-awesome-icon icon="fa-solid fa-xmark" />
													</b-btn>
												</div>
											</b-list-group-item>
										</b-list-group>

									</div>
									<div v-if="filteredServices.length > 0">
										<b-list-group>
											<b-list-group-item v-for="service in filteredServices" :key="service.id"
												@click="selectService(service)">
												{{ service.name }}
											</b-list-group-item>
										</b-list-group>
									</div>
								</b-form-group>
								

								<!-- Search and Add Services Section -->
								<!-- <b-form-group label="Assigned Services" label-for="services_ids" label-cols-lg="4"> -->
								<!-- Custom search input for services -->
								<!-- <loading-indicator v-if="loadingServices && availableServices.length <= 0" /> -->
								<!-- <b-input-group>
									<b-form-input
									
									v-model="searchQuery"
									
									:disabled="saving || loadingServices"
									value-field="id"
									text-field="name"
									:placeholder="loadingServices ? 'Loading services...' : 'Search services...'"
									></b-form-input>
									<b-input-group-append>
									<b-button @click="searchServices">Search</b-button>
									</b-input-group-append>
								</b-input-group> -->

								 <!-- List of matching services -->
								 <!-- <b-form-select
									v-model="entity.services._ids"
									:options="matchingServices"
									:disabled="saving || loadingServices"
									value-field="id"
									text-field="name"
									multiple
								></b-form-select> -->


								<!-- Button to add selected services -->
								<!-- <b-button @click="addSelectedServices">Add Selected Services</b-button> -->
							<!-- </b-form-group> -->
							</b-card-body>
						</b-collapse>
						<b-card-header v-if="fromNPI" header-tag="header" role="tab" class="p-0">
						<b-button block v-b-toggle.collapseNpiInformation variant="light" role="tab"
							class="text-left px-4 py-3 m-0">
							NPI Information
						</b-button>
					</b-card-header>
					<b-collapse id="collapseNpiInformation" role="tabpanel">
						<b-card-body>
							<div class="d-flex">
								<div class="flex-grow-1 pr-3">
									<!-- <h4 class="card-title">{{ entity.name }}</h4>
									<h5 class="card-subtitle mb-4">{{ ` ${entity.state}, ${entity.city}` }}</h5> -->
									<!-- <hr class="my-2"> -->
									<div class="label-value-row">
										<div class="label-text">NPI Number:</div>
										<div class="text">{{ entity.npi_number }}</div>
									</div>
									<div class="label-value-row">
										<div class="label-text">Doing Business As:</div>
										<div class="text">{{ entity.othername }}</div>
									</div>
									<hr class="my-2">
									<div class="label-value-row">
										<div class="label-text">Enumeration Type:</div>
										<div class="text">{{ ` ${entity.enumeration_type} Organization` }}</div>
									</div>
									
									<div class="label-value-row">
										<div class="label-text">Status</div>
										<div class="text">{{ entity.active ? 'Active' : 'Inactive' }}</div>
									</div>
									<div class="label-value-row">
										<div class="label-text">Organization Subpart ?	</div>
										<div class="text">{{ entity.organizational_subpart }}</div>
									</div>

									<hr class="my-2">

									<!-- <div class="d-flex">
										<div class="flex-grow-1 pr-3">
											<div class="label-value-row">
												<div class="label-text">Location Address:</div>
												<div class="text-primary">{{ `${entity.street_address_1}, ${entity.street_address_2}, ${entity.city}, ${entity.state}, ${entity.zip}` }}</div>
											</div> -->
											<div class="d-flex">
												<div class="flex-grow-1 pr-3">
												<div class="label-value-row">
													<div class="label-text">Location Address:</div>
													<div class="text">{{ entity.address_2 }}</div>
											</div>
											<div class="label-value-row">
												<div class="label-text">Phone Number:</div>
												<div class="text">{{ entity.locationPhoneNumber }}</div>
											</div>
											<hr class="my-1">
											<div class="label-value-row">
												<div class="label-text">Mailing Address:</div>
												<div class="text">{{ `${entity.address_1}, ${entity.street_address_2}, ${entity.city}, ${entity.state}, ${entity.zip}` }}</div>
											</div>
											<!-- <div class="label-value-row">
												<div class="label-text">Organization Subpart ?</div>
												<div class="text-primary">{{ entity.organizational_subpart }}</div>
											</div> -->
											<div class="label-value-row">
												<div class="label-text">Phone Number:</div>
												<div class="text">{{ entity.mailingPhoneNumber }}</div>
											</div>
										</div>
									</div>


									<hr class="my-2">

									<div class="d-flex">
										<div class="flex-grow-1 pr-3">
											<div class="label-value-row">
												<div class="label-text">Primary Taxonomy:</div>
												<div class="text">{{ entity.primary_taxonomy }}</div>
											</div>
											<hr class="my-2">
											<div class="label-value-row">
												<div class="label-text">Additional Taxonomies:</div>
												<div class="text">{{ entity.additionalTaxonomies }}</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</b-card-body>
					</b-collapse>
					</b-card>
				</b-card-body>
				

				<!-- <b-card v-if="fromNPI" no-body> -->
					<!-- <b-card-header v-if="fromNPI" header-tag="header" role="tab" class="p-0">
						<b-button block v-b-toggle.collapseNpiInformation variant="light" role="tab"
							class="text-left px-4 py-3 m-0">
							<h6 class="mb-0">NPI Data</h6>
						</b-button>
					</b-card-header>
					<b-collapse id="collapseNpiInformation" role="tabpanel">
						<b-card-body>
							<div class="d-flex">
								<div class="flex-grow-1 pr-3">
									<div class="label-value-row">
										<div class="label-text">Other Name:</div>
										<div class="text-primary">{{ entity.othername }}</div>
									</div>
									<div class="label-value-row">
										<div class="label-text">Enumeration Type:</div>
										<div class="text-primary">{{ entity.enumeration_type }}</div>
									</div>
									<div class="label-value-row">
										<div class="label-text">Gender:</div>
										<div class="text-primary">{{ entity.gender }}</div>
									</div>
									<div class="label-value-row">
										<div class="label-text">Sole Proprietor ?</div>
										<div class="text-primary">{{ entity.proprietor }}</div>
									</div>


									<hr class="my-2">

									<div class="d-flex">
										<div class="flex-grow-1 pr-3">
											<div class="label-value-row">
												<div class="label-text">Location Address:</div>
												<div class="text-primary">{{ entity.address_2 }}</div>
											</div>
											<div class="label-value-row">
												<div class="label-text">Phone Number:</div>
												<div class="text-primary">{{ entity.locationPhoneNumber }}</div>
											</div>
											<hr class="my-1">
											<div class="label-value-row">
												<div class="label-text">Mailing Address:</div>
												<div class="text-primary">{{ entity.address_1 }}</div>
											</div>
											<div class="label-value-row">
												<div class="label-text">Phone Number:</div>
												<div class="text-primary">{{ entity.mailingPhoneNumber }}</div>
											</div>
										</div>
									</div>


									<hr class="my-2">

									<div class="d-flex">
										<div class="flex-grow-1 pr-3">
											<div class="label-value-row">
												<div class="label-text">Primary Taxonomy:</div>
												<div class="text-primary">{{ entity.primaryTaxonomy }}</div>
											</div>
											<hr class="my-2">
											<div class="label-value-row">
												<div class="label-text">Additional Taxonomies:</div>
												<div class="text-primary">{{ entity.additionalTaxonomies }}</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</b-card-body>
					</b-collapse> -->
				<!-- </b-card> -->

				<b-card-footer>
					<b-row>
						<b-col cols="12" md="6" xl="4" class="mb-4 mb-md-0">
							<b-button block variant="light" type="button" @click.stop="cancel">
								<span>Cancel</span>
							</b-button>
						</b-col>
						<b-col cols="12" md="6" offset-xl="4" xl="4" class="mb-2 mb-md-0">
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
import NPIOrganization from "@/clients/components/NPI/NPIOrganization.vue";

export default {
	name: "FacilityForm",
	components: {
		NPIOrganization,
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
			npiLookingUp: false,
			npiSearched: false,
			npiResults: [],
			searchQuery: '',            // The search query entered by the user
        	// availableServices: [],               // The list of all available services
        	// matchingServices: [],       // The list of services matching the search query
        	filteredServices: [], 
			selectedServices: [],		 // The list of services selected by the user
			services: [],
			entity: {
				id: this.id,
				name: "",
				display_name:null,
				facility_type_id: null,
				active: true,
				phone: null,
				fax: null,
				email: null,
				// street_address_1: null,
				// street_address_2: null,
				city: null,
				state: null,
				zip: null,
				npi_number: null,
				npi_manual: null,
				primary_taxonomy: null,
				locationPhoneNumber: null,
				mailingPhoneNumber: null,
				additionalTaxonomies: null,
				client_owned: true,
				chain_name: null,
				area_name: null,
				ou_number: null,
				territory: null,
				// rvp_name: null,
				has_contract: false,
				contract_start_date: null,
				contract_end_date: null,
				indemnification_days: null,
				max_return_work_days: null,
				address_1: null,
				address_2: null,
				// taxonomy_code: null,
				// taxonomy_desc: null,
				// taxonomy_group: null,
				// taxonomy_license:  null,
				// taxonomy_state: null,
				othername: null,
				enumeration_type: null,
				organizational_subpart:null,
				services: {
					_ids: [],
				},
			},
		};
	},
	computed: 
	{
		concatenatedStreetAddress() {
        return `${this.entity.street_address_1 || ''} ${this.entity.street_address_2 || ''}`.trim();
    	},
		fromNPI() {
				if (this.entity.id !== null) {
					return true;
				}
			},

		...mapGetters({
			states: "states/states",
			facilityTypes: "facilityTypes/all",
			loadingFacilityTypes: "facilityTypes/loadingAll",
			services: "services/all",
			loadingServices: "services/loadingAll",
		}),
	},
	mounted() {
		this.getServices();

		if (this.id) {
			this.refresh();
		} else {
			this.loading = false;
		}
	},
	methods: {
		// Method to search and filter services based on the search query
			// searchServices() {
			// 	if (this.searchQuery === '') {
			// 		// Show all services when the search query is empty
			// 		this.matchingServices = this.services;
			// 	} else {
			// 		// Filter services based on the search query
			// 		this.matchingServices = this.services.filter(service => {
			// 			return service.name.toLowerCase().includes(this.searchQuery.toLowerCase());
			// 		});
   			// 	}
			// },

		// Method to add the selected services to the entity
		// addSelectedServices() {
		// 	// Add the selected services to entity.services._ids
		// 	this.entity.services._ids = this.selectedServices.map(service => service.id);

		// 	// Clear the search and selected services
		// 	this.searchQuery = '';
		// 	this.selectedServices = [];
		// 	},
		
		// filterServices() {
		// 	// Implement the logic to filter Services based on the search term
		// 	const searchTerm = this.searchQuery.toLowerCase();
		// 	this.filteredServices = this.services.filter((service) =>
		// 		service.name.toLowerCase().includes(searchTerm)
		// 	);
		// },
		filterServices() {
			// Implement the logic to filter services based on the search term
			const searchTerm = this.searchQuery ? this.searchQuery.toLowerCase() : '';
			this.filteredServices = this.services.filter((service) =>
				service.name.toLowerCase().includes(searchTerm)
			);
			},

		selectService(selectedService) {
			console.log('Selected Service:', selectedService);
			// Check if the service ID is not already selected
			if (!this.entity.services._ids.includes(selectedService.id)) {
				// Push the selected service ID to the array
				this.entity.services._ids.push(selectedService.id);
			}

			// Clear the search term and filtered services
			this.searchQuery = '';
			this.filteredServices = [];
			},



		// selectService(selectedService) {
		// 	console.log('Selected Service:', selectedService);
		// 	// Check if the facility is not already selected
		// 	if (!this.selectedServices.some(service => service.id === selectedService.id)) {
		// 		// Push the selected facility to the array
		// 	this.selectedServices.push(selectedService);
		// 	// console.log('Selected Services array:', this.selectedServices);
		// 	this.entity.services._ids.push(selectedService);
		// 	// console.log('check:', this.entity.services._ids);

		// 	}

		// 	// Clear the search term and filtered facilities
		// 	this.searchQuery = '';
		// 	this.filteredServices = [];
		// },
		deselectService(selectedService) {
			// Remove the selected facility from the array
			this.selectedServices = this.selectedServices.filter(service => service.id !== selectedService.id);
		},

		getValidationState,
		async getServices() {
			await this.$store.dispatch("services/getAll");
			 this.availableServices = this.services; // Initialize availableServices with all services
		},
		cancel() {
			this.$emit("cancel");
		},
		async npiLookup() {
			try {
				this.npiLookingUp = true;

				const response = await this.$store.dispatch("facilities/npiLookup", {
					name: this.entity.name,
				});

				this.npiResults = response;
				this.npiSearched = true;
			} finally {
				this.npiLookingUp = false;
			}
		},
		async refresh() {
			try {
				this.loading = true;

				const response = await this.$store.dispatch("facilities/get", {
					id: this.id,
				});

				this.entity = response;
				this.entity.services = {
					_ids: response.services.map((service) => service.id),
				};
				this.$emit("loaded", response);
			} catch (e) {
				this.$store.dispatch("apiError", {
					error: e,
					message: "Error getting facility details",
				});
			} finally {
				this.loading = false;
				this.initialLoaded = true;
			}
		},
		// async save() {
		// 	try {
		// 		this.saving = true;

		// 		// const response = await save({
		// 		// ...this.entity,
		// 		// services: {
		// 		// 	_ids: this.selectedServices.map(service => service.id),
		// 		// },
		// 		// });
		// 		console.log("services=", services)
				
		// 		// const response = await this.$store.dispatch("facilities/save", this.entity);
		// 		const response = await save({
		// 			...this.entity,
		// 			services: {
		// 				_ids: this.services_ids,
		// 			},
		// 		});
		// 		console.log("response=",response);

		// 		// this.entity.services = this.selectedServices.map(service => service.id);
		// 		// this.entity.services = this.selectedServices.map(service => service.id);

		// 		this.$emit("saved", response);
		// 		this.$emit("update:id", response.id);

		// 		this.$store.dispatch("facilities/getAll");
		// 		this.$store.dispatch("facilities/getActive");
		// 	} catch (e) {
		// 		if (e.response.data.errors) {
		// 			this.$refs.observer.setErrors(formatErrors(e.response.data.errors));
		// 		}

		// 		this.$store.dispatch("apiError", {
		// 			error: e,
		// 			title: "Save Failed",
		// 			message: "Error saving facility details. Please check for errors.",
		// 			variant: "warning",
		// 		});
		// 	} finally {
		// 		this.saving = false;
		// 	}
		// },
		// async save() {
		// 	try {
		// 		this.saving = true;
		// 		// console.log("Before Response=", response);
		// 		// const response = await save({
		// 		// 	...this.entity,
		// 		// 	services: {
		// 		// 		_ids: this.services_ids,
		// 		// 	},
		// 		// });
		// // 		console.log("response=",response);

		// 		const response = await this.$store.dispatch("facilities/save",{ ...this.entity, 
		// 		services: {
		// 				_ids: this.services_ids,
		// 			}},);
		// 		console.log("Response=", response);
		// 		this.$emit("saved", response);
		// 		this.$emit("update:id", response.id);

		// 		this.$store.dispatch("facilities/getAll");
		// 		this.$store.dispatch("facilities/getActive");
		// 	} catch (e) {
		// 		if (e.response.data.errors) {
		// 			this.$refs.observer.setErrors(formatErrors(e.response.data.errors));
		// 		}

		// 		this.$store.dispatch("apiError", {
		// 			error: e,
		// 			title: "Save Failed",
		// 			message: "Error saving facility details. Please check for errors.",
		// 			variant: "warning",
		// 		});
		// 	} finally {
		// 		this.saving = false;
		// 	}
		// },
		async save() {
			try {
				this.saving = true;
				const response = await this.$store.dispatch("facilities/save", this.entity);

				this.$emit("saved", response);
				this.$emit("update:id", response.id);

				this.$store.dispatch("facilities/getAll");
				this.$store.dispatch("facilities/getActive");
			} catch (e) {
				if (e.response.data.errors) {
					this.$refs.observer.setErrors(formatErrors(e.response.data.errors));
				}

				this.$store.dispatch("apiError", {
					error: e,
					title: "Save Failed",
					message: "Error saving facility details. Please check for errors.",
					variant: "warning",
				});
			} finally {
				this.saving = false;
			}
		},
		selectedNpiResult(result) {
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

			console.log("Selected NPI result", result);

			this.entity.name = result.name;
			this.entity.npi_number = result.number ?? "";
			this.entity.npi_manual = false;

			const locationAddress = result.addresses.find((address) => address.address_purpose == "LOCATION");
			if (locationAddress) {
				// Contact
				this.entity.phone = locationAddress.telephone_number ?? "";
				this.entity.fax = locationAddress.fax_number ?? "";
				// Address
				this.entity.street_address_1 = locationAddress.address_1 ?? "";
				this.entity.street_address_2 = locationAddress.address_2 ?? "";
				this.entity.city = locationAddress.city ?? "";
				this.entity.state = locationAddress.state ?? "";
				this.entity.zip = locationAddress.postal_code ?? "";
			} else {
				console.warn("Unable to parse location address", locationAddress);
			}

			const primaryTaxonomy = result.taxonomies.find((taxonomy) => taxonomy.primary == true);
			if (primaryTaxonomy) {
				this.entity.primary_taxonomy = primaryTaxonomy.code ?? "";
			} else {
				console.warn("Unable to parse primary taxonomy", primaryTaxonomy);
			}

			this.npiResults = [];
			this.npiSearched = false;
		},
	},
};
</script>
<style scoped>
.compact-card {
	margin-bottom: 0;
}

.label-value-row {
	display: flex;
	justify-content: flex-start;
	align-items: center;
	margin-bottom: 0.2rem;
}

.label-text {
	font-weight: bold;
	display: inline-block;
	width: 150px;
	margin-right: 10px;
}

.text {
	color: #101111d8;
}
</style>


