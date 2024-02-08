import api from "@/api";
const url = "/chains";
// const url = "/client/Api/Chains/save"; 
// const url = '/client/api/Chains/add';
// const url = 'Chains/add';

// store add chain form data
export async function save(params) {
    alert('chain.js inside client/servics/chain.js page')
    alert(JSON.stringify(params))
	if (params.id) {
        alert('params id found!')
		const response = await api.post(`${url}/edit/${params.id}`, params);
		return response.data.data;
	} else {
        alert('params id not found')
		const response = await api.post(url, params);
		alert('response')
		alert(response)
		alert(JSON.stringify(response))
        // const response = await api.post(`${url}/save`, params);
		return response.data.data;
	}
}



// // store facility id, agency id along with above stored chain id

// export async function saveChainOrganization(params) {
//     alert('chain.js inside client/servics/chain.js page store chain organizations')
//     alert(JSON.stringify(params))
// 	if (params.id) {
// 		const response = await api.post(`${url}/edit/${params.id}`, params);
// 		return response.data.data;
// 	} else {
// 		const response = await api.post(url, params);
// 		return response.data.data;
// 	}
// }

export async function getActive(params) {
	const response = await api.get(`${url}/active`, { params });
	return response.data.data;
}

export async function getAll(params) {
	// alert('getAll fucntion called')
	// alert(JSON.stringify(params))
	// alert(params)
	// /api/chains/all  ['get']
	const response = await api.get(`${url}/all`, { params });
	return response.data.data;
}

export async function getIndex(params) {
	const response = await api.get(url, { params });
	return response.data; // { data: [], pagination: [] }
}

// New method
// export async function getAllRecord() {
// 	// Your implementation to fetch all data from Chains table
// 	alert('inside getAll record method')
// 	try {
// 	//   const response = await api.get('/client/getChains/getAllRecord');
// 		const response = await api.post('/getChains');
// 	  	alert(JSON.stringify(response.data))
// 	  	return response.data;
// 	} catch (error) {
// 	  console.error('Error in getAllRecord:', error);
// 	  throw error;
// 	}
//   }


export async function create(params) {
	const response = await api.post(url, params);
	return response.data.data;
}

export async function get(id) {
	alert('get(id) function is called on clients /services/chain.js')
	const response = await api.get(`${url}/view/${id}`);
	return response.data.data;
}

export async function update(id, params) {
	const response = await api.post(`${url}/edit/${id}`, params);
	return response.data.data;
}

export async function destroy(id, params) {
	const response = await post(`${url}/delete/${id}`, params);
	return response.data.data;
}
