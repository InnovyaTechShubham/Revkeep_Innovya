<template>
	<loading-indicator v-if="loading" class="my-5" />
	<validation-observer v-else v-bind="$attrs" ref="observer" v-slot="{ invalid }">
		<b-form @submit.prevent="save">
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
							:disabled="saving"
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
						<b-form-group label="Address" label-for="street_address_1" label-cols-lg="4">
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
											v-model="entity.contractDetails.original_start_date"
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

					<validation-provider vid="active" name="Active" :rules="{ required: false }" v-slot="validationContext">
						<b-form-group label="Facility Status" label-for="active" label-cols-lg="4">
							<b-form-select v-model="entity.facility_status" :options="facilityStatus" :disabled="saving"></b-form-select>
							<b-form-invalid-feedback v-for="error in validationContext.errors" :key="error" v-text="error" />
						</b-form-group>
					</validation-provider>


					<b-form-group label="Bill Type" label-for="bill_type" label-cols-lg="4">
							<b-form-select name="bill_type" v-model="entity.bill_type" :options="billTypeOptions" value-field="abbreviation" text-field="name" :disabled="saving">
								<!-- <template #first>
									<option :value="null" /> -->
								<!-- </template> -->
							</b-form-select>
					</b-form-group>

					<b-form-group label="Chain" label-for="chain_name" label-cols-lg="4">
								<b-input-group>
									<b-form-input type="text" name="chain_name" v-model="searchChain"
										:disabled="saving"
										placeholder="Search for a Chain..." @input="filterChains" />
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

						<validation-provider vid="term_date" name="Term Date" :rules="{ required: false }" v-slot="validationContext">
						<b-form-group label="Term Date" label-for="term_date" label-cols-lg="4">
							<b-form-input
							type="date"
							v-model="entity.contractDetails.term_date"
							name="term_date"
							:disabled="saving"
							:state="getValidationState(validationContext)"
							:style="{ color: entity.facility_status === 'Inactive' ? 'red' : 'inherit' }"
							/>
							<b-form-invalid-feedback v-for="error in validationContext.errors" :key="error" v-text="error" />
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
									:checked="entity.has_contract"
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
					</b-col>
					</b-row>
							

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
							<validation-provider vid="region" name="Region" :rules="{ required: false, max: 60 }" v-slot="validationContext">
									<b-form-group label="Region" label-for="region" label-cols-lg="2">
										<b-form-input name="region" type="text" v-model="entity.region" :state="getValidationState(validationContext)" :disabled="saving" />
										<b-form-invalid-feedback v-for="error in validationContext.errors" :key="error" v-text="error" />
									</b-form-group>
							</validation-provider>

							<b-row>
							<!-- First Column -->
							<b-col md="6">
								<validation-provider vid="territory" name="Territory" :rules="{ required: false, max: 60 }" v-slot="validationContext">
										<b-form-group label="Territory" label-for="territory" label-cols-lg="4">
											<b-form-input name="territory" type="text" v-model="entity.territory" :state="getValidationState(validationContext)" :disabled="saving" />
											<b-form-invalid-feedback v-for="error in validationContext.errors" :key="error" v-text="error" />
										</b-form-group>
								</validation-provider>


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
									
									<!-- Territory
									<validation-provider vid="territory" name="Territory" :rules="{ required: false, max: 60 }" v-slot="validationContext">
									<b-form-group label="Territory" label-for="territory" label-cols-lg="4">
										<b-form-input name="territory" type="text" v-model="entity.territory" :state="getValidationState(validationContext)" :disabled="saving" />
										<b-form-invalid-feedback v-for="error in validationContext.errors" :key="error" v-text="error" />
									</b-form-group>
									</validation-provider> -->

									<!-- Area -->
									<validation-provider vid="area_name" name="Area" :rules="{ required: false, max: 60 }" v-slot="validationContext">
									<b-form-group label="Area" label-for="area_name" label-cols-lg="4">
										<b-form-input name="area_name" type="text" v-model="entity.area_name" :state="getValidationState(validationContext)" :disabled="saving" />
										<b-form-invalid-feedback v-for="error in validationContext.errors" :key="error" v-text="error" />
									</b-form-group>
									</validation-provider>

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
							<p class="font-weight-bold">No of Bed</p>
                                <b-row>
                                    <!-- Skilled Field -->
                                      <b-col md="3">
                                          <validation-provider vid="skilled" name="Skilled" :rules="{ required: false, max: 60 }" v-slot="validationContext">
                                              <b-form-group label="Skilled" label-for="skilled" label-cols-lg="4">
                                                  <b-form-input name="skilled" type="text" v-model="entity.skilled" :state="getValidationState(validationContext)" :disabled="saving" />
                                                  <b-form-invalid-feedback v-for="error in validationContext.errors" :key="error" v-text="error" />
                                              </b-form-group>
                                          </validation-provider>
                                      </b-col>
 
                                     <!-- LTC Field -->
                                     <b-col md="3">
                                         <validation-provider vid="ltc" name="LTC" :rules="{ required: false, max: 60 }" v-slot="validationContext">
                                             <b-form-group label="LTC" label-for="ltc" label-cols-lg="4">
                                                 <b-form-input name="ltc" type="text" v-model="entity.ltc" :state="getValidationState(validationContext)" :disabled="saving" />
                                                 <b-form-invalid-feedback v-for="error in validationContext.errors" :key="error" v-text="error" />
                                             </b-form-group>
                                         </validation-provider>
                                     </b-col>
 
                                     <!-- AI Field -->
                                     <b-col md="3">
                                         <validation-provider vid="ai" name="AI" :rules="{ required: false, max: 60 }" v-slot="validationContext">
                                             <b-form-group label="AI" label-for="ai" label-cols-lg="4">
                                                 <b-form-input name="ai" type="text" v-model="entity.ai" :state="getValidationState(validationContext)" :disabled="saving" />
                                                 <b-form-invalid-feedback v-for="error in validationContext.errors" :key="error" v-text="error" />
                                             </b-form-group>
                                         </validation-provider>
                                     </b-col>
 
                                     <!-- IL Field -->
                                     <b-col md="3">
                                         <validation-provider vid="il" name="IL" :rules="{ required: false, max: 60 }" v-slot="validationContext">
                                             <b-form-group label="IL" label-for="il" label-cols-lg="4">
                                                 <b-form-input name="il" type="text" v-model="entity.il" :state="getValidationState(validationContext)" :disabled="saving" />
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
								<b-row>
								<!-- First Column -->
								<b-col md="6">
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
									
								</b-col>

								<!-- Second Column -->
								<b-col md="6">
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
								</b-col>
								</b-row>

								<b-input-group-append>
									<b-button variant="primary" class="mb-1" @click="createNewForm">
									   <font-awesome-icon icon="plus" fixed-width />
									   <span>Add Contacts</span>
									</b-button>
								  </b-input-group-append>

								  <form v-for="(form, index) in forms" :key="`form-${index}`" class="mb-2">
									<b-card body>
										<b-row>
											<!-- First Column -->
											<b-col md="4">
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
												
													
												<validation-provider vid="phone" name="Phone" :rules="{ required: false }" v-slot="validationContext">
																<div class="d-flex align-items-end">
																	<b-form-group label="Contact Number Type" label-for="type" label-cols-lg="4">
																	<!-- Dropdown (select) field -->
																	<b-input-group class="mb-3">
																		<label :for="'contacType' + index"></label>
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
																	</b-form-group>
																</div>
																</validation-provider>

															</b-col>

															<!-- Second Column -->
															<b-col md="4">
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

															<validation-provider vid="phone" name="Phone" :rules="{ required: false }" v-slot="validationContext">
																<div class="mb-3 d-flex align-items-end">
																	<label :for="'phone' + index" class="mr-2" label-cols-lg="4">Contact Number</label>
																	<b-input-group style="width: 100%;">
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
																</div>
															</validation-provider>





																</b-col>
																<!-- Third Column -->
																<b-col md="4">
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
																</b-col>

														</b-row>
											
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
										<b-form-checkbox name="active" v-model="entity.contractDetails.contract_status" :disabled="saving"
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
									vid="contract_end_date"
									name="Contract End Date"
									:rules="{ required: false }"
									v-slot="validationContext"
								>
									<b-form-group label="Expiration Date" label-for="contract_end_date" label-cols-lg="4">
										<b-form-input
											type="date"
											v-model="entity.contractDetails.contract_end_date"
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

								

							</b-col>

							<!-- Second Column -->
							<b-col md="6">
								<validation-provider
									vid="contract_start_date"
									name="Contract Start Date"
									:rules="{ required: false }"
									v-slot="validationContext"
								>
									<b-form-group label="Contract Effective Date" label-for="contract_start_date" label-cols-lg="4">
										<b-form-input
											type="date"
											v-model="entity.contractDetails.contract_start_date"
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
									vid="renewal_date"
									name="Renewal Date"
									:rules="{ required: false }"
									v-slot="validationContext"
								>
									<b-form-group label="Renewal Date" label-for="renewal_date" label-cols-lg="4">
										<b-form-input
											type="date"
											v-model="entity.contractDetails.renewal_date"
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
											v-model="entity.contractDetails.contract_bill_type"
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
												v-model="entity.contractDetails.indemnification_days"
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
											v-model="entity.contractDetails.contract_type"
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
												v-model="entity.contractDetails.max_return_work_days"
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
									v-model="entity.contractDetails.serviceOperation"
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
										<b-input-group-append>
											<b-input-group-text>
												<font-awesome-icon icon="search" fixed-width />
											</b-input-group-text>
										</b-input-group-append>
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
														<b-form-checkbox v-model="selectedEmails" :value="info.item" class="mr-2" />
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
														<b-form-checkbox v-model="entity.selectedFaxes" :value="info.item" :key="info.item.fax" class="mr-2" />
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
import { mapGetters } from "vuex";
import { formatErrors, getValidationState } from "@/validation";
import axios from "axios";
import { ref} from "vue";
// get All record
const records = ref([]);

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
				facility_status:null,
				internal_owner:null,
				bill_type:null,
				skilled: null,
                ltc: null,
                ai: null,
                il: null,
				contractDetails: {
					// facility_id: this.id,
					original_start_date: null,
					term_date: null,
					contract_status:true,
					contract_end_date: null,
					contract_start_date: null,
					renewal_date: null,
					indemnification_days: null,
					max_return_work_days: null,
					serviceOperation: null,
					contract_bill_type: null,
					contract_type: null,
					ownership_type: null,
					newSchedule: {
						ins_id: '',
						rate: '',
						facility_id: ''
					},
					
    },
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
			//contract
			pricing_schedules: [],
			serviceOperationsOptions: [],
			contractBillTypes: [],
			contractTypes: [],
			ownershipTypes: [],
			insurances: [],
			insuranceRates: {},
			selectedInsuranceId: null,
			contract_insurance_type: null,
			// end contract
			facilityTypes:[],
   
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
	computed: mapGetters({
		states: "states/states",
		// facilityTypes: "facilityTypes/all",
		// loadingFacilityTypes: "facilityTypes/loadingAll",
		services: "services/all",
		loadingServices: "services/loadingAll",
	}),
	mounted() {
		this.getChains();
		this.getServices();
		this.TitleShow();
        this.fetchContactTypes();
		this.fetchFacilityStatus();
		this.fetchFacilityBillType();
		this.fetchContractBillTypes();
		this.fetchContractTypes();
		this.fetchOwnershipTypes();
		this.fetchServiceOperations();
		this.fetchInsurances();
		this.fetchReceivingEmails();
		this.fetchReceivingFaxes();
		this.fetchFacilityType();


		if (this.id) {
			this.refresh();
		} else {
			this.loading = false;
		}
	},
	
	methods: 
	{
		async saveContract() {
			try {
				const apiUrl = '/client/facilitiescontracts';

				// Extract contract-related data from entity
				const contractData = this.entity.contractDetails;

				// Make the API call with the extracted data
				const response = await axios.post(apiUrl, contractData);

				// Handle success response if needed
				console.log('Facilities Contract saved successfully:', response.data);

				// Optionally notify the user or perform other actions
			} catch (error) {
				// Handle error
				console.error('Error saving Facilities Contract:', error);

				// Optionally notify the user or perform other error handling actions
			}
		},
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
								
							console.log("facility type listed :", response);
							response.data.forEach((item)=>{
								this.facilityTypes.push(item.name);
							});
							console.log('facility type options =' , this.facilityTypes);
						}
					catch (error) 
					{
						console.error("Error fetching data:", error.message);
					}
		},
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
							rate: this.entity.rate || '',
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
	async updateReceivingMethods(receivingEmailId, receivingFaxId) {
			const facilityId = this.entity.id;

			// Determine if receivingEmailId or receivingFaxId is provided
			const data = {
				facility_id: facilityId,
				receiving_email_id: receivingEmailId || null,
				receiving_fax_id: receivingFaxId || null,
			};
			console.log("Payload",data);

			try {
				const response = await axios.post('/client/receivingMethods', data, {
					headers: {
						'Content-Type': 'application/json',
					},
				});
				console.log('Receiving methods updated:', response.data);
			} catch (error) {
				console.error('Error updating receiving methods:', error);
			}
	},
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
	async addFax() {
    try {
        const newFax = { ...this.newFax };
        console.log("new:", newFax);
		const fax = newFax.fax;
		const description = newFax.description;
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
        if (this.entity.receiving_faxes.some(existingFax => existingFax.fax === newFax.fax)) {
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
        const faxData = {
            fax,
            description,
        };
        console.log("header:", faxData);

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
      this.entity.selectedFaxes = [];
    },
	deleteSelectedFaxes() {
			console.log("Inside",this.entity.selectedFaxes);

			// const selectedFaxesList = { ...this.entity.selectedFaxes };

			// Check if selectedFaxes is defined, if not, initialize it as an empty array
			if (!Array.isArray(this.entity.selectedFaxes)) {
					this.$set(this.entity, 'selectedFaxes', []);
				}
			console.log("selectedfaxes",this.entity.selectedFaxes);
			

			// Iterate through selectedFaxes and delete each fax
			this.entity.selectedFaxes.forEach((selectedFax) => {
				const apiUrl = `/client/api/deletereceivingfax/${selectedFax.id}`;

				axios.post(apiUrl)
					.then(response => {
						// Handle success response if needed
						console.log(`Fax with ID ${selectedFax.id} deleted successfully:`, response.data);
					})
					.catch(error => {
						// Handle error
						console.error(`Error deleting fax with ID ${selectedFax.id}:`, error);
					});
			});

			// Update the receiving_faxes array and reset selectedFaxes array
			this.entity.receiving_faxes = this.entity.receiving_faxes.filter(
				(fax) => !this.entity.selectedFaxes.includes(fax)
			);
			// this.entity.selectedFaxes = [];
			this.entity.selectedFaxes.push(...this.entity.selectedFaxes);

			 // Log the updated state of selectedFaxes
			 console.log("selectedfaxes after deletion", this.entity.selectedFaxes);

			// Close the delete popup or perform any other actions
			this.closeDeleteFaxPopup();
		},

// 	deleteSelectedFaxes() {
//     // Add logic to delete selected faxes
//     console.log("Inside");
//     const updatedFaxes = this.entity.receiving_faxes.filter(
//         (fax) => !this.selectedFaxes.includes(fax.fax)
//     );
//     console.log("Deleted:", updatedFaxes);

//     // Update the receiving_faxes array with the updatedFaxes
//     this.entity.receiving_faxes = updatedFaxes;

//     // Reset selectedFaxes array
//     this.selectedFaxes = [];
	
// 	console.log("ID",updatedFaxes[0].id)
//     // Make Axios call to delete faxes from the database
//     const apiUrl = `/client/api/deletereceivingfax/${updatedFaxes[0].id}`; 
// 	console.log("API check",apiUrl)
//     axios.post(apiUrl)
//         .then(response => {
//             // Handle success response if needed
//             console.log('Faxes deleted successfully:', response.data);
//         })
//         .catch(error => {
//             // Handle error
//             console.error('Error deleting faxes:', error);
//         })
//         .finally(() => {
//             // Close the delete popup or perform any other actions
//             this.closeDeleteFaxPopup();
//         });
// },
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
							this.$set(this.entity, 'receiving_faxes', response.data.map(item => ({  id:item.id,fax: item.fax, description: item.description })));
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
							

							if (response.data && Array.isArray(response.data)) {
								
								this.$set(this.entity, 'receiving_emails', response.data.map(item => ({ id:item.id,email: item.email, description: item.description })));
							}
							// Use nextTick to ensure the rendering has completed
							this.$nextTick(() => {
								console.log('receiving emails =' , this.entity.receiving_emails);
							});
							
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
					await this.updateReceivingMethods(responseData.id, null);
					this.$nextTick(() => {
						this.$store.dispatch('notify', {
							variant: 'primary',
							title: 'Email Created!',
							message: 'New email created.',
						});
					});
					
			} else {
				// Server response is missing expected properties
				console.error('Invalid server response:', responseData);
			}
			} else {
			// Server indicates failure with a non-successful status code
			console.error('Failed to save email. Status:', response.status);
			
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

	async deleteSelectedEmails() {
    console.log("Inside", this.entity.receiving_emails);
    console.log("Selected", this.selectedEmails);

    let updatedEmails = null;

    try {
        // Iterate over selected emails and delete them
        for (const email of this.selectedEmails) {
            const apiUrl = `/client/deletereceivingemail/${email.id}`;
            await axios.delete(apiUrl);
        }

        // Filter out the selected emails from the entity's receiving_emails
        const updatedEmails = this.entity.receiving_emails.filter(
            (email) => !this.selectedEmails.some(selectedEmail => selectedEmail.id === email.id)
        );

        // Wait for the next DOM update before emitting the event
        await this.$nextTick();

        // Emit event to notify about the deletion and pass the updated emails
        this.$emit("Receiving_emails", updatedEmails);

        // Show notification for successful deletion
        this.$nextTick(() => {
            this.$store.dispatch('notify', {
                variant: 'success',
                title: 'Emails Deleted!',
                message: 'Selected emails deleted successfully.',
            });
        });

        // Log success message
        console.log('Emails deleted successfully');
    } catch (error) {
        // Handle error
        console.error('Error deleting emails:', error);

        // Show notification for deletion error
        this.$nextTick(() => {
            this.$store.dispatch('notify', {
                variant: 'danger',
                title: 'Error Deleting Emails',
                message: 'An error occurred while deleting emails.',
            });
        });
    } finally {
        // Close the delete popup or perform any other actions
        this.closeDeletePopup();
    }

    // Update the receiving_emails array with the updatedEmails
    this.entity.receiving_emails = updatedEmails;

    // Reset selectedEmails array
    this.selectedEmails = [];
},

    
	// async deleteSelectedEmails() {
	// 	// Add logic to delete selected emails
	// 	console.log("Inside",this.entity.receiving_emails);
	// 	// Create a unique identifier for each email based on email and description
	// 	// const uniqueIdentifier = (email) => `${email.email}_${email.description}`;
	// 	console.log("Selected",this.selectedEmails);
	// 	const updatedEmails = this.entity.receiving_emails.filter(
	// 	(email) => !this.selectedEmails.includes(email.email)
	// 	);
		

	// 	 // Make Axios call to delete emails from the database
	// 	const apiUrl = `/client/deletereceivingemail/`;
    // 	await axios.post(apiUrl, { selectedEmails: this.selectedEmails })
    //     .then(response => {
    //         // Handle success response if needed
    //         console.log('Emails deleted successfully:', response.data);
    //     })
    //     .catch(error => {
    //         // Handle error
    //         console.error('Error deleting emails:', error);
    //     })
    //     .finally(() => {
    //         // Close the delete popup or perform any other actions
    //         this.closeDeletePopup();
    //     });

	// 	console.log("Updated:",updatedEmails);

	// 	// Update the receiving_emails array with the updatedEmails
	// 	this.entity.receiving_emails = updatedEmails;

	// 	// Reset selectedEmails array
	// 	this.selectedEmails = [];
	// },
		
		filterChains() {
			const searchTerm = this.searchChain ? this.searchChain.toLowerCase() : '';
			console.log("Search:",searchTerm);
			console.log("chains:",records);

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
			this.searchChain = chain.chain_name;
			this.entity.chain_name = chain.chain_name;
        	this.filteredChains = [];
			},
		
		filterServices() {
			// Implement the logic to filter services based on the search term
			const searchTerm = this.searchQuery ? this.searchQuery.toLowerCase() : '';
			console.log("Search:",searchTerm);
			console.log("services:",this.services);


			// Filter services, excluding the ones already selected
			this.filteredServices = this.services.filter((service) =>
				service.name.toLowerCase().includes(searchTerm) && !this.selectedServices.some(selected => selected.id === service.id)&&
				!this.filteredServices.some(filtered => filtered.id === service.id)
			);
			console.log("Filtered:",this.filteredServices);

			},

		
		async selectService(selectedService) {
			
			if (!this.selectedServices.some(service => service.id === selectedService.id)) {
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
		} catch (error) {
			console.error("Error fetching services:", error);
			}

			// Clear the search term and filtered services
			this.searchQuery = '';
			
			// Update the filtered services, excluding all selected services
			this.filteredServices = this.filteredServices.filter(service => !this.selectedServices.some(selected => selected.id === service.id));

		},
		deselectService(selectedService) {
			// Remove the selected facility from the array
			this.selectedServices = this.selectedServices.filter(service => service.id !== selectedService.id);
		},

		getValidationState,
		async getServices() {
			await this.$store.dispatch("services/getAll");
		},
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

		async save() {
			this.entity.name = this.entity.display_name;
			try {
				this.saving = true;
				const response = await this.$store.dispatch("facilities/save", this.entity);

				this.$emit("saved", response);
				this.$emit("update:id", response.id);

				this.$store.dispatch("facilities/getAll");
				this.$store.dispatch("facilities/getActive");
                  
				console.log("post data :", this.forms);
				// await axios.post('/client/facilityAddForms', this.forms );
				try{
				const responsed = await axios.post('/client/facilityAddForms', this.forms);
        		console.log('saving Response:', responsed);
                console.log('Data saved successfully');
				}catch(err){
					console.log('An error occured while saving the form data: ', err);
				}

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

	async fetchContactTypes() {
				try{
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
			}catch (error) {
				console.error("Error fetching data:", error.message);
				}
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

        createNewForm() {
			const newForm = {
			
			f_name: null,
			l_name: null,
			title_id: null,
			contact_id: null,
			phone_no: null,

			facility_name:this.entity.name

			
			};
			// Push an empty object to the forms array
			this.forms.push(newForm);
			console.log("my form :",this.forms);
        },
      removeForm(index) {
        // Remove the form at the specified index
        this.forms.splice(index, 1);
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
							console.log('status options =' , this.facilityStatus);
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
