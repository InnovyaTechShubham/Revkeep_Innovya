<template>

	<div>

		  <page-header>

				<template #title>Appeals</template>

				<template #buttons>

					  <b-button variant="success" @click="exportToCSV" title="Export CSV">

							<font-awesome-icon icon="file-csv" fixed-width />

							<span>Export To CSV</span>

					  </b-button>





					  <b-button variant="primary" :to="{ name: 'cases.add' }" title="Add New Case">

							<font-awesome-icon icon="plus" fixed-width />

							<span>Add New Case</span>

					  </b-button>

				</template>

		  </page-header>



		  <b-card-header header-tag="nav">

				<b-nav card-header tabs>

					  <b-nav-item :to="{ name: 'appeals' }" exact exact-active-class="active font-weight-bold">

							<span>All</span>

					  </b-nav-item>

					  <b-nav-item :to="{ name: 'appeals.index.open' }" exact exact-active-class="active font-weight-bold">

							<span>Open</span>

					  </b-nav-item>

					  <b-nav-item :to="{ name: 'appeals.index.utc' }" exact exact-active-class="active font-weight-bold">

							<span>UTC</span>

					  </b-nav-item>

					  <b-nav-item :to="{ name: 'appeals.index.cancelled' }" exact

							exact-active-class="active font-weight-bold">

							<span>Cancelled</span>

					  </b-nav-item>

					  <b-nav-item :to="{ name: 'appeals.index.closed' }" exact exact-active-class="active font-weight-bold">

							<span>Closed</span>

					  </b-nav-item>

					  <b-nav-item :to="{ name: 'appeals.index.unassigned' }" exact

							exact-active-class="active font-weight-bold">

							<span>Unassigned</span>

					  </b-nav-item>

				</b-nav>

		  </b-card-header>



		  <router-view />

	</div>

</template>



<script setup>

import { ref } from "vue";

import { getIndex } from "@/clients/services/appeals";





//const appeals = ref([]);



const exportToCSV = async () => {

  try {

	  // Assuming you get the data from an API call like this

	  const response = await getIndex();

	  const appeals = response.data;

	  console.log("appeals", appeals);



	  const csvContent = "Status, Patient Name, Appeals Level, Appeal Type, Facility, Denial Type, Assigned To, Due, Priority, Defendable, Agency, Insurance Provider, Insurance Type, Insurance Plan, Insurance Number, Audit id, Created, Updated\n" +

		  appeals.map(c => {

			  // Extract relevant fields from the appeal object

			  const { appeal_status, patient, appeal_level, appeal_type, facility, denial_type, assigned_to_user, due_date, priority, defendable, agency, insurance_provider, insurance_type, insurance_plan, insurance_number, audit_identifier, created, modified } = c;



			  const denialTypeString = c.case && c.case.denial_type ? c.case.denial_type.name || "NO DATA" : "NO DATA";



			  const facilityName = c.case && c.case.facility ? c.case.facility.name || "NO DATA" : "NO DATA";

			  const insuranceProvider = c.case && c.case.insurance_provider ? c.case.insurance_provider.name || "NO DATA" : "NO DATA";

			  const insuranceType = c.case && c.case.insurance_type ? c.case.insurance_type.name || "NO DATA" : "NO DATA";

			  const insurancePlan = c.case && c.case.insurance_plan ? c.case.insurance_plan || "NO DATA" : "NO DATA";

			  const insuranceNumber = c.case && c.case.insurance_number ? c.case.insurance_number || "NO DATA" : "NO DATA";

			  const PatientLastName = c.case && c.case.patient ? c.case.patient.full_name || "NO DATA" : "NO DATA";

			  const assignedToFullName = assigned_to_user ? assigned_to_user.full_name || "NO DATA" : "NO DATA";

			  const agencyName = agency ? agency.name || "NO DATA" : "NO DATA";



			  const formattedDueDate = due_date ? new Date(due_date).toLocaleDateString("en-US") || "NO DATA" : "NO DATA";

			  const formattedCreatedDate = created ? new Intl.DateTimeFormat("en-US", {

				  year: "numeric",

				  month: "2-digit",

				  day: "2-digit",

				  hour: "2-digit",

				  minute: "2-digit",

				  timeZoneName: "short"

			  }).format(new Date(created)).replace(/,/g, '') || "NO DATA" : "NO DATA";

			  const formattedModifiedDate = modified ? new Intl.DateTimeFormat("en-US", {

				  year: "numeric",

				  month: "2-digit",

				  day: "2-digit",

				  hour: "2-digit",

				  minute: "2-digit",

				  timeZoneName: "short"

			  }).format(new Date(modified)).replace(/,/g, '') || "NO DATA" : "NO DATA";



			  // Create a CSV row

			  return `${appeal_status || "NO DATA"},${PatientLastName},${appeal_level?.name || "NO DATA"},${appeal_type?.name || "NO DATA"},${facilityName},${denialTypeString},${assignedToFullName},${formattedDueDate},${priority || "False"},${defendable || "False"},${agencyName},${insuranceProvider},${insuranceType},${insurancePlan},${insuranceNumber},${audit_identifier || "NO DATA"},${formattedCreatedDate},${formattedModifiedDate}`;

		  }).join("\n");



	  // Create a Blob and download the CSV file

	  const blob = new Blob([csvContent], { type: "text/csv" });

	  const url = URL.createObjectURL(blob);

	  const a = document.createElement("a");

	  a.href = url;

	  a.download = "appeals.csv";

	  document.body.appendChild(a);

	  a.click();

	  window.URL.revokeObjectURL(url);

	  document.body.removeChild(a);

  } catch (error) {

	  console.error("Error exporting data to CSV:", error);

  }

};

</script>