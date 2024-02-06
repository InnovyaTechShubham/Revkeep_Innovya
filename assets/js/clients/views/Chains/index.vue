<template>
	<paginated-results
		v-slot="{
			doSearch,
			empty,
			hasNextPage,
			hasPrevPage,
			loading,
			nextPage,
			prevPage,
			page,
			pages,
			refresh,
			results,
			total,
		}"
		v-bind="{
			// action,
			filters,
			search,
			perPage,
		}"
	>
		<page-header v-bind="{ loading, total }">
			<template #title>Chains</template>
			<template #buttons>
				<b-button variant="primary" :to="{ name: 'chains.add' }" title="Add New">
					<font-awesome-icon icon="plus" fixed-width />
					<span>Add New</span>
				</b-button>
			</template>
		</page-header>

		<b-row class="mt-4">
			<b-col cols="12" md="9" lg="4" order="1" class="mb-4 mb-lg-0">
				<b-form @submit.prevent="doSearch">
					<search-input v-model="search" v-bind="{ loading }" />
				</b-form>
			</b-col>
			<!-- <b-col cols="6" md="3" lg="2" order="2" class="text-left text-md-right text-lg-left">
				<b-dropdown split @click="filtering = !filtering" :pressed="filtering">
					<template #button-content>
						<font-awesome-icon icon="filter" fixed-width />
						<span>Filter</span>
					</template>
					<b-dropdown-item-button @click="resetFilters" :disabled="loading" title="Clear all filters">
						<span>Clear Filters</span>
					</b-dropdown-item-button>
					<b-dropdown-item-button @click="refresh" :disabled="loading" title="Refresh">
						<span>Refresh</span>
					</b-dropdown-item-button>
				</b-dropdown>
			</b-col> -->
		</b-row>
	  <b-row>
		<b-col cols="12">
		  <b-collapse v-model="filtering" class="py-2">
			<b-form @submit.prevent="doSearch">
			  <b-card>
				<IndexFilters v-model="filters" :disabled="loading" />
			  </b-card>
			</b-form>
		  </b-collapse>
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

<script setup>
import { ref, reactive, onMounted } from "vue";
import { getIndex } from "@/clients/services/chain";

import IndexFilters from "@/clients/components/Services/Filters.vue";
import axios from 'axios';

const defaultFilters = {
	active: null,
	owned: null,
};

const filters = reactive({ ...defaultFilters });
const resetFilters = () => Object.assign(filters, defaultFilters);
const filtering = ref(false);

const search = ref("");
const perPage = ref(15);
// const action = getIndex;

// get All record
const records = ref([]);

async function fetchData(){
	
	await axios.get('/client/getChains')
		.then(response => {
		// response data stored in records attribute to render as list
		records.value = response.data;
		})
		.catch(error => {
			console.error(error);
		})
		.finally(() => {
			this.saving = false;
		});
}

// Call the fetchData function on page load
onMounted(fetchData);
</script>
