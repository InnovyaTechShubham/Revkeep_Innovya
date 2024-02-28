<?php
 
namespace App\Controller\Client;

use App\Model\Table\chainServices;
use App\Model\Table\ChainsTable;
use App\Model\Table\ChainOrganizationsTable;
use App\Controller\AppController;
use Cake\Network\Exception\MethodNotAllowedException;
use Cake\ORM\TableRegistry;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;


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
			'chain_name' => 'asc',
		],
		'sortableFields' => [
			'chain_name',
		],
	];


    public function initialize(): void
    {
        parent::initialize();
        // $this->loadComponent('Paginator');
    }

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
                    'message' => 'Chain name required.',
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
                $client_id = $this->request->getData('client_id');
                $client_id = strval($client_id);


                $new = $type->newEntity([
                    
                    'chain_name' => $chain_name,
                    // 'chain_type' => $chain_type,
                    'client_id' => $client_id
                ]);

                // write data to json file starts here
                 // Create an array with chain_name and client_id
                // $dataToWrite = [
                //     'chain_name' => $chain_name,
                //     'client_id' => $client_id,
                // ];

                // // Convert the array to JSON format
                // $jsonData = json_encode($dataToWrite, JSON_PRETTY_PRINT);

                // // // Specify the path where you want to save the JSON file
                // // $filePath = '/path/to/your/directory/chain_data.json';

                // // // Write the JSON data to the file
                // // file_put_contents($filePath, $jsonData);


                // $filePath = WWW_ROOT . 'json/powerback_denial_reasons.json';
                // file_put_contents($filePath, $jsonData);


                // write data to json file ends here
            
                if ($type->save($new)) {
                    $chainId = $new->id;

                    // Iterate over the arrays and create entries in chainOrganizations table
                    if (!empty($facilityArray)) {
                        foreach ($facilityArray as $facilityId) {
                            $newChainOrganization = $chainOrganizationsTable->newEntity([
                                'chain_id' => $chainId,
                                'org_id' => $facilityId['id'],
                                'desc' => 'Facility',
                            ]);
        
                            $chainOrganizationsTable->save($newChainOrganization);
                        }
                    } 
                    
                    if(!empty($serviceArray)){
                        foreach ($serviceArray as $serviceId) {
                            $newChainOrganization = $chainOrganizationsTable->newEntity([
                                'chain_id' => $chainId,
                                'org_id' => $serviceId['id'],
                                'desc' => 'Service',
                            ]);
                            
                            $chainOrganizationsTable->save($newChainOrganization);
                        }
                    }
                    
                    $response = [
                        'success' => true,
                        'message' => 'Document entry and related chainOrganizations entries saved.',
                    ];

                    // Send the JSON response back to the client
                    echo json_encode($response);
                    // Optionally, you can use "die();" to terminate further script execution
                    die();
                } else {
                    $response = [
                        'success' => false,
                        'message' => 'Error saving data in Chains table.',
                    ];
                    // Send the JSON response back to the client
                    echo json_encode($response);
                    // Optionally, you can use "die();" to terminate further script execution
                    die();
                }
            }
            
        }
    }

	public function getAllRecord()
	{

        try {
            $this->autoRender = false;

            // Get the ChainsTable instance
            $chainsTable = $this->getTableLocator()->get('Chains');

            // Get pagination parameters from the request
            // params: {
            //     page: currentPage.value,
            //     perPage: pageSize, // Add a limit parameter for pagination
            //   },
            $page = $this->request->getQuery('page', 1);
            $limit = $this->request->getQuery('perPage', 15);
            $searchTerm = $this->request->getQuery('search', ''); // Retrieve the new parameter


            // Create a Paginator instance
            // Create a connection instance
            // $connection = ConnectionManager::get('default');

            // Set up pagination configuration
            $paginationConfig = [
                'limit' => $limit,
                'page' => $page,
            ];

            // Add search condition if the search term is provided
            if (!empty($searchTerm)) {
                $paginationConfig['conditions']['chain_name LIKE'] = "%$searchTerm%";
            }

            // Retrieve all records from the "chains" table
            // $records = $chainsTable->find('all')->toArray();
            // $records = $chainsTable->find('all')->paginate($paginationConfig)->toArray();

            // Retrieve all records using the Paginator instance
            // Retrieve paginated records from the "chains" table
            $query = $chainsTable->find('all');
            // Specify the association and fields to be retrieved
            $query->contain([
                'ChainOrganizations' => function ($q) {
                    return $q->select(['chain_id', 'org_id', 'desc']);
                }
            ]);
            $records = $this->paginate($query, $paginationConfig)->toArray();

            //  // Initialize an array to store the total facility count for each chain_name
            // $facilityCounts = [];

            // // Calculate and store total facility count for each chain_name
            // foreach ($records as $record) {
            //     $facilityCount = 0;
            //     foreach ($record->chain_organizations as $chainOrganization) {
            //         if ($chainOrganization->desc === 'Facility') {
            //             $facilityCount++;
            //         }
            //     }
            //     $records[$record->chain_name] = $facilityCount;
            // }

            // Get the total count of records for the pagination header
            $totalRecords = $chainsTable->find('all')->count();

            // Set the x-total-count header
            $this->response = $this->response->withHeader('X-Total-Count', $totalRecords);


            $filePath = WWW_ROOT . 'json/powerback_denial_reasons.json';
            $jsonContent = json_encode($records, JSON_PRETTY_PRINT);
            $file = fopen($filePath, 'w');
            fwrite($file, $jsonContent);
            fclose($file);

            // Return JSON response
            $this->response = $this->response->withType('application/json')
                ->withStringBody(json_encode($records));
            return $this->response;

        } catch (\Exception $e) {

            $filePath = WWW_ROOT . 'json/powerback_denial_reasons.json';
            $jsonContent = json_encode($e->getMessage(), JSON_PRETTY_PRINT);
            $file = fopen($filePath, 'w');
            fwrite($file, $jsonContent);
            fclose($file);

            $this->log($e->getMessage(), 'error');
            $this->response = $this->response->withStatus(500);
        }	 
	}


    public function viewChain($id)
    {
        $this->autoRender = false;

        // Get the ChainsTable instance
        $chainsTable = $this->getTableLocator()->get('Chains');

        try {
            // Retrieve a single record from the "chains" table based on the provided $id
            $record = $chainsTable->get($id);

            $chainOrganizationsTable = TableRegistry::getTableLocator()->get('ChainOrganizations');
            $query = $chainOrganizationsTable->find('all')
                ->contain([
                    'Facilities' => function ($q) {
                        return $q->select(['id', 'name', 'facility_type_id']);
                    },
                    'Services' => function ($q) {
                        return $q->select(['id', 'name']);
                    }
                ])
                ->where(['ChainOrganizations.chain_id' => $id]);

            $results = $query->all();
            // Add the fetched facility data to the response
            $record->chain_organizations = $results;
            // Return JSON response
            $this->response = $this->response->withType('application/json')
            ->withStringBody(json_encode($record));
            return $this->response;

        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            // Handle the case where the record is not found
            $this->response = $this->response->withStatus(404); // Not Found
            return $this->response;
        }
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
                $result = $chainOrganizationsTable->deleteAll(['chain_id' => $id]);


                // Iterate over the arrays and create entries in chainOrganizations table
                if (!empty($facilityArray)) {
                    foreach ($facilityArray as $facilityId) {
                        $newChainOrganization = $chainOrganizationsTable->newEntity([
                            'chain_id' => $id,
                            'org_id' => $facilityId['id'],
                            'desc' => 'Facility',
                        ]);
    
                        $chainOrganizationsTable->save($newChainOrganization);
                    }
                } 
                
                if(!empty($serviceArray)){
                    foreach ($serviceArray as $serviceId) {
                        $newChainOrganization = $chainOrganizationsTable->newEntity([
                            'chain_id' => $id,
                            'org_id' => $serviceId['id'],
                            'desc' => 'Service',
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
            // delete related entries from chain_organization table
            $chainOrganizationsTable = new ChainOrganizationsTable();
            $result = $chainOrganizationsTable->deleteAll(['chain_id' => $id]);
			$this->set('data', $record);
			$this->set('success', true);
		} catch (PersistenceFailedException $e) {
			$this->Log->deleteFailed($e, $record);
			$this->setResponse($this->ApiError->entity($e, $record));
		}
	}
}