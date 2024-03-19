import api from "@/api";
const url = "/facilities";

export async function getIndex(params) {
	console.log('on sevices/facility.js , inside getIndex method:-');
	console.log('params are:-');
	console.log(JSON.stringify(params));
	const response = await api.get(url, { params });
	console.log('response is:-');
	console.log(JSON.stringify(response.data));
	return response.data; // { data: [], pagination: [] }
}

export async function getAll(params) {
	console.log('on sevices/facility.js , inside getAll method:-');
	console.log('params are:-');
	console.log(JSON.stringify(params));
	const response = await api.get(`${url}/all`, { params });
	return response.data.data;
}

export async function getActive(params) {
	console.log('on sevices/facility.js , inside getActive method:-');
	console.log('params are:-');
	console.log(JSON.stringify(params));
	const response = await api.get(`${url}/active`, { params });
	return response.data.data;
}

export async function get(id, params) {
	console.log('on sevices/facility.js , inside get method:-');
	console.log('params are:-');
	console.log(JSON.stringify(params));
	const response = await api.get(`${url}/${id}`, { params });
	return response.data.data;
}

export async function save(params) {
	if (params.id) {
		const response = await api.patch(`${url}/${id}`, params);
		return response.data.data;
	} else {
		const response = await api.post(url, params);
		return response.data.data;
	}
}

export async function create(params) {
	const response = await api.post(url, params);
	return response.data.data;
}

export async function update(id, params) {
	const response = await api.patch(`${url}/${id}`, params);
	return response.data.data;
}

export async function destroy(id, params) {
	const response = await api.delete(`${url}/${id}`, {
		_method: "DELETE",
	});
	return response.data;
}

export async function npiLookup(params) {
	const response = await api.post(`${url}/npiLookup`, params);
	return response.data.data;
}
