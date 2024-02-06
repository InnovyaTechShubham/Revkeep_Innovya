<?php
 
namespace App\Controller\Client;

use App\Model\Table\chainServices;
use App\Model\Table\ChainsTable;
use App\Model\Table\ChainOrganizationsTable;
use App\Controller\AppController;
use Cake\Network\Exception\MethodNotAllowedException;


/**
 * Services Controller
 *
 * @property \App\Controller\Component\ApiErrorComponent $ApiError
 * @property \App\Controller\Component\LogComponent $Log
 * @property \App\Model\Table\ChainsTable $Chains
 */
 
class ChainsController extends AppController
{
    /**
	 * @var array
	 */
	public $paginate = [
		'finder' => 'search',
		'limit' => PAGINATION_DEFAULT_LIMIT,
		'order' => [
			'name' => 'asc',
		],
		'sortableFields' => [
			'chain_name',
			'chain_type',
		],
	];

    public function index()
    {
        $this->autoRender = false;
        $type = new ChainsTable();
        // $chainOrganizationsTable = $ChainOrganizationsTable->newEmptyEntity();
        // $chainOrganizationsTable = $this->ChainsOrganizations;
        $chainOrganizationsTable = new ChainOrganizationsTable();

        if ($this->request->is('post')) {
            $chain_name = $this->request->getData('chain_name');
            // $chain_type = $this->request->getData('chain_type');
             // Check if chain_name already exists
            $existingChain = $type->exists(['chain_name' => $chain_name]);
            // if chain_name is empty
            if (empty($chain_name)) {
                // Handle the case where $chain_name is undefined, null, or empty
                $response = [
                    'success' => false,
                    'message' => 'Chain name and Chain Type is required.',
                ];
            
                // Send the JSON response back to the client
                echo json_encode($response);
                // Optionally, you can use "die();" to terminate further script execution
                die();
            }
            if ($existingChain) {
                // Handle the case where the chain_name already exists
                $response = [
                    'success' => false,
                    'message' => 'Chain Already exists.',
                ];
                // Send the JSON response back to the client
                echo json_encode($response);
                // Optionally, you can use "die();" to terminate further script execution
                die();
            }else{
                // $chain_name = $this->request->getData('chain_name');
                // $chain_type = $this->request->getData('chain_type');
                

            //  get facility and services data
            $facilityArray = $this->request->getData('Facility_data');
            $serviceArray = $this->request->getData('Service_data');


                $new = $type->newEntity([
                    
                    'chain_name' => $chain_name,
                    // 'chain_type' => $chain_type,
                ]);
            
                if ($type->save($new)) {
                    $chainId = $new->id;

                // Iterate over the arrays and create entries in chainOrganizations table
                foreach ($facilityArray as $facilityId) {
                    foreach ($serviceArray as $serviceId) {
                        $newChainOrganization = $chainOrganizationsTable->newEntity([
                            'chain_id' => $chainId,
                            'facility_id' => $facilityId['id'],
                            'service_id' => $serviceId['id'],
                        ]);

                        $chainOrganizationsTable->save($newChainOrganization);
                    }
                }

                $response = [
                    'success' => true,
                    'message' => 'Document entry and related chainOrganizations entries saved.',
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Error saving data in Chains table.',
                ];
            }
        }
    }

	public function getAllRecord()
	{

        $this->autoRender = false;

        // Get the ChainsTable instance
        $chainsTable = $this->getTableLocator()->get('Chains');

        // Retrieve all records from the "chains" table
        $records = $chainsTable->find('all')->toArray();

        // Return JSON response
        $this->response = $this->response->withType('application/json')
                                         ->withStringBody(json_encode($records));
        return $this->response;
		 
	}


    public function viewChain($id)
    {
        $this->autoRender = false;

        // Get the ChainsTable instance
        $chainsTable = $this->getTableLocator()->get('Chains');

        try {
            // Retrieve a single record from the "chains" table based on the provided $id
            $record = $chainsTable->get($id);

            // Fetch associated ChainOrganizations data with facilities
            $chainOrganizationsTable = $this->getTableLocator()->get('ChainOrganizations');
            $chainOrganizationsData = $chainOrganizationsTable->find()
                ->select(['facility_id'])
                ->where(['chain_id' => $id])
                ->contain([
                    'Facilities' => ['fields' => ['id', 'name', 'facility_type_id']],
                    'Services' => function ($q) {
                        return $q->select(['id', 'name']);
                    }
                ])
                ->toArray();

            // Add the fetched facility data to the response
            $record->chain_organizations = $chainOrganizationsData;

        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            // Handle the case where the record is not found
            $this->response = $this->response->withStatus(404); // Not Found
            return $this->response;
        }

        // Return JSON response
        $this->response = $this->response->withType('application/json')
                                        ->withStringBody(json_encode($record));
        return $this->response;

    }

    public function editChain($id)
    {
        $this->autoRender = false;
        $type = new ChainsTable();

        $chainOrganizationsTable = new ChainOrganizationsTable();

        if ($this->request->is('post')) {
            // $chain_id = $this->request->getData('id'); // Assuming you have an 'id' field in your form
            $chain_name = $this->request->getData('chain_name');
            // $chain_type = $this->request->getData('chain_type');
            // if chain_name is empty
            if (empty($chain_name)) {
                // Handle the case where $chain_name is undefined, null, or empty
                $response = [
                    'success' => false,
                    'message' => 'Chain name and Chain Type is required.',
                ];
            
                // Send the JSON response back to the client
                echo json_encode($response);
                // Optionally, you can use "die();" to terminate further script execution
                die();
            }
            //  get facility and services data
            $facilityArray = $this->request->getData('Facility_data');
            $serviceArray = $this->request->getData('Service_data');
        
            // Load the entity to be updated
            $chain = $type->get($id);
        
            // Patch the entity with the new data
            $type->patchEntity($chain, [
                'chain_name' => $chain_name,
                // 'chain_type' => $chain_type,
            ]);
        
            // Save the changes
            if ($type->save($chain)) {
                // Successfully saved
                // You can handle the success response here

                // echo json_encode(['success' => true, 'message' => 'Chain updated successfully']);
                // $chainId = $chain->id;

                // Deleting entries for the specified chain ID 
                // TODO: REMOVE THE DELETE QUERY. Find alternate way to update all entries
                $result = $chainOrganizationsTable->deleteAll(['chain_id' => $id]);


                // Iterate over the arrays and create entries in chainOrganizations table
                foreach ($facilityArray as $facilityId) {
                    foreach ($serviceArray as $serviceId) {
                        $newChainOrganization = $chainOrganizationsTable->newEntity([
                            'chain_id' => $id,
                            'facility_id' => $facilityId['id'],
                            'service_id' => $serviceId['id'],
                        ]);

                        $chainOrganizationsTable->save($newChainOrganization);
                    }
                }

                $response = [
                    'success' => true,
                    'message' => 'Document entry and related chainOrganizations entries saved.',
                ];
            } else {
                // Failed to save
                // You can handle the error response here
                // echo json_encode(['success' => false, 'message' => 'Failed to update chain']);
                $response = [
                    'success' => false,
                    'message' => 'Error saving data in Chains table.',
                ];
            }
        }
    }


	public function delete($id)
	{
        $this->autoRender = false;
        $chainsTable = $this->getTableLocator()->get('Chains');
        $record = $chainsTable->get($id);
		// $entity = $this->Chains->getFull($id);

		try {
			$this->Chains->deleteOrFail($record);
			$this->set('data', $record);
			$this->set('success', true);
		} catch (PersistenceFailedException $e) {
			$this->Log->deleteFailed($e, $record);
			$this->setResponse($this->ApiError->entity($e, $record));
		}
	}
}