<template>
	<div>
		<b-row class="mx-1" style="background: white;">
			<div class="header-container w-100">
				<div class="d-flex justify-content-between align-items-center w-100">
					<page-header class="no-shadow">
						<template #title>Chains<span class="badge ml-4 my-0 text-muted badge-light badge-pill">{{ records.length }}</span></template>
						
					</page-header>
					

					<div>
						<b-button variant="primary" :to="{ name: 'chains.add' }" title="Add New">
						<font-awesome-icon icon="plus" fixed-width />
						<span>Add New</span>
						</b-button>
					</div>
				</div>
			</div>
		</b-row>

		<b-row class="mt-4">
			<b-col cols="12" md="9" lg="4" order="1" class="mb-4 mb-lg-0">
			<b-form @submit.prevent="doSearch">
				<search-input v-model="search" v-bind="{ loading }" />
			</b-form>
			</b-col>
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
<style scoped>
	.header-container {
		display: flex;
		justify-content: space-between;
		align-items: center;
		padding: 10px; /* Adjust padding as needed */
	}
	.no-shadow {
		box-shadow: none !important;
	}
</style>
<script setup>
import { ref, reactive, onMounted } from "vue";
import axios from "axios";
import { getIndex } from "@/clients/services/chain";

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
