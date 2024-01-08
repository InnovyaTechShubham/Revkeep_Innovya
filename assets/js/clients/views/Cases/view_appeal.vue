<template>
	<b-container fluid class="my-4">
		<loading-indicator v-if="loading && !this.appeal.id" class="my-5" />
		<error-alert v-else-if="error"> Error </error-alert>
		<b-container v-else-if="editing">
			<b-row>
				<b-col cols="12" class="mb-4">
					<appeal-form :appeal="appeal" @cancel="editing = false" @saved="savedEdit">
						<template #header>
							<b-card-header>
								<div class="d-flex justify-content-between align-items-center">
									<span class="font-weight-bold">Edit Appeal</span>
									<b-button
										variant="secondary"
										size="sm"
										@click="editing = false"
										title="Cancel"
										class="mb-0"
									>
										<font-awesome-icon icon="remove" fixed-width class="my-0 py-0" />
									</b-button>
								</div>
							</b-card-header>
						</template>
					</appeal-form>
				</b-col>
			</b-row>
		</b-container>
		<div v-else>
			<b-row>
				<b-col cols="6" md="3" lg="4" xl="6" order="1" order-md="1" class="text-left mb-4">
					<b-button @click="showDetails = !showDetails" variant="secondary">
						<span v-if="showDetails">Hide Details</span>
						<span v-else>Show Details</span>
					</b-button>
					<b-button
                        variant="primary"
                        @click="openForm"
                        :disabled="isRequest || addingRequest"
                        >
                        <span v-if="isRequest || addingRequest">Hide Request</span>
                        <span v-else>Add Request</span>
                    </b-button>

						
				</b-col>
				<b-col cols="12" md="5" lg="4" xl="3" order="3" order-md="2" class="text-left mb-4">
					<appeal-assign :appeal="appeal" />
				</b-col>
				<b-col cols="6" md="4" lg="4" xl="3" order="2" order-md="3" class="text-right text-md-right mb-4">
					<b-button
						@click="editing = true"
						:active="editing"
						:disabled="caseClosed"
						variant="secondary"
						:title="caseClosed ? 'This case is closed' : 'Edit appeal details'"
					>
						<font-awesome-icon icon="edit" fixed-width />
						<span>Edit Appeal</span>
					</b-button>

					<b-dropdown variant="secondary" right title="Appeal Options">
						<template #button-content>
							<font-awesome-icon icon="cog" fixed-width />
						</template>

						<b-dropdown-item @click="cancelAppeal" :disabled="caseClosed || !canCancel || cancelling">
							<font-awesome-icon icon="ban" fixed-width />
							<span>Cancel Appeal</span>
						</b-dropdown-item>

						<b-dropdown-item @click="reopenAppeal" :disabled="caseClosed || !canReopen || reopening">
							<font-awesome-icon icon="envelope-open" fixed-width />
							<span>Reopen Appeal</span>
						</b-dropdown-item>

						<b-dropdown-divider />

						<b-dropdown-item
							variant="danger"
							@click="deleteAppeal"
							:disabled="deleting || caseClosed || !canDelete"
						>
							<font-awesome-icon icon="trash" fixed-width />
							<span>Delete Appeal</span>
						</b-dropdown-item>
					</b-dropdown>
				</b-col>
			</b-row>
			<b-collapse v-model="showDetails">
				<appeal-summary :appeal="appeal" class="mb-4" />
			</b-collapse>
		<b-row v-if="addingRequest" class="my-2">
			<b-col cols="6">
				<case-request-form :case-entity="caseEntity" @saved="addedRequest" @cancel="addingRequest = false">
					<template #header>
						<b-card-header>
							<div class="d-flex justify-content-between align-items-center">
								<span class="font-weight-bold">Add New Request</span>
								<b-button
									variant="secondary"
									size="sm"
									@click="addingRequest = false"
									title="Cancel"
									class="mb-0"
								>
									<font-awesome-icon icon="remove" fixed-width class="my-0 py-0" />
								</b-button>
							</div>
						</b-card-header>
					</template>
				</case-request-form>
			</b-col>
		</b-row>
		<!--request section start here-->
		<b-row v-if="isRequest" >
			<b-col cols="6"  class="mb-2">
				<b-card no-body>
						<b-tabs card active-nav-item-class="font-weight-bold">
                           <b-tab>
							<template #title>Request</template>
							<b-card>
								<b-nav card-header tabs class="d-flex mb-2">
                                 <b-nav-item
                                 v-for="caseRequest in caseEntity.case_requests"
                                 :key="'request_' + caseRequest.id"
                                 :to="{
                                 params: { id: caseEntity.id, case_request_id: caseRequest.id },
                                 }"
                                  :title="caseRequest.name ? caseRequest.name : '(Missing Name)'"
                                  active-class="active font-weight-bold"
                                 @click="handleTabClick(caseRequest)"
		                         class="m-1"
                                >
                                <case-request-status-label icon :value="caseRequest" class="d-none d-lg-inline mr-2" />
                                <span v-if="!caseRequest.type_label">Request</span>
                                <span v-else>{{ caseRequest.type_label }}</span>
                                </b-nav-item>
                                </b-nav>
							</b-card>
							<b-row class="mt-2">
								<b-col cols="12" lg="6" class="mb-2">
									<b-card>
										<dl class="mb-0">
											<div class="row">
												<dt class="col-5 text-muted h6 small">Name</dt>
												<dd class="col-7">
													{{ entity.name }}
												</dd>
											</div>

											<div class="row">
												<dt class="col-5 text-muted h6 small">Status</dt>
												<dd class="col-7">
													<case-request-status-label :value="entity" />
												</dd>
											</div>
											<div class="row">
												<dt class="col-5 text-muted h6 small">Type</dt>
												<dd class="col-7">
													{{ entity.type_label }}
												</dd>
											</div>
											<div class="row">
												<dt class="col-5 text-muted h6 small">Insurance Provider</dt>
												<dd class="col-7">
													<router-link
														v-if="entity.insurance_provider"
														:to="{
															name: 'insuranceProviders.view',
															params: { id: entity.insurance_provider_id },
														}"
													>
														{{ entity.insurance_provider.name }}
													</router-link>
													<div v-else class="text-muted">&mdash;</div>
												</dd>
											</div>
											<div class="row">
												<dt class="col-5 text-muted h6 small">Agency</dt>
												<dd class="col-7">
													<router-link
														v-if="entity.agency"
														:to="{
															name: 'agencies.view',
															params: { id: entity.agency_id },
														}"
													>
														{{ entity.agency.name }}
													</router-link>
													<div v-else class="text-muted">&mdash;</div>
												</dd>
											</div>
											<div class="row">
												<dt class="col-5 text-muted h6 small">Priority</dt>
												<dd class="col-7">
													<div v-if="entity.priority" class="text-primary font-weight-bold">
														Yes
													</div>
													<div v-else class="text-muted">No</div>
												</dd>
											</div>
										</dl>
									</b-card>
								</b-col>
								<b-col cols="12" lg="6" class="mb-2">
									<b-card>
										<dl class="mb-0">
											<div class="row">
												<dt class="col-5 text-muted h6 small">Created</dt>
												<dd class="col-7">
													<p :title="$filters.formatTimestamp(entity.created)" class="mb-0">
														{{ $filters.fromNow(entity.created) }}
													</p>
													<p
														v-if="entity.created_by && entity.created_by_user"
														class="small text-muted mb-0"
													>
														by {{ entity.created_by_user.full_name }}
													</p>
												</dd>
											</div>
											<div class="row">
												<dt class="col-5 text-muted h6 small">Last Updated</dt>
												<dd class="col-7">
													<p :title="$filters.formatTimestamp(entity.modified)" class="mb-0">
														{{ $filters.fromNow(entity.modified) }}
													</p>
													<p
														v-if="entity.modified_by && entity.modified_by_user"
														class="small text-muted mb-0"
													>
														by {{ entity.modified_by_user.full_name }}
													</p>
												</dd>
											</div>
											<div class="row">
												<dt class="col-5 text-muted h6 small">Due</dt>
												<dd class="col-7">
													<span v-if="entity.due_date">
														{{ $filters.fromNow(entity.due_date) }} on
														{{ $filters.formatDate(entity.due_date) }}
													</span>
													<span v-else class="text-muted"> &mdash; </span>
												</dd>
											</div>
											<div class="row">
												<dt class="col-5 text-muted h6 small" title="Unable To Complete">
													UTC
												</dt>
												<dd class="col-7">
													<div v-if="entity.unable_to_complete" class="text-warning">
														Unable To Complete
													</div>
													<div v-else class="text-muted">No</div>
												</dd>
											</div>
											<div class="row">
												<dt class="col-5 text-muted h6 small">Completed</dt>
												<dd class="col-7">
													<span v-if="entity.completed" class="text-success">
														Completed {{ $filters.fromNow(entity.completed_at) }}
														<span v-if="entity.completed_by && entity.completed_by_user">
															by {{ entity.completed_by_user.full_name }}
														</span>
													</span>
													<span v-else class="text-muted"> &mdash; </span>
												</dd>
											</div>
										</dl>
										</b-card>
										</b-col>
										</b-row>
                                         </b-tab>
                                 <b-tab>
								<template #title>Files</template>
								<b-tabs card pills>
								<b-tab no-body lazy>
                                <template #title>Case Documents </template>
								<CaseFiles
									ref="caseFiles"
									:id="$route.params.id"
									:flush="false"
									:selected.sync="selectedCaseFiles"
								/>
							    </b-tab>
								<b-tab no-body lazy active>
								<template #title>Appeal Documents</template>
								<AppealFiles
									ref="appealFiles"
									:id="$route.params.appeal_id"
									:flush="false"
									:selected.sync="selectedAppealFiles"
								/>
							</b-tab>
							<b-tab no-body lazy>
								<template #title> Created Documents</template>
								
							</b-tab>

								</b-tabs>
								
							</b-tab>
							<b-tab no-body>
								<template #title>
									<span>Create</span>
								</template>
								<b-tabs card pills>
									<b-tab no-body lazy>
										<template #title>Cover Page</template>
										<appeal-cover-page :appeal="appeal" @saved="savedCoverPage" />
									</b-tab>

									<b-tab no-body lazy>
										<template #title>Template</template>
										<b-card-body>
											<empty-result>
												No templates
												<template #content> No appeal response templates created. </template>
											</empty-result>
										</b-card-body>
									</b-tab>
									<b-tab no-body lazy>
										<template #title>Forms</template>
										<b-card-body>
											<b-list-group>
												<b-list-group-item
													href="https://www.hhs.gov/sites/default/files/omha-100.pdf"
													target="_blank"
												>
													<font-awesome-icon icon="file-pdf" fixed-width />
													OMHA-100
												</b-list-group-item>
											</b-list-group>
										</b-card-body>
									</b-tab>
							</b-tabs>
							</b-tab>
							<b-tab >
								<template #title>Notes</template>
								<add-note-form ref="addNoteForm" @submit="addNote" :saving="addingNote" />

								<div v-if="hasNotes" style="max-height:17rem" class="mt-2 overflow-y-auto">
									<transition-group name="fade">
										<div
											v-for="note in appeal.appeal_notes"
											:key="note.id"
											class="px-2 py-2 my-4 shadow-sm rounded border"
										>
											<user-note
												:note-id="note.id"
												:user="note.created_by_user"
												:body="note.notes"
												:timestamp="note.created"
												:deletable="canDeleteNote(note)"
												:deleting="deletingNote == note.id"
												@delete="deleteNote"
											/>
										</div>
									</transition-group>
								</div>
						</b-tab>

						<b-card-footer>
					<b-row>
						<b-col cols="12" md="6" xl="4" class="mb-4 mb-md-0">
							<b-button v-if="!disableCancel" block variant="light" @click="remove">Cancel</b-button>
						</b-col>
						<b-col cols="12" md="6" offset-xl="4" xl="4">
							<b-button
								block
								variant="primary"
								@click="ispacket = !ispacket"
							>
							<font-awesome-icon :icon="ispacket ? 'minus' : 'plus'" fixed-width />
                            <span>Packet</span>
							</b-button>
						</b-col>
					</b-row>
				</b-card-footer>
										</b-tabs>	
			    </b-card>
            </b-col>
			<b-col cols="6" v-if="ispacket" >
					<b-card no-body active>
						<b-tabs card active-nav-item-class="font-weight-bold">
							<b-tab no-body>
								<template #title>Build</template>
								<appeal-response
									:value="appeal"
									:appeal-files="selectedAppealFiles"
									:case-files="selectedCaseFiles"
									show-case-files
									@submitted="appealPacketSubmitted"
									@remove="unselectFile"
								/>
							</b-tab>
							
							
							<b-tab no-body>
								<template #title>
									<span>UTC</span>

									<b-badge variant="warning" v-if="appeal.unable_to_complete === true" pill>
										<font-awesome-icon icon="exclamation-triangle" class="mx-0 px-0" />
									</b-badge>
								</template>
								<appeal-utc :appeal="appeal" @saved="updatedUtc" disable-cancel />
							</b-tab>

							<b-tab v-if="hasIncomingDocuments" no-body lazy>
								<template #title>Incoming</template>
								<b-alert show variant="info" class="rounded-0 mb-0">
									<font-awesome-icon icon="info-circle" fixed-width />
									Incoming documents are copied to this appeal's files when attaching.
								</b-alert>
								<b-tabs v-if="appeal.incoming_documents.length > 0" card pills lazy vertical>
									<b-tab v-for="document in appeal.incoming_documents" :key="document.id" no-body>
										<template #title>
											<span>{{ $filters.formatTimestamp(document.created) }}</span>
										</template>
										<pdf-frame v-if="document.preview_url" :url="document.preview_url" />
									</b-tab>
								</b-tabs>
								<empty-result v-else>
									No attached documents
									<template #content>
										<p>Documents can be attached from Incoming Documents.</p>
									</template>
								</empty-result>
							</b-tab>
						
						
							<b-tab no-body>
								<template #title>Collaborate</template>

								<b-tabs card pills active-nav-item-class="font-weight-bold">
									<b-tab title="Guest Portal" no-body>
										<appeal-guest-portal
											:appeal="appeal"
											:case-entity="caseEntity"
											@saved="addedPortal"
										/>
									</b-tab>
									<b-tab v-if="enableVendorService">
										<template #title>
											{{ serviceName }}
											<b-badge variant="light">Pro</b-badge>
										</template>
										<appeal-vendor-stages
											:appeal="appeal"
											:case-entity="caseEntity"
											@saved="updatedAppeal"
											@submitted="submittedAppeal"
											@reopened="reopenedAppeal"
											@closed="closedAppeal"
										/>
									</b-tab>
								</b-tabs>
							</b-tab>
							
						</b-tabs>
					</b-card>
				</b-col>
			
		</b-row>
		<!--appeal section start here-->
			<b-row>
				<b-col cols="12" md="12" lg="6" >
					<b-card no-body>
						<b-tabs card active-nav-item-class="font-weight-bold">
							<b-tab>
								<template #title>Files</template>
								<b-tabs card pills>
								<b-tab no-body lazy>
                                <template #title>Case Documents </template>
								<CaseFiles
									ref="caseFiles"
									:id="$route.params.id"
									:flush="false"
									:selected.sync="selectedCaseFiles"
								/>
							    </b-tab>
								<b-tab no-body lazy active>
								<template #title>Appeal Documents</template>
								<AppealFiles
									ref="appealFiles"
									:id="$route.params.appeal_id"
									:flush="false"
									:selected.sync="selectedAppealFiles"
								/>
							</b-tab>
							<b-tab no-body lazy>
								<template #title> Created Documents</template>
								
							</b-tab>

								</b-tabs>
								
							</b-tab>
							<b-tab no-body>
								<template #title>
									<span>Create</span>
								</template>
								<b-tabs card pills>
									<b-tab no-body lazy>
										<template #title>Cover Page</template>
										<appeal-cover-page :appeal="appeal" @saved="savedCoverPage" />
									</b-tab>

									<b-tab no-body lazy>
										<template #title>Template</template>
										<b-card-body>
											<empty-result>
												No templates
												<template #content> No appeal response templates created. </template>
											</empty-result>
										</b-card-body>
									</b-tab>
									<b-tab no-body lazy>
										<template #title>Forms</template>
										<b-card-body>
											<b-list-group>
												<b-list-group-item
													href="https://www.hhs.gov/sites/default/files/omha-100.pdf"
													target="_blank"
												>
													<font-awesome-icon icon="file-pdf" fixed-width />
													OMHA-100
												</b-list-group-item>
											</b-list-group>
										</b-card-body>
									</b-tab>
							</b-tabs>
							</b-tab>
							<b-tab >
								<template #title>Notes</template>
								<add-note-form ref="addNoteForm" @submit="addNote" :saving="addingNote" />

								<div v-if="hasNotes" style="max-height:17rem" class="mt-2 overflow-y-auto">
									<transition-group name="fade">
										<div
											v-for="note in appeal.appeal_notes"
											:key="note.id"
											class="px-2 py-2 my-4 shadow-sm rounded border"
										>
											<user-note
												:note-id="note.id"
												:user="note.created_by_user"
												:body="note.notes"
												:timestamp="note.created"
												:deletable="canDeleteNote(note)"
												:deleting="deletingNote == note.id"
												@delete="deleteNote"
											/>
										</div>
									</transition-group>
								</div>
						</b-tab>
					</b-tabs>
					</b-card>
				</b-col>
							
				<b-col cols="12" md="12" lg="6" >
					<b-card no-body active>
						<b-tabs card active-nav-item-class="font-weight-bold">
							<b-tab no-body>
								<template #title>Build</template>
									<appeal-response
									:value="appeal"
									:appeal-files="selectedAppealFiles"
									:case-files="selectedCaseFiles"
									show-case-files
									@submitted="appealPacketSubmitted"
									@remove="unselectFile"
								/>
							</b-tab>
							<!--<b-tab no-body>
								<template #title>
									<span>Create</span>
								</template>
								<b-tabs card pills>
									<b-tab no-body lazy>
										<template #title>Cover Page</template>
										<appeal-cover-page :appeal="appeal" @saved="savedCoverPage" />
									</b-tab>

									<b-tab no-body lazy>
										<template #title>Template</template>
										<b-card-body>
											<empty-result>
												No templates
												<template #content> No appeal response templates created. </template>
											</empty-result>
										</b-card-body>
									</b-tab> 
									</b-tab> 
									<b-tab no-body lazy>
										<template #title>Forms</template>
										<b-card-body>
											<b-list-group>
												<b-list-group-item
													href="https://www.hhs.gov/sites/default/files/omha-100.pdf"
													target="_blank"
												>
													<font-awesome-icon icon="file-pdf" fixed-width />
													OMHA-100
												</b-list-group-item>
											</b-list-group>
										</b-card-body>
									</b-tab>
								</b-tabs>
							</b-tab> 
							</b-tab> -->
							<b-tab no-body>
								<template #title>
									<span>Defendable</span>

									<font-awesome-icon
										v-if="appeal.defendable === true"
										icon="check-circle"
										class="ml-1 pr-0 text-success"
									/>
									<font-awesome-icon
										v-else-if="appeal.defendable === false"
										icon="ban"
										class="ml-1 pr-0 text-danger"
									/>
								</template>
								<appeal-defendable :appeal="appeal" @saved="updatedDefendable" disable-cancel />
							</b-tab>
							<b-tab no-body>
								<template #title>
									<span>UTC</span>

									<b-badge variant="warning" v-if="appeal.unable_to_complete === true" pill>
										<font-awesome-icon icon="exclamation-triangle" class="mx-0 px-0" />
									</b-badge>
								</template>
								<appeal-utc :appeal="appeal" @saved="updatedUtc" disable-cancel />
							</b-tab>

							<b-tab v-if="hasIncomingDocuments" no-body lazy>
								<template #title>Incoming</template>
								<b-alert show variant="info" class="rounded-0 mb-0">
									<font-awesome-icon icon="info-circle" fixed-width />
									Incoming documents are copied to this appeal's files when attaching.
								</b-alert>
								<b-tabs v-if="appeal.incoming_documents.length > 0" card pills lazy vertical>
									<b-tab v-for="document in appeal.incoming_documents" :key="document.id" no-body>
										<template #title>
											<span>{{ $filters.formatTimestamp(document.created) }}</span>
										</template>
										<pdf-frame v-if="document.preview_url" :url="document.preview_url" />
									</b-tab>
								</b-tabs>
								<empty-result v-else>
									No attached documents
									<template #content>
										<p>Documents can be attached from Incoming Documents.</p>
									</template>
								</empty-result>
							</b-tab>
						<!--	<b-tab >
							<b-tab >
								<template #title>Notes</template>
								<add-note-form ref="addNoteForm" @submit="addNote" :saving="addingNote" />

								<div v-if="hasNotes" style="max-height:17rem" class="mt-2 overflow-y-auto">
									<transition-group name="fade">
										<div
											v-for="note in appeal.appeal_notes"
											:key="note.id"
											class="px-2 py-2 my-4 shadow-sm rounded border"
										>
											<user-note
												:note-id="note.id"
												:user="note.created_by_user"
												:body="note.notes"
												:timestamp="note.created"
												:deletable="canDeleteNote(note)"
												:deleting="deletingNote == note.id"
												@delete="deleteNote"
											/>
										</div>
									</transition-group>
								</div>
						</b-tab> 
						</b-tab> -->
							<b-tab no-body>
								<template #title>Collaborate</template>

								<b-tabs card pills active-nav-item-class="font-weight-bold">
									<b-tab title="Guest Portal" no-body>
										<appeal-guest-portal
											:appeal="appeal"
											:case-entity="caseEntity"
											@saved="addedPortal"
										/>
									</b-tab>
									<b-tab v-if="enableVendorService">
										<template #title>
											{{ serviceName }}
											<b-badge variant="light">Pro</b-badge>
										</template>
										<appeal-vendor-stages
											:appeal="appeal"
											:case-entity="caseEntity"
											@saved="updatedAppeal"
											@submitted="submittedAppeal"
											@reopened="reopenedAppeal"
											@closed="closedAppeal"
										/>
									</b-tab>
								</b-tabs>
							</b-tab>
							<!--Hearing tab-->
							<b-tab no-body>
                                <template #title>Hearing</template>
                              <b-card-body>
								<validation-provider
									vid="hearing_date"
									name="Hearing Date"
									:rules="{ required: false }"
									v-slot="validationContext"
								>
									<b-form-group label="Hearing Date" label-for="hearing_date" label-cols-lg="4">
										<b-form-input
											name="hearing_date"
											type="date"
											v-model="hearing_date"
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
									vid="hearing_time"
									name="Hearing Time"
									:rules="{ required: false }"
									v-slot="validationContext"
								>
									<b-form-group label="Hearing Time" label-for="hearing_time" label-cols-lg="4">
										<b-form-input
											name="hearing_time"
											type="time"
											v-model="hearing_time"
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

								<b-form-group label="Meeting Type" label-for="meeting_type" label-cols-lg="4">
      <b-form-select
        id="meeting_type"
        v-model="entity.meeting_type"
        :disabled="saving"
      >
        <option value="Location">Location</option>
        <option value="Telephonic">Telephonic</option>
        <option value="Video Conference">Video Conference</option>
      </b-form-select>
    </b-form-group>

    <!-- Render input based on selected Meeting Type -->
    <template v-if="entity.meeting_type === 'Location'">
      <b-form-group label="Address" label-for="address" label-cols-lg="4">
        <b-form-input
          id="address"
          v-model="entity.address"
          :disabled="saving"
        />
      </b-form-group>
    </template>
    <template v-else-if="entity.meeting_type === 'Telephonic'">
      <b-form-group label="Phone Number" label-for="phone_number" label-cols-lg="4">
        <b-form-input
          id="phone_number"
          v-model="entity.phone_number"
          :disabled="saving"
        />
      </b-form-group>
    </template>
    <template v-else-if="entity.meeting_type === 'Video Conference'">
      <b-form-group label="Conference URL" label-for="conference_url" label-cols-lg="4">
        <b-form-input
          id="conference_url"
          v-model="entity.conference_url"
          :disabled="saving"
        />
      </b-form-group>
    </template>
  </b-card-body>
								
				<b-card-footer>
					<b-row>
						<b-col cols="12" md="6" xl="4" class="mb-4 mb-md-0">
							<b-button v-if="!disableCancel" block variant="light" @click="cancel">Cancel</b-button>
						</b-col>
						<b-col cols="12" md="6" offset-xl="4" xl="4">
							<b-button
								block
								variant="primary"
								type="submit"
								:disabled="saving"
								:title="invalid ? 'Please fix any validation errors' : 'Save'"
								@click="save"
							>
								<font-awesome-icon icon="circle-notch" v-if="saving" spin fixed-width />
								<span>Save</span>
							</b-button>
						</b-col>
					</b-row>
				</b-card-footer>
                              </b-tab>

						</b-tabs>
					</b-card>
				</b-col>
			</b-row>
			<b-row> 
			<b-col  md="12" lg="6" class="mt-2 col" >
				<b-card  no-body>
				    <div >
						<nav class="d-flex justify-content-between align-item-center p-2 " style="background-color:#eeeeee;">
							<p class=" font-weight-bold h5 ml-4 align-item-center text-center" >Notes</p>
								<b-button @click="notesToggele();" class="bg-primary mr-3 "> 
									 
									<font-awesome-icon icon="plus" fixed-width />
							
						        </b-button>
						</nav>
                                <add-note-form ref="addNoteForm" @submit="addNote" :saving="addingNote" v-if="toggele" class="m-4"/>
								<div v-if="hasNotes"  style="max-height: 20rem" class="m-4  overflow-y-auto">
									<transition-group name="fade">
										<div
											v-for="note in appeal.appeal_notes"
											:key="note.id"
											class="px-2 py-2 my-4 shadow-sm rounded border"
										>
											<user-note
												:note-id="note.id"
												:user="note.created_by_user"
												:body="note.notes"
												:timestamp="note.created"
												:deletable="canDeleteNote(note)"
												:deleting="deletingNote == note.id"
												@delete="deleteNote"
											/>
										</div>
									</transition-group>
								</div>
					</div>		
				</b-card>
			</b-col>
		</b-row>
		</div>
	</b-container>
</template>

<script type="text/javascript">
import { mapGetters } from "vuex";

import AppealAssign from "@/clients/components/Appeals/Assign.vue";
import AppealCoverPage from "@/clients/components/Appeals/CoverPage.vue";
import AppealDefendable from "@/clients/components/Appeals/Defendable.vue";
import AppealFiles from "@/clients/components/Appeals/Files.vue";
import AppealForm from "@/clients/components/Appeals/Form.vue";
import AppealGuestPortal from "@/clients/components/Appeals/GuestPortal.vue";
import AppealResponse from "@/clients/components/Appeals/Response.vue";
import AppealStatusLabel from "@/clients/components/Appeals/StatusLabel.vue";
import AppealSummary from "@/clients/components/Appeals/Summary.vue";
import AppealUtc from "@/clients/components/Appeals/UnableToComplete.vue";
import AppealVendorStages from "@/clients/components/Appeals/VendorStages.vue";
import CaseIncomingDocument from "@/clients/components/Cases/IncomingDocument.vue";
import CaseFiles from "@/clients/components/Cases/Files.vue";

import AddNoteForm from "@/shared/components/AddNoteForm.vue";
import UserNote from "@/shared/components/UserNote.vue";
import PdfFrame from "@/shared/components/PdfFrame.vue";
import CaseRequestStatusLabel from "@/clients/components/CaseRequests/StatusLabel.vue";
import CaseRequestAssign from "@/clients/components/CaseRequests/Assign.vue";
import CaseRequestForm from "@/clients/components/CaseRequests/Form.vue";
import AttachCaseListItem from "@/clients/components/IncomingDocuments/AttachCaseListItem.vue";
import { formatErrors, getValidationState } from "@/validation";
import axios from "axios";

export default {
	name: "ViewAppeal",
	props: {
		value: {
			type: Object,
			default: () => {
				return {
					id: null,
					incoming_documents: [],
					appeal_reference_numbers: [],
					appeal_notes: [],
					appeal_type: {
						id: null,
						name: null,
					},
					guest_portals: [],
					unable_to_complete: null,
					can_cancel: false,
					can_delete: false,
					id : null,
					client_id: null,
					created: null,
					created_by: null,
					modified: null,
					modified_by: null,
					deleted: null,
					deleted_by: null,
					case_id: null,
					request_type: null,
					name: null,
					unable_to_complete: null,
					due_date: null,
					completed: null,
					completed_at: null,
					completed_by: null,
					assigned: null,
					assigned_to: null,
					assigned_to_user: null,
					insurance_provider_id: null,
					insurance_provider: null,
					agency_id: null,
					agency: null,
					// Virtual
					days_due_left: null,
					status_label: "",
					type_label: "",
				};
			},
		},
		caseEntity: {
			type: Object,
			default: () => {
				return {
					id: null,
					patient: {
						id: null,
						full_name: null,
					},
					closed: null,
					insurance_provider: null,
					insurance_type: null,
				};
			},
		},
		enableVendorService: {
			type: Boolean,
			default: true,
		},
		disableCancel: {
			type: Boolean,
			default: false,
		},
	},
	components: {
		AppealAssign,
		AppealCoverPage,
		AppealDefendable,
		AppealFiles,
		AppealForm,
		AppealGuestPortal,
		AppealResponse,
		AppealStatusLabel,
		AppealSummary,
		AppealUtc,
		AppealVendorStages,
		CaseIncomingDocument,
		CaseFiles,
		AddNoteForm,
		UserNote,
		PdfFrame,
		CaseRequestStatusLabel,
		CaseRequestAssign,
		CaseRequestForm,
		AttachCaseListItem,
	},
	computed: {
		caseClosed() {
			return this.caseEntity.closed && this.caseEntity.closed !== null;
		},
		insuranceProvider() {
			if (!this.caseEntity || !this.caseEntity.insurance_provider) {
				return false;
			}

			return this.caseEntity.insurance_provider;
		},
		insuranceType() {
			if (!this.caseEntity || !this.caseEntity.insurance_type) {
				return false;
			}

			return this.caseEntity.insurance_type;
		},
		hasIncomingDocuments() {
			return this.appeal.incoming_documents && this.appeal.incoming_documents.length > 0;
		},
		hasReferenceNumbers() {
			return this.appeal.appeal_reference_numbers && this.appeal.appeal_reference_numbers.length > 0;
		},
		hasNotes() {
			return this.appeal.appeal_notes && this.appeal.appeal_notes.length > 0;
		},
		canCancel() {
			return this.appeal.can_cancel || false;
		},
		canDelete() {
			return this.appeal.can_delete || false;
		},
		canReopen() {
			return this.appeal.can_reopen || false;
		},
		...mapGetters({
			user: "user",
			serviceName: "vendorServiceName",
		}),
	},
	data() {
		return {
			appeal: this.value,
			loading: true,
			error: false,
			editing: false,
			cancelling: false,
			deleting: false,
			updating: false,
			reopening: false,
			addingNote: null,
			deletingNote: null,
			showDetails: false,
			selectedCaseFiles: [],
			selectedAppealFiles: [],
			toggele:false,
			entity: this.value,
			hearing_date: null,
			hearing_time: null,
			meeting_type: null,
			address: null,
			phone_number: null,
			conference_url: null,
			saving: false,
			addingRequest: false,
			isRequest: false,
			ispacket: false,
		};
	},
	
	mounted() {
		this.refresh();
		this.hearing();
	},
	methods: {
		/**
		 * Get Details
		 */
		 cancel(e) {
			if (e) {
				e.preventDefault();
			}

			this.$emit("cancel");
		},
		 async refresh() {
			try {
				this.loading = true;
				this.error = false;

				const response = await this.$store.dispatch("caseRequests/get", {
					case_id: this.$route.params.id,
					id: this.$route.params.case_request_id,
				});

				this.entity = response;
			} catch (e) {
				this.error = true;
				this.$store.dispatch("apiError", {
					error: e,
					message: "Failed to find request",
				});
			} finally {
				this.loading = false;
			}
		},
		async refresh() {
			try {
				this.loading = true;
				this.error = false;

				const response = await this.$store.dispatch("appeals/get", {
					id: this.$route.params.appeal_id,
				});

				this.appeal = response;
			} catch (e) {
				this.$store.dispatch("apiError", {
					error: e,
					message: "Unable to load appeal details",
				});

				this.error = e.response.data.message || "Unable to load appeal details";
			} finally {
				this.loading = false;
			}
		},
		async setUTC() {
			try {
				this.updating = true;
				const newValue = !this.entity.unable_to_complete;

				const response = await this.$store.dispatch("caseRequests/setUtc", {
					case_id: this.$route.params.id,
					id: this.$route.params.case_request_id,
					unable_to_complete: newValue,
				});

				this.$emit("updated-request", response);

				this.$store.dispatch("notify", {
					variant: "primary",
					title: "Request Marked UTC",
					message: "Case request UTC status updated",
					data: response,
				});
			} catch (e) {
				this.$store.dispatch("apiError", {
					error: e,
					message: "Failed to update request UTC status",
				});
			} finally {
				this.updating = false;
			}
		},
		async updatedRequest(entity) {
			this.$emit("updated-request", entity);
			this.editing = false;
		},
		updatedAppeal(appeal, action = "") {
			if (appeal && appeal.id) {
				//this.$emit('update:appeal', appeal);
				this.$emit("saved", appeal);
			}

			this.$store.dispatch("notify", {
				variant: "primary",
				title: "Appeal Updated",
				message: "Appeal updated successfully.",
			});

			this.refresh();
		},
		submittedAppeal(appeal) {
			if (appeal && appeal.id) {
				//this.$emit('update:appeal', appeal);
				this.$emit("saved", appeal);
			}

			this.$store.dispatch("notify", {
				variant: "primary",
				title: "Appeal Submitted",
				message: "Appeal submitted successfully.",
			});

			this.refresh();
		},
		reopenedAppeal(appeal) {
			if (appeal && appeal.id) {
				//this.$emit('update:appeal', appeal);
				this.$emit("saved", appeal);
			}

			this.$emit("reopened", appeal);

			this.$store.dispatch("notify", {
				variant: "primary",
				title: "Appeal Reopened",
				message: "Appeal reopened successfully.",
			});

			this.refresh();
		},
		closedAppeal(appeal) {
			if (appeal && appeal.id) {
				//this.$emit('update:appeal', appeal);
				this.$emit("saved", appeal);
			}

			this.$store.dispatch("notify", {
				variant: "primary",
				title: "Appeal Closed",
				message: "Appeal closed successfully.",
			});

			this.refresh();
		},
		appealPacketSubmitted(response) {
			this.refresh();
		},
		updatedDefendable(appeal) {
			this.$store.dispatch("notify", {
				variant: "primary",
				title: "Appeal Defendability Updated",
				message: "Appeal defendable status updated.",
			});

			this.refresh();
		},
		updatedUtc(appeal) {
			this.$store.dispatch("notify", {
				variant: "primary",
				title: "Appeal UTC Updated",
				message: "Appeal UTC status updated.",
			});

			this.refresh();
		},
		assignedAppeal(response) {
			var message = "Appeal assigned to open queue.";
			if (response.assigned_to_user && response.assigned_to_user.full_name) {
				message = `Appeal assigned to ${response.assigned_to_user.full_name}.`;
			}

			this.$store.dispatch("notify", {
				variant: "primary",
				title: "Appeal Assigned",
				message: message,
			});

			this.$emit("update:appeal", response);
		},
		async cancelAppeal() {
			const message = "Are you sure you want to cancel this appeal?";
			if (!confirm(message)) {
				return false;
			}

			try {
				this.cancelling = true;

				const response = await this.$store.dispatch("appeals/cancel", {
					id: this.appeal.id,
				});

				this.$store.dispatch("notify", {
					variant: "primary",
					title: "Appeal Cancelled",
					message: `Appeal level ${this.appeal.appeal_level.name || "(Unknown)"} was cancelled.`,
				});

				this.$emit("cancelled", response.data);
				this.refresh();
			} catch (e) {
				this.$store.dispatch("apiError", {
					error: e,
					title: "Cancel Failed",
					message: "Failed to cancel appeal",
				});
			} finally {
				this.cancelling = false;
			}
		},
		async reopenAppeal() {
			const message = `Are you sure? This will reset the status to 'Open' and cancel any progression.`;
			if (!confirm(message)) {
				return false;
			}

			try {
				this.reopening = true;

				const response = await this.$store.dispatch("appeals/reopen", {
					id: this.appeal.id,
				});

				this.$store.dispatch("notify", {
					variant: "primary",
					title: "Appeal Reopened",
					message: `Appeal level ${this.appeal.appeal_level.name || "(Unknown)"} was reopened.`,
				});

				this.$emit("update:appeal", response);
				this.$emit("reopened", response);
				this.refresh();
			} catch (e) {
				this.$store.dispatch("apiError", {
					error: e,
					title: "Reopen Failed",
					message: "Failed to reopen appeal",
				});
			} finally {
				this.reopening = false;
			}
		},
		async deleteAppeal() {
			const message = "Are you sure you want to delete this appeal?";
			if (!confirm(message)) {
				return false;
			}

			try {
				this.deleting = true;

				const response = await this.$store.dispatch("appeals/delete", {
					id: this.appeal.id,
				});

				const appealLevel = (response.data.appeal_level && response.data.appeal_level.name) || "(Missing)";

				this.$emit("deleted", response.data);

				this.$router.push({
					name: "cases.view",
					params: {
						id: this.$route.params.id,
					},
				});

				this.$nextTick(() => {
					this.$store.dispatch("notify", {
						variant: "primary",
						title: "Appeal Deleted",
						message: `Appeal level ${appealLevel} was deleted.`,
					});
				});
			} catch (e) {
				this.$store.dispatch("apiError", {
					error: e,
					title: "Delete Failed",
					message: "Failed to delete appeal",
				});
			} finally {
				this.deleting = false;
			}
		},
		/**
		 * Edit
		 */
		savedEdit(appeal) {
			this.editing = false;
			this.refresh();
			this.$emit("updated", appeal);
		},
		/**
		 * Notes
		 */
		async addNote(note) {
			try {
				this.addingNote = true;

				const response = await this.$store.dispatch("appealNotes/addNote", {
					id: this.appeal.id,
					notes: note.notes,
				});

				this.appeal.appeal_notes.unshift(response);

				if (this.$refs.addNoteForm) {
					this.$refs.addNoteForm.reset();
				}
                
				if(this.toggele==true){
				this.toggele = false;
				
			    }else{
				this.toggele=true;
				
			}
                

			} catch (e) {
				this.$store.dispatch("apiError", {
					error: e,
					title: "Add Note Failed",
					message: "Failed to add appeal note",
				});
			} finally {
				this.addingNote = false;
				this.refresh();
			}
		},
		
		canDeleteNote(note) {
			if (!note || !note.id) return false;
			if (this.user.admin) return true;

			return note.created_by == this.user.id;
		},
		async deleteNote(noteId) {
			try {
				this.deletingNote = noteId;

				const response = await this.$store.dispatch("appealNotes/deleteNote", {
					appeal_id: this.appeal.id,
					id: noteId,
				});

				const index = this.appeal.appeal_notes.findIndex((note) => {
					return note.id == response.data.id;
				});

				if (index !== -1) {
					this.appeal.appeal_notes.splice(index, 1);
				}
			} catch (e) {
				this.$store.dispatch("apiError", {
					error: e,
					title: "Delete Note Failed",
					message: "Failed to delete appeal note",
				});
			} finally {
				this.deletingNote = null;
				this.refresh();
			}
		},
		/**
		 * Files
		 */
		unselectFile(selectedFile) {
			switch (selectedFile.source) {
				case "Appeal":
					const appealFileIdx = this.selectedAppealFiles.findIndex((file) => file == selectedFile.file);
					if (appealFileIdx !== -1) {
						this.selectedAppealFiles.splice(appealFileIdx, 1);
					}
					break;
				case "Case":
					const caseFileIdx = this.selectedCaseFiles.findIndex((file) => file == selectedFile.file);
					if (caseFileIdx !== -1) {
						this.selectedCaseFiles.splice(caseFileIdx, 1);
					}
					break;
				default:
					this.$store.dispatch("notify", {
						variant: "warning",
						title: "Invalid File Source",
						message: `File ${selectedFile.basename} from ${selectedFile.source} was unable to be unselected.`,
					});
					break;
			}
		},
		/**
		 * Portals
		 */
		addedPortal(portal) {
			console.log("New Guest Portal", portal);
			this.refresh();
		},
		/**
		 * Cover Page
		 */
		savedCoverPage(response) {
			this.$refs.appealFiles.refresh();
			this.refresh();
		},
        
		notesToggele(){
            if(this.toggele==false){
				this.toggele = true;
				
			}else{
				this.toggele=false;
				
			}
		},
		// request tabs 
		handleTabClick(caseRequest) {
			console.log('Appeal ID:', this.appeal.id);
			const appealId = caseRequest.id;

// Now you can use the appealId as needed
console.log('Clicked on nav item with appeal_id:', appealId);
        this.entity = {
        name: caseRequest.name,
        type_label: caseRequest.type_label,
		status_label: caseRequest.status_label,
		insurance_provider: caseRequest.insurance_provider,
		agency: caseRequest.agency,
		insurance_provider_id: caseRequest.insurance_provider_id,
		agency_id: caseRequest.agency_id,
        days_due_left: caseRequest.days_due_left,
		due_date: caseRequest.due_date,
		completed: caseRequest.completed,
		completed_at: caseRequest.completed_at,
		created: caseRequest.created,
		unable_to_complete: caseRequest.unable_to_complete,
		assigned_to_user: caseRequest.assigned_to_user,
		assigned_to: caseRequest.assigned_to,
		completed_by: caseRequest.completed_by,
      };
    }, 

	

	getValidationState,
		cancel() {
			this.$emit("cancel");
			this.reset();
		},
	// hearing save 
		async save(e) {
			try {
				this.saving = true;
				console.log("saving appeal =", this.entity.appeal_level_id)
				const response = await this.$store.dispatch("appeals/save", {
					hearing_date: this.entity.hearing_date,
					hearing_time: this.entity.hearing_time,
					meeting_type: this.entity.meeting_type,
				    address: this.entity.address,
				    phone_number: this.entity.phone_number,
				    conference_url: this.entity.conference_url,
				});

				this.saving = false;
				this.$emit("saved", response);
			} catch (e) {
				console.log('error =',e);
				if (e.response.data.errors) {
					this.$refs.observer.setErrors(formatErrors(e.response.data.errors));
				}

				this.$store.dispatch("apiError", {
					error: e,
					title: "Save Failed",
					message: "Failed to save appeal",
				});
			} finally {
				this.saving = false;
			}
		},
		reset() {
			this.entity = {
			
				hearing_date: null,
				hearing_time: null,
				meeting_type: null,
				address: null,
				phone_number: null,
				conference_url: null,
			};
		},
		//post request
		async hearing() {
			try{
			const url = "/client/hearing";
				
				const response = await axios.post(url, {
				headers: {
					"Accept": "application/json",
					// You can add other headers here if needed
				},
				});

		}catch (error) {
            console.error("Error fetching data:", error.message);
             }
    },
    openForm() {
      this.addingRequest=true;
    },
	addedRequest() {
      this.addingRequest = false;
	  this.isRequest= true;
	  this.ispacket = false;
    },
    remove(){
       this.isRequest = false;
	   this.ispacket = false;
    },

	},
};



</script>
