<template>
	<paginated-results
		v-slot="{ doSearch, empty, hasNextPage, hasPrevPage, loading, nextPage, prevPage, refresh, results }"
		v-bind="{
			action,
			filters: {
				status:[ 'NEW','DELIVERED','FAILED','CANCELLED'],
			},
			search: newSearch,
			perPage,
		}"
	>
		<b-row class="mb-4">
			<b-col cols="6" md="6" lg="6" class="mb-0">
				<b-form @submit.prevent="doSearch">
					<search-input v-model="newSearch" v-bind="{ loading }" />
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
					<div class="table-container">
					<table class="table table-bordered mb-0 scrollable-row ">
            <thead>
                <tr>
					<th class="col-md-1">Id</th>
				   <th class="col-md-1">Status</th>
				   <th class="col-md-1">Facility</th>
                   <th class="col-md-1">Patient Name</th>
                   <th class="col-md-2">Recipient Name</th>
				   <th class="col-md-2">Recipient Type</th>
                   <th class="col-md-1">Level</th>
				   <th class="col-md-1">Sent Date</th>
				   <th class="col-md-1">Method</th>
				    <th class="col-md-1">Download</th>
                  <!--<th class="col-md-2">Actions</th>--> 
                </tr>
            </thead>
        </table>
		</div>
					<outgoing-document-list-item
					    v-for="(result, index) in results"
						:key="result.id"
						:value="result"
						@updated="
							recount();
							refresh();
						"
						:style="{ backgroundColor: index % 2 === 0 ? '#FFFFFF' : '#e7eaea' }"
						class="list-item"
					/>
				</div>
				<empty-result v-else icon="envelope-open">
					No new documents
					<template #content> Completed packets from appeals will appear here. </template>
				</empty-result>
			</b-col>
		</b-row>
	</paginated-results>
</template>

<script setup>
import { ref } from "vue";
import { getIndex } from "@/clients/services/outgoingDocuments";
import OutgoingDocumentListItem from "@/clients/components/OutgoingDocuments/ListItem.vue";
import store from "@/clients/store";

// Search queries for various statuses
const newSearch = ref("");

const perPage = ref(15);
const action = getIndex;

const recount = () => {
	store.dispatch("updateState");
};
</script>
<style scoped>
  .list-item:hover {
    background-color: #e7eaea !important;
  }

</style>
