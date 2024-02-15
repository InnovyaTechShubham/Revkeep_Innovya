<?php

declare(strict_types=1);

namespace App\Controller\Client\Api;
use App\Model\Table\FacilityTypesTable;

/**
 * Facility Types Controller
 *
 * @property \App\Model\Table\FacilityTypesTable $FacilityTypes
 */
class FacilityTypesController extends ApiController
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
			'name',
			'created',
			'modified',
			'deleted',
		],
	];

	/**
	 * View method
	 *
	 * @param string $id
	 * @return void
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	public function view($id): void
	{
		$entity = $this->FacilityTypes->get($id);

		$this->set('data', $entity);
	}

	/**
	 * Index method
	 *
	 * 
	 */
	public function index()
	{
		$this->FacilityTypes = new FacilityTypesTable();
		 // Query all the information from the facility types table
		 $FacilityTypes = $this->FacilityTypes->find()->toArray();
        
		 // Create a response object with JSON data
		 $response = $this->response->withType('application/json');
		 $response = $response->withStringBody(json_encode($FacilityTypes));
		 
		 return $response;
	}

	/**
	 * All method
	 *
	 * @return void
	 */
	public function all(): void
	{
		$entities = $this->FacilityTypes
			->find('all')
			->find('ordered')
			->find('limited')
			->cache('FacilityTypes', 'all')
			->all();

		$this->set('data', $entities);
	}
}
