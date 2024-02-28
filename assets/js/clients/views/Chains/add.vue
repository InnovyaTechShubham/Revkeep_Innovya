<template>
	<div>
		<page-header>

			<template #title>
				<router-link :to="{ name: 'chains' }" v-text="`Chains /`" />
				<span>{{ $route.meta.title }}</span>
			</template>
		</page-header>

		<b-row class="my-4">
			<b-col cols="12">
				<AddForm v-model="entity" :client_id="client_id" @cancel="toIndex" @saved="toView" />
			</b-col>
		</b-row>
	</div>
</template>

<script type="text/javascript">
import AddForm from "@/clients/components/Chains/Form.vue";


export default {
	name: "ViewAddService",
	components: {
		AddForm,
	},
	data() {
		return {
			entity: {
				id: null,
				name: "",
				active: true,
			},
			client_id: window.authUser?.client_id || null,
		};
	},
	mounted(){
		console.log('inside chain  add.vue:-')
		console.log(this.client_id);
	},
	methods: {
		toIndex() {
			this.$router.push({
				name: "chains",
			});
		},
		toView(entity) {
			this.$router.push({
				name: "chains.view",
				params: {
					id: entity.id,
				},
			});
		},
	},
};
</script>
