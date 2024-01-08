<template>
	<loading-indicator v-if="loading" class="my-5" title="Fetching role..." />
	<validation-observer
		v-else
		tag="form"
		v-bind="$attrs"
		ref="observer"
		v-slot="{ validated, invalid }"
		@submit.prevent="save"
	>
		<b-card no-body>
			<slot name="header" v-bind="{ invalid, loading, saving, save, validated }"></slot>
			<b-card-body>
				<form-group
					name="name"
					label="Name"
					:rules="{ required: true, min: 2, max: 60 }"
					v-slot="{ state }"
					label-cols-lg="4"
					label-cols-xl="2"
					class="mb-4"
				>
					<b-form-input
						name="name"
						type="text"
						size="lg"
						v-model="entity.name"
						required
						placeholder="Required"
						:state="state"
						:disabled="saving"
					/>
				</form-group>
				<b-row>
					<b-col cols="12" md="6" lg="6">
						<form-group label="Members" name="users._ids" label-cols-lg="4">
							<b-form-checkbox-group
								stacked
								name="user_ids"
								v-model="entity.users._ids"
								:options="users"
								:disabled="saving || loadingUsers"
								value-field="id"
								text-field="full_name"
							/>
						</form-group>
					</b-col>
					<b-col cols="12" md="6" lg="6">
            <form-group label="Permissions" name="permissions._ids" label-cols-lg="4">
				<div class="main-permissions" style="height: 300px; overflow-y: auto;">
              <div class="permission-subheading" style="color: #808080;">AGENCIES</div>
              <b-form-checkbox-group
                stacked
                name="permission_ids"
                v-model="entity.permissions._ids"
                :options="hardcodedPermissions['AGENCIES']"
                :disabled="saving || loadingPermissions"
                value-field="name"
                text-field="name"
              />
              <div class="permission-subheading" style="color: #808080;">APPEAL FILES</div>
              <b-form-checkbox-group
                stacked
                name="permission_ids"
                v-model="entity.permissions._ids"
                :options="hardcodedPermissions['APPEAL FILES']"
                :disabled="saving || loadingPermissions"
                value-field="name"
                text-field="name"
              />
              <div class="permission-subheading" style="color: #808080;">APPEAL LEVELS</div>
              <b-form-checkbox-group
                stacked
                name="permission_ids"
                v-model="entity.permissions._ids"
                :options="hardcodedPermissions['APPEAL LEVELS']"
                :disabled="saving || loadingPermissions"
                value-field="name"
                text-field="name"
              />
              <div class="permission-subheading" style="color: #808080;">APPEAL NOTES</div>
              <b-form-checkbox-group
                stacked
                name="permission_ids"
                v-model="entity.permissions._ids"
                :options="hardcodedPermissions['APPEAL NOTES']"
                :disabled="saving || loadingPermissions"
                value-field="name"
                text-field="name"
              />
              <div class="permission-subheading" style="color: #808080;">APPEALS</div>
              <b-form-checkbox-group
                stacked
                name="permission_ids"
                v-model="entity.permissions._ids"
                :options="hardcodedPermissions['APPEALS']"
                :disabled="saving || loadingPermissions"
                value-field="name"
                text-field="name"
              />
              <div class="permission-subheading" style="color: #808080;">APPEAL TEMPLATES</div>
              <b-form-checkbox-group
                stacked
                name="permission_ids"
                v-model="entity.permissions._ids"
                :options="hardcodedPermissions['APPEAL TEMPLATES']"
                :disabled="saving || loadingPermissions"
                value-field="name"
                text-field="name"
              />
              <div class="permission-subheading" style="color: #808080;">CASE FILES</div>
              <b-form-checkbox-group
                stacked
                name="permission_ids"
                v-model="entity.permissions._ids"
                :options="hardcodedPermissions['CASE FILES']"
                :disabled="saving || loadingPermissions"
                value-field="name"
                text-field="name"
              />
              <div class="permission-subheading" style="color: #808080;">CASE OUTCOMES</div>
              <b-form-checkbox-group
                stacked
                name="permission_ids"
                v-model="entity.permissions._ids"
                :options="hardcodedPermissions['CASE OUTCOMES']"
                :disabled="saving || loadingPermissions"
                value-field="name"
                text-field="name"
              />
              <div class="permission-subheading" style="color: #808080;">CASES</div>
              <b-form-checkbox-group
                stacked
                name="permission_ids"
                v-model="entity.permissions._ids"
                :options="hardcodedPermissions['CASES']"
                :disabled="saving || loadingPermissions"
                value-field="name"
                text-field="name"
              />
              <div class="permission-subheading" style="color: #808080;">CASE TYPES</div>
              <b-form-checkbox-group
                stacked
                name="permission_ids"
                v-model="entity.permissions._ids"
                :options="hardcodedPermissions['CASE TYPES']"
                :disabled="saving || loadingPermissions"
                value-field="name"
                text-field="name"
              />
			  <div class="permission-subheading" style="color: #808080;">CLIENT EMPLOYEES</div>
              <b-form-checkbox-group
                stacked
                name="permission_ids"
                v-model="entity.permissions._ids"
                :options="hardcodedPermissions['CLIENT EMPLOYEES']"
                :disabled="saving || loadingPermissions"
                value-field="name"
                text-field="name"
              />
			  <div class="permission-subheading" style="color: #808080;">CLIENT EMPLOYEE TYPES</div>
              <b-form-checkbox-group
                stacked
                name="permission_ids"
                v-model="entity.permissions._ids"
                :options="hardcodedPermissions['CLIENT EMPLOYEE TYPES']"
                :disabled="saving || loadingPermissions"
                value-field="name"
                text-field="name"
              />
			  <div class="permission-subheading" style="color: #808080;">CLIENTS</div>
              <b-form-checkbox-group
                stacked
                name="permission_ids"
                v-model="entity.permissions._ids"
                :options="hardcodedPermissions['CLIENTS']"
                :disabled="saving || loadingPermissions"
                value-field="name"
                text-field="name"
              />
			  <div class="permission-subheading" style="color: #808080;">DENIAL TYPES</div>
<b-form-checkbox-group
  stacked
  name="permission_ids"
  v-model="entity.permissions._ids"
  :options="hardcodedPermissions['DENIAL TYPES']"
  :disabled="saving || loadingPermissions"
  value-field="name"
  text-field="name"
/>

<div class="permission-subheading" style="color: #808080;">EVIDENCE CRITERIA</div>
<b-form-checkbox-group
  stacked
  name="permission_ids"
  v-model="entity.permissions._ids"
  :options="hardcodedPermissions['EVIDENCE CRITERIA']"
  :disabled="saving || loadingPermissions"
  value-field="name"
  text-field="name"
/>

<div class="permission-subheading" style="color: #808080;">FACILITIES</div>
<b-form-checkbox-group
  stacked
  name="permission_ids"
  v-model="entity.permissions._ids"
  :options="hardcodedPermissions['FACILITIES']"
  :disabled="saving || loadingPermissions"
  value-field="name"
  text-field="name"
/>

<div class="permission-subheading" style="color: #808080;">FACILITY FAXES</div>
<b-form-checkbox-group
  stacked
  name="permission_ids"
  v-model="entity.permissions._ids"
  :options="hardcodedPermissions['FACILITY FAXES']"
  :disabled="saving || loadingPermissions"
  value-field="name"
  text-field="name"
/>

<div class="permission-subheading" style="color: #808080;">FACILITY TYPES</div>
<b-form-checkbox-group
  stacked
  name="permission_ids"
  v-model="entity.permissions._ids"
  :options="hardcodedPermissions['FACILITY TYPES']"
  :disabled="saving || loadingPermissions"
  value-field="name"
  text-field="name"
/>

<div class="permission-subheading" style="color: #808080;">GUIDELINE FILES</div>
<b-form-checkbox-group
  stacked
  name="permission_ids"
  v-model="entity.permissions._ids"
  :options="hardcodedPermissions['GUIDELINE FILES']"
  :disabled="saving || loadingPermissions"
  value-field="name"
  text-field="name"
/>

<div class="permission-subheading" style="color: #808080;">GUIDELINES</div>
<b-form-checkbox-group
  stacked
  name="permission_ids"
  v-model="entity.permissions._ids"
  :options="hardcodedPermissions['GUIDELINES']"
  :disabled="saving || loadingPermissions"
  value-field="name"
  text-field="name"
/>

<div class="permission-subheading" style="color: #808080;">INCOMING FAXES</div>
<b-form-checkbox-group
  stacked
  name="permission_ids"
  v-model="entity.permissions._ids"
  :options="hardcodedPermissions['INCOMING FAXES']"
  :disabled="saving || loadingPermissions"
  value-field="name"
  text-field="name"
/>

<div class="permission-subheading" style="color: #808080;">INSURANCE PROVIDERS</div>
<b-form-checkbox-group
  stacked
  name="permission_ids"
  v-model="entity.permissions._ids"
  :options="hardcodedPermissions['INSURANCE PROVIDERS']"
  :disabled="saving || loadingPermissions"
  value-field="name"
  text-field="name"
/>

<div class="permission-subheading" style="color: #808080;">INSURANCE TYPES</div>
<b-form-checkbox-group
  stacked
  name="permission_ids"
  v-model="entity.permissions.__ids"
  :options="hardcodedPermissions['INSURANCE TYPES']"
  :disabled="saving || loadingPermissions"
  value-field="name"
  text-field="name"
/>

<div class="permission-subheading" style="color: #808080;">LIBRARIES</div>
<b-form-checkbox-group
  stacked
  name="permission_ids"
  v-model="entity.permissions._ids"
  :options="hardcodedPermissions['LIBRARIES']"
  :disabled="saving || loadingPermissions"
  value-field="name"
  text-field="name"
/>
<div class="permission-subheading" style="color: #808080;">NOT DEFENDABLE REASONS</div>
<b-form-checkbox-group
  stacked
  name="permission_ids"
  v-model="entity.permissions._ids"
  :options="hardcodedPermissions['NOT DEFENDABLE REASONS']"
  :disabled="saving || loadingPermissions"
  value-field="name"
  text-field="name"
/>

<div class="permission-subheading" style="color: #808080;">OUTBOUND EMAILS</div>
<b-form-checkbox-group
  stacked
  name="permission_ids"
  v-model="entity.permissions._ids"
  :options="hardcodedPermissions['OUTBOUND EMAILS']"
  :disabled="saving || loadingPermissions"
  value-field="name"
  text-field="name"
/>

<div class="permission-subheading" style="color: #808080;">OUTBOUND FAXES</div>
<b-form-checkbox-group
  stacked
  name="permission_ids"
  v-model="entity.permissions._ids"
  :options="hardcodedPermissions['OUTBOUND FAXES']"
  :disabled="saving || loadingPermissions"
  value-field="name"
  text-field="name"
/>

<div class="permission-subheading" style="color: #808080;">PATIENTS</div>
<b-form-checkbox-group
  stacked
  name="permission_ids"
  v-model="entity.permissions._ids"
  :options="hardcodedPermissions['PATIENTS']"
  :disabled="saving || loadingPermissions"
  value-field="name"
  text-field="name"
/>

<div class="permission-subheading" style="color: #808080;">REFERENCE NUMBERS</div>
<b-form-checkbox-group
  stacked
  name="permission_ids"
  v-model="entity.permissions._ids"
  :options="hardcodedPermissions['REFERENCE NUMBERS']"
  :disabled="saving || loadingPermissions"
  value-field="name"
  text-field="name"
/>

<div class="permission-subheading" style="color: #808080;">REPORTS</div>
<b-form-checkbox-group
  stacked
  name="permission_ids"
  v-model="entity.permissions._ids"
  :options="hardcodedPermissions['REPORTS']"
  :disabled="saving || loadingPermissions"
  value-field="name"
  text-field="name"
/>

<div class="permission-subheading" style="color: #808080;">ROLES</div>
<b-form-checkbox-group
  stacked
  name="permission_ids"
  v-model="entity.permissions._ids"
  :options="hardcodedPermissions['ROLES']"
  :disabled="saving || loadingPermissions"
  value-field="name"
  text-field="name"
/>

<div class="permission-subheading" style="color: #808080;">TAGS</div>
<b-form-checkbox-group
  stacked
  name="permission_ids"
  v-model="entity.permissions._ids"
  :options="hardcodedPermissions['TAGS']"
  :disabled="saving || loadingPermissions"
  value-field="name"
  text-field="name"
/>

<div class="permission-subheading" style="color: #808080;">TEMPLATE ITEMS</div>
<b-form-checkbox-group
  stacked
  name="permission_ids"
  v-model="entity.permissions._ids"
  :options="hardcodedPermissions['TEMPLATE ITEMS']"
  :disabled="saving || loadingPermissions"
  value-field="name"
  text-field="name"
/>

<div class="permission-subheading" style="color: #808080;">TEMPLATE SECTIONS</div>
<b-form-checkbox-group
  stacked
  name="permission_ids"
  v-model="entity.permissions._ids"
  :options="hardcodedPermissions['TEMPLATE SECTIONS']"
  :disabled="saving || loadingPermissions"
  value-field="name"
  text-field="name"
/>

<div class="permission-subheading" style="color: #808080;">USERS</div>
<b-form-checkbox-group
  stacked
  name="permission_ids"
  v-model="entity.permissions._ids"
  :options="hardcodedPermissions['USERS']"
  :disabled="saving || loadingPermissions"
  value-field="name"
  text-field="name"
/>

<div class="permission-subheading" style="color: #808080;">UTILIZATION MANAGEMENT TOOLS</div>
<b-form-checkbox-group
  stacked
  name="permission_ids"
  v-model="entity.permissions._ids"
  :options="hardcodedPermissions['UTILIZATION MANAGEMENT TOOLS']"
  :disabled="saving || loadingPermissions"
  value-field="name"
  text-field="name"
/>

<div class="permission-subheading" style="color: #808080;">WITHDRAWN REASONS</div>
<b-form-checkbox-group
  stacked
  name="permission_ids"
  v-model="entity.permissions._ids"
  :options="hardcodedPermissions['WITHDRAWN REASONS']"
  :disabled="saving || loadingPermissions"
  value-field="name"
  text-field="name"
/>
</div>           
</form-group>
          </b-col>
				</b-row>
			</b-card-body>

			<slot name="footer" v-bind="{ cancel, invalid, saving, save }">
				<b-card-footer>
					<b-row>
						<b-col cols="12" md="6" lg="4" class="mb-4 mb-md-0">
							<b-button block variant="light" type="button" @click.prevent="cancel">Cancel</b-button>
						</b-col>
						<b-col cols="12" md="6" offset-lg="4" lg="4" class="mb-2 mb-md-0">
							<b-button block variant="primary" type="submit" :disabled="saving">
								<font-awesome-icon icon="circle-notch" v-if="saving" spin fixed-width />
								<font-awesome-icon icon="exclamation-triangle" v-else-if="invalid" fixed-width />
								<span>Save</span>
							</b-button>
						</b-col>
					</b-row>
				</b-card-footer>
			</slot>
		</b-card>
	</validation-observer>
</template>

<script type="text/javascript">
import { mapGetters } from "vuex";
import { save, get } from "@/clients/services/roles";
import { formatErrors, getValidationState } from "@/validation";

export default {
	name: "RoleForm",
	props: {
		id: {
			default: null,
		},
	},
	computed: mapGetters({
		users: "users/active",
		loadingUsers: "users/loadingActive",
		permissions: "permissions/all",
		loadingPermissions: "permissions/loadingAll",
	}),
	data() {
		return {
			loading: true,
			saving: false,
			entity: {
				id: this.id,
				name: "",
				permissions: {
					_ids: [],
				},
				users: {
					_ids: [],
				},
			},
			hardcodedPermissions: {
      "AGENCIES": ["Add Agencies", "Delete Agencies", "Edit Agencies"],
      "APPEAL FILES": ["Delete Appeal Files", "Download Appeal Files", "Preview Appeal Files", "Rename Appeal Files", "Upload Appeal Files"],
      "APPEAL LEVELS": ["Add Appeal Levels", "Delete Appeal Levels", "Edit Appeal Levels"],
      "APPEAL NOTES": ["Add Appeal Notes", "Delete Appeal Notes", "Edit Appeal Notes"],
      "APPEALS": ["Add Appeals", "Assign Appeals", "Complete Appeals", "Delete Appeals", "Determine Appeals", "Edit Appeals", "Final Review Appeals", "Initial Review Appeals", "View Appeal Index"],
      "APPEAL TEMPLATES": ["Add Appeal Templates", "Delete Appeal Templates", "Edit Appeal Templates"],
      "CASE FILES": ["Delete Case Files", "Download Case Files", "Preview Case Files", "Rename Case Files", "Upload Case Files"],
      "CASE OUTCOMES": ["Add New Case Outcomes", "Delete Case Outcomes", "Edit Case Outcomes"],
      "CASES": ["Add New Cases", "Assign Cases", "Attach Concurrent To Case", "Close Cases", "Delete Cases", "Detach Concurrent From Case", "Edit Case Utilization Management Criteria", "Edit Cases", "Reopen Cases", "View Case Index", "View Cases"],
      "CASE TYPES": ["Add New Case Types", "Delete Case Types", "Edit Case Types"],
      "CLIENT EMPLOYEES": ["Add New Client Employees", "Delete Client Employees", "Edit Client Employees"],
      "CLIENT EMPLOYEE TYPES": ["Add New Client Employee Types", "Delete Client Employee Types", "Edit Client Employee Types"],
      "CLIENTS": ["Add New Clients", "Delete Clients", "Edit Clients", "View All Clients", "View Clients"],
      "DENIAL TYPES": ["Add New Denial Types", "Delete Denial Types", "Edit Denial Types"],
      "EVIDENCE CRITERIA": ["Add New Evidence Criteria", "Delete Evidence Criteria", "Edit Evidence Criteria"],
      "FACILITIES": ["Add New Facilities", "Delete Facilities", "Edit Facilities", "View Facilities", "View Facility Index"],
      "FACILITY FAXES": ["Add New Facility Fax Numbers", "Delete Facility Fax Numbers", "Edit Facility Fax Numbers"],
      "FACILITY TYPES": ["Add New Facility Types", "Delete Facility Types", "Edit Facility Types"],
      "GUIDELINE FILES": ["Delete Guideline Files", "Download Guideline Files", "Preview Guideline Files", "Rename Guideline Files", "Upload Guideline Files"],
      "GUIDELINES": ["Add New Guidelines", "Delete Guidelines", "Edit Guidelines"],
      "INCOMING FAXES": ["Assign Incoming Fax To User", "Attach Incoming Fax To Concurrent", "Delete Incoming Faxes", "Detach Incoming Fax From Concurrent", "Edit Incoming Faxes"],
      "INSURANCE PROVIDERS": ["Add New Insurance Providers", "Delete Insurance Providers", "Edit Insurance Providers", "View Insurance Provider Index", "View Insurance Providers"],
      "INSURANCE TYPES": ["Add New Insurance Types", "Delete Insurance Types", "Edit Insurance Types"],
      "LIBRARIES": ["Delete Library Files", "Download Library Files", "Preview Library Files", "Rename Library Files", "Upload Library Files", "View Library"],
      "NOT DEFENDABLE REASONS": ["Add New Not Defendable Reasons", "Delete Not Defendable Reasons", "Edit Not Defendable Reasons"],
      "OUTBOUND EMAILS": ["Cancel Outbound Emails", "Delete Outbound Emails (History)", "Preview Outbound Emails", "Resubmit Outbound Emails"],
      "OUTBOUND FAXES": ["Cancel Outbound Faxes", "Delete Outbound Faxes (History)", "Preview Outbound Faxes", "Resubmit Outbound Faxes"],
      "PATIENTS": ["Add New Patients", "Delete Patients", "Edit Patients", "Merge Patients", "View Patient Index", "View Patients", "View Similar Patients"],
      "REFERENCE NUMBERS": ["Add New Reference Numbers", "Delete Reference Numbers", "Edit Reference Numbers"],
      "REPORTS": ["Facility Concurrent Census"],
      "ROLES": ["Add New Roles", "Add Role Index", "Delete Roles", "Edit Roles", "View Roles"],
      "TAGS": ["Add New Tags", "Delete Tags", "Edit Tags"],
      "TEMPLATE ITEMS": ["Add New Template Items", "Delete Template Items", "Edit Template Items"],
      "TEMPLATE SECTIONS": ["Add New Template Sections", "Delete Template Sections", "Edit Template Sections"],
      "USERS": ["Add New Users", "Bulk Disable Users", "Bulk Enable Users", "Change Other Users Passwords", "Delete Users", "Disable Users", "Edit Users", "Enable Users", "Promote Users To Administrator", "Revoke Administrator From Users", "Unlock Locked-Out Users", "View Other Users Permissions"],
      "UTILIZATION MANAGEMENT TOOLS": ["Add New Utilization Management Tools", "Delete Utilization Management Tools", "Edit Utilization Management Tools"],
      "WITHDRAWN REASONS": ["Add New Withdrawn Reasons", "Delete Withdrawn Reasons", "Edit Withdrawn Reasons"]
    }
		};
	},
	mounted() {
		this.$store.dispatch("permissions/getAll");

		if (this.id) {
			this.refresh();
		} else {
			this.loading = false;
		}
	},
	methods: {
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
				this.entity.permissions = {
					_ids: response.permissions.map((permission) => permission.id),
				};
				this.entity.users = {
					_ids: response.users.map((user) => user.id),
				};

				this.$emit("loaded", this.entity);
			} catch (e) {
				this.$store.dispatch("apiError", {
					error: e,
					message: "Error getting role details",
				});
			} finally {
				this.loading = false;
			}
		},
		async save() {
			try {
				this.saving = true;

				const response = await save(this.entity);

				this.$emit("saved", response);
				this.$emit("update:id", response.id);
			} catch (e) {
				if (e.response.data.errors) {
					this.$refs.observer.setErrors(formatErrors(e.response.data.errors));
				}

				this.$store.dispatch("apiError", {
					error: e,
					title: "Save Failed",
					message: "Failed to save role details. Please check for errors.",
					variant: "warning",
				});
			} finally {
				this.saving = false;
			}
		},
	},
};
</script>
