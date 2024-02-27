import Index from "@/clients/views/ClientEmployees/index.vue";
import Add from "@/clients/views/ClientEmployees/add.vue";
import AddNPI from "@/clients/views/ClientEmployees/add_npi.vue";
import Edit from "@/clients/views/ClientEmployees/edit.vue";
import View from "@/clients/views/ClientEmployees/view.vue";

// Base URLs for different routes 
const baseUrl = "/physicians"; // if accessing from physician 
const Url = "/cases"; // if accessing from edit case 
const NewCaseUrl = "/newcases" // if accessing from new case

export default [
	{
		path: baseUrl,
		name: "clientEmployees",
		component: Index,
		meta: {
			title: "Physicians",
		},
	},
	{
		path: `${baseUrl}/add/npi`,
		name: "clientEmployees.add.npi",
		component: AddNPI,
		meta: {
			title: "Add Physician From NPI Registry",
		},
	},
	{
		path: `${Url}/:id/add/npi`,
		name: "clientEmployees.add.npi.cases",
		component: AddNPI,
		meta: {
			title: "Add Physician From NPI Registry",
		},
	},
	{
		path: `${NewCaseUrl}/add/npi`,
		name: "clientEmployees.add.npi.newcase",
		component: AddNPI,
		meta: {
			title: "Add Physician From NPI Registry",
		},
	},
	{
		path: `${baseUrl}/add`,
		name: "clientEmployees.add",
		component: Add,
		meta: {
			title: "Add Physician",
		},
	},
	{
		path: `${baseUrl}/:id/edit`,
		name: "clientEmployees.edit",
		component: Edit,
		meta: {
			title: "Edit Physician",
		},
	},
	{
		path: `${baseUrl}/:id`,
		name: "clientEmployees.view",
		component: View,
		meta: {
			title: "View Physician",
		},
	},
];
