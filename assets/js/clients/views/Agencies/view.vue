<template>
	<div>
		<page-header>
			<template #title>
				<router-link :to="{ name: 'agencies' }" v-text="`Agencies /`" />
				<span>{{ entity.name }}</span>
			</template>
			<template #buttons>
				<b-button variant="primary" :to="{ name: 'agencies.edit', params: { id: $route.params.id } }" title="Edit">
					<font-awesome-icon icon="edit" fixed-width />
					<span>Edit</span>
				</b-button>

				<b-dropdown variant="secondary" right title="More Options">
					<template #button-content>
						<font-awesome-icon icon="cog" fixed-width />
					</template>

					<b-dropdown-item @click="destroy" :disabled="loading" variant="danger">
						<font-awesome-icon icon="trash" fixed-width />
						<span>Delete</span>
					</b-dropdown-item>
				</b-dropdown>
			</template>
		</page-header>

		<loading-indicator v-if="showLoading" class="my-5" />
		<div v-else class="my-4">
			<b-row>
				<b-col v-if="entity.full_address" cols="12" class="mb-2">
					<p class="text-muted mb-0" title="Address">
						<font-awesome-icon icon="location-dot" fixed-width />
						{{ entity.full_address }}
					</p>
				</b-col>
			</b-row>
			<b-row>
				<b-col cols="12" sm="6" lg="6" class="mb-2">
					<b-badge pill variant="primary" v-if="entity.outgoing_primary_method_label"
						title="Primary outgoing delivery method">
						{{ entity.outgoing_primary_method_label }}
					</b-badge>
					<b-badge pill variant="secondary" v-if="entity.active == false" title="Agency is not active">
						Inactive
					</b-badge>
					<b-badge pill variant="info" v-if="entity.third_party_contractor == true"
						title="Third party contractor">
						3rd Party
					</b-badge>
				</b-col>
				<b-col cols="12" sm="6" lg="6" class="mb-2 text-sm-right">
					<p class="small text-muted">
						<span> Last updated {{ $filters.fromNow(entity.modified) }} </span>
						<span v-if="entity.modified_by_user?.full_name">
							by {{ entity.modified_by_user.full_name }}
						</span>
					</p>
				</b-col>
			</b-row>



			<b-card no-body class="shadow-sm">
				<b-tabs card active-nav-item-class="font-weight-bold">
					<b-tab lazy>
    <template #title>Details</template>
    <b-card class="border mb-4">
        <b-card-header class="font-weight-bold">Outgoing Methods</b-card-header>
        <b-card-body>
            <b-row>
                <b-col cols="12" lg="6" class="mb-4">
                    <h6 class="h6 text-muted text-uppercase font-weight-bold">Email</h6>
                    <b-list-group v-if="entity.receiving_emails && entity.receiving_emails.length > 0">
                        <b-list-group-item v-for="(email, index) in entity.receiving_emails" :key="index">
                            <b-row>
                                <b-col cols="6">
                                    <h6>{{ email.email }}</h6>
                                </b-col>
                                <b-col cols="6"  class="text-right">
                                    <p class="small text-muted mb-0">{{ email.description }}</p>
                                </b-col>
                            </b-row>
                        </b-list-group-item>
                    </b-list-group>
                    <empty-result v-else>
                        No email methods
                        <template #content>
                            No email methods found for this agency.
                        </template>
                    </empty-result>
                </b-col>
                <b-col cols="12" lg="6" class="mb-4">
                    <h6 class="h6 text-muted text-uppercase font-weight-bold">Fax</h6>
                    <b-list-group v-if="entity.receiving_faxes && entity.receiving_faxes.length > 0">
                        <b-list-group-item v-for="(fax, index) in entity.receiving_faxes" :key="index">
                            <b-row>
                                <b-col cols="6">
                                    <h6>{{ fax.fax }}</h6>
                                </b-col>
                                <b-col cols="6" class="text-right">
                                    <p class="small text-muted mb-0">{{ fax.description }}</p>
                                </b-col>
                            </b-row>
                        </b-list-group-item>
                    </b-list-group>
                    <empty-result v-else>
                        No fax methods
                        <template #content>
                            No fax methods found for this agency.
                        </template>
                    </empty-result>
                </b-col>
            </b-row>
        </b-card-body>
    </b-card>

    <b-card class="border mb-4">
        <b-card-header class="font-weight-bold">Audit Reviewers</b-card-header>
        <b-card-body>
            <b-list-group v-if="entity.audit_reviewers && entity.audit_reviewers.length > 0">
                <b-list-group-item v-for="auditReviewer in entity.audit_reviewers" :key="auditReviewer.id"
                    :to="{ name: 'auditReviewers.view', params: { id: auditReviewer.id } }">
                    <div class="py-2 d-flex justify-start align-items-center">
                        <b-avatar rounded :variant="auditReviewer.active ? 'primary' : 'light'"
                            class="mr-3 px-0 text-center">
                            <font-awesome-icon icon="user" class="px-0 mx-0" />
                        </b-avatar>
                        <b-row class="flex-fill">
                            <b-col cols="12" class="text-left">
                                <h6 class="h6 font-weight-bold mb-1">{{ auditReviewer.full_name }}</h6>
                                <div>
                                    <b-badge pill variant="light" v-if="!auditReviewer.active">Inactive</b-badge>
                                </div>
                            </b-col>
                        </b-row>
                    </div>
                </b-list-group-item>
            </b-list-group>
            <empty-result v-else>
                No audit reviewers
                <template #content>Reviewers can be added to an agency to track denials.</template>
            </empty-result>
        </b-card-body>
    </b-card>
</b-tab>


				</b-tabs>
			</b-card>

			<b-card no-body class="mt-4 shadow-sm">
				<b-card-header class="font-weight-bold"> Outgoing Documents </b-card-header>
				<b-card-body>
					<paginated-results v-slot="{
						doSearch,
						empty,
						hasNextPage,
						hasPrevPage,
						loading,
						nextPage,
						prevPage,
						refresh,
						results,
					}" v-bind="{
	action: GetOutgoingDocuments,
	filters: outgoingFilters,
	search: outgoingSearch,
	perPage: outgoingPerPage,
}">
						<b-row class="mb-4">
							<b-col cols="6" md="6" lg="6" class="mb-0">
								<b-form @submit.prevent="doSearch">
									<search-input v-model="outgoingSearch" v-bind="{ loading }" />
								</b-form>
							</b-col>
							<b-col cols="6" md="6" lg="6" class="text-right">
								<simple-pagination v-bind="{ loading, nextPage, prevPage, hasPrevPage, hasNextPage }" />
							</b-col>
						</b-row>
						<b-row>
							<b-col cols="12">
								<loading-indicator v-if="loading && empty" size="4x" class="my-5" />
								<div v-else-if="!empty">
									<outgoing-document-list-item v-for="result in results" :key="result.id" :value="result"
										@updated="refresh" class="mb-2 shadow-sm" />
								</div>
								<empty-result v-else icon="envelope-open">
									No outgoing documents
									<template #content> No outgoing documents were found. </template>
								</empty-result>
							</b-col>
						</b-row>
					</paginated-results>
				</b-card-body>
			</b-card>
		</div>
	</div>
</template>

<script>
import { get as GetAgency, destroy as DeleteAgency } from "@/clients/services/agencies";
import { getIndex as GetOutgoingDocuments } from "@/clients/services/outgoingDocuments";
import OutgoingDocumentListItem from "@/clients/components/OutgoingDocuments/ListItem.vue";
import axios from "axios";

export default {
	name: "ViewAgency",
	components: {
		OutgoingDocumentListItem,
	},
	data() {
		return {
			loading: true,
			deleting: false,
			entity: {
				id: null,
				client_id: null,
				created: null,
				created_by: null,
				modified: null,
				modified_by: null,
				name: "",
				active: null,
				third_party_contractor: null,
				receiving_emails: [],
				receiving_faxes: [],
				outgoing_profile: {
					id: null,
					agency_id: null,
					email: null,
					fax_number: null,
					electronic_website: null,
					mail_to_name: null,
					contact_number: null,
				},
				audit_reviewers: [],
			},
			outgoingSearch: "",
			outgoingPerPage: 15,
		};
	},
	computed: {
		outgoingFilters() {
			return {
				agency_id: this.$route.params.id,
			};
		},
		showLoading() {
			return this.loading && (!this.entity.id || this.entity.id == null);
		},
	},
	mounted() {
		this.refresh();
		this.MultiAgencyContactList();
	},
	methods: {
		GetOutgoingDocuments,
		// async MultiAgencyContactList() {
		// 	try {
		// 		const url = "/client/multiagencycontactlist";

		// 		// Fetch data from the server
		// 		const response = await axios.get(url, {
		// 			headers: {
		// 				"Accept": "application/json",
		// 			},
		// 		});
		// 		// Clear existing data in receiving_emails and receiving_faxes arrays
		// 		this.entity.receiving_emails = [];
		// 		this.entity.receiving_faxes = [];

		// 		// Filter contacts based on the agency ID
		// 		const filteredContacts = response.data.filter(contact => contact.agency_id === this.id);

		// 		// Iterate over the filtered contacts and populate email and fax arrays
		// 		filteredContacts.forEach(contact => {
		// 			if (contact.agency_email) {
		// 				this.entity.receiving_emails.push({ email: contact.agency_email, description: contact.desc_email });
		// 			}
		// 			if (contact.agency_fax) {
		// 				this.entity.receiving_faxes.push({ fax: contact.agency_fax, description: contact.desc_fax });
		// 			}
		// 		});
		// 	} catch (error) {
		// 		console.error("Error fetching multi agency contact:", error);
		// 	}
		// },
		// async refresh() {
		// 	try {
		// 		this.loading = true;
		// 		this.entity = await GetAgency(this.$route.params.id);
		// 	} catch (e) {
		// 		this.$router.push({ name: "agencies" });

		// 		this.$nextTick(function () {
		// 			this.$store.dispatch("notify", {
		// 				variant: "danger",
		// 				title: "Agency Not Found",
		// 				message: `Agency details were not found.`,
		// 			});
		// 		});
		// 	} finally {
		// 		this.loading = false;
		// 	}
		// },
		async MultiAgencyContactList() {
			try {
				const url = "/client/multiagencycontactlist";

				// Fetch data from the server
				const response = await axios.get(url, {
					headers: {
						"Accept": "application/json",
					},
				});
				console.log("line 342");

				// Initialize arrays to store email and fax data
				const receivingEmails = [];
				const receivingFaxes = [];

				// Filter contacts based on the agency ID
				const filteredContacts = response.data.filter(contact => contact.agency_id === this.entity.id);

				// Iterate over the filtered contacts and populate email and fax arrays
				filteredContacts.forEach(contact => {
					if (contact.agency_email !== "NULL" && contact.desc_email !== "NULL") {
						receivingEmails.push({ email: contact.agency_email, description: contact.desc_email });
					}
					if (contact.agency_fax) {
						receivingFaxes.push({ fax: contact.agency_fax, description: contact.desc_fax });
					}
				});

				console.log("line 355");

				// Update entity data with email and fax data
				this.entity.receiving_emails = receivingEmails;
				this.entity.receiving_faxes = receivingFaxes;

				console.log("emails are", receivingEmails);
			} catch (error) {
				console.error("Error fetching multi agency contact:", error);
			}
		},

		async refresh() {
			try {
				this.loading = true;
				this.entity = await GetAgency(this.$route.params.id);
				await this.MultiAgencyContactList(); // Call the function to populate email and fax data
			} catch (e) {
				this.$router.push({ name: "agencies" });

				this.$nextTick(function () {
					this.$store.dispatch("notify", {
						variant: "danger",
						title: "Agency Not Found",
						message: `Agency details were not found.`,
					});
				});
			} finally {
				this.loading = false;
			}
		},
		async destroy() {
			if (!confirm("Are you sure you want to delete this agency?")) {
				return;
			}

			try {
				this.deleting = true;
				const response = await DeleteAgency(this.$route.params.id);
				this.$router.push({ name: "agencies" });

				this.$nextTick(function () {
					this.$store.dispatch("notify", {
						variant: "primary",
						title: "Agency Deleted",
						message: `Agency ${response.data.name} was deleted.`,
					});
				});
			} catch (e) {
				this.$store.dispatch("apiError", {
					error: e,
					title: "Delete Failed",
					message: "Failed to delete agency",
				});
			} finally {
				this.deleting = false;
			}
		},
	},
	watch: {
		"$route.params.id": {
			handler(val) {
				this.entity = {
					id: null,
					name: null,
				};

				this.refresh();
			},
		},
	},
};
</script>
