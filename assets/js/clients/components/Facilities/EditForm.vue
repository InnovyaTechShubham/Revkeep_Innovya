<template>
	<loading-indicator v-if="loading" class="my-5" />
	<validation-observer v-else v-bind="$attrs" ref="observer" v-slot="{ invalid }">
		<b-form @submit.prevent="save" >
			<b-card no-body>
				<slot name="header"></slot>

				
                <!--Main Section start-->
				<b-card-body>
					<b-row>
						<b-col md="6">
							<validation-provider
								vid="disp_name"
								name="display_name"
								:rules="{ required: true, max: 60 }"
								v-slot="validationContext"
							>
								<b-form-group label="Account Name" label-for="disp_name" label-cols-lg="4">
									<b-form-input
										name="disp_name"
										type="text"
										v-model="entity.display_name"
										:state="getValidationState(validationContext)"
										required="required"
										
									/>
									<b-form-invalid-feedback
										v-for="error in validationContext.errors"
										:key="error"
										v-text="error"
									/>
								</b-form-group>
							</validation-provider>
						</b-col>
						<b-col md="6">
							<validation-provider
								vid="pri_name"
								name="prior_name"
								:rules="{ required: false, max: 60 }"
								v-slot="validationContext"
							>
								<b-form-group label="Prior Name" label-for="pri_name" label-cols-lg="4">
									<b-form-input
										name="pri_name"
										type="text"
										v-model="entity.prior_name"
										:state="getValidationState(validationContext)"
										
									/>
									<b-form-invalid-feedback
										v-for="error in validationContext.errors"
										:key="error"
										v-text="error"
									/>
								</b-form-group>
							</validation-provider>
						</b-col>
					</b-row>
					<div>
					<b-row>
					<!-- First Column -->
					<b-col md="6">
						<!-- Facility Type -->
						<validation-provider
						vid="facility_type_id"
						name="Facility Type"
						:rules="{ required: true }"
						v-slot="validationContext"
						>
						<b-form-group label="Facility Type" label-for="facility_type_id" label-cols-lg="4">
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
					</b-col>

					<!-- Second Column -->
					<b-col md="6">
						<!-- Ownership Type -->
						<validation-provider
						vid="ownership_type"
						name="Ownership Type"
						:rules="{ required: false }"
						v-slot="validationContext"
						>
						<b-form-group label="Type of Ownership" label-for="ownership_type" label-cols-lg="4">
							<b-form-select
							name="ownership_type"
							v-model="entity.ownership_type"
							:state="getValidationState(validationContext)"
							:options="ownershipTypes"
							:disabled="saving"
							value-field="value"
							text-field="text"
							/>
							<b-form-invalid-feedback
							v-for="error in validationContext.errors"
							:key="error"
							v-text="error"
							/>
						</b-form-group>
						</validation-provider>
					</b-col>
					</b-row>
				</div>


					<b-row>
					<!-- First Column -->
					<b-col md="6">
						<!-- Address 1 -->
						<validation-provider vid="street_address_1" name="Street Address" :rules="{ required: false, max: 50 }" v-slot="validationContext">
						<b-form-group label="Address1" label-for="street_address_1" label-cols-lg="4">
							<b-form-input name="street_address_1" type="text" v-model="entity.address_2" placeholder="Street address" class="rounded-b-0" :state="getValidationState(validationContext)" :disabled="saving" />
							<b-form-invalid-feedback v-for="error in validationContext.errors" :key="error" v-text="error" />
						</b-form-group>
						</validation-provider>

						<!-- City -->
						<validation-provider vid="city" name="City" :rules="{ required: false, max: 50 }" v-slot="validationContext">
						<b-form-group label="City" label-for="city" label-cols-lg="4">
							<b-form-input name="city" type="text" v-model="entity.city" :state="getValidationState(validationContext)" :disabled="saving" />
							<b-form-invalid-feedback v-for="error in validationContext.errors" :key="error" v-text="error" />
						</b-form-group>
						</validation-provider>

						<!-- Zip -->
						<validation-provider vid="zip" name="Zip" :rules="{ required: false, max: 20, alpha_num: true }" v-slot="validationContext">
						<b-form-group label="Zip" label-for="zip" label-cols-lg="4">
							<b-form-input name="zip" type="text" v-model="entity.zip" :state="getValidationState(validationContext)" :disabled="saving" />
							<b-form-invalid-feedback v-for="error in validationContext.errors" :key="error" v-text="error" />
						</b-form-group>
						</validation-provider>

						<validation-provider
									vid="original_start_date"
									name="Original Start Date"
									:rules="{ required: false }"
									v-slot="validationContext"
								>
									<b-form-group label="Original Start Date" label-for="original_start_date" label-cols-lg="4">
										<b-form-input
											type="date"
											v-model="entity.original_start_date"
											name="original_start_date"
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
						<!-- Active -->
						
					<!-- <validation-provider vid="active" name="Active" :rules="{ required: false }" v-slot="validationContext">
						<b-form-group label="Facility Status" label-for="active" label-cols-lg="4" description="Inactive facilities will not show up in dropdown lists.">
						<b-form-checkbox name="active" v-model="entity.active" :disabled="saving">Active</b-form-checkbox>
						<b-form-invalid-feedback v-for="error in validationContext.errors" :key="error" v-text="error" />
						</b-form-group>
					</validation-provider> -->

					<validation-provider vid="active" name="Active" :rules="{ required: false }" v-slot="validationContext">
						<b-form-group label="Facility Status" label-for="active" label-cols-lg="4" description="Inactive facilities will not show up in dropdown lists.">
							<b-form-select v-model="entity.facility_status" :options="facilityStatus" :disabled="saving"></b-form-select>
							<b-form-invalid-feedback v-for="error in validationContext.errors" :key="error" v-text="error" />
						</b-form-group>
					</validation-provider>


					<b-form-group label="Bill Type" label-for="bill_type" label-cols-lg="4">
							<b-form-select name="bill_type" v-model="entity.bill_type" :options="billTypeOptions" value-field="abbreviation" text-field="name" :disabled="saving">
								<template #first>
									<option :value="null" />
								</template>
							</b-form-select>
						</b-form-group>


					
					</b-col>

					<!-- Second Column -->
					<b-col md="6">

						<!-- Address 2 -->
						<validation-provider vid="street_address_2" name="Street Address" :rules="{ required: false, max: 50 }" v-slot="validationContext">
						<b-form-group label="Address2" label-for="street_address_2" label-cols-lg="4">
							<b-form-input name="street_address_2" type="text" v-model="entity.street_address_2" placeholder="Suite, unit, floor, etc..." class="rounded-b-0" :state="getValidationState(validationContext)" :disabled="saving" />
							<b-form-invalid-feedback v-for="error in validationContext.errors" :key="error" v-text="error" />
						</b-form-group>
						</validation-provider>

						<!-- State -->
						<validation-provider vid="state" name="State" :rules="{ required: false, max: 2 }" v-slot="validationContext">
						<b-form-group label="State" label-for="state" label-cols-lg="4">
							<b-form-select name="state" v-model="entity.state" :options="states" value-field="abbreviation" text-field="name" :state="getValidationState(validationContext)" :disabled="saving">
							<template #first>
								<option :value="null" />
							</template>
							</b-form-select>
							<b-form-invalid-feedback v-for="error in validationContext.errors" :key="error" v-text="error" />
						</b-form-group>
						</validation-provider>

						<!-- County -->
						<validation-provider vid="county" name="County" :rules="{ required: false, max: 50 }" v-slot="validationContext">
						<b-form-group label="County" label-for="county" label-cols-lg="4">
							<b-form-input name="county" type="text" v-model="entity.county" :state="getValidationState(validationContext)" :disabled="saving" />
							<b-form-invalid-feedback v-for="error in validationContext.errors" :key="error" v-text="error" />
						</b-form-group>
						</validation-provider>

						<validation-provider
									vid="term_date"
									name="Term Date"
									:rules="{ required: false }"
									v-slot="validationContext"
								>
									<b-form-group label="Term Date" label-for="term_date" label-cols-lg="4">
										<b-form-input
											type="date"
											v-model="entity.term_date"
											name="term_date"
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

						 <!-- Owned -->
						<validation-provider vid="client_owned" name="Owned" :rules="{ required: false }" v-slot="validationContext">
							<b-form-group label="Owned" label-for="client_owned" label-cols-lg="4" description="Facility is owned/provided by the client.">
							<b-form-checkbox name="client_owned" v-model="entity.client_owned" :disabled="saving">Owned</b-form-checkbox>
							<b-form-invalid-feedback v-for="error in validationContext.errors" :key="error" v-text="error" />
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
										:disabled="true"
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

						<!-- <validation-provider vid="ownership_type" name="Ownership Type" :rules="{ required: false, max: 2 }" v-slot="validationContext">
							<b-form-group label="Bill Types" label-for="bill_type" label-cols-lg="4">
								<b-form-select name="bill_type" v-model="entity.bill_type" :options="billTypeOptions" value-field="abbreviation" text-field="name" :state="getValidationState(validationContext)" :disabled="saving">
									<template #first>
										<option :value="null" />
									</template>
								</b-form-select>
								<b-form-invalid-feedback v-for="error in validationContext.errors" :key="error" v-text="error" />
							</b-form-group>
						</validation-provider> -->

						<!-- <b-form-group label="Bill Typed" label-for="bill_type" label-cols-lg="4">
							<b-form-select name="bill_type" v-model="entity.bill_type" :options="billTypeOptions" value-field="abbreviation" text-field="name" :disabled="saving">
								<template #first>
									<option :value="null" />
								</template>
							</b-form-select>
						</b-form-group> -->


					</b-col>
					</b-row>
					
			<b-form-group label="Chain" label-for="chain_name" label-cols-lg="2">
				<b-input-group>
					<b-form-input type="text" name="chain_name" v-model="searchChain"
						:disabled="saving"
						placeholder="Search for a Chain..." @input="filterChains" />
					<!-- <b-input-group-append>
						<b-input-group-text>
							<font-awesome-icon icon="search" fixed-width />
						</b-input-group-text>
					</b-input-group-append> -->
				</b-input-group>
				<div class="mb-0" style="margin: 0;">
					<b-list-group v-if="filteredChains.length > 0">
						<b-list-group-item v-for="chain in filteredChains" :key="chain.id"
							@click="selectChain(chain)">
							{{ chain.chain_name }}
						</b-list-group-item>
					</b-list-group>
				</div>
			</b-form-group>

				</b-card-body>
				<!--Main section end-->

				<!-- Details section start-->
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
								<b-row>
									<b-col md="4">
										<validation-provider vid="region" name="Region" :rules="{ required: false, max: 60 }" v-slot="validationContext">
										<b-form-group label="Region" label-for="region" label-cols-lg="4">
											<b-form-input name="region" type="text" v-model="entity.region" :state="getValidationState(validationContext)" :disabled="saving" />
											<b-form-invalid-feedback v-for="error in validationContext.errors" :key="error" v-text="error" />
										</b-form-group>
									</validation-provider>
									</b-col>
									<b-col md="4">
										<validation-provider vid="territory" name="Territory" :rules="{ required: false, max: 60 }" v-slot="validationContext">
											<b-form-group label="Territory" label-for="territory" label-cols-lg="4">
												<b-form-input name="territory" type="text" v-model="entity.territory" :state="getValidationState(validationContext)" :disabled="saving" />
												<b-form-invalid-feedback v-for="error in validationContext.errors" :key="error" v-text="error" />
											</b-form-group>
										</validation-provider>
									</b-col>
									<b-col md="4">
										<validation-provider vid="area_name" name="Area" :rules="{ required: false, max: 60 }" v-slot="validationContext">
											<b-form-group label="Area" label-for="area_name" label-cols-lg="4">
												<b-form-input name="area_name" type="text" v-model="entity.area_name" :state="getValidationState(validationContext)" :disabled="saving" />
												<b-form-invalid-feedback v-for="error in validationContext.errors" :key="error" v-text="error" />
											</b-form-group>
										</validation-provider>
									</b-col>
								</b-row>

								<b-row>
								<!-- First Column -->
								<b-col md="6">

									<!-- Region -->
									<!-- <validation-provider vid="region" name="Region" :rules="{ required: false, max: 60 }" v-slot="validationContext">
										<b-form-group label="Region" label-for="region" label-cols-lg="4">
											<b-form-input name="region" type="text" v-model="entity.region" :state="getValidationState(validationContext)" :disabled="saving" />
											<b-form-invalid-feedback v-for="error in validationContext.errors" :key="error" v-text="error" />
										</b-form-group>
									</validation-provider> -->

									<!-- Division -->
									<validation-provider vid="division" name="Division" :rules="{ required: false, max: 60 }" v-slot="validationContext">
										<b-form-group label="Division" label-for="division" label-cols-lg="4">
											<b-form-input name="division" type="text" v-model="entity.division" :state="getValidationState(validationContext)" :disabled="saving" />
											<b-form-invalid-feedback v-for="error in validationContext.errors" :key="error" v-text="error" />
										</b-form-group>
									</validation-provider>
									

									<!-- OU Number -->
									<validation-provider vid="ou_number" name="OU Number" :rules="{ required: false, max: 60 }" v-slot="validationContext">
									<b-form-group label="OU Number" label-for="ou_number" label-cols-lg="4">
										<b-form-input name="ou_number" type="text" v-model="entity.ou_number" :state="getValidationState(validationContext)" :disabled="saving" />
										<b-form-invalid-feedback v-for="error in validationContext.errors" :key="error" v-text="error" />
									</b-form-group>
									</validation-provider>
								</b-col>

								<!-- Second Column -->
								
								
									<b-col md="6">
									
									<!-- Territory -->
									<!-- <validation-provider vid="territory" name="Territory" :rules="{ required: false, max: 60 }" v-slot="validationContext">
									<b-form-group label="Territory" label-for="territory" label-cols-lg="4">
										<b-form-input name="territory" type="text" v-model="entity.territory" :state="getValidationState(validationContext)" :disabled="saving" />
										<b-form-invalid-feedback v-for="error in validationContext.errors" :key="error" v-text="error" />
									</b-form-group>
									</validation-provider> -->

									<!-- Area -->
									<!-- <validation-provider vid="area_name" name="Area" :rules="{ required: false, max: 60 }" v-slot="validationContext">
									<b-form-group label="Area" label-for="area_name" label-cols-lg="4">
										<b-form-input name="area_name" type="text" v-model="entity.area_name" :state="getValidationState(validationContext)" :disabled="saving" />
										<b-form-invalid-feedback v-for="error in validationContext.errors" :key="error" v-text="error" />
									</b-form-group>
									</validation-provider> -->

									<!--  Internal Owner -->
									<validation-provider vid="int_owner" name="Internal Owner" :rules="{ required: false, max: 60 }" v-slot="validationContext">
									<b-form-group label="Internal Owners" label-for="int_owner" label-cols-lg="4">
										<b-form-input name="int_owner" type="text" v-model="entity.internal_owner" :state="getValidationState(validationContext)" :disabled="saving" />
										<b-form-invalid-feedback v-for="error in validationContext.errors" :key="error" v-text="error" />
									</b-form-group>
									</validation-provider>
									<!-- BU Number -->
									<validation-provider vid="bu_number" name="BU Number" :rules="{ required: false, max: 60 }" v-slot="validationContext">
									<b-form-group label="BU Number" label-for="bu_number" label-cols-lg="4">
										<b-form-input name="bu_number" type="text" v-model="entity.bu_number" :state="getValidationState(validationContext)" :disabled="saving" />
										<b-form-invalid-feedback v-for="error in validationContext.errors" :key="error" v-text="error" />
									</b-form-group>
									</validation-provider>
								</b-col>
								</b-row>

								
							</b-card-body>
						</b-collapse>
						<!-- Details section end  -->

						<!-- Contact section start-->
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
				                 	<span>Add Contacts</span>
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
													v-model="form.first_name"
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
													v-model="form.last_name"
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
																v-model="form.phone"
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
						<!-- Contact section end-->

						<!-- Contract Section Start-->
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
							<b-row>
							<!-- First Column -->
							<b-col md="6">
								<validation-provider
									vid="active"
									name="Active"
									:rules="{ required: false }"
									v-slot="validationContext"
								>
									<b-form-group
										label="Contract Status"
										label-for="active"
										label-cols-lg="4"
										description="Inactive contracts will not show up in dropdown lists."
									>
										<b-form-checkbox name="active" v-model="entity.contract_status" :disabled="saving"
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
									vid="contract_start_date"
									name="Contract Start Date"
									:rules="{ required: false }"
									v-slot="validationContext"
								>
									<b-form-group label="Contract Effective Date" label-for="contract_start_date" label-cols-lg="4">
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

							</b-col>

							<!-- Second Column -->
							<b-col md="6">
								<validation-provider
									vid="contract_end_date"
									name="Contract End Date"
									:rules="{ required: false }"
									v-slot="validationContext"
								>
									<b-form-group label="Expiration Date" label-for="contract_end_date" label-cols-lg="4">
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
									vid="renewal_date"
									name="Renewal Date"
									:rules="{ required: false }"
									v-slot="validationContext"
								>
									<b-form-group label="Renewal Date" label-for="renewal_date" label-cols-lg="4">
										<b-form-input
											type="date"
											v-model="entity.renewal_date"
											name="renewal_date"
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

								</b-col>
								</b-row>

									<b-row>
									<!-- First Column -->
									<b-col md="6">
										<!-- Contract Bill Type -->
										<validation-provider
										vid="contract_bill_type"
										name="Contract Bill Type"
										:rules="{ required: false }"
										v-slot="validationContext"
										>
										<b-form-group label="Contract Bill Type" label-for="contract_bill_type" label-cols-lg="4">
											<b-form-select
											name="contract_bill_type"
											v-model="entity.contract_bill_type"
											:state="getValidationState(validationContext)"
											:options="contractBillTypes"
											:disabled="saving"
											value-field="value"
											text-field="text"
											>
											<!-- <template #first>
												<option :value="null" />
											</template> -->
											</b-form-select>
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

									</b-col>

									<!-- Second Column -->
									<b-col md="6">
										<!-- Contract Type -->
										<validation-provider
										vid="contract_type"
										name="Contract Type"
										v-slot="validationContext"
										>
										<b-form-group label="Contract Type" label-for="contract_type" label-cols-lg="4">
											<b-form-select
											name="contract_type"
											v-model="entity.contract_type"
											:state="getValidationState(validationContext)"
											:options="contractTypes"
											:disabled="saving"
											value-field="value"
											text-field="text"
											direction="down"
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
									</b-col>
								</b-row>

								<validation-provider
								vid="service_operations"
								name="Service Operations"
								:rules="{ required: false }"
								v-slot="validationContext"
								>
								<b-form-group label="Service Operations" label-for="service_operations" label-cols-lg="2">
									<b-form-checkbox-group
									id="service_operations"
									v-model="entity.serviceOperation"
									:options="serviceOperationsOptions"
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

								<b-card title="Contract Pricing Schedule" border-variant="light">
								<b-row>
									<b-col md="6">
										<b-table :items="insurances.slice(0, 6)" :fields="['insurance_rate_type', 'contract_rate']">
											<template v-slot:cell(contract_rate)="info">
												<div class="d-flex">
													<input type="text" v-model="info.item.rate" class="form-control" placeholder="Add rate in %" @input="addPricingSchedule(info.item)" />
												
												</div>
											</template>
										</b-table>
									</b-col>

									<b-col md="6">
										<b-table :items="insurances.slice(6, 12)" :fields="['insurance_rate_type', 'contract_rate']">
											<template v-slot:cell(contract_rate)="info">
												<div class="d-flex">
													<input type="text" v-model="info.item.rate" class="form-control" placeholder="Add rate in %" @input="addPricingSchedule(info.item)" />
												</div>
											</template>
										</b-table>
									</b-col>
								</b-row>
							</b-card>

							
							</b-card-body>
						</b-collapse>
						<!-- Contract Section End-->

						<!--Service section start-->
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

									<b-form-group label="Assigned Services" label-for="service_ids" label-cols-lg="4" class="mb-0" style="margin: 0;">
									<loading-indicator v-if="loadingServices && services.length <= 0" />
									<b-input-group>
										<b-form-input type="text" name="service_ids" v-model="searchQuery"
											:disabled="saving || loadingServices"
											placeholder="Search for a Service..." @input="filterServices" class="mb-0" />
										
									</b-input-group>
									<div class="mb-0" style="margin: 0;">
										
										<b-list-group v-if="selectedServices.length > 0" class="mb-0">
											<b-list-group-item v-for="service in selectedServices" :key="service.id" class="mb-0">
												<div class="d-flex justify-content-between align-items-center mb-0">
													<div class="mb-0">{{ service.name }}</div>
													<b-btn variant="danger" @click="deselectService(service)" size="sm">
														
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
						<!--Service section End-->

						<!--Receiving Methods section start-->
						<b-card-header header-tag="header" role="tab" class="p-0">
							<b-button
								block
								v-b-toggle.collapseReceivingMethods
								variant="light"
								role="tab"
								class="text-left px-4 py-3 m-0"
							>Outgoing Methods</b-button>
						</b-card-header>
						<b-collapse id="collapseReceivingMethods" role="tabpanel">
							<b-card-body>

								<template>
									<div>
										<b-row>
										<!-- Section for Receiving Emails -->
										<b-col md="6">
											
											<!-- Display entered emails in tabular format -->
											<div>
												<h6>Outgoing Emails</h6>
												<b-table v-if="entity && entity.receiving_emails && entity.receiving_emails.length > 0" :items="entity.receiving_emails" :fields="['email', 'description']" striped hover>
												<template slot="cell(email)" slot-scope="info">
													{{ info.item.email }}
												</template>
												<template slot="cell(description)" slot-scope="info">
													{{ info.item.description }}
												</template>
												</b-table>
												<empty-result v-else class="small-empty-result">
												<span>No emails added</span>
												</empty-result>
											</div>

											<div class="d-flex justify-content-between">
												<!-- Plus icon button on the left -->
												<b-button @click="openPopup" variant="primary">
													<font-awesome-icon icon="plus" fixed-width />
												</b-button>

												<b-button @click="openDeletePopup" variant="danger" v-if="entity.receiving_emails && entity.receiving_emails.length > 0" class="mr-8">
													<font-awesome-icon icon="trash" fixed-width />
												</b-button>
											</div>

											<!-- Pop-up for adding emails -->
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


											<!-- Pop-up for deleting selected entries -->
											<b-modal v-model="deletePopupVisible" title="Delete Emails" @ok="deleteSelectedEmails" ok-only>
												<b-form>
												<div> <!-- Wrap the b-table in a div -->
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
											<!-- </b-form-group> -->
										</b-col>

										<!-- Section for Receiving Faxes -->
										<b-col md="6">
											
											<!-- Display entered faxes in tabular format -->
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

											<!-- Icon to open the pop-up -->
											<div class="d-flex justify-content-between">
												<!-- Plus icon button on the left -->
												<b-button @click="openPopupFax" variant="primary">
												<font-awesome-icon icon="plus" fixed-width />
												</b-button>

												<b-button @click="openDeleteFaxPopup" variant="danger" v-if="entity.receiving_faxes && entity.receiving_faxes.length > 0" class="mr-8">
												<font-awesome-icon icon="trash" fixed-width />
												</b-button>
											</div>

											<!-- Pop-up for adding faxes -->
											<b-modal v-model="popupVisibleFax" title="Add Fax" hide-footer>
												<b-form @submit.prevent="addFax">
													<b-form-group label="Fax" label-for="fax">
														<b-form-input v-model="newFax.fax" @input="formatFax" id="fax" required />
													</b-form-group>
													<b-form-group label="Description" label-for="description">
														<b-form-input v-model="newFax.description" id="description" />
													</b-form-group>
													<b-button type="submit" variant="primary" class="mx-auto d-block">Ok</b-button>
												</b-form>
											</b-modal>




											<!-- Pop-up for deleting selected entries -->
											<b-modal v-model="deletePopupVisibleFax" title="Delete Faxes" @ok="deleteSelectedFaxes" ok-only>
												<b-form>
												<div> <!-- Wrap the b-table in a div -->
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
											<!-- </b-form-group> -->
										</b-col>
										</b-row>
									</div>
									</template>
								


							</b-card-body>
						</b-collapse>

						<!-- end Receiving Methods -->

						<!--NPI information section start-->

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
									<div class="label-value-row">
										<div class="label-text">Name:</div>
										<div class="text">{{ entity.name }}</div>
									</div>
									<div class="label-value-row">
										<div class="label-text">NPI Number:</div>
										<div class="text">{{ entity.npi_number }}</div>
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
									

									<hr class="my-2">

									
											<div class="d-flex">
												<div class="flex-grow-1 pr-3">
												<div class="label-value-row">
													<div class="label-text">Location Address:</div>
													<div class="text">{{ entity.address_2 }}</div>
											</div>
											<div class="label-value-row">
												<div class="label-text">Phone Number:</div>
												<div class="text">{{ entity.location_phone }}</div>
											</div>
											<hr class="my-1">
											<div class="label-value-row">
												<div class="label-text">Mailing Address:</div>
												<div class="text">{{entity.address_1}}</div>
											</div>
											<!-- <div class="label-value-row">
												<div class="label-text">Organization Subpart ?</div>
												<div class="text-primary">{{ entity.organizational_subpart }}</div>
											</div> -->
											<div class="label-value-row">
												<div class="label-text">Phone Number:</div>
												<div class="text">{{ entity.mailing_phone }}</div>
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
												<div class="text">{{ processAdditionalTaxonomies(entity.additional_taxonomies) }}</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</b-card-body>
					</b-collapse>

					<!--NPI information section end-->
				
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
			</b-card>
		</b-form>
	</validation-observer>
</template>

<script type="text/javascript">
import { mapGetters} from "vuex";
import { formatErrors, getValidationState } from "@/validation";
import NPIOrganization from "@/clients/components/NPI/NPIOrganization.vue";
import axios from "axios";
import { ref} from "vue";
// get All record
const records = ref([]);

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
			searchChain:'',
			selectedChain: '',
			filteredChains:[],
			searchQuery: '',            // The search query entered by the user
        	// availableServices: [],               // The list of all available services
        	// matchingServices: [],       // The list of services matching the search query
        	filteredServices: [], 
			selectedServices: [],		 // The list of services selected by the user
			// services: [],
			entity: {
				id: this.id,
				name: "",
				display_name:null,
				prior_name:null,
				facility_type_id: null,
				active: true,
				contract_status:true,
				phone: null,
				fax: null,
				email: null,
				website: null,
				f_name: null,
				l_name: null,
				title_id: null,
				// street_address_1: null,
				street_address_2: null,
				city: null,
				state: null,
				zip: null,
				county: null,
				npi_number: null,
				npi_manual: null,
				primary_taxonomy: null,
				location_phone: null,
				mailing_phone: null,
				additional_taxonomies: null,
				client_owned: true,
				chain_name: '',
				area_name: null,
				ou_number: null,
				bu_number: null,
				territory: null,
				// rvp_name: null,
				has_contract: false,
				contract_start_date: null,
				contract_end_date: null,
				original_start_date: null,
				term_date: null,
				renewal_date: null,
				indemnification_days: null,
				max_return_work_days: null,
				// service_operations: null,
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
				services: [],
				chains:[],
				receiving_email: '', // For input
            	receiving_emails: [], // For storing multiple emails
				receiving_fax: '', // For input
            	receiving_faxes: [], // For storing multiple faxes
				// outgoing_emails: [],
            	receiving_methods: [], 
				pricing_schedules: [],
				newSchedule: {
				ins_id: '',
				rate: '',
				facility_id: ''
			},
				serviceOperation: null,
				contract_bill_type: null,
				contract_type: null,
				ownership_type: null,
				contract_insurance_type: null,
				facility_status:null,
				internal_owner:null,
				bill_type:null,

			},
			billTypeOptions:[],
			facilityStatus:[],
			service_ids: [],
			forms: [],
			titlename: [],
			contactTypes: [],
			inputFields: [{ selectedContactType: 'phone', phone: '' }],
			popupVisible: false,
			popupVisibleFax: false,
			deletePopupVisible: false,
			deletePopupVisibleFax: false,
			isFaxInputDisabled: false,
			// faxNumberPattern: /^[0-9]{10}$/, // Adjust the regex pattern based on your fax number format
			// allowedDigits: 10,
			// existingFaxes: [] ,

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
			serviceOperationsOptions: [
				// { value: 'pt', text: 'PT' },
				// { value: 'ot', text: 'OT' },
				// { value: 'st', text: 'ST' },
			],
			contractBillTypes: [],
			// { value: 'other', text: 'Other' },
			// { value: 'ghc', text: 'GHC' },
			// { value: 'synergy', text: 'Synergy' },
			// { value: 'encore', text: 'Encore' },
			
			contractTypes: [
			// { value: 'management_agreement', text: 'Management Agreement' },
			// { value: 'snf_therapy_percent', text: 'SNF - % Therapy Component' },
			// { value: 'snf_flat_fee', text: 'SNF - Flat Fee' },
			// { value: 'snf_flat_fee_part_a', text: 'SNF - Flat Fee (Part A)' },
			// { value: 'snf_partnership_plus', text: 'SNF - Partnership Plus' },
			// { value: 'snf_per_diem', text: 'SNF - Per Diem' },
			// { value: 'snf_per_diem_sd', text: 'SNF - Per Diem (SD)' },
			// { value: 'snf_per_minute', text: 'SNF - Per Minute' },
			// { value: 'snf_per_minute_sd', text: 'SNF - Per Minute (SD)' },
			// { value: 'snf_percent_fac_rate', text: 'SNF - Percent Facility Rate' },
			// { value: 'snf_percent_pdpm_ther_comp', text: 'SNF - Percent PDPM Therapy Component' },
			],
			ownershipTypes: [
			// { value: 'corporate_chain', text: 'Corporate Chain' },
			// { value: 'county_owned', text: 'County Owned' },
			// { value: 'hospital_owned', text: 'Hospital Owned' },
			// { value: 'independent', text: 'Independent' },
			// { value: 'managed', text: 'Managed' },
			// { value: 'management_company', text: 'Management Company' },
			// { value: 'silver_stone_living', text: 'Silver Stone Living' },
		],
			
			insuranceRates: {},
			selectedInsuranceId: null,

			insurances: [
				
		],
    // 	fields: [{ key: 'insurance_type', label: 'Insurance Type' },
    //   { key: 'rate', label: 'Contract Rate (%)' },],
	 };
	},
	watch: {
		'entity.bill_type': function(newBillType) {
		if (newBillType === 'Synergy' || newBillType === 'Contract Bill Other') {
			this.entity.has_contract = true;
		} else {
			this.entity.has_contract = false;
		}
		}
	},
	computed: 
	{
	
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
			// chains: "chains/all",
			// loadingChains: "chains/loadingAll",
		}),
	},
	mounted() {
		this.getServices();
		this.getChains();
		this.TitleShow();
    	this.fetchContactTypes();
		this.listFacilityContacts();
		this.fetchFacilityStatus();
		this.fetchFacilityBillType();
		this.fetchContractBillTypes();
		this.fetchContractTypes();
		this.fetchOwnershipTypes();
		this.fetchServiceOperations();
		this.fetchInsurances();
		this.fetchReceivingEmails();
		this.fetchReceivingFaxes();



		
		if (this.id) {
			this.refresh();
		} else {
			this.loading = false;
		}
	},
	
	methods: {
		// updateSelectedInsuranceId(id) {
		// 	this.selectedInsuranceId = id;
		// },
		async addPricingSchedule(obj) {
			console.log("inside");
			this.insuranceRates= obj ;
			// const facilityId = facility_id;
			console.log("ins:",this.insuranceRates);

			 // Ensure that this.entity.pricing_schedules is an array
			 if (!Array.isArray(this.entity.pricing_schedules)) {
				this.$set(this.entity, 'pricing_schedules', []);
				}
			// console.log("before",this.entity.pricing_schedules);
			let newpricingSchedule;


			this.entity.pricing_schedules.push(this.insuranceRates);
			console.log("final",this.entity.pricing_schedules);
		
			try {
				// Make a POST request to store the data in the database
				const response = await axios.post('/client/contractpricingschedule', this.entity.pricing_schedules);
				console.log('Axios Response:', response);
				await this.$nextTick();
				this.$emit("pricing_schedules", response);
				console.log("Emitted data:", response.data);
				
			} catch (error) {
				console.error('Error creating schedule:', error);
			}
},
		
		async fetchInsurances(){
			try
						{
							const url = "/client/contractinsurancelist";
								
								const response = await axios.get(url, {
								headers: {
									"Accept": "application/json",
									// You can add other headers here if needed
								},
								});
								
							console.log("insurance types listed :", response);
							// response.data.forEach((item)=>{
							// 	this.insurances.push(item.insurance_type);
							// });
							this.insurances = response.data.map(item => ({
							id:item.id,
							insurance_rate_type: item.insurance_type,
							rate: this.entity.contract_rate || '',
							facility_id: this.entity.id
						}));
							console.log('ownership type options =' , this.insurances);
						}
					catch (error) 
					{
						console.error("Error fetching data:", error.message);
					}
		},
		async fetchServiceOperations(){
			try
						{
							const url = "/client/serviceoperationlist";
								
								const response = await axios.get(url, {
								headers: {
									"Accept": "application/json",
									// You can add other headers here if needed
								},
								});
								
							console.log("service operations listed :", response);
							response.data.forEach((item)=>{
								this.serviceOperationsOptions.push(item.operation);
							});
							console.log('ownership type options =' , this.serviceOperationsOptions);
						}
					catch (error) 
					{
						console.error("Error fetching data:", error.message);
					}
		},
		async fetchOwnershipTypes(){
			try
						{
							const url = "/client/ownershiptypelist";
								
								const response = await axios.get(url, {
								headers: {
									"Accept": "application/json",
									// You can add other headers here if needed
								},
								});
								
							console.log("ownership type listed :", response);
							response.data.forEach((item)=>{
								this.ownershipTypes.push(item.ownership_type);
							});
							console.log('ownership type options =' , this.ownershipTypes);
						}
					catch (error) 
					{
						console.error("Error fetching data:", error.message);
					}
		},

		async fetchContractTypes(){
			try
						{
							const url = "/client/contracttypelist";
								
								const response = await axios.get(url, {
								headers: {
									"Accept": "application/json",
									// You can add other headers here if needed
								},
								});
								
							console.log("contract type listed :", response);
							console.log("before",this.contractTypes)
							response.data.forEach((item)=>{
								this.contractTypes.push(item.contract_type);
							});
							console.log('contract type options =' , this.contractTypes);
						}
					catch (error) 
					{
						console.error("Error fetching data:", error.message);
					}
		},
		async fetchContractBillTypes(){
			try
						{
							const url = "/client/contractbilltypelist";
								
								const response = await axios.get(url, {
								headers: {
									"Accept": "application/json",
									// You can add other headers here if needed
								},
								});
								
							console.log("contract bill type listed :", response);
							response.data.forEach((item)=>{
								this.contractBillTypes.push(item.bill_type);
							});
							console.log('contract bill type options =' , this.contractBillTypes);
						}
					catch (error) 
					{
						console.error("Error fetching data:", error.message);
					}
		},

    


		getTypeOptions(row) {
		return row.typeOptions.concat(['Custom']);
		},
		getValueOptions(row) {
		return row.valueOptions.concat(['Custom']);
		},

		getPlaceholder(selectedValue) {
		// You can customize the placeholder based on the selected value
		if (selectedValue === 'per_min') {
			return '$0.00/min';
		} else if (selectedValue === 'per_hour') {
			return '$0.00/hr';
		} else if (selectedValue === 'per_diem') {
			return '$0.00/diem';
		} else {
			return 'Enter rate...';
		}
		},
		async updateReceivingMethods(receivingEmailId, receivingFaxId) {
			const facilityId = this.entity.id;
			console.log('inside updateRecievingMethods');
			console.log('receivingEmailId',receivingEmailId);
			console.log('receivingFaxId',receivingFaxId);
			// Determine if receivingEmailId or receivingFaxId is provided
			const data = {
				facility_id: facilityId,
				receiving_email_id: receivingEmailId || null,
				receiving_fax_id: receivingFaxId || null,
			};
			console.log("Payload",data);

			try {
				// const response = await axios.post('/client/receivingMethods', data, {
				// 	headers: {
				// 		'Content-Type': 'application/json',
				// 	},
				// });
				const response = await axios.post('/client/receivingMethods', data);
				console.log('Receiving methods updated:', response.data);
			} catch (error) {
				console.error('Error updating receiving methods:', error);
			}
		},
	// 	addReceivingMethod() {
    //     // Assuming you have the necessary data in your component's data or computed properties
	// 	const facilityId = this.entity.id;
	// 		const data = {
	// 			facility_id: facilityId,
	// 			receiving_email_id: this.selectedReceivingEmailId,
	// 			receiving_fax_id: this.selectedReceivingFaxId,
	// 		};

	// 		// Make an Axios POST request to store data
	// 		axios.post('/facilities-receivingmethods/store', data)
	// 			.then(response => {
	// 				// Handle the success response as needed
	// 				console.log(response.data);
	// 			})
	// 			.catch(error => {
	// 				// Handle errors
	// 				console.error(error);
	// 			});
    // },
	
		// async addReceivingMethod() {

		// 	console.log("started");
		// 	const facilityId = this.entity.id;
		// 	const data = {
		// 		facility_id: facilityId,
		// 		receiving_email_id: this.selectedReceivingEmailId,
		// 		receiving_fax_id: this.selectedReceivingFaxId,
		// 	};
		// 	// console.log(facilityId);
			

		// 	// Send a POST request to your controller to add the new type
		// 	axios.post('/client/receivingMethods', data)
		// 		.then((response) => {
		// 			this.receiving_methods.push(response.data);
		// 			console.log("check",response);

		// 		})
		// 		.catch((error) => {
		// 			// Handle any errors, e.g., show an error message
		// 			console.error('Error adding new type:', error);
		// 		});
		// 	},
	
	openPopupFax() {
		this.popupVisibleFax = true;
		},
	closePopupFax() {
		this.popupVisibleFax = false;
		},
	formatFax() {
		const numericFax = this.newFax.fax.replace(/\D/g, '');

		if (numericFax.length > 10) {
		this.faxInputError = true; // Invalid fax number
		// this.isFaxInputDisabled = true; // Disable the input field
		} else {
		this.newFax.fax = numericFax ? numericFax.replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3') : '';
		this.faxInputError = false;
		// this.isFaxInputDisabled = false; // Enable the input field
		}
		},
// 	addFax() {
//     const newFax = { ...this.newFax };
//     console.log("new:", newFax);

//     // Check if receiving_faxes is defined, if not, initialize it as an empty array
//     if (!Array.isArray(this.entity.receiving_faxes)) {
//         this.$set(this.entity, 'receiving_faxes', []);
//     }

//     // Check if the fax number already exists
//     if (this.entity.receiving_faxes.map((fax) => fax.fax).includes(this.newFax.fax)) {
//         this.$bvToast.toast('Error: Fax number already exists. Please enter a different fax.', {
//             title: 'Error',
//             variant: 'danger',
//             solid: true,
//             autoHideDelay: 5000, // milliseconds
//         });
//         return;
//     }

//     // Add the new fax to the array
//     this.existingFaxes.push(this.newFax.fax);
//     this.entity.receiving_faxes.push(newFax);
//     console.log('Before addFax:', this.entity.receiving_faxes);
//     console.log('After addFax:', this.entity.receiving_faxes);

//     // Clear the newFax object for the next entry
//     this.newFax = { fax: '', description: '' };

//     // Use $nextTick to ensure the DOM is updated
//     this.$nextTick(() => {
//         console.log("Receiving Faxes:", this.entity.receiving_faxes);
//     });

//     // Close the pop-up
//     this.popupVisibleFax = false;
// },

async addFax() {
    
        const newFax = { ...this.newFax };
        console.log("new:", newFax);
		const fax = newFax.fax;
		const description = newFax.description;
		console.log('fax',fax);
		console.log('description',description);
		// Clear the newFax object for the next entry
        this.newFax = { fax: '', description: '' };

        // Validate fax number format
        const faxRegex = /^\(\d{3}\) \d{3}-\d{4}$/;
        if (!faxRegex.test(fax)) {
            this.$bvToast.toast('Error: Please enter a valid fax number. (Format: (123) 456-7890)', {
                title: 'Error',
                variant: 'danger',
                solid: true,
                autoHideDelay: 5000, // milliseconds
            });
            return;
        }

        // Check if receiving_faxes is defined, if not, initialize it as an empty array
        if (!Array.isArray(this.entity.receiving_faxes)) {
            this.$set(this.entity, 'receiving_faxes', []);
        }

        // Check if the fax number already exists
        if (this.entity.receiving_faxes.some(existingFax => existingFax.fax === fax)) {
            this.$bvToast.toast('Error: Fax number already exists. Please enter a different fax.', {
                title: 'Error',
                variant: 'danger',
                solid: true,
                autoHideDelay: 5000, // milliseconds
            });
            return;
        }

        // Add the new fax to the array
        this.entity.receiving_faxes.push(newFax);

        // Clear the newFax object for the next entry
        this.newFax = { fax: '', description: '' };

        // Close the pop-up
        this.popupVisibleFax = false;

        // Prepare the data to be sent in the POST request
        // Prepare the data to be sent in the POST request
		const faxData = {
			fax,
			description,
		};
		console.log("header:", faxData);
		try {
			// Make a POST request to store the data in the database
			const response = await axios.post('/client/receivingFaxes', faxData);
			console.log('Axios Response:', response);
			await this.$nextTick();
			this.$emit("Receiving_faxes", response);
			console.log("Emitted data:", response.data);
			// Check for a successful status code (2xx)
		if (response.status >= 200 && response.status < 300) {
			// Parse the JSON response
				const responseData = response.data;
				// Check if the expected properties are present
				if (responseData.fax && responseData.description && responseData.id) 
				{
					console.log('Fax saved successfully.');
					this.saving = false;
					await this.updateReceivingMethods(null, responseData.id);

					this.$nextTick(() => {
						this.$store.dispatch('notify', {
							variant: 'primary',
							title: 'Fax Created!',
							message: 'New fax created.',
						});
					});
					
					
			} else {
				// Server response is missing expected properties
				console.error('Invalid server response:', responseData);
			}
			} else {
			// Server indicates failure with a non-successful status code
			console.error('Failed to save fax. Status:', response.status);
			// You can handle different status codes as needed
			// For example, if it's a validation error, show a different notification
			// Or if it's a server error, show an error message
			}
		} catch (error) {
			console.error('Error creating fax:', error);
		}
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
    // deleteSelectedFaxes() {
    //   // Add logic to delete selected faxes
    //   // Update the displayedFaxes text
    //   this.displayedFaxes = ''; // Update with your logic
    //   this.closeDeletePopup();
    // },
	deleteSelectedFaxes() {
		// Add logic to delete selected faxes
		console.log("Inside");
		const updatedFaxes = this.entity.receiving_faxes.filter(
		(fax) => !this.selectedFaxes.includes(fax.fax)
		);
		console.log("Deleted:",updatedFaxes);

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

	async fetchReceivingFaxes(){
			try
						{
							const url = "/client/receivingfaxlist";
								
								const response = await axios.get(url, {
								headers: {
									"Accept": "application/json",
									// You can add other headers here if needed
								},
								});
								
							console.log("receiving faxes listed :", response);
							// response.data.forEach((item)=>{
							// 	this.entity.receiving_emails.push(item.receiving_email);
							// });

							if (response.data && Array.isArray(response.data)) {
								// for (let i = 0; i < response.data.length; i++) {
								// 	const { email, description } = response.data[i];
        						// 	this.entity.receiving_emails.push({ email, description });
								// }
								this.$set(this.entity, 'receiving_faxes', response.data.map(item => ({ fax: item.fax, description: item.description })));
							}
							// Use nextTick to ensure the rendering has completed
							this.$nextTick(() => {
								console.log('receiving faxes =' , this.entity.receiving_faxes);
							});
							// console.log('receiving emails =' , this.entity.receiving_emails);
							
						}
					catch (error) 
					{
						console.error("Error fetching data:", error.message);
					}
		},
	async fetchReceivingEmails(){
			try
						{
							const url = "/client/receivingemaillist";
								
								const response = await axios.get(url, {
								headers: {
									"Accept": "application/json",
									// You can add other headers here if needed
								},
								});
								
							console.log("receiving emails listed :", response);
							// response.data.forEach((item)=>{
							// 	this.entity.receiving_emails.push(item.receiving_email);
							// });

							if (response.data && Array.isArray(response.data)) {
								// for (let i = 0; i < response.data.length; i++) {
								// 	const { email, description } = response.data[i];
        						// 	this.entity.receiving_emails.push({ email, description });
								// }
								this.$set(this.entity, 'receiving_emails', response.data.map(item => ({ email: item.email, description: item.description })));
							}
							// Use nextTick to ensure the rendering has completed
							this.$nextTick(() => {
								console.log('receiving emails =' , this.entity.receiving_emails);
							});
							// console.log('receiving emails =' , this.entity.receiving_emails);
							
						}
					catch (error) 
					{
						console.error("Error fetching data:", error.message);
					}
		},

	async addEmail() {
		const newEmail = { ...this.newEmail };
		const email = newEmail.email;
		const description = newEmail.description;
		// Clear the newEmail object for the next entry
		this.newEmail = { email: '', description: '' };

		// Check if the email is in a valid format
		const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

		if (!emailRegex.test(email)) {
			this.$bvToast.toast('Error: Please enter a valid email address.', {
				title: 'Error',
				variant: 'danger',
				solid: true,
				autoHideDelay: 5000, // milliseconds
		});
		return;
		}


		// Check if receiving_emails is defined, if not, initialize it as an empty array
		if (!Array.isArray(this.entity.receiving_emails)) {
			this.$set(this.entity, 'receiving_emails', []);
		}

		// // Check if the email already exists
		// if (this.entity.receiving_emails.some(existingEmail => existingEmail.email === email)) {
		//     alert('Email address already exists. Please enter a different email.');
		//     return;
		// }
		// Check if the email already exists
		if (this.entity.receiving_emails.some(existingEmail => existingEmail.email === email)) {
			this.$bvToast.toast('Error: Email address already exists. Please enter a different email.', {
				title: 'Error',
				variant: 'danger',
				solid: true,
				autoHideDelay: 5000, // milliseconds
			});
			return;
		}


		// Add the new email to the array
		this.entity.receiving_emails.push(newEmail);

		// Clear the newEmail object for the next entry
		this.newEmail = { email: '', description: '' };

		// Close the pop-up
		this.popupVisible = false;

		// Prepare the data to be sent in the POST request
		const emailData = {   
			email,
			description,
		};
		console.log("header:",emailData);
		try {
			// Make a POST request to store the data in the database
			const response = await axios.post('/client/receivingEmails', emailData);
			console.log('Axios Response:', response);
			await this.$nextTick();
			this.$emit("Receiving_emails", response);
			console.log("Emitted data:", response.data);
			// Check for a successful status code (2xx)
			if (response.status >= 200 && response.status < 300) {
			// Parse the JSON response
				const responseData = response.data;
				console.log("id",responseData.id);
				// Check if the expected properties are present
				if (responseData.email && responseData.description && responseData.id) 
				{
				// if (response.data.success) {
					console.log('Email saved successfully.');
					this.saving = false;
					// this.$router.push({ name: 'receivingEmails' });
					this.$nextTick(() => {
						this.$store.dispatch('notify', {
							variant: 'primary',
							title: 'Email Created!',
							message: 'New email created.',
						});
					});
					await this.updateReceivingMethods(responseData.id, null);

					// redirect_index();
				// } else {
				// 	this.saving = false;
				// 	// console.log('Email already exists');
				// 	this.errorMessage = response.data.message;
				// 	this.$nextTick(() => {
				// 		this.$store.dispatch('notify', {
				// 			variant: 'danger',
				// 			title: 'Email Error',
				// 			message: this.errorMessage,
				// 		});
				// 	});
				// }
			} else {
				// Server response is missing expected properties
				console.error('Invalid server response:', responseData);
			}
			} else {
			// Server indicates failure with a non-successful status code
			console.error('Failed to save email. Status:', response.status);
			// You can handle different status codes as needed
			// For example, if it's a validation error, show a different notification
			// Or if it's a server error, show an error message
			}
		} catch (error) {
			console.error('Error creating email:', error);
		}
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
    // deleteSelectedEmails() {
    //   // Add logic to delete selected emails
    //   // Update the displayedEmails text
    //   this.displayedEmails = ''; // Update with your logic
    //   this.closeDeletePopup();
    // },
	deleteSelectedEmails() {
		// Add logic to delete selected emails
		console.log("Inside");
		const updatedEmails = this.entity.receiving_emails.filter(
		(email) => !this.selectedEmails.includes(email.email)
		);
		console.log("Deleted:",updatedEmails);

		// Update the receiving_emails array with the updatedEmails
		this.entity.receiving_emails = updatedEmails;

		// Reset selectedEmails array
		this.selectedEmails = [];

		// Close the delete popup
		this.closeDeletePopup();
	},

	// 	async addReceivingEmail() {
    //     // Trim the entered email and check if it's not empty
    //     const trimmedEmail = this.entity.receiving_email.trim();
	// 	console.log("Email:",trimmedEmail);
    //     if (trimmedEmail !== '') {
	// 		// Ensure that receiving_emails is an array before pushing
	// 		if (!Array.isArray(this.entity.receiving_emails)) {
    //         this.$set(this.entity, 'receiving_emails', []);
    //     }

    //         // Push the trimmed email to the receiving_emails array
    //         this.entity.receiving_emails.push(trimmedEmail);

	// 		console.log("Array:",this.entity.receiving_emails);

	// 		// try {
    //         //     // Make Axios POST request to store the data in the database
    //         //     const response = await axios.post('/client/api/receivingEmails', {
    //         //         receivingEmails: this.entity.receiving_emails
    //         //     });

	// 		// 	response.log("API call:",response);

    //         //     // Assuming the server responds with the updated list of receiving emails
    //         //     this.receivingEmails = response.data.receivingEmails;

    //         // }
	// 		try {
	// 		const url = "/client/api/receivingEmails";
	// 		const data = {'receivingEmails':this.entity.receiving_emails}
	// 		console.log(data);
	// 		// const resp = await axios.post('/client/sendemail', data);
	// 		const response = await axios.post(url,data);
	// 		console.log("Response from API:", response.data);

	// 		}
	// 		 catch (error) {
    //             console.error('Error storing data:', error);
    //         }
    //         // Clear the input for the next entry
    //         this.entity.receiving_email = '';
    //     }
	// },
	// removeReceivingEmail(index) {
    //     // Remove the email at the specified index from the receiving_emails array
    //     this.entity.receiving_emails.splice(index, 1);
    // },
	// addReceivingFax() {
    //     // Trim the entered fax and check if it's not empty
    //     const trimmedFax = this.entity.receiving_fax.trim();
	// 	console.log("Fax:",trimmedFax);
    //     if (trimmedFax !== '') {
	// 		// Ensure that receiving_emails is an array before pushing
	// 		if (!Array.isArray(this.entity.receiving_faxes)) {
    //         this.$set(this.entity, 'receiving_faxes', []);
    //     }

    //         // Push the trimmed email to the receiving_emails array
    //         this.entity.receiving_faxes.push(trimmedFax);

	// 		console.log("Array:",this.entity.receiving_faxes);
    //         // Clear the input for the next entry
    //         this.entity.receiving_fax = '';
    //     }
	// },
	// removeReceivingFax(index) {
    //     // Remove the email at the specified index from the receiving_emails array
    //     this.entity.receiving_faxes.splice(index, 1);
    // },
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
		// filterChains(option, query) {
		// 	return option.toLowerCase().includes(query.toLowerCase());
		// },
		processAdditionalTaxonomies(jsonString) {
			// Check if jsonString is null or undefined
			if (jsonString === null || jsonString === undefined || jsonString === "NONE") {
			return '';  // or any default value you prefer
			}

			// Parse the JSON string into an array
			const taxonomiesArray = JSON.parse(jsonString);

			// Check if taxonomiesArray is an array
			if (!Array.isArray(taxonomiesArray)) {
			return '';  // or any default value you prefer
			}

			// Join the array elements into a string without quotes
			const formattedTaxonomies = taxonomiesArray.join(', ');

			return formattedTaxonomies;
		},
		filterChains() {
			// Wait for chains to be loaded
  			// await this.getChains();
			// Implement the logic to filter chains based on the search term
			// .trim().replace(/"/g,'')
			const searchTerm = this.searchChain ? this.searchChain.toLowerCase() : '';
			console.log("Search:",searchTerm);
			console.log("chains:",records);
			// console.log("Check", this.entity.chains);

			// Filter chains, excluding the ones already selected
			this.filteredChains = records.value.filter((chain) =>
			chain.chain_name.trim().replace(/"/g,'').toLowerCase().includes(searchTerm) 
			// && chain.chain_name.length <= maxLength
			// !this.selectedChains.some(selected => selected.id === chain.id) &&
			// !this.filteredChains.some(filtered => filtered.id === chain.id)
    		);
			console.log("Filtered:",this.filteredChains);

			},
		selectChain(chain) {
			// Set the selected chain
			// this.selectedChain = chain.chain_name;
			// console.log("Selected Chain:",this.selectedChain);
			// this.entity.chain_name = chain.chain_name;
			// console.log(" chain_name:",this.entity.chain_name);

			// // Clear the search term and filtered chains
			// this.searchChain = '';
			// this.filteredChains = [];


			this.searchChain = chain.chain_name;
			this.entity.chain_name = chain.chain_name;
        	this.filteredChains = [];
			},

	filterServices() {
			// Implement the logic to filter services based on the search term
			const searchTerm = this.searchQuery ? this.searchQuery.toLowerCase() : '';
			console.log("Search:",searchTerm);
			console.log("services:",this.services);
			console.log("Check", this.entity.services);

			// this.filteredServices = this.services.filter((service) =>
			// 	service.name.toLowerCase().includes(searchTerm)
			// );

			// // Filter services, excluding the ones already selected
			// this.filteredServices = this.services.filter((service) =>
			// 	service.name.toLowerCase().includes(searchTerm) && !this.selectedServices.some(selected => selected.id === service.id)
			// );
			// Filter services, excluding the ones already selected
			this.filteredServices = this.services.filter((service) =>
			service.name.toLowerCase().includes(searchTerm) &&
			!this.selectedServices.some(selected => selected.id === service.id) &&
			!this.filteredServices.some(filtered => filtered.id === service.id)
    		);
			console.log("Filtered:",this.filteredServices);

			},
		// 	deselectChain() {
		// 	// Clear the selected chain
		// 	this.selectedChain = null;

		// 	// Clear or update this.entity.chain_name as needed
		// 	this.entity.chain_name = '';
		// },

	async selectService(selectedService) {
			// console.log('Selected Service:', selectedService);
			// Check if the service ID is not already selected
			// if (!this.entity.services._ids.includes(selectedService.id)) {
			// 	// Push the selected service ID to the array
			// 	this.entity.services._ids.push(selectedService.id);
			// }

			// const url = "/client/api/serviceList";
				
			// 	const response = await axios.get(url, {
			// 	headers: {
			// 		"Accept": "application/json",
			// 		// You can add other headers here if needed
			// 	},
			// 	});

			// console.log("Response from API:", response);
			// // Check if the selected service is not already in the response data
			// const serviceInResponse = response.data.find(service => service.service_id === selectedService.id);

			if (!this.selectedServices.some(service => service.id === selectedService.id)) {
			// if (serviceInResponse && !this.selectedServices.some(service => service.id === selectedService.id)) {
				// Push the selected facility to the array
				this.selectedServices.push(selectedService);

				// // Save the updated selected services for the specific facility to localStorage
				// const facilityId = this.entity.id;
    			// localStorage.setItem(`selectedServices_${facilityId}`, JSON.stringify(this.selectedServices));
				
				console.log("selected array:",this.selectedServices);
				this.entity.services.push(selectedService);
				console.log("pushed:",this.entity.services);
			}
			const facilityId = this.entity.id;

			try {
			const url = "/client/api/serviceList";
			const response = await axios.get(url, {
				headers: {
				"Accept": "application/json",
				},
			});

			console.log("Response from API:", response.data);

			response.data.facilityservices.forEach((item, index) => {
    		console.log(`Element at index ${index}:`, item);

			if (item.facility_id == facilityId) {
				console.log("match found =", item.service_id);

				response.data.services.forEach((i, index) => {
					console.log(`service at index ${index}:`, i);
					if (i.id == item.service_id) {
						console.log("service found =", i.name);
						// Check if the service is not already in selectedServices before pushing
						if (!this.selectedServices.some(service => service.id === i.id)) {
							this.selectedServices.push(i);
							console.log("output", this.selectedServices);
                }
					}
				});
			}
		});

			// response.data.facilityservices.forEach((item, index) => {
			// 	console.log(`Element at index ${index}:`, item);
			// 	if(item.facility_id == facilityId){
			// 		console.log("match found = ", item.service_id);
			// 		response.data.services.foreach((i,index)=> {
			// 			if(i.service_id == item.service_id){
			// 				this.selectedServices.push(i.name);
			// 				console.log("output", this.selectedServices);
			// 			}
			// 		});

			// 		// this.selectedServices.push(item.service_id);
			// 		// console.log("output", this.selectedServices);
			// 	}
			// 	});
				// console.log("thiss insurance provider id", insid);

			// Filter services for the specific facility
			// const servicesForFacility = response.data.filter(service => service.facility_id === facilityId);
			// const servicesForFacility = response.data.filter(entry => entry.facility_id === facilityId).map(entry => entry.service_id);
			// console.log("from db:",servicesForFacility)

			// // Set the filtered services to the selectedServices array
			// this.selectedServices = servicesForFacility;

			// console.log("Services for Facility:", this.selectedServices);
			} catch (error) {
			console.error("Error fetching services:", error);
			}

			// Clear the search term and filtered services
			this.searchQuery = '';
			// this.filteredServices = [];
			 // Update the filtered services, excluding the selected service
  			// this.filteredServices = this.filteredServices.filter(service => service.id !== selectedService.id);
			// Update the filtered services, excluding all selected services
			this.filteredServices = this.filteredServices.filter(service => !this.selectedServices.some(selected => selected.id === service.id));

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
			//  this.availableServices = this.services; // Initialize availableServices with all services
		},
		// async getChains() {
		// 	await this.$store.dispatch("chains/getAll");
		// },
		// async getChains() {
		// 	console.log("Fetching chains...");
		// 	// await this.$store.dispatch("chains/get");
		// 	const facilityId = this.entity.id;
		// 	await axios.get('/client/api/chainList')
		// 	.then(response => {
		// 		console.log("Response:",response.data);
		// 	// // response data stored in records attribute to render as list
		// 	// records.value = response.data;
		// 		response.data.facilityChains.forEach((item, index) => {
		// 		// console.log(`Element at index ${index}:`, item);

		// 		if (item.facility_id == facilityId) {
		// 			console.log("match found =", item.chain_id);
		// 			console.log("log =", response.data.chains);

		// 			response.data.chains.forEach((i, index) => {
		// 				console.log(`chain at index ${index}:`, i);
		// 				if (i.id == item.chain_id) {
		// 					console.log("Item found =", i.chain_name);
		// 					// Check if the service is not already in selectedServices before pushing
		// 					// if (!this.selectedServices.some(service => service.id === i.id)) {
		// 						// this.selectedServices.push(i);
		// 						this.selectedChain = i.chain_name;
		// 						console.log("output", this.selectedChain);
		// 						// response data stored in records attribute to render as list
		// 						records.value = response.data.chains;
		// 						// }
		// 				}
		// 			});
		// 		}
		// 	});
		// 	})
		// 	.catch(error => {
		// 		console.error(error);
		// 	})
		// 	.finally(() => {
		// 		this.saving = false;
		// 	});
		// 	console.log("Chains fetched successfully.");
		// 	},
		async getChains() {
			console.log("Fetching chains...");
			// await this.$store.dispatch("chains/get");
			await axios.get('/client/getChains')
			.then(response => {
				console.log("Response:",response.data);
			// response data stored in records attribute to render as list
			records.value = response.data;
			})
			.catch(error => {
				console.error(error);
			})
			.finally(() => {
				this.saving = false;
			});
			console.log("Chains fetched successfully.");
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
				// this.entity.services = {
				// 	_ids: response.services.map((service) => service.id),
				// };
				this.service_ids = response.services.map((service) => service.id);
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
			// console.log("Check:",JSON.stringify(this.insuranceRates));
			try {
				this.saving = true;
				const response = await this.$store.dispatch("facilities/save", this.entity);
				await this.addPricingSchedule(response.id);
				// const response = await save({
				// 	...this.entity,
				// 	services: {
				// 		_ids: this.service_ids,
				// 	},
				// });
				console.log("saved:", response);


				this.$emit("saved", response);
				this.$emit("update:id", response.id);

				this.$store.dispatch("facilities/getAll");
				this.$store.dispatch("facilities/getActive");
				const responsed = await axios.post('/client/facilityAddForms/edit', this.forms);
        		console.log('saving Response:', responsed);
                console.log('Data saved successfully');
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
			this.entity.othername=result.other_names.length > 0 ? `${result.other_names[0].organization_name ?? ""}`: "NONE";
			this.entity.organizational_subpart= result.organizational_subpart;

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
		createNewForm() {
			const newForm = {
			
			f_name: null,
			l_name: null,
			title_id: null,
			contact_id: null,
			phone_no: null,
			facility_name:this.entity.name
			// ... other form fields ...
			
			// ... other form-specific data ...
			};
			// Push an empty object to the forms array
			this.forms.push(newForm);
			console.log("my form :",this.forms);
        },
		async TitleShow (){
			try {
					const url = "/client/facilityTitle";
						
						const response = await axios.get(url, {
						headers: {
							"Accept": "application/json",
							// You can add other headers here if needed
						},
						
						});
						console.log("check =",response.data);
					
					if (response.data && Array.isArray(response.data)) {
							for (let i = 0; i < response.data.length; i++) {
							this.titlename.push(response.data[i].title);
							}
						}
							console.log("Titlename:", this.titlename);
				}catch (error) {
					console.error("Error fetching data:", error.message);
					}
		},
		
		async fetchContactTypes(){
				try
					{
						const url = "/client/facilityTitle";
							
							const response = await axios.get(url, {
							headers: {
								"Accept": "application/json",
								// You can add other headers here if needed
							},
							});
							if (response.data && Array.isArray(response.data)) {
								for (let i = 0; i < response.data.length; i++) {
								this.contactTypes.push(response.data[i].contact_type);
								}
							}
							console.log("contacttype:", this.contactTypes);
					}
				catch (error) 
				{
					console.error("Error fetching data:", error.message);
				}
			},
	
		async listFacilityContacts(){
			try
						{
							const url = "/client/facilityContactList";
								
								const response = await axios.get(url, {
								headers: {
									"Accept": "application/json",
									// You can add other headers here if needed
								},
								});
								if (response.data && Array.isArray(response.data)) {
									response.data.forEach((item)=>{
										if(item.facility_id == this.entity.id){
											this.forms.push(item);
										}

									});
								}
							console.log("contact listed :", this.forms);
						}
					catch (error) 
					{
						console.error("Error fetching data:", error.message);
					}
		},
		async fetchFacilityStatus(){
			try
						{
							const url = "/client/facilitystatuslist";
								
								const response = await axios.get(url, {
								headers: {
									"Accept": "application/json",
									// You can add other headers here if needed
								},
								});
								
							console.log("facility statuses listed :", response);
							response.data.forEach((item)=>{
								this.facilityStatus.push(item.status);
							});
							console.log('status option =' , this.facilityStatus);
						}
					catch (error) 
					{
						console.error("Error fetching data:", error.message);
					}
		},
		async fetchFacilityBillType(){
			try
						{
							const url = "/client/facilitybilltypelist";
								
								const response = await axios.get(url, {
								headers: {
									"Accept": "application/json",
									// You can add other headers here if needed
								},
								});
								
							console.log("facility bill type listed :", response);
							response.data.forEach((item)=>{
								this.billTypeOptions.push(item.bill_type);
							});
							console.log('bill type options =' , this.billTypeOptions);
						}
					catch (error) 
					{
						console.error("Error fetching data:", error.message);
					}
		},
},
};
</script>
<style scoped>

.small-empty-result {
    height: 50px; /* Adjust the height as needed */
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
  }

  .small-empty-result span {
    font-size: 12px; /* Adjust the font size as needed */
    margin-top: 5px; /* Add margin as needed */
  }

.custom-modal .modal-footer {
    display: none;
  }
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


