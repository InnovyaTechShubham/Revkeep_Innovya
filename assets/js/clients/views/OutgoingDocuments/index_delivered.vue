<template>
	<paginated-results
		v-slot="{ doSearch, empty, hasNextPage, hasPrevPage, loading, nextPage, prevPage, refresh, results }"
		v-bind="{
			action,
			filters: {
				status: 'DELIVERED',
			},
			search: deliveredSearch,
			perPage,
		}"
	>
		<b-row class="mb-4">
			<b-col cols="6" md="6" lg="6" class="mb-0">
				<b-form @submit.prevent="doSearch">
					<search-input v-model="deliveredSearch" v-bind="{ loading }" />
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
					<table class="table mb-0">
            <thead>
                <tr>
                   <th class="col-md-2">Patient Name</th>
                   <th class="col-md-2">Delivery Method</th>
                   <th class="col-md-2">Status</th>
                   <th class="col-md-2">Agency</th>
                   <th class="col-md-1">Download</th>
                   <th class="col-md-1">Appeal Level</th>
                   <th class="col-md-6">Actions</th>
                </tr>
            </thead>
        </table>
					<outgoing-document-list-item
					v-for="(result, index) in results"
						:key="result.id"
						:value="result"
						@updated="
							recount();
							refresh();
						"
						:style="{ backgroundColor: index % 2 === 0 ? '#FFFFFF' : '#dee2e6' }"
						class="mb-2 shadow-sm"
					/>
				</div>
				<empty-result v-else icon="envelope">
					No delivered documents
					<template #content> Audits marked as delivered will appear here. </template>
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
const deliveredSearch = ref("");

const perPage = ref(15);
const action = getIndex;

const recount = () => {
	store.dispatch("updateState");
};
</script>
