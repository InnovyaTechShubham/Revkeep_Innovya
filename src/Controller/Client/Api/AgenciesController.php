<?php

declare(strict_types=1);

namespace App\Controller\Client\Api;

use Cake\ORM\Exception\PersistenceFailedException;

/**
 * Agencies Controller
 *
 * @property \App\Model\Table\AgenciesTable $Agencies
 */
class AgenciesController extends ApiController
{
	/**
	 * @var array
	 */
	public $paginate = [
		'finder' => 'search',
		'contain' => [
			'OutgoingProfile'
		],
		'limit' => PAGINATION_DEFAULT_LIMIT,
		'order' => [
			'name' => 'asc',
		],
		'sortableFields' => [
			'name',
			'active',
			'third_party_contractor',
			'created',
			'modified',
			'deleted',
		],
	];

	/**
	 * Add method
	 *
	 * @return void
	 * @throws \Cake\ORM\Exception\PersistenceFailedException When not valid.
	 */
	public function add(): void
	{
		$entity = $this->Agencies->newEntity($this->getRequest()->getData(), [
			'associated' => [
				'OutgoingProfile',
			],
		]);

		try {
			$this->Agencies->saveOrFail($entity, [
				'associated' => [
					'OutgoingProfile',
				],
			]);
			$entity = $this->Agencies->getFull($entity->id);
			$this->set('data', $entity);
		} catch (PersistenceFailedException $e) {
			$this->Log->saveFailed($e, $entity);
			$this->setResponse($this->ApiError->entity($e, $entity));
		}
	}

	/**
	 * View method
	 *
	 * @param string $id
	 * @return void
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	public function view($id): void
	{
		$this->set('data', $this->Agencies->getFull($id));
	}

	/**
	 * Index method
	 *
	 * @return void
	 */
	public function index(): void
	{
		// $this->crudIndex();
		// new test code block starts here
		// Get query parameters from the request
		$params = $this->getRequest()->getQueryParams();

		// Check if $params has the key 'facility_status'
		$query = $this->Agencies
		->find()
		->contain([
			'OutgoingProfile', // Include associated FacilityTypes
			// Add more associations as needed
		]);
		// Apply filtering conditions based on query parameters
		// Check if facility_status parameter is set
		if (isset($params['active']) && $params['active'] !== null) {
			// // Execute the query and fetch results
			// $result1 = $query->where(['Facilities.facility_status' => $params['facility_status']])->toArray();
			
			// // Append results to $data
			// $data = array_merge($data, $result1);
			// Add facility_status condition
			$query->andWhere(['Agencies.active' => $params['active']]);
		}
		if (isset($params['third_party_contractor']) && $params['third_party_contractor'] !== null) {
			// // Execute the query and fetch results
			// $result2 = $query->where(['Facilities.facility_type_id' => $params['facility_type_id']])->toArray();
			
			// // Append results to $data
			// $data = array_merge($data, $result2);
			// Add facility_type_id condition
			$query->andWhere(['Agencies.third_party_contractor' => $params['third_party_contractor']]);
		}
		if (isset($params['outgoing_primary_method']) && $params['outgoing_primary_method'] !== null) {
			// // Execute the query and fetch results
			// $result2 = $query->where(['Facilities.facility_type_id' => $params['facility_type_id']])->toArray();
			
			// // Append results to $data
			// $data = array_merge($data, $result2);
			// Add facility_type_id condition
			$query->andWhere(['Agencies.outgoing_primary_method' => $params['outgoing_primary_method']]);
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
					"Agencies.name" => "asc"
				],
				"limit" => null,
				"scope" => null,
				"finder" => "search"
			],
		]);
		// new test code block ends here
	}

	/**
	 * Active method
	 *
	 * @return void
	 */
	public function active(): void
	{
		$entities = $this->Agencies
			->find('active')
			->find('ordered')
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
		$entities = $this->Agencies
			->find('all')
			->find('ordered')
			->cache('Agencies', 'all')
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
		$entity = $this->Agencies->get($id);

		try {
			$entity = $this->Agencies->patchEntity($entity, $this->getRequest()->getData(), [
				'associated' => [
					'OutgoingProfile',
				],
			]);

			$this->Agencies->saveOrFail($entity);
			$entity = $this->Agencies->getFull($entity->id);
			$this->set('data', $entity);
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
		$entity = $this->Agencies->getFull($id);

		try {
			$this->Agencies->deleteOrFail($entity);
			$this->set('data', $entity);
			$this->set('success', true);
		} catch (PersistenceFailedException $e) {
			$this->Log->deleteFailed($e, $entity);
			$this->setResponse($this->ApiError->entity($e, $entity));
		}
	}
}
