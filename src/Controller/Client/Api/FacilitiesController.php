<?php

declare(strict_types=1);

namespace App\Controller\Client\Api;

use App\Lib\NpiUtility\NpiOrganizationResult;
use App\Service\NpiServiceInterface;
use Cake\Cache\Cache;
use Cake\ORM\Exception\PersistenceFailedException;
use Cake\Utility\Text;

/**
 * Facilities Controller
 *
 * @property \App\Controller\Component\ApiErrorComponent $ApiError
 * @property \App\Controller\Component\LogComponent $Log
 * @property \App\Model\Table\FacilitiesTable $Facilities
 */
class FacilitiesController extends ApiController
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
			'created',
			'modified',
			'deleted',
			'name',
			'phone',
			'fax',
			'street_address_1',
			'street_address_2',
			'city',
			'state',
			'zip',
			'active',
			'npi_number',
			'npi_manual',
			'primary_taxonomy',
			'client_owned',
			'chain_name',
			'area_name',
			'ou_number',
			'territory',
			'rvp_name',
			'has_contract',
			'contract_start_date',
			'contract_end_date',
			'indemnification_days',
			'max_return_work_days',
			// Associations
			'FacilityTypes.name',

		],
		'contain' => [
			'FacilityTypes' => [
				'finder' => 'limited'
			],
			'ClientEmployees' => [
				'finder' => 'limited'
			],
			'Services' => [
				'finder' => 'limited'
			]
		],
	];

	/**
	 * Initialization hook method.
	 *
	 * Use this method to add common initialization code like loading components.
	 *
	 * @return void
	 */
	public function initialize(): void
	{
		parent::initialize();
	}

	/**
	 * Add method
	 *
	 * @return void
	 * @throws \Cake\ORM\Exception\PersistenceFailedException When not valid.
	 */
	public function add(): void
	{
		$entity = $this->Facilities->newEntity($this->getRequest()->getData(), [
			'associated' => [
				'Services',
				// 'Chains'
			],
		]);

		try {
			$this->Facilities->saveOrFail($entity);
			$entity = $this->Facilities->getFull($entity->id);

			$this->set('data', $entity);
			// $data = $this->request->getData();

			// Insert debugging code
			// $filePath = 'C:\xampp\htdocs\Revkeep_Innovya\example1.json';
			// $demo = array
			// (    
			// 'name'
			// =>
			// 'John'
			// ,    
			// 'age'
			// =>
			// 30
			// ,    
			// 'city'
			// =>
			// 'New York'
			// );
			
			// $jsonContent = json_encode($entity, JSON_PRETTY_PRINT);
			// $file = fopen($filePath, 'w');
			// fwrite($file, $jsonContent);
			// fclose($file);

		} catch (PersistenceFailedException $e) {
			$this->Log->saveFailed($e, $entity);
			$this->setResponse($this->ApiError->entity($e, $entity));
		}
	}
	
	/**
 * Add method
 *
 * @return void
 * @throws \Cake\ORM\Exception\PersistenceFailedException When not valid.
 */
// public function add(): void
// {	
	
//     $requestData = $this->getRequest()->getData();

	
// 	// echo '<pre>';
// 	// var_dump($requestData);
// 	// echo '</pre>';

//     // Extract selected services
//     $selectedServices = $requestData['services'] ?? [];

//     // Remove services from main data to prevent validation issues
//     unset($requestData['services']);

//     $entity = $this->Facilities->newEntity($requestData, [
//         'associated' => [
//             'Services',
//         ],
//     ]);

//     // Begin a transaction
//     $this->Facilities->getConnection()->begin();

//     try {
//         // Save the facility
//         $this->Facilities->saveOrFail($entity);

//         // Save selected services in facilities_services table
//         foreach ($selectedServices as $serviceId) {
//             $serviceEntity = $this->Facilities->Services->get($serviceId);
//             $this->Facilities->link($entity, [$serviceEntity]);
//         }

//         // Commit the transaction
//         $this->Facilities->getConnection()->commit();

//         // Get the full entity
//         $entity = $this->Facilities->getFull($entity->id);
//         $this->set('data', $entity);
//     } catch (PersistenceFailedException $e) {
//         // Rollback the transaction on failure
//         $this->Facilities->getConnection()->rollback();

//         $this->Log->saveFailed($e, $entity);
//         $this->setResponse($this->ApiError->entity($e, $entity));
//     }
// }


	/**
	 * View method
	 *
	 * @param string $id
	 * @return void
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	public function view($id): void
	{
		$this->set('data', $this->Facilities->getFull($id));
	}

	/**
	 * Index method
	 *
	 * @return void
	 */
	public function index(): void
	{
		// $this->crudIndex();

		// Get query parameters from the request
		$params = $this->getRequest()->getQueryParams();

		// Check if $params has the key 'facility_status'
		$query = $this->Facilities
		->find()
		->contain([
			'FacilityTypes', // Include associated FacilityTypes
			// Add more associations as needed
		]);
		// Apply filtering conditions based on query parameters
		// Check if facility_status parameter is set
		if (isset($params['facility_status']) && $params['facility_status'] !== null) {
			// // Execute the query and fetch results
			// $result1 = $query->where(['Facilities.facility_status' => $params['facility_status']])->toArray();
			
			// // Append results to $data
			// $data = array_merge($data, $result1);
			// Add facility_status condition
			$query->andWhere(['Facilities.facility_status' => $params['facility_status']]);
		}
		if (isset($params['facility_type_id']) && $params['facility_type_id'] !== null) {
			// // Execute the query and fetch results
			// $result2 = $query->where(['Facilities.facility_type_id' => $params['facility_type_id']])->toArray();
			
			// // Append results to $data
			// $data = array_merge($data, $result2);
			// Add facility_type_id condition
			$query->andWhere(['Facilities.facility_type_id' => $params['facility_type_id']]);
		}
		if (isset($params['state']) && $params['state'] !== null) {
			// // Execute the query and fetch results
			// $result2 = $query->where(['Facilities.facility_type_id' => $params['facility_type_id']])->toArray();
			
			// // Append results to $data
			// $data = array_merge($data, $result2);
			// Add facility_type_id condition
			$query->andWhere(['Facilities.state' => $params['state']]);
		}
		if (isset($params['client_owned']) && $params['client_owned'] !== null) {
			// // Execute the query and fetch results
			// $result2 = $query->where(['Facilities.facility_type_id' => $params['facility_type_id']])->toArray();
			
			// // Append results to $data
			// $data = array_merge($data, $result2);
			// Add facility_type_id condition
			$query->andWhere(['Facilities.client_owned' => $params['client_owned']]);
		}
		if (isset($params['has_contract']) && $params['has_contract'] !== null) {
			// // Execute the query and fetch results
			// $result2 = $query->where(['Facilities.facility_type_id' => $params['facility_type_id']])->toArray();
			
			// // Append results to $data
			// $data = array_merge($data, $result2);
			// Add facility_type_id condition
			$query->andWhere(['Facilities.has_contract' => $params['has_contract']]);
		}
		if (isset($params['is_encore']) && $params['is_encore'] !== null) {
			// // Execute the query and fetch results
			// $result2 = $query->where(['Facilities.facility_type_id' => $params['facility_type_id']])->toArray();
			
			// // Append results to $data
			// $data = array_merge($data, $result2);
			// Add facility_type_id condition
			$query->andWhere(['Facilities.is_encore' => $params['is_encore']]);
		}

		
		$data = $query->all();

		$this->set([
			// Results
			'data' => $data,
			// Pagination Metadata
			'pagination' => [
				"count" => 11,
				"current" => 11,
				"perPage" => 15,
				"page" => 1,
				"requestedPage" => 1,
				"pageCount" => 1,
				"start" => 1,
				"end" => 11,
				"prevPage" => false,
				"nextPage" => false,
				"sort" => "name",
				"direction" => "asc",
				"sortDefault" => "name",
				"directionDefault" => "asc",
				"completeSort" => [
					"Facilities.name" => "asc"
				],
				"limit" => null,
				"scope" => null,
				"finder" => "search"
			],
		]);
	}

	/**
	 * Active method
	 *
	 * @return void
	 */
	public function active(): void
	{
		$entities = $this->Facilities
			->find('active')
			->find('ordered')
			->contain([
				'FacilityTypes',
			])
			->cache('Facilities', 'active')
			->all();

		$this->set('data', $entities);
	}

	/**
	 * All method
	 *
	 * @return void
	 */
	public function all(): void
	{
		$entities = $this->Facilities
			->find('all')
			->find('ordered')
			->contain([
				'FacilityTypes',
			])
			->all();

		$this->set('data', $entities);
	}

	/**
	 * Edit method
	 *
	 * @param string $id
	 * @return void
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 * @throws \Cake\ORM\Exception\PersistenceFailedException When not valid.
	 */
	public function edit($id): void
	{
		$entity = $this->Facilities->get($id);
		
		try {
			$entity = $this->Facilities->patchEntity($entity, $this->getRequest()->getData(), [
				'associated' => [
					'Services',
					// 'Chains'
				],
			]);

			$this->Facilities->saveOrFail($entity);
			$entity = $this->Facilities->getFull($entity->id);
			$this->set('data', $entity);

			// Insert debugging code
			// $filePath = 'C:\xampp\htdocs\Revkeep_Innovya\example.json';
		// $demo = array
		// (    
		// 'name'
		// =>
		// 'John'
		// ,    
		// 'age'
		// =>
		// 30
		// ,    
		// 'city'
		// =>
		// 'New York'
		// );
		
		// $jsonContent = json_encode($entity, JSON_PRETTY_PRINT);
		// $file = fopen($filePath, 'w');
		// fwrite($file, $jsonContent);
		// fclose($file);

		

		} catch (PersistenceFailedException $e) {
			$this->Log->saveFailed($e, $entity);
			$this->setResponse($this->ApiError->entity($e, $entity));
		}
	}

	/**
	 * Delete method
	 *
	 * @param string $id
	 * @return void
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 * @throws \Cake\ORM\Exception\PersistenceFailedException When rules check fails.
	 */
	public function delete($id): void
	{
		$entity = $this->Facilities->getFull($id);

		try {
			$this->Facilities->deleteOrFail($entity);
			$this->set('data', $entity);
			$this->set('success', true);
		} catch (PersistenceFailedException $e) {
			$this->Log->deleteFailed($e, $entity);
			$this->setResponse($this->ApiError->entity($e, $entity));
		}
	}

	/**
	 * Get the organization details by NPI number provided
	 * @param NpiServiceInterface $npiService
	 * @return void
	 */
	public function npiLookup(NpiServiceInterface $npiService): void
	{
		$this->request->allowMethod(['post']);

		$name = (string) $this->request->getData('name');
		$state = (string) $this->request->getData('state');
		$city = (string) $this->request->getData('city');
		$zip = (string) $this->request->getData('zip');


		$cacheState = Text::slug(strtoupper($state), '_');
		$cacheCity = Text::slug(strtoupper($city), '_');
		$cacheZip = Text::slug(strtoupper($zip), '_');
		$cacheName = Text::slug(strtolower($name));
		$cacheKey = 'org_' . $cacheState . '__' . $cacheCity .'__' . $cacheZip .'__' . $cacheName;

		// /** @var \App\Lib\NpiUtility\NpiOrganizationResult[] */
		// $results = Cache::remember(
		// 	$cacheKey,
		// 	function () use ($npiService, $name, $state) {
		// 		return $npiService->searchOrganizationByNameAndState($name, $state);
		// 	},
		// 	'npi'
		// );

		/** @var \App\Lib\NpiUtility\NpiOrganizationResult[] */
		$results = Cache::remember(
			$cacheKey,
			function () use ($npiService, $name, $state, $city, $zip) {
				return $npiService->searchOrganizationByNameAndStateAndCityAndZip($name, $state, $city, $zip);
			},
			'npi'
		);

		$this->set('data', $results);
	}
}
