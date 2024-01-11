<template>
	<loading-indicator v-if="loading" class="my-5" />
	<validation-observer v-else v-bind="$attrs" ref="observer" v-slot="{ invalid }">
		<b-form @submit.prevent="save">
			<b-card no-body>
				<slot name="header"></slot>

				<b-card-body>
					<validation-provider
						vid="name"
						name="Name"
						:rules="{ required: true, min: 2, max: 50 }"
						v-slot="validationContext"
					>
						<b-form-group label="Name" label-for="facility_name" label-cols-lg="4">
							<b-input-group>
								<b-form-input
									autofocus
									name="facility_name"
									size="lg"
									type="text"
									v-model="entity.name"
									:state="getValidationState(validationContext)"
									:disabled="saving"
									required
									placeholder="Required"
								/>
								<b-form-invalid-feedback
									v-for="error in validationContext.errors"
									:key="error"
									v-text="error"
								/>
							</b-input-group>
						</b-form-group>
					</validation-provider>

					<validation-provider
						vid="disp_name"
						name="display_name"
						:rules="{ required: false, max: 60 }"
						v-slot="validationContext"
					>
						<b-form-group label="Display Name" label-for="disp_name" label-cols-lg="4">
							<b-form-input
								name="disp_name"
								type="text"
								v-model="entity.display_name"
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

					<b-form-group label="Location Address" label-for="street_address_1" label-cols-lg="4">
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
						<!--<validation-provider
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
						</validation-provider>-->
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

				<b-card-body>

					<!-- <h6 class="text-muted">Optional</h6> -->
					<!-- <b-card no-body> -->

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
								</validation-provider>
							</b-card-body>
						</b-collapse>
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
							</b-card-body>
						</b-collapse>
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
								  <b-button variant="primary" class="mb-1" @click="createNewForm">
				                 	<font-awesome-icon icon="plus" fixed-width />
				                 	<span>Add Contact</span>
			                      </b-button>
                                </b-input-group-append>

								<form v-for="(form, index) in forms" :key="`form-${index}`" class="mb-2">
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
											v-model="form.f_name"
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
											v-model="form.l_name"
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
								:rules="{ required: true, numeric: true }"
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
											v-model="form.title_id"
											:options="titlename"
											:disabled="saving || loadingtitlename"
											:state="getValidationState(validationContext)"
											value-field="id"
											text-field="full_name"
											
										>
										
											<template #first>
												<option disabled v-if="!hastitlename" :value="null">
												   Please Select Title
												</option>
											</template>
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
            <b-form-group label="Contact Number Type" label-for="type">
            <!-- Wrapper for select and input fields -->
            <div class="d-flex align-items-end" v-for="(field, index) in inputFields" :key="index">
              <!-- Dropdown (select) field -->
              <label :for="'contacType' + index"></label>
              <b-input-group  class="mb-3">
										<b-form-select
											name="conatct_id"
											v-model="form.contact_id"
											:options="contactTypes"
											:disabled="saving || loadingcontactTypes"
											:state="getValidationState(validationContext)"
											value-field="id"
											text-field="full_name"
											
										>
											<template #first>
												<option disabled v-if="!hascontactTypes" :value="null">
												   Please Select Contact Type
												</option>
											</template>
										</b-form-select>
										</b-input-group>
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
				v-model="form.phone_no"
                v-mask="'(###) ###-####'"
                :state="getValidationState(validationContext)"
                :disabled="saving"
              ></b-form-input>

              <!-- Button inside the input group to remove the corresponding field -->
              <b-input-group-append>
                <b-button variant="danger" @click="removeInputField(index)" v-if="inputFields.length > 1">
                  <font-awesome-icon icon="minus" fixed-width />
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
											v-model="form.email"
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
									<b-card-footer class="d-flex justify-content-end">
                                          <b-button type="button" variant="light"  @click="removeForm(index)">
                                           <span>Cancel</span>
                                          </b-button>
                                    </b-card-footer>
	
	<b-modal id="customTitle" title="Add Custom Title " @ok="addCustomTitleName">
    <b-form-input
      id="newCustomName"
      name="newCustomeTitleName"
      type="text"
	  v-model="form.title_id"
      placeholder="Add custom Title"
      :disabled="saving"
    />
  </b-modal>

					</b-card>
				</form>
							</b-card-body>
						</b-collapse>

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
							<!--	<validation-provider
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
								</validation-provider>-->

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

						<!-- <b-card-header header-tag="header" role="tab" class="p-0">
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

									<b-form-group label="Assigned Services" label-for="service_ids" label-cols-lg="4" class="mb-0" style="margin: 0;">
									<loading-indicator v-if="loadingServices && services.length <= 0" />
									<b-input-group>
										<b-form-input type="text" name="service_ids" v-model="searchQuery"
											:disabled="saving || loadingServices || formDisabled"
											placeholder="Search for a Service..." @input="filterServices" class="mb-0" />
										<b-input-group-append>
											<b-input-group-text>
												<font-awesome-icon icon="search" fixed-width />
											</b-input-group-text>
										</b-input-group-append>
									</b-input-group>
									<div class="mb-0" style="margin: 0;">
										<!-- <b-list-group v-if="selectedServices.length > 0">
											<b-list-group-item v-for="service in selectedServices" :key="service.id">
												{{ service.name }}
												<b-btn @click="deselectService(service)" size="sm" variant="danger">Remove</b-btn>
											</b-list-group-item>
										</b-list-group> -->
										<b-list-group v-if="selectedServices.length > 0" class="mb-0">
											<b-list-group-item v-for="service in selectedServices" :key="service.id" class="mb-0">
												<div class="d-flex justify-content-between align-items-center mb-0">
													<div class="mb-0">{{ service.name }}</div>
													<b-btn variant="danger" @click="deselectService(service)" size="sm">
														<!-- <b-icon icon="x"></b-icon> -->
														<!-- <font-awesome-icon icon="fa-xmark"  style="color:red"/> -->
														<font-awesome-icon
															icon="times"
															fixed-width
														/>
													</b-btn>
												</div>
											</b-list-group-item>
										</b-list-group>

									</div>
									<div v-if="filteredServices.length > 0" class="mb-0">
										<b-list-group>
											<b-list-group-item v-for="service in filteredServices" :key="service.id"
												@click="selectService(service)">
												{{ service.name }}
											</b-list-group-item>
										</b-list-group>
									</div>
								</b-form-group>
							</b-card-body>
			</b-collapse>
			</b-card-body>
					</b-card>
				

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
			<!-- </b-card> -->
		</b-form>
	</validation-observer>
</template>

<script type="text/javascript">
import { mapGetters } from "vuex";
import { formatErrors, getValidationState } from "@/validation";
import axios from "axios";

export default {
	name: "FacilityAddForm",
	components: {},
	props: {
		id: {
			default: null,
		},
	},
	data() {
		return {
			loading: true,
			saving: false,
			searchQuery: '',            // The search query entered by the user
			filteredServices: [], 
			selectedServices: [],		 // The list of services selected by the user
			entity: {
				id: this.id,
				name: "",
				display_name:null,
				facility_type_id: null,
				active: true,
				phone: null,
				fax: null,
				email: null,
				website: null,
				f_name: null,
				l_name: null,
				title_id: null,
				street_address_1: null,
				street_address_2: null,
				city: null,
				state: null,
				zip: null,
				npi_number: null,
				npi_manual: null,
				primary_taxonomy: null,
				client_owned: false,
				division: null,
				region:null,
				chain_name: null,
				area_name: null,
				ou_number: null,
				territory: null,
				rvp_name: null,
				has_contract: false,
				contract_start_date: null,
				contract_end_date: null,
				indemnification_days: null,
				max_return_work_days: null,
				// services: {
				// 	_ids: [],
				// },
				services: [],
			},
			service_ids: [],
      
				selectedContactType: 'phone',
			},
			forms: [],
			titlename: [],
			contactTypes: [],
			inputFields: [{ selectedContactType: 'phone', phone: '' }],

		};
	},
	computed: mapGetters({
		states: "states/states",
		facilityTypes: "facilityTypes/all",
		loadingFacilityTypes: "facilityTypes/loadingAll",
		services: "services/all",
		loadingServices: "services/loadingAll",
	}),
	mounted() {
		this.getServices();
		this.TitleShow();
        this.fetchContactTypes();
		if (this.id) {
			this.refresh();
		} else {
			this.loading = false;
		}
	},

	created() {
		// Assuming you have a unique identifier for the facility, replace 'facilityId' with the actual identifier
		const facilityId = this.entity.id;

		// Retrieve previously selected services for the specific facility from localStorage
		const storedServices = localStorage.getItem(`selectedServices_${facilityId}`);

		// Initialize selectedServices array with the retrieved values or an empty array if none
		this.selectedServices = storedServices ? JSON.parse(storedServices) : [];
		},

	methods: {
		filterServices() {
			// Implement the logic to filter services based on the search term
			const searchTerm = this.searchQuery ? this.searchQuery.toLowerCase() : '';
			console.log("Search:",searchTerm);
			console.log("services:",this.services);

			// this.filteredServices = this.services.filter((service) =>
			// 	service.name.toLowerCase().includes(searchTerm)
			// );

			// Filter services, excluding the ones already selected
			this.filteredServices = this.services.filter((service) =>
				service.name.toLowerCase().includes(searchTerm) && !this.selectedServices.some(selected => selected.id === service.id)
			);
			console.log("Filtered:",this.filteredServices);

			},

		selectService(selectedService) {
			console.log('Selected Service:', selectedService);
			// Check if the service ID is not already selected
			// if (!this.entity.services._ids.includes(selectedService.id)) {
			// 	// Push the selected service ID to the array
			// 	this.entity.services._ids.push(selectedService.id);
			// }

			if (!this.selectedServices.some(service => service.id === selectedService.id)) {
				// Push the selected facility to the array
				this.selectedServices.push(selectedService);

				// Save the updated selected services for the specific facility to localStorage
				const facilityId = this.entity.id;
    			localStorage.setItem(`selectedServices_${facilityId}`, JSON.stringify(this.selectedServices));
				
				console.log("selected array:",this.selectedServices);
				this.entity.services.push(selectedService);
				console.log("pushed:",this.entity.services);
			}

			// Clear the search term and filtered services
			this.searchQuery = '';
			// this.filteredServices = [];
			 // Update the filtered services, excluding the selected service
  			this.filteredServices = this.filteredServices.filter(service => service.id !== selectedService.id);
			},
		deselectService(selectedService) {
			// Remove the selected facility from the array
			this.selectedServices = this.selectedServices.filter(service => service.id !== selectedService.id);
		},

		getValidationState,
		async getServices() {
			await this.$store.dispatch("services/getAll");
		},
		cancel() {
			this.$emit("cancel");
		},
		async refresh() {
			try {
				this.loading = true;

				const response = await this.$store.dispatch("facilities/get", {
					id: this.id,
				});

				this.entity = response;
				this.entity.services = {
					_ids: response.services.map((service) => service.id) ?? [],
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

		async save() {

		
			try {
				this.saving = true;
				const response = await this.$store.dispatch("facilities/save", this.entity);

				this.$emit("saved", response);
				this.$emit("update:id", response.id);

				this.$store.dispatch("facilities/getAll");
				this.$store.dispatch("facilities/getActive");
                  
				console.log("post data :", this.forms);
				// await axios.post('/client/facilityAddForms', this.forms );
				const responsed = await axios.post('/client/facilityAddForms', this.forms);
        		console.log('saving Response:', responsed);
				
                console.log('Data saved successfully');
			} 
			catch (e) {
				if (e.response.data.errors) {
					this.$refs.observer.setErrors(formatErrors(e.response.data.errors));
					
				}

				this.$store.dispatch("apiError", {
					error: e,
					title: "Save Failed",
					message: "Error saving facility details. Please check for errors.",
					variant: "warning",
				});
			} 
			finally {
				this.saving = false;
			}
		},
		openCustomTitle() {
			// Open the custom Title type modal when the "Add" button is clicked
			this.$bvModal.show("customTitle");
		},
	async addCustomTitleName() {
		const newType = this.newCustomName;
		const insid = this.id;
		console.log(insid);
		// Check if the new type is not empty
		if (newType.trim() === '') {
			return;
		}

		// Send a POST request to your controller to add the new type
		axios.post('/client/addtype', { newType , insid})
			.then((response) => {
				// Handle the response, e.g., update the insuranceTypes list
				this.titlename.push(response.data);

				// Close the modal
				this.$bvModal.hide('customTitle');

				// Clear the input field
				this.newCustomName = '';
				console.log("check",response);

		window.location.reload();
	})
	.catch((error) => {
		// Handle any errors, e.g., show an error message
		console.error('Error adding new type:', error);
	});
},
addInputField() {
      this.inputFields.push({ selectedContactType: 'phone', phone: '' });
    },
    removeInputField(index) {
      this.inputFields.splice(index, 1);
    },
    getValidationState(validationContext) {
      // Implement your validation state logic if needed
      return null;
    },
	
	},
};
</script>
