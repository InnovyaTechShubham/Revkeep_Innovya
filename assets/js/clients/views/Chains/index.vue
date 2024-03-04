<template>
	<div>
		<b-row class="" style="background: white;margin-left: 2px;margin-right: 1px;">
			<div class="header-container w-100">
				<div class="d-flex justify-content-between align-items-center header_outer">
					<page-header class="no-shadow">
					<template #title class="ml-2 py-2">
						<h1 class="h5 d-inline-block my-0 py-0 font-weight-bold text-dark text-break">Chains</h1>
						<span class="badge ml-4 my-0 text-muted badge-light badge-pill">{{ totalCount }}</span>
					</template>
					</page-header>

					<div class="d-flex align-items-center">
					<b-button variant="primary" :to="{ name: 'chains.add' }" title="Add New" class="mr-3">
						<font-awesome-icon icon="plus" fixed-width />
						<span>Add New</span>
					</b-button>
					</div>
				</div>
			</div>
		</b-row>

		<b-row class="mt-4">
			<!-- Search input column -->
			<b-col cols="12" md="9" lg="8" order="1" class="mb-4 mb-lg-0">
				<div class="search-container">
				<i class="fas fa-search search-icon"></i>
				<input 
					ref="searchInput"
					v-model="search" 
					@input="handleSearch" 
					@focus="inputFocus = true"
					@blur="inputFocus = false"
					:class="{ 'focused': inputFocus }"
					placeholder="Search..."
					class="search-input" />
				</div>
			</b-col>

			<!-- Pagination buttons column -->
			<b-col cols="12" md="3" lg="4" order="2">
				<div class="d-flex justify-content-end">
				<b-button @click="previousPage"  class="custom-prev-button" style="background-color: #9EA3A9;">
					<font-awesome-icon icon="chevron-left" /> Prev
				</b-button>

				<b-button @click="nextPage"  class="custom-next-button" style="background-color: #9EA3A9;">
					Next <font-awesome-icon icon="chevron-right" />
				</b-button>
				</div>
			</b-col>
		</b-row>


	  <b-row>
		<b-col cols="12">
		  <!-- <b-collapse v-model="filtering" class="py-2">
			<b-form @submit.prevent="doSearch">
			  <b-card>
				<IndexFilters v-model="filters" :disabled="loading" />
			  </b-card>
			</b-form>
		  </b-collapse> -->
		</b-col>
	  </b-row>
	  <b-row class="my-4">
		<b-col cols="12" class="mb-4">
		  <div v-if="records.length">
			<b-list-group class="shadow-sm">
			  <b-list-group-item
				v-for="result in records"
				:key="result.id"
				:to="{ name: 'chains.view', params: { id: result.id } }"
				:variant="result.active ? '' : 'light'"
			  >
				<div class="py-2 d-flex justify-start align-items-top">
				  <b-avatar
					rounded
					class="mr-3 px-0 text-center bg-primary"
				  >
					<font-awesome-icon icon="fa-solid fa-link" class="text-center ml-1 badge-primary rounded"/>
				  </b-avatar>
				  <b-row class="flex-fill">
					<b-col cols="12" class="text-left">
						<h6 class="h6 font-weight-bold mb-1">
							{{ result.chain_name }}
						</h6>
						<!-- <p v-if="result.chain_type" class="small mb-1 text-muted" title="Description">
							{{ result.chain_type }}
						</p> -->
						<!-- Display facility count conditionally -->
						<p style="font-size:small;font: 900;">
							
							<span v-if="result.facility_count === 1 && result.facility_count !== undefined">
								<font-awesome-icon style="color: #007BFF;" icon="house" /> {{ result.facility_count }} Facility
							</span>
							<span v-else-if="result.facility_count > 1 && result.facility_count !== undefined">
								<font-awesome-icon style="color: #007BFF;" icon="house" />{{ result.facility_count }} Facilities
							</span>
							<span v-else>
								<font-awesome-icon style="color: #007BFF;" icon="house" /> No Facilities Attached.
							</span>
						</p>
					</b-col>
				  </b-row>
				</div>
			  </b-list-group-item>
			</b-list-group>	
		  </div>
		  <empty-result v-else>
			No Chains Created.
			<template #content> No Chains have been created.</template>
		  </empty-result>
		</b-col>
	  </b-row>
	</div>
</template>
<style scoped>
	.header-container {
		display: flex;
		justify-content: space-between;
		align-items: center;
		/* padding: 10px; Adjust padding as needed */
		padding-top: 5px;
		padding-bottom: 5px;
	}	

	.header_outer{
		width: 100%;
	}
	.no-shadow {
		box-shadow: none !important;
	}

	.search-container {
		display: flex;
  		align-items: center;
	}

	.search-icon {
		color: #555; /* Adjust color as needed */
		background-color: #E9ECEF;
		cursor: pointer;
		padding: 10px;
		border-radius: 3px 0 0 3px;  /* Rounded corners for the search icon */
		margin-right: 0; /* Add some spacing between icon and input */
		border: 1px solid #ced4da;
	}

	.search-input {
		width: 355px;
		padding: 6px; /* Adjust padding for thickness */
		border-radius: 0 5px 5px 0; /* Rounded corners for the input */
		border: 1px solid #ccc; /* Border for the input */
		outline: none; /* Remove default input focus outline */
	}

	.search-input:focus {
		color: #495057;
		/* e9ecef */
		background-color: #fff;
		border-color: #80bdff;
		outline: 0;
		box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
	}

	/* pagination prev and next button styles */
	.custom-prev-button {
		border-top-right-radius: 0;
		border-bottom-right-radius: 0;
		width: 75px;
		border-right-width: 0;
	}
	.custom-next-button{
		border-top-left-radius: 0;
		border-bottom-left-radius: 0;
		width: 75px;
	}
	.focused {
		border: 2px #4e77a3; /* Adjust the styling as needed */
	}
</style>
<script setup>
import { ref, onMounted, watch } from "vue";
import axios from "axios";
import { debounce } from 'lodash';

// Reactive variables
const records = ref([]);
const originalRecords = ref([]);
const search = ref('');
const loading = ref(false);

// Pagination
const pageSize = 15; // Set the number of records per page
const currentPage = ref(1);
const totalPages = ref(1); // Initialize totalPages
const totalCount = ref(0);

const searchInput = ref(null);
const inputFocus = ref(false);

// Fetch data on page load
onMounted(async () => {
  await fetchData();
});

// Watch for changes in the search term and trigger search logic after three key presses
const debouncedSearch = debounce(async () => {
  loading.value = true;
  await fetchData();
  loading.value = false;
}, 300); // Adjust the debounce delay as needed

// Watch for changes in the current page and trigger data fetch
watch(currentPage, async () => {
  await fetchData();
});

// Watch for changes in the search term and trigger search logic after two key presses
watch(search, async () => {
  console.log('searching...');
  loading.value = true;
  // Introduce a delay before triggering the search logic (adjust as needed)
  await new Promise(resolve => setTimeout(resolve, 300));
  filterRecords();
  loading.value = false;
});

// Fetch data function
async function fetchData() {
	// await nextTick(); // Wait for the next rendering cycle
    searchInput.value.focus();
	inputFocus.value = true;
  try {
    console.log('inside fetchData function');
    const response = await axios.get('/client/getChains',{
      params: {
        page: currentPage.value,
        perPage: pageSize, // Add a limit parameter for pagination
		search: search.value,
      },
    });
    console.log('inside fetchData of chain index:-')
    console.log(JSON.stringify(response.data));
    records.value = response.data;

	records.value = records.value.map(item => {
	// Check if chain_organizations is not an empty array
	if (Array.isArray(item.chain_organizations) && item.chain_organizations.length > 0) {
		// Count the occurrences of objects with desc as 'Facility'
		const facilityCount = item.chain_organizations.filter(obj => obj.desc === 'Facility').length;
		
		// Add a new field facility_count to the object
		return { ...item, facility_count: facilityCount };
	}

	// If chain_organizations is an empty array or not an array, keep the original object
	return item;
	});
    originalRecords.value = [...response.data]; 

    // Update totalPages based on the total records from the server
    totalPages.value = Math.ceil(response.headers['x-total-count'] / pageSize);

	console.log('x-total-count header:', response.headers['x-total-count']);
	console.log('totalPage value inside fetchdata:-');
	console.log(totalPages.value);
	totalCount.value = response.headers['x-total-count'];
  } catch (error) {
    console.error(error);
  }
}

// Search/filter logic
async function filterRecords() {
  try {
    loading.value = true;
    const searchTerm = search.value.toLowerCase();
    if (searchTerm === '' || searchTerm.length < 2) {
      // Show full records when searchTerm is empty or its length is less than 2
      records.value = [...originalRecords.value];
    } else {
      // Always fetch data when filterRecords is called
      await fetchData();
      records.value = records.value.filter(record => {
        return record.chain_name.toLowerCase().includes(searchTerm);
      });
    }
  } catch (error) {
    console.error(error);
  } finally {
    loading.value = false;
  }
}

function handleSearch(event) {
	debouncedSearch();
  // You can add any additional logic if needed
  console.log('Search input value:', event.target.value);
}

// Pagination controls
function nextPage() {
	console.log("Next Page Clicked", currentPage.value);
	console.log('totalPages.value');
	console.log(totalPages.value)
	if (currentPage.value < totalPages.value) {
		currentPage.value++;
		
		fetchData();
	}
}

function previousPage() {
	console.log("Previous Page Clicked", currentPage.value);
	console.log('totalPages.value');
	console.log(totalPages.value)
	if (currentPage.value > 1) {
		currentPage.value--;
		
		fetchData();
	}
}

</script>
