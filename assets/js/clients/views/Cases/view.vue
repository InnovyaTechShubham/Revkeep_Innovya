<template>
	<div>
		<page-header>
			<template #title>
				
				<h2 span v-if="loading && !caseEntity.patient?.list_name">
					<font-awesome-icon icon="circle-notch" spin fixed-width />
				</h2>
				<span span v-if="loading && !caseEntity.patient?.date_of_birth">
				</span>
				<span span v-if="loading && !caseEntity.patient?.age">
				</span>
				
                 <h2  v-else> 
	                {{ caseEntity.patient?.list_name ?? "View Case" }}
                 </h2>
					
				<span>
					
					<font-awesome-icon icon="birthday-cake" />
					{{ caseEntity.patient?.date_of_birth ?? "View Case"  }}
					&mdash;
					{{ caseEntity.patient?.age ?? "View Case" }}
				</span>
			</template>
			<template #buttons>
				<b-button
					variant="primary"
					v-if="!caseClosed"
					v-b-modal.closeCaseModal
					:disabled="showLoading"
					title="Close this case when all opportunities have concluded"
				>
					<font-awesome-icon icon="lock" fixed-width />
					<span>Close Case</span>
				</b-button>
				<b-button
					variant="primary"
					v-else
					@click="reopenCase"
					:disabled="showLoading || reopening"
					title="Reopen this case for further progression"
				>
					<font-awesome-icon v-if="reopening" icon="sync" :spin="reopening" fixed-width />
					<font-awesome-icon v-else icon="unlock" fixed-width />
					<span>Reopen Case</span>
				</b-button>

				<b-dropdown variant="secondary" right title="More Options">
					<template #button-content>
						<font-awesome-icon icon="cog" :spin="loading" fixed-width />
					</template>

					<b-dropdown-item
						:to="{ name: 'cases.edit', params: { id: $route.params.id } }"
						title="Edit case details"
					>
						<font-awesome-icon icon="edit" fixed-width />
						<span>Edit Case</span>
					</b-dropdown-item>

					<b-dropdown-item @click="refresh" :disabled="loading" title="Refresh case details">
						<font-awesome-icon icon="sync" :spin="loading" fixed-width />
						<span>Refresh</span>
					</b-dropdown-item>

					<b-dropdown-divider />

					<b-dropdown-item
						v-if="caseEntity.patient && caseEntity.patient.id"
						:to="{
							name: 'patients.view',
							params: { id: caseEntity.patient.id },
						}"
						title="View patient details"
					>
						<div class="d-flex justify-content-between align-items-center">
							<div>
								<div>View Patient</div>
								<small class="text-muted d-block">
									{{ $filters.truncatedString(caseEntity.patient.full_name, 20) }}
								</small>
							</div>
							<font-awesome-icon icon="chevron-right" class="my-0 py-0" />
						</div>
					</b-dropdown-item>

					<b-dropdown-item
						v-if="caseEntity.patient && caseEntity.patient.id"
						:to="{
							name: 'patients.edit',
							params: { id: caseEntity.patient.id },
						}"
						title="Edit patient details"
					>
						<font-awesome-icon icon="edit" fixed-width />
						<span>Edit Patient</span>
					</b-dropdown-item>

					<b-dropdown-divider />

					<b-dropdown-item
						v-if="caseEntity.facility && caseEntity.facility.id"
						:to="{
							name: 'facilities.view',
							params: { id: caseEntity.facility.id },
						}"
						title="View facility details"
					>
						<div class="d-flex justify-content-between align-items-center">
							<div>
								<div>View Facility</div>
								<small class="text-muted d-block">
									{{ $filters.truncatedString(caseEntity.facility.name, 20) }}
								</small>
							</div>
							<font-awesome-icon icon="chevron-right" class="my-0 py-0" />
						</div>
					</b-dropdown-item>

					<b-dropdown-item
						v-if="caseEntity.insurance_provider && caseEntity.insurance_provider.id"
						:to="{
							name: 'insuranceProviders.view',
							params: { id: caseEntity.insurance_provider.id },
						}"
						title="View insurance provider details"
					>
						<div class="d-flex justify-content-between align-items-center">
							<div class="mr-3">
								<div>View Insurance Provider</div>
								<small class="text-muted d-block">
									{{ $filters.truncatedString(caseEntity.insurance_provider.name, 20) }}
								</small>
							</div>
							<font-awesome-icon icon="chevron-right" class="my-0 py-0" />
						</div>
					</b-dropdown-item>

					<b-dropdown-divider />

					<b-dropdown-item
						@click="deleteEntity"
						:disabled="showLoading"
						variant="danger"
						title="Delete this case"
					>
						<font-awesome-icon icon="trash" fixed-width />
						<span>Delete Case</span>
					</b-dropdown-item>
				</b-dropdown>
			</template>
		</page-header>

		<loading-indicator v-if="showLoading" class="my-5" />
		<b-container v-else-if="error" fluid>
			<error-alert class="my-5">
				<span>{{ error }}</span>
				<template #content>
					<div class="my-4">
						<b-button variant="primary" :to="{ name: 'cases' }">
							<font-awesome-icon icon="list" fixed-width />
							<span>All Cases</span>
						</b-button>

						<b-button variant="secondary" @click="refresh" :disabled="loading">
							<font-awesome-icon icon="sync" :spin="loading" fixed-width />
							<span>Retry</span>
						</b-button>
					</div>
				</template>
			</error-alert>
		</b-container>
		
		<b-card v-else no-body>
			<b-card-header header-tag="nav">
				<b-row>
					<b-col cols="12" md="6" class="mb-2">
						<case-activity :case-id="$route.params.id" />
					</b-col>
					<b-col cols="12" md="6" class="text-left text-md-right mb-2">
						<div v-if="caseEntity.modified" class="small text-muted">
							<span v-if="caseEntity.modified" :title="$filters.formatTimestamp(caseEntity.modified)">
								Last updated {{ $filters.fromNow(caseEntity.modified) }}
							</span>
							<span v-if="caseEntity.modified_by_user && caseEntity.modified_by_user.full_name">
								by
								<router-link
									:to="{ name: 'users.view', params: { id: caseEntity.modified_by } }"
									title="View User"
								>
									{{ caseEntity.modified_by_user.full_name }}
								</router-link>
							</span>
						</div>
					</b-col>
				</b-row>
		 <b-row class="my-4">
			   <b-col cols="4" xl="8" class="text-left">
				<b-button @click="showDetails = !showDetails" variant="secondary">
					<span v-if="showDetails">Hide Details</span>
					<span v-else>Show Details</span>
				</b-button>
				<b-button @click="showData" variant="secondary">
					<span v-if="showLoveMessage">Hide Data</span>
					<span v-else>Show Data</span>
				</b-button>
				<b-button @click="showFormattedData" variant="secondary">
					<span v-if="isFormattedData">Hide Formatted Data</span>
					<span v-else>Show Formatted Data</span>
				</b-button>
				<!-- <b-button v-b-toggle.formattedData>
					<span >Formatted Data</span>
				</b-button> -->
			</b-col>
		</b-row>
		<b-collapse v-model="isFormattedData" id="collapse1" class="mt-2">
			<b-container fluid class="bv-example-row">
				
				<template>
					<div >
						<b-table responsive striped hover :items="items"></b-table>
					</div>
				</template>
				<hr>
			    <b-row>
				<b-col>
				  <div class="info-box">
					
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
						    <b-col cols="5.5" ><p class="value-box">Sakshi</p></b-col>
					    </b-row>
					    <b-row class="content-margin">
						    <b-col cols="6.5" >Middle Name  &nbsp;  &nbsp;</b-col> 
						    <b-col cols="5.5" ><p class="value-box"></p></b-col>
					    </b-row>
					    <b-row class="content-margin">
						    <b-col cols="6.5" >Last Name  &nbsp;  &nbsp;</b-col> 
						    <b-col cols="5.5" ><p class="value-box">Mittal</p></b-col>
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
						<b-col cols="5.5" ><p class="value-box">MEDICARE B</p></b-col>
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
				

				<b-col>
				  <div class="info-box">
					
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
						    
					    </b-row>

				</div>
				</b-col>

				
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
			<b-collapse v-model="showLoveMessage">
				<template>
					<div >
						<pre>{{ formattedData }}</pre>
					</div>
				</template>
			</b-collapse>
		
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
				<b-nav card-header tabs >
					<b-nav-item 
						title="Case Details"
						exact
						active-class="active font-weight-bold"
						link-classes="px-3"
						:to="{ name: 'cases.view', params: { id: $route.params.id } }"
					>
						<case-status-label :value="caseEntity" class="mb-0" />
						<b-badge v-if="caseEntity.unable_to_complete" pill variant="warning" title="Unable To Complete">
							<font-awesome-icon icon="exclamation-triangle" class="mx-0 px-0" />
						</b-badge>
						<span >Case</span>
					</b-nav-item>

			<!--		<b-nav-item
						v-for="caseRequest in caseEntity.case_requests"
						:key="'request_' + caseRequest.id"
						:to="{
							name: 'caseRequests.view',
							params: { id: caseEntity.id, case_request_id: caseRequest.id },
						}"
						:title="caseRequest.name ? caseRequest.name : '(Missing Name)'"
						active-class="active font-weight-bold"
					>
						<case-request-status-label icon :value="caseRequest" class="d-none d-lg-inline mr-2" />
						<span v-if="!caseRequest.type_label">Request</span>
						<span v-else>{{ caseRequest.type_label }}</span>
					</b-nav-item>

				-->
				</b-nav>
			</b-card-header>
			<b-card-header header-tag="nav" class="mt-2">
			<b-nav card-header tabs > 
                 
				<b-nav-item
						v-for="appeal in caseEntity.appeals"
						:key="'appeal_' + appeal.id"
						:to="{ name: 'appeals.view', params: { id: caseEntity.id, appeal_id: appeal.id } }"
						:title="
							appeal.appeal_level && appeal.appeal_level.short_name
								? appeal.appeal_level.short_name
								: '(Missing Level)'
						"
						active-class="active font-weight-bold"
					>
						<appeal-status-label icon :value="appeal" class="d-none d-lg-inline mr-2" />
						<!-- <span
							v-if="appeal.appeal_level && appeal.appeal_level.short_name"
							v-text="checkAppealName(appeal)"
						/>
						<span v-else class="text-danger">(Missing Level)test1</span> -->
						<span
							v-text="checkAppealName(caseEntity , appeal)"
						/>
					</b-nav-item>
                

				</b-nav>
          </b-card-header>
			<router-view
				ref="routerView"
				:key="routerKey"
				:case-entity="caseEntity"
				:value="currentAppeal"
				@added="addedAppeal"
				@deleted="deletedAppeal"
				@updated="updatedAppeal"
				@cancelled="refresh"
				@reopened="refresh"
				@added-request="addedRequest"
				@updated-request="updatedRequest"
				@deleted-request="deletedRequest"
			></router-view>
		</b-card>

		<close-case-modal
			v-if="caseEntity.id"
			id="closeCaseModal"
			title="Close Case"
			:case-entity="caseEntity"
			@closed="closedCase"
		/>
	</div>
</template>

<script type="text/javascript">
import AppealSummary from "@/clients/components/Appeals/Summary.vue";
import AppealStatusLabel from "@/clients/components/Appeals/StatusLabel.vue";
import CaseActivity from "@/clients/components/Cases/Activity.vue";
import CloseCaseModal from "@/clients/components/Cases/CloseCaseModal.vue";
import CaseRequestStatusLabel from "@/clients/components/CaseRequests/StatusLabel.vue";
import CaseStatusLabel from "@/clients/components/Cases/StatusLabel.vue";
import axios from "axios";

export default {
	name: "CaseView",
	components: {
		AppealStatusLabel,
		CaseActivity,
		CloseCaseModal,
		CaseRequestStatusLabel,
		CaseStatusLabel,
		AppealSummary,
	},
	data() {
		return {
			loading: true,
			reopening: false,
			error: false,
			showDetails: false,
			isFormattedData: false,
			showLoveMessage: false,
			caseEntity: {
				id: null,
				created: null,
				modified: null,
				deleted: null,
				patient_id: null,
				facility_id: null,
				denial_type_id: null,
				case_outcome_id: null,
				insurance_provider_id: null,
				insurance_type_id: null,
				insurance_plan: null,
				insurance_number: null,
				total_claim_amount: null,
				reimbursement_amount: null,
				disputed_amount: null,
				settled_amount: null,
				visit_number: null,
				admit_date: null,
				discharge_date: null,
				closed: null,
				closed_by: null,
				assigned: null,
				assigned_to: null,
				client_employee_id: null,
				unable_to_complete: null,
				discipline_id: null,
				// Virtual fields
				can_add_appeal: null,
				// Associations
				patient: {
					id: null,
					full_name: "",
					list_name: "",
				},
				appeals: [],
				disciplines: [],
				case_requests: [],
				

			},
			timer: null,
			outgoingList:null,
			appealList:null,
			name:null,
		};
	},
	computed: {
		routerKey() {
			if (this.$route.params.appeal_id) {
				return "appeal_" + this.$route.params.appeal_id;
			}

			if (this.$route.params.case_request_id) {
				return "request_" + this.$route.params.case_request_id;
			}

			return "case";
		},
		currentAppeal() {
			return this.caseEntity.appeals.find((appeal) => appeal.id == this.$route.params.appeal_id);
		},
		hasAppeals() {
			if (!this.caseEntity || !this.caseEntity.appeals) {
				return false;
			}

			return this.caseEntity.appeals.length && this.caseEntity.appeals.length > 0;
		},
		appealCount() {
			if (!this.hasAppeals) {
				return 0;
			}

			return this.caseEntity.appeals.length;
		},
		showLoading() {
			if (this.caseEntity.id) {
				return false;
			}

			return this.loading;
		},
		caseClosed() {
			return this.caseEntity.closed && this.caseEntity.closed !== null;
		},
	},
	mounted() {
		this.refresh();
		// this.test();

		//this.timer = setInterval(this.refresh, 30000);
	},
	methods: {
		/**
		 * Get Details
		 */
		async refresh() {
			try {
				this.loading = true;
				this.error = false;

				const response = await this.$store.dispatch("cases/get", {
					id: this.$route.params.id,
				});

				this.caseEntity = response;
			} catch (e) {
				this.error = e.response.data.message || "Unable to load case details";

				this.$store.dispatch("apiError", {
					error: e,
					message: "Failed getting case details",
				});
			} finally {
				this.loading = false;
			}
		},
		/**
		 * Delete
		 */
		async deleteEntity() {
			const confirmMessage = "Are you sure you want to delete this case?";
			if (!confirm(confirmMessage)) {
				return false;
			}

			try {
				this.deleting = true;

				const response = await this.$store.dispatch("cases/delete", {
					id: this.$route.params.id,
				});

				this.$router.push({
					name: "cases",
				});

				this.$nextTick(function () {
					this.$store.dispatch("notify", {
						variant: "primary",
						title: "Case Deleted",
						message: `Case for patient ${response.data.patient.list_name} was deleted.`,
					});
				});
			} catch (e) {
				this.$store.dispatch("apiError", {
					error: e,
					title: "Delete Failed",
					message: "Failed to delete case.",
				});
			} finally {
				this.deleting = false;
			}
		},
		/**
		 * Reopen
		 */
		async reopenCase(e) {
			const confirmMessage = "Are you sure you want to reopen this case? The case outcome will be removed.";
			if (!confirm(confirmMessage)) {
				return false;
			}

			try {
				this.reopening = true;

				const response = await this.$store.dispatch("cases/open", {
					id: this.$route.params.id,
				});

				this.caseEntity = response;

				this.refresh();
			} catch (e) {
				this.$store.dispatch("apiError", {
					error: e,
					title: "Reopen Failed",
					message: "Failed to reopen case",
				});
			} finally {
				this.reopening = false;
			}
		},
		closedCase(caseEntity) {
			this.caseEntity = caseEntity;
		},
		addedAppeal(appeal) {
			this.caseEntity.appeals.push(appeal);
		},
		updatedAppeal(appeal) {
			this.refresh();
		},
		deletedAppeal(appeal) {
			this.refresh();
		},
		addedRequest(request) {
			this.caseEntity.case_requests.push(request);
		},
		updatedRequest(request) {
			this.$refs.routerView.refresh();
			this.refresh();
		},
		deletedRequest(request) {
			this.refresh();
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

			// 	const agencyListUrl = '/client/agencyList';
			// const agencyListResponse = await axios.get(agencyListUrl, {
			// 	headers: {
			// 		"Accept": "application/json",
			// 		// You can add other headers here if needed
			// 	},
			// 	});
			// 	console.log("Agency Response =", agencyListResponse);
			// 	this.agencyList = agencyListResponse.data;
				
		},
		checkAppealName(caseEntity , appeal){
			// this.test();
			
			console.log("case testing = ",caseEntity);
			console.log("appeal testing = ",appeal);
			let name ="";
			caseEntity.insurance_provider.appeal_levels.map((item , index)=>{
				console.log("inside loop")
				if(appeal.insurance_appeal_id == item._joinData.id){
					console.log("match found =", item._joinData.label)
					name = item._joinData.label;
					
				}
			});
			

			// return this.name;
			return name;
			
		},
		showFormattedData(){
			this.isFormattedData = !this.isFormattedData;
		},
		async showData(){
			console.log('Button Clicked');
			console.log('case deta2 =', this.caseEntity);
			console.log('case deta3 =', this.caseEntity.patient.full_name);
			this.showLoveMessage = !this.showLoveMessage;
			const patientDetails = {
                   fullName:this.caseEntity.patient.full_name,
				   firstName:this.caseEntity.patient.first_name,
				   middleName:this.caseEntity.patient.middle_name,
				   lastName:this.caseEntity.patient.last_name,
				   admitDate:this.caseEntity.admit_date
                };

			try{
				const response = await axios.post('/client/patientParsedInfo', patientDetails);
				console.log("Response1 =", response.data);
				console.log("check = ",response.data.Loop2110);
				if(response.data.Loop2110==undefined){
					this.response = "DATA NOT AVAILABLE FOR THIS CASE";
				}
				else{
					this.response = response.data;
				}
			}
			catch(error){
				this.response = "DATA NOT AVAILABLE FOR THIS CASE";
			}
		},
	},
	destroyed() {
		clearInterval(this.timer);
	},
};
</script>
