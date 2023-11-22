<template>

	<div>
  
	  <page-header>
  
		<template #title>Cases</template>
  
		<template #buttons>
  
		  <b-button variant="success" @click="exportToCSV" title="Export CSV">
  
			<font-awesome-icon icon="file-csv" fixed-width />
  
			<span>Export To CSV</span>
  
		  </b-button>
  
		  <b-button variant="primary" :to="{ name: 'cases.add' }" title="Add New">
  
			<font-awesome-icon icon="plus" fixed-width />
  
			<span>Add New</span>
  
		  </b-button>
  
		</template>
  
	  </page-header>
  
   
  
	  <b-card-header header-tag="nav">
  
		<b-nav card-header tabs>
  
		  <b-nav-item :to="{ name: 'cases' }" exact exact-active-class="active font-weight-bold">
  
			<span>All</span>
  
		  </b-nav-item>
  
		  <b-nav-item :to="{ name: 'cases.index.open' }" exact exact-active-class="active font-weight-bold">
  
			<span>Open</span>
  
		  </b-nav-item>
  
		  <b-nav-item :to="{ name: 'cases.index.utc' }" exact exact-active-class="active font-weight-bold">
  
			<span>UTC</span>
  
		  </b-nav-item>
  
		  <b-nav-item :to="{ name: 'cases.index.closed' }" exact exact-active-class="active font-weight-bold">
  
			<span>Closed</span>
  
		  </b-nav-item>
  
		  <b-nav-item :to="{ name: 'cases.index.empty' }" exact exact-active-class="active font-weight-bold">
  
			<span>Empty</span>
  
		  </b-nav-item>
  
		</b-nav>
  
	  </b-card-header>
  
   
  
	  <router-view />
  
	</div>
  
  </template>
  
   
  
  <script setup>
  
  import { ref } from "vue";
  
  import { getIndex } from "@/clients/services/cases";
  
   
  
  const search = ref("");
  
  const filters = ref({});
  
  const sort = ref("created");
  
  const sortDescending = ref(true);
  
  const perPage = ref(10);
  
   
  
  const exportToCSV = async () => {
  
	try {
  
	  const response = await getIndex({
  
		search: search.value,
  
		filters: filters.value,
  
		sort: sort.value,
  
		sortDescending: sortDescending.value,
  
		page: 1,
  
		perPage: perPage.value,
  
	  });
  
   
  
	  const cases = response.data;
  
	  console.log("cases=", cases);
  
   
  
	  const csvContent = "Case ID, Patient Name, Status, Facility, Assigned To, Denial Type, Admit Date, Disciplines, Physician, Outcome, Insurance Provider, Insurance Type, Disputed Amount, Added\n" +
  
		cases.map(c => {
  
		  // Extract relevant fields from the case object
  
		  const { id, patient, status, facility, assigned_to_user, denial_type, admit_date, disciplines, client_employee, case_outcome, insurance_provider, insurance_type, disputed_amount, created, appeals } = c;
  
		  
  
		  const facilityName = facility ? (facility.name || facility.full_address || "NO DATA") : "NO DATA";
		  
		  
		  const assignedToFullName = assigned_to_user ? assigned_to_user.full_name || "NO DATA" : "NO DATA";

		  
		  const disciplineNames = disciplines ? disciplines.map(discipline => discipline.name).join(", ") || "NO DATA" : "NO DATA";
		  console.log("before app name");
		//   const appealLevels = appeals ? appeals.map(appeal => appeal.appeal_level.name).join(", ") || "NO DATA" : "NO DATA";
		  console.log("after appeal");
		  const physicianFullName = client_employee ? client_employee.full_name || "NO DATA" : "NO DATA";
  
		  const caseOutcomeName = case_outcome ? case_outcome.name || "NO DATA" : "NO DATA";
  
		  const insuranceProviderName = insurance_provider ? insurance_provider.name || "NO DATA" : "NO DATA";
  
		  const insuranceTypeName = insurance_type ? insurance_type.name || "NO DATA" : "NO DATA";
		 
  
		  const formattedAdmitDate = admit_date ? new Date(admit_date).toLocaleDateString("en-US") : "NO DATA";
  
		  const formattedAddedDate = created ? new Intl.DateTimeFormat("en-US", {
  
			year: "numeric",
  
			month: "2-digit",
  
			day: "2-digit",
  
			hour: "2-digit",
  
			minute: "2-digit",
  
			timeZoneName: "short"
  
		  }).format(new Date(created)).replace(/,/g, '') : 'NO DATA';
  
		  const disputedAmount = disputed_amount || "NO DATA";
  
   
  
		//   return `${id},${patient?.full_name || "NO DATA"},${status || "NO DATA"},${facilityName},${assignedToFullName},${denial_type?.name || "NO DATA"},${formattedAdmitDate},"${appealLevels}",${disciplineNames},${physicianFullName},${caseOutcomeName},${insuranceProviderName},${insuranceTypeName},${disputedAmount},${formattedAddedDate}`;
		return `${id},${patient?.full_name || "NO DATA"},${status || "NO DATA"},${facilityName},${assignedToFullName},${denial_type?.name || "NO DATA"},${formattedAdmitDate},${disciplineNames},${physicianFullName},${caseOutcomeName},${insuranceProviderName},${insuranceTypeName},${disputedAmount},${formattedAddedDate}`;
  
		}).join("\n");
  
   
  
		  // Create a Blob and download the CSV file
  
		  const blob = new Blob([csvContent], { type: "text/csv" });
  
		  const url = URL.createObjectURL(blob);
  
		  const a = document.createElement("a");
  
		  a.href = url;
  
		  a.download = "cases.csv";
  
		  document.body.appendChild(a);
  
		  a.click();
  
		  window.URL.revokeObjectURL(url);
  
		  document.body.removeChild(a);
  
		} catch (error) {
  
		  console.error("Error exporting data to CSV:", error);
  
		}
  
	};
  
   
  
  </script>