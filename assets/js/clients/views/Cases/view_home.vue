<template>
	<b-container fluid class="mb-4">
		<b-row class="my-4">
			<b-col cols="4" xl="8" class="text-left">
				<b-button @click="showDetails = !showDetails" variant="secondary">
					<span v-if="showDetails">Hide Details</span>
					<span v-else>Show Details</span>
				</b-button>
				<b-button @click="showLoveMessage = !showLoveMessage" variant="secondary">
					<span v-if="showLoveMessage">Hide Data</span>
					<span v-else>Show Data</span>
				</b-button>
			</b-col>
		
			<b-col cols="8" xl="4" class="text-right">
				<case-assign :case-entity="caseEntity" />
			</b-col>
		</b-row>
		<div>
			<b-collapse v-model="showLoveMessage">
			  <b-container fluid class="bv-example-row">
				<!-- table for service claim information -->
				<template>
					<div >
						<b-table responsive striped hover :items="items"></b-table>
					</div>
				</template>
				<hr>
			    <b-row>
				<b-col>
				  <div class="info-box">
					<!-- patient information -->
					<b-row style="margin-bottom: 20px;padding-right: 50px;">
							<b-col cols="12">
								<div>
									<b-nav tabs>
										<b-nav-item active><h6>Patient Information</h6></b-nav-item>
									</b-nav>
								</div>
							</b-col>
						</b-row>
					    <b-row class="content-margin">
						    <b-col cols="6.5" >Identifier Code  &nbsp;  &nbsp;</b-col> 
						    <b-col cols="5.5" ><p class="value-box">QC</p></b-col>
					    </b-row>
					    <b-row class="content-margin">
						    <b-col cols="6.5" >First Name  &nbsp;  &nbsp;</b-col> 
						    <b-col cols="5.5" ><p class="value-box">RAYMOND</p></b-col>
					    </b-row>
					    <b-row class="content-margin">
						    <b-col cols="6.5" >Middle Name  &nbsp;  &nbsp;</b-col> 
						    <b-col cols="5.5" ><p class="value-box">W</p></b-col>
					    </b-row>
					    <b-row class="content-margin">
						    <b-col cols="6.5" >Last Name  &nbsp;  &nbsp;</b-col> 
						    <b-col cols="5.5" ><p class="value-box">BURCK</p></b-col>
					    </b-row>
					    <b-row class="content-margin">
						    <b-col cols="6.5" >Contact Number  &nbsp;  &nbsp;</b-col> 
						    <b-col cols="5.5" ><p class="value-box">(987)-654-3210</p></b-col>
					    </b-row>
					    <b-row class="content-margin">
						    <b-col cols="6.5" >Claim Status Code &nbsp;  &nbsp;</b-col> 
						    <b-col cols="5.5" ><p class="value-box">2</p></b-col>
					    </b-row>
					    <b-row class="content-margin">
						    <b-col cols="6.5" >Total Claim Charge Amount &nbsp;  &nbsp;</b-col> 
						    <b-col cols="5.5" ><p class="value-box">$226.00</p></b-col>
					    </b-row>

					    <b-row class="content-margin">
						    <b-col cols="6.5" >Claim Payment Amount  &nbsp;  &nbsp;</b-col> 
						    <b-col cols="5.5" ><p class="value-box">$132.00</p></b-col>
					    </b-row>
					
					<b-row style="margin-bottom: 20px;padding-right: 50px;">
						<b-col cols="12">
							<div>
								<b-nav tabs>
									<b-nav-item active ><h6>Payer Identification</h6></b-nav-item>
								</b-nav>
							</div>
						</b-col>
					</b-row>
					<b-row class="content-margin" >
						<b-col cols="6.5" >Entity Identifier  &nbsp;  &nbsp;</b-col> 
						<b-col cols="5.5" ><p class="value-box">PR</p></b-col>
					</b-row>
					<b-row class="content-margin">
						<b-col cols="6.5" >Payer Name  &nbsp;  &nbsp;</b-col> 
						<b-col cols="5.5" ><p class="value-box">YOUR TAX DOLLARS AT WORK</p></b-col>
					</b-row>
					
					<b-row style="margin-bottom: 20px;padding-right: 50px;">
						<b-col cols="12">
							<div>
								<b-nav tabs>
									<b-nav-item active><h6>Payer Address</h6></b-nav-item>
								</b-nav>
							</div>
						</b-col>
					</b-row>
					<b-row class="content-margin">
						<b-col cols="6.5" >Address &nbsp;  &nbsp;</b-col> 
						<b-col cols="5.5" ><p class="value-box">481A00 DEER RUN ROAD</p></b-col>
					</b-row>
					<b-row class="content-margin">
						<b-col cols="6.5" >City &nbsp;  &nbsp;</b-col> 
						<b-col cols="5.5" ><p class="value-box">WEST PALM BCH</p></b-col>
					</b-row>
					<b-row class="content-margin">
						<b-col cols="6.5" >State  &nbsp;  &nbsp;</b-col> 
						<b-col cols="5.5" ><p class="value-box">FL</p></b-col>
					</b-row>
					<b-row class="content-margin">
						<b-col cols="6.5" >ZIP &nbsp;  &nbsp;</b-col> 
						<b-col cols="5.5" ><p class="value-box">11114</p></b-col>
					</b-row>
					<!-- PER_PayerTechnicalContactInformation -->
					<b-row style="margin-bottom: 20px;padding-right: 50px;">
						<b-col cols="12">
							<div>
								<b-nav tabs>
									<b-nav-item active><h6>Payer Contact Information</h6></b-nav-item>
								</b-nav>
							</div>
						</b-col>
					</b-row>
					<b-row class="content-margin">
						<b-col cols="6.5" >Contact Name &nbsp;  &nbsp;</b-col> 
						<b-col cols="5.5" ><p class="value-box">JOHN WAYNE</p></b-col>
					</b-row>
					<b-row class="content-margin">
						<b-col cols="6.5" >Contact Number &nbsp;  &nbsp;</b-col> 
						<b-col cols="5.5" ><p class="value-box">(123)-456-7890</p></b-col>
					</b-row>
					<b-row class="content-margin">
						<b-col cols="6.5" >Alternate Contact Number &nbsp;  &nbsp;</b-col> 
						<b-col cols="5.5" ><p class="value-box">(800)-555-1212</p></b-col>
					</b-row>
					
				</div>
					
				</b-col>
				<!-- Second column for 835 data -->

				<b-col>
				  <div class="info-box">
					<!-- N1_PayeeIdentification -->
					<b-row style="margin-bottom: 20px;padding-right: 50px;">
						<b-col cols="12">
							<div>
								<b-nav tabs>
									<b-nav-item active><h6>Payee Identification</h6></b-nav-item>
								</b-nav>
							</div>
						</b-col>
					</b-row>
					<b-row class="content-margin">
						<b-col cols="6.5" >Entity Identifier  &nbsp;  &nbsp;</b-col> 
						<b-col cols="5.5" ><p class="value-box">PE</p></b-col>
					</b-row>
					<b-row class="content-margin">
						<b-col cols="6.5" >Premium Payer Name &nbsp;  &nbsp;</b-col> 
						<b-col cols="5.5" ><p class="value-box">ATONEWITHHEALTH</p></b-col>
					</b-row>
					<b-row class="content-margin">
						<b-col cols="6.5" >Intermediary Bank Identifier &nbsp;  &nbsp;</b-col> 
						<b-col cols="5.5" ><p class="value-box">3UR334563</p></b-col>
					</b-row>
					
					<!-- payee address line -->
					<b-row style="margin-bottom: 20px;padding-right: 50px;">
						<b-col cols="12">
							<div>
								<b-nav tabs>
									<b-nav-item active><h6>Payee Address</h6></b-nav-item>
								</b-nav>
							</div>
						</b-col>
					</b-row>
					<b-row class="content-margin">
						<b-col cols="6.5" >Address &nbsp;  &nbsp;</b-col> 
						<b-col cols="5.5" ><p class="value-box">3501 JOHNSON STREET</p></b-col>
					</b-row>
					<b-row class="content-margin">
						<b-col cols="6.5" >City  &nbsp;  &nbsp;</b-col> 
						<b-col cols="5.5" ><p class="value-box">SUNSHINE</p></b-col>
					</b-row>
					<b-row class="content-margin">
						<b-col cols="6.5" >State &nbsp;  &nbsp;</b-col> 
						<b-col cols="5.5" ><p class="value-box">FL</p></b-col>
					</b-row>
					<b-row class="content-margin">
						<b-col cols="6.5" >ZIP  &nbsp;  &nbsp;</b-col> 
						<b-col cols="5.5" ><p class="value-box">12345</p></b-col>
					</b-row>
					
					<b-row class="content-margin">
						<b-col cols="6.5" >Contact Number &nbsp;  &nbsp;</b-col> 
						<b-col cols="5.5" ><p class="value-box">(123)-456-7890</p></b-col>
					</b-row>

					<!-- service claim information -->
					<b-row style="margin-bottom: 20px;padding-right: 50px;">
						<b-col cols="12">
							<div>
								<b-nav tabs>
									<b-nav-item active><h6>Service Claim Information</h6></b-nav-item>
								</b-nav>
							</div>
						</b-col>
					</b-row>
					<b-row class="content-margin">
						<b-col cols="6.5" >Policy Number  &nbsp;  &nbsp;</b-col> 
						<b-col cols="5.5" ><p class="value-box">11861</p></b-col>
					</b-row>
					<b-row class="content-margin">
						<b-col cols="6.5" >Total Billed Amount &nbsp;  &nbsp;</b-col> 
						<b-col cols="5.5" ><p class="value-box">$226.00</p></b-col>
					</b-row>
					
					<b-row class="content-margin">
						<b-col cols="6.5" >Total Adjustment Amount &nbsp;  &nbsp;</b-col> 
						<b-col cols="5.5" ><p class="value-box">$94.00</p></b-col>
					</b-row>
					<b-row class="content-margin">
						<b-col cols="6.5" >Total Paid &nbsp;  &nbsp;</b-col> 
						<b-col cols="5.5" ><p class="value-box">$132.00</p></b-col>
					</b-row>

					<b-row style="margin-bottom: 20px;padding-right: 50px;">
							<b-col cols="12">
								<div>
									<b-nav tabs>
										<b-nav-item active><h6>Diagnosis Code</h6></b-nav-item>
									</b-nav>
								</div>
							</b-col>
						</b-row>
					    <b-row class="content-margin">
						    <b-col cols="6.5" > 837P Primary DX &nbsp;  &nbsp;</b-col> 
						    <b-col cols="5.5" ><p class="value-box">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</p></b-col>
					    </b-row>
					    <b-row class="content-margin">
						    <b-col cols="6.5" >837P Secondary DX&nbsp;  &nbsp;</b-col> 
						    <!-- <b-col cols="5.5" ><p class="value-box">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</p></b-col> -->
					    </b-row>

				</div>
				</b-col>

				<!-- Third column for 835 data -->
				<b-col>
					<div class="info-box">
					<b-row style="margin-bottom: 20px;padding-right: 50px;">
						<b-col cols="12">
							<div>
								<b-nav tabs>
									<b-nav-item active><h6>Transactions</h6></b-nav-item>
								</b-nav>
							</div>
						</b-col>
					</b-row>
					<b-row class="content-margin">
						<b-col cols="6.5" >Transaction Set Identifier &nbsp;  &nbsp;</b-col> 
						<b-col cols="5.5" ><p class="value-box">835</p></b-col>
					</b-row>
					<b-row class="content-margin">
						<b-col cols="6.5" >Transaction Set Control Number &nbsp;</b-col> 
						<b-col cols="5.5" ><p class="value-box">0001</p></b-col>
					</b-row>
					<b-row style="margin-bottom: 20px;padding-right: 50px;">
						<b-col cols="12">
							<div>
								<b-nav tabs>
									<b-nav-item active><h6>Financial Information</h6></b-nav-item>
								</b-nav>
							</div>
						</b-col>
					</b-row>
					<b-row class="content-margin">
						<b-col cols="6.5" >Transaction Handling Code  &nbsp;  &nbsp;</b-col> 
						<b-col cols="5.5" ><p class="value-box">I</p></b-col>
					</b-row>
						<b-row class="content-margin">
							<b-col cols="6.5" >Total Premium Payment  &nbsp;  &nbsp;</b-col> 
							<b-col cols="5.5" ><p class="value-box">$132.00</p></b-col>
						</b-row>
						<b-row class="content-margin">
							<b-col cols="6.5" >Credit or Debit Code  &nbsp;  &nbsp;</b-col> 
							<b-col cols="5.5" ><p class="value-box">C</p></b-col>
						</b-row>
					    <b-row  class="content-margin">
						    <b-col cols="6.5" >Payment Method  &nbsp;  &nbsp;</b-col> 
						    <b-col cols="5.5" ><p class="value-box">Check</p></b-col>
					    </b-row>
						<!-- TRN_ReassociationTraceNumber -->
						<b-row style="margin-bottom: 20px;padding-right: 50px;">
							<b-col cols="12">
								<div>
									<b-nav tabs>
										<b-nav-item active><h6>Reassociation Trace Number</h6></b-nav-item>
									</b-nav>
								</div>
							</b-col>
						</b-row>
					    <b-row class="content-margin">
						    <b-col cols="6.5" >Trace Type Code  &nbsp;  &nbsp;</b-col> 
						    <b-col cols="5.5" ><p class="value-box">1</p></b-col>
					    </b-row>
					    <b-row class="content-margin">
						    <b-col cols="6.5" >Current Transaction Trace Number &nbsp;  &nbsp;</b-col> 
						    <b-col cols="5.5" ><p class="value-box">0063158ABC</p></b-col>
					    </b-row>
					    <b-row class="content-margin">
						    <b-col cols="6.5" >Originating Company Identifier  &nbsp;  &nbsp;</b-col> 
						    <b-col cols="5.5" ><p class="value-box">1566339911</p></b-col>
					    </b-row>

					    <b-row class="content-margin">
						    <b-col cols="6.5" >Reference Identification Qualifier  &nbsp;  &nbsp;</b-col> 
						    <b-col cols="5.5" ><p class="value-box">EV</p></b-col>
					    </b-row>
					    <b-row class="content-margin">
						    <b-col cols="6.5" >Member Group or Policy Number  &nbsp;  &nbsp;</b-col> 
						    <b-col cols="5.5" ><p class="value-box">030240928</p></b-col>
					    </b-row>
						
				    </div>
				</b-col>


				  


				</b-row>
			  </b-container>
			</b-collapse>
		    </div>
		    
		<b-collapse v-model="showDetails">
			<b-row>
				<b-col cols="12" lg="4" class="mb-2">
					<h5 class="h6 my-2 font-weight-bold text-muted text-uppercase">Case Details</h5>
					<b-card>
						<dl class="mb-0">
							<div class="row">
								<dt class="col-5 text-muted h6 small">Status</dt>
								<dd class="col-7">
									<case-status-label :value="caseEntity" />
									<b-badge v-if="caseEntity.unable_to_complete" pill variant="warning"
										title="Unable To Complete">
										<font-awesome-icon icon="exclamation-triangle"
											class="mx-0 px-0" />
										UTC
									</b-badge>
								</dd>
							</div>
							<div v-if="caseEntity.patient && caseEntity.patient.full_name" class="row">
								<dt class="col-5 text-muted h6 small">Patient</dt>
								<dd class="col-7">
									<router-link
										:to="{ name: 'patients.view', params: { id: caseEntity.patient_id } }"
										title="View Patient">
										{{ caseEntity.patient.full_name }}
									</router-link>
								</dd>
							</div>
							<div v-if="caseEntity.patient && caseEntity.patient.date_of_birth" class="row">
								<dt class="col-5 text-muted h6 small">Patient DOB</dt>
								<dd class="col-7">
									<span>{{ $filters.formatDate(caseEntity.patient.date_of_birth) }}</span>
									<span v-if="caseEntity.patient.age">
										&mdash;
										{{ caseEntity.patient.age }}
									</span>
								</dd>
							</div>

							<div v-if="caseEntity.case_type && caseEntity.case_type.name" class="row">
								<dt class="col-5 text-muted h6 small">Type</dt>
								<dd class="col-7">{{ caseEntity.case_type.name }}</dd>
							</div>
							<div v-if="caseEntity.denial_type && caseEntity.denial_type.name" class="row">
								<dt class="col-5 text-muted h6 small">Denial Type</dt>
								<dd class="col-7">
									{{ caseEntity.denial_type.name }}
								</dd>
							</div>
							<div v-if="caseEntity.client_employee && caseEntity.client_employee.full_name"
								class="row">
								<dt class="col-5 text-muted h6 small">Primary Physician</dt>
								<dd class="col-7">
									<router-link :to="{
										name: 'clientEmployees.view',
										params: { id: caseEntity.client_employee.id },
									}" title="View Physician">
										{{ caseEntity.client_employee.full_name }}
									</router-link>
								</dd>
							</div>
							<div v-if="caseEntity.case_outcome && caseEntity.case_outcome.name" class="row">
								<dt class="col-5 text-muted h6 small">Outcome</dt>
								<dd class="col-7">
									{{ caseEntity.case_outcome.name }}
								</dd>
							</div>
							<div v-if="caseEntity.total_claim_amount" class="row">
								<dt class="col-5 text-muted h6 small">Total Claim</dt>
								<dd class="col-7">
									{{ $filters.currency(caseEntity.total_claim_amount) }}
								</dd>
							</div>
							<div v-if="caseEntity.disputed_amount" class="row">
								<dt class="col-5 text-muted h6 small">Disputed</dt>
								<dd class="col-7">
									{{ $filters.currency(caseEntity.disputed_amount) }}
								</dd>
							</div>
							<div v-if="caseEntity.settled_amount" class="row">
								<dt class="col-5 text-muted h6 small">Settled</dt>
								<dd class="col-7">
									{{ $filters.currency(caseEntity.settled_amount) }}
								</dd>
							</div>
							<div v-if="caseEntity.reimbursement_amount" class="row">
								<dt class="col-5 text-muted h6 small">Reimbursement</dt>
								<dd class="col-7">
									{{ $filters.currency(caseEntity.reimbursement_amount) }}
								</dd>
							</div>
						</dl>
					</b-card>
				</b-col>
				<b-col cols="12" lg="4" class="mb-2">
					<h5 class="h6 my-2 font-weight-bold text-muted text-uppercase">Facility &amp; Visit</h5>
					<b-card>
						<dl class="mb-0">
							<div class="row">
								<dt class="col-5 text-muted h6 small">Name</dt>
								<dd class="col-7">
									<div v-if="caseEntity.facility && caseEntity.facility.name">
										<router-link :to="{
											name: 'facilities.view',
											params: { id: caseEntity.facility.id },
										}">
											{{ caseEntity.facility.name }}
										</router-link>
									</div>
									<div v-else class="text-muted">&mdash;</div>
								</dd>
							</div>
							<div v-if="caseEntity.facility &&
								caseEntity.facility_type &&
								caseEntity.facility.facility_type.name
								" class="row">
								<dt class="col-5 text-muted h6 small">Type</dt>
								<dd class="col-7" v-text="caseEntity.facility.facility_type.name" />
							</div>
							<div v-if="caseEntity.visit_number" class="row">
								<dt class="col-5 text-muted h6 small">Visit ID</dt>
								<dd class="col-7" v-text="caseEntity.visit_number" />
							</div>
							<div v-if="caseEntity.admit_date" class="row">
								<dt class="col-5 text-muted h6 small">Admitted</dt>
								<dd class="col-7">
									<p class="mb-0">
										{{ $filters.formatDate(caseEntity.admit_date) }}
									</p>
									<p class="mb-0 small text-muted">
										{{ $filters.fromNow(caseEntity.admit_date) }}
									</p>
								</dd>
							</div>
							<div v-if="caseEntity.discharge_date" class="row">
								<dt class="col-5 text-muted h6 small">Discharged</dt>
								<dd class="col-7">
									<p class="mb-0">
										{{ $filters.formatDate(caseEntity.discharge_date) }}
									</p>
									<p class="mb-0 small text-muted">
										{{ $filters.fromNow(caseEntity.discharge_date) }}
									</p>
								</dd>
							</div>
							<div v-if="caseEntity.length_of_stay" class="row">
								<dt class="col-5 text-muted h6 small">Length of Stay</dt>
								<dd class="col-7">
									{{ $filters.formatNumber(caseEntity.length_of_stay) }} day{{
										caseEntity.length_of_stay !== 1 ? "s" : ""
									}}
								</dd>
							</div>
							<div v-if="hasReadmissions" class="row">
								<dt class="col-5 text-muted h6 small">Readmissions</dt>
								<dd class="col-7">
									<b-list-group class="mb-0">
										<b-list-group-item
											v-for="readmission in caseEntity.case_readmissions"
											:key="readmission.id"
											class="d-flex justify-content-between align-items-center">
											<div class="d-flex align-items-start">
												<b-avatar variant="light" class="mr-2" size="sm">
													<font-awesome-icon icon="calendar"
														fixed-width />
												</b-avatar>
												<div>
													<div>
														<span v-if="readmission.admit_date">
															{{
																$filters.formatDate(readmission.admit_date)
															}}
														</span>
														<span v-if="readmission.admit_date && readmission.discharge_date"
															class="text-muted">&mdash;</span>
														<span v-if="readmission.discharge_date">{{
															$filters.formatDate(readmission.discharge_date)
														}}</span>
													</div>
													<div class="small text-muted">
														<span v-if="readmission.length_of_stay">{{
															readmission.length_of_stay }} day{{
		readmission.length_of_stay != 1 ?
		"s" : ""
	}}</span>
														<span v-if="readmission.length_of_stay && readmission.visit_number
																">&mdash;</span>
														<span v-if="readmission.visit_number">Visit
															#{{ readmission.visit_number
															}}</span>
													</div>
												</div>
											</div>
										</b-list-group-item>
									</b-list-group>
								</dd>
							</div>
						</dl>
					</b-card>
				</b-col>
				<b-col cols="12" lg="4" class="mb-2">
					<h5 class="h6 my-2 font-weight-bold text-muted text-uppercase">Primary Insurance</h5>
					<b-card class="mb-4">
						<dl class="mb-0">
							<div v-if="caseEntity.insurance_provider && caseEntity.insurance_provider.name"
								class="row">
								<dt class="col-5 text-muted h6 small">Name</dt>
								<dd class="col-7">
									<router-link :to="{
										name: 'insuranceProviders.view',
										params: { id: caseEntity.insurance_provider.id },
									}">
										{{ caseEntity.insurance_provider.name }}
									</router-link>
								</dd>
							</div>
							<div class="row">
								<dt class="col-5 text-muted h6 small">Type</dt>
								<dd class="col-7">
									<span
										v-if="caseEntity.insurance_type && caseEntity.insurance_type.name">
										{{ caseEntity.insurance_type.name }}
									</span>
									<span v-else class="text-danger"> Missing </span>
								</dd>
							</div>
							<div v-if="caseEntity.insurance_plan" class="row">
								<dt class="col-5 text-muted h6 small">Plan</dt>
								<dd class="col-7">
									{{ caseEntity.insurance_plan }}
								</dd>
							</div>
							<div v-if="caseEntity.insurance_number" class="row">
								<dt class="col-5 text-muted h6 small">Number</dt>
								<dd class="col-7">
									{{ caseEntity.insurance_number }}
								</dd>
							</div>
						</dl>
					</b-card>

					<div v-if="caseEntity.denial_reasons.length > 0" cols="12" lg="4" class="mb-2">
						<h5 class="h6 my-2 font-weight-bold text-muted text-uppercase">Denial Reasons</h5>

						<b-list-group>
							<b-list-group-item v-for="denialReason in caseEntity.denial_reasons"
								:key="denialReason.id" class="py-2">
								<span>{{ denialReason.name }}</span>
							</b-list-group-item>
						</b-list-group>
					</div>
					<div v-if="caseEntity.disciplines.length > 0" cols="12" lg="4" class="mb-2">
						<h5 class="h6 my-2 font-weight-bold text-muted text-uppercase">Disciplines</h5>

						<b-list-group>
							<b-list-group-item v-for="discipline in caseEntity.disciplines" :key="discipline.id"
								class="py-2">
								<span>{{ discipline.name }}</span>
							</b-list-group-item>
						</b-list-group>
					</div>
				</b-col>
			</b-row>
		</b-collapse>
		<b-row>
			<b-col cols="12" lg="6" xl="6">
				<h5 class="h6 my-2 font-weight-bold text-muted text-uppercase">Case Documents</h5>
				<case-files :id="caseEntity.id" :flush="false" />
			</b-col>
			<b-col cols="12" lg="6" xl="6">
				<b-alert v-if="caseClosed" show variant="warning" class="my-4 p-4">
					<h6 class="h6 mb-2">
						<font-awesome-icon icon="lock" fixed-width class="mr-1 mr-lg-2" />
						<strong>This case has been closed.</strong>
					</h6>
					<p class="small mb-0">
						<span>Appeal and requests cannot be added or changed unless this case is reopened.</span>
					</p>
				</b-alert>
				<div v-else>
					<h5 class="h6 my-2 font-weight-bold text-muted text-uppercase">Add New...</h5>
					<b-card no-body>
						<b-tabs card active-nav-item-class="font-weight-bold">
							<b-tab title="Appeal" no-body>
								<appeal-form disable-cancel flush :case-entity="caseEntity"
									@saved="createdAppeal" />
							</b-tab>
							<b-tab title="Request" no-body>
								<case-request-form disable-cancel flush :case-entity="caseEntity"
									@saved="createdRequest" />
							</b-tab>
						</b-tabs>
					</b-card>
				</div>
			</b-col>
		</b-row>
	</b-container>
</template>

<script>
import AppealForm from "@/clients/components/Appeals/Form.vue";
import CaseAssign from "@/clients/components/Cases/Assign.vue";
import CaseStatusLabel from "@/clients/components/Cases/StatusLabel.vue";
import CaseFiles from "@/clients/components/Cases/Files.vue";
import CaseRequestForm from "@/clients/components/CaseRequests/Form.vue";

export default {
	name: "ViewCasesViewHome",
	components: {
		AppealForm,
		CaseAssign,
		CaseFiles,
		CaseStatusLabel,
		CaseRequestForm,
	},
	props: {
		caseEntity: {
			type: Object,
			default: () => {
				return {
					id: null,
					disputed_amount: null,
					reimbursement_amount: null,
					settled_amount: null,
					total_claim_amount: null,
					visit_number: null,
					admit_date: null,
					discharge_date: null,
					length_of_stay: null,
					insurance_plan: null,
					insurance_number: null,
					case_type: {
						id: null,
						name: null,
					},
					case_outcome: {
						id: null,
						name: null,
					},
					denial_type: {
						id: null,
						name: null,
					},
					client_employee: {
						id: null,
						full_name: null,
					},
					facility: {
						id: null,
						name: null,
						facility_type: {
							id: null,
							name: null,
						},
					},
					denial_reasons: [],
					disciplines: [],
					case_requests: [],
					case_readmissions: [],
				};
			},
		},
	},
	computed: {
		caseClosed() {
			return this.caseEntity.closed && this.caseEntity.closed !== null;
		},
		hasReadmissions() {
			return this.caseEntity.case_readmissions && this.caseEntity.case_readmissions.length > 0;
		},
	},
	data() {
		return {
			showDetails: false,
			showLoveMessage: false,
			items: [
				{ ProcDate: '03/24/2019', ProcCode: '55669', Billed: '$46.00' , Allowed: '$25.00' , Deduct: '$0.00' , Co_Ins: '$0.00' , Co_Pay: '$0.00' , AdjCode: 'CO-45' , Adjustment: '$21.00' , ProvPaid: '$25.00' },
				{ ProcDate: '03/24/2019', ProcCode: '55670', Billed: '$25.00' , Allowed: '$14.00' , Deduct: '$0.00' , Co_Ins: '$0.00' , Co_Pay: '$0.00' , AdjCode: 'CO-45' , Adjustment: '$11.00' , ProvPaid: '$14.00' },
				{ ProcDate: '03/24/2019', ProcCode: '55671', Billed: '$22.00' , Allowed: '$10.00' , Deduct: '$0.00' , Co_Ins: '$0.00' , Co_Pay: '$0.00' , AdjCode: 'CO-45' , Adjustment: '$12.00' , ProvPaid: '$10.00' },
				{ ProcDate: '03/24/2019', ProcCode: '55672', Billed: '$60.00' , Allowed: '$34.00' , Deduct: '$0.00' , Co_Ins: '$0.00' , Co_Pay: '$0.00' , AdjCode: 'CO-45' , Adjustment: '$26.00' , ProvPaid: '$34.00' },
				{ ProcDate: '03/24/2019', ProcCode: '55673', Billed: '$73.00' , Allowed: '$49.00' , Deduct: '$0.00' , Co_Ins: '$0.00' , Co_Pay: '$0.00' , AdjCode: 'CO-45' , Adjustment: '$24.00' , ProvPaid: '$49.00' },
				{ ProcDate: 'Totals', ProcCode: '', Billed: '$226.00' , Allowed: '$132.00' , Deduct: '$0.00' , Co_Ins: '$0.00' , Co_Pay: '$0.00' , AdjCode: '' , Adjustment: '$94.00' , ProvPaid: '$132.00' },
			]
		};
	},
	methods: {
		createdAppeal(appeal) {
			this.$router.push({
				name: "appeals.view",
				params: {
					id: this.caseEntity.id,
					appeal_id: appeal.id,
				},
			});

			this.$emit("added", appeal);
		},
		createdRequest(request) {
			this.$router.push({
				name: "caseRequests.view",
				params: {
					id: this.caseEntity.id,
					case_request_id: request.id,
				},
			});

			this.$emit("added-request", request);
		},
	},
};
</script>
<style scoped>
.value-box {
  border: 1px solid #ccc;
  width: fit-content;
  padding-left: 5px;
  padding-right: 5px;
  
}
.content-margin{
	margin-left: 10px;
}
</style>