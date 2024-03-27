<template>
	<div>
		<page-header :fluid="false">
			<template #title>
				<router-link :to="{ name: 'appeals' }" v-text="`Appeals /`" />
				<router-link :to="{ name: 'appeals', params: { id: $route.params.id } }" v-text="name" />
				<span>/&nbsp;Edit</span>
			</template>
		</page-header>

		<b-container class="my-4">
			<b-row>
				<b-col cols="12" class="mb-5">
					<EditForm :id="$route.params.id" @loaded="loaded" @cancel="toView" @saved="toView" />
				</b-col>
			</b-row>
		</b-container>
	</div>
</template>

<script type="text/javascript">
import EditForm from "@/clients/components/Appeals/Form.vue";

export default {
	name: "ViewEditAppeal",
	components: {
		EditForm,
	},
	data() {
		return {
			name: null,
		};
	},
	methods: {
		toView() {
			this.$router.push({
				name: "appeals",
				params: {
					id: this.$route.params.id,
				},
			});
		},
		// loaded(entity) {
		// 	this.name = entity.patient.list_name;
		// },
        loaded() {
			this.name = 'TEST';
		},
	},
};
</script>
