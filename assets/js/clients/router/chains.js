// import to access index page for chains
import Index from "@/clients/views/Chains/index.vue";
import Add from "@/clients/views/Chains/add.vue";
// import Edit from "@/clients/views/Services/edit.vue";
import View from "@/clients/views/Chains/view.vue";

const clientId = window.authUser?.client_id || null;
console.log('chains rounter', clientId);
const baseUrl = "/chains";

export default [
	{
		path: baseUrl,
		name: "chains",
		component: Index,
		meta: {
			title: "Chains",
		},
	},
	{
		path: `${baseUrl}/add`,
		name: "chains.add",
		component: Add,
		meta: {
			title: "Add Chains",
		},
		props: {
			client_id: clientId,
		},
	},
	{
		path: `${baseUrl}/:id`,
		name: "chains.view",
		component: View,
		meta: {
			title: "View Chains",
		},
	},
	{
		path: `${baseUrl}/:id/edit`,
		name: "chains.edit",
		component: Add,
		meta: {
			title: "Edit Chains",
		},
	},
	// {
	// 	path: `${baseUrl}/:id`,
	// 	name: "services.view",
	// 	component: View,
	// 	meta: {
	// 		title: "View Service",
	// 	},
	// },
];
