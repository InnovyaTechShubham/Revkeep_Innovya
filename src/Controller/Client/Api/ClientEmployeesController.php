<?php

declare(strict_types=1);

namespace App\Controller\Client\Api;

use App\Service\NpiServiceInterface;
use Cake\Cache\Cache;
use Cake\ORM\Exception\PersistenceFailedException;
use Cake\Utility\Text;

/**
 * Client Employee Types Controller
 *
 * @property \App\Controller\Component\ApiErrorComponent $ApiError
 * @property \App\Controller\Component\LogComponent $Log
 * @property \App\Model\Table\ClientEmployeesTable $ClientEmployees
 */
class ClientEmployeesController extends ApiController
{
	/**
	 * @var array
	 */
	public $paginate = [
		'finder' => 'search',
		'limit' => PAGINATION_DEFAULT_LIMIT,
		'order' => [
			'last_name' => 'asc',
			'first_name' => 'asc'
		],
		'sortableFields' => [
			'first_name',
			'last_name',
			'title',
			'work_phone',
			'mobile_phone',
			'email',
			'state',
			'created',
			'modified',
			'deleted',
			'active',
			'npi_number',
			// Associations
			'Facilities.name',
		],
		'contain' => [
			'Facilities',
		],
	];

	/**
	 * Add method
	 *
	 * @return void
	 * @throws \Cake\ORM\Exception\PersistenceFailedException When not valid.
	 */
	// public function add(): void
	// {
	// 	$entity = $this->ClientEmployees->newEntity($this->getRequest()->getData(), [
	// 		'fields' => [
	// 			'active',
	// 			'first_name',
	// 			'last_name',
	// 			'facility_id',
	// 			'npi_number',
	// 			'state',
	// 			'title',
	// 			'email',
	// 			'mobile_phone',
	// 			'work_phone'
	// 		],
	// 		'associated' => [],
	// 	]);

	// 	try {
	// 		$this->ClientEmployees->saveOrFail($entity);
	// 		$entity = $this->ClientEmployees->getFull($entity->id);
	// 		$this->set('data', $entity);
	// 	} catch (PersistenceFailedException $e) {
	// 		$this->Log->saveFailed($e, $entity);
	// 		$this->setResponse($this->ApiError->entity($e, $entity));
	// 	}
	// }
	public function add(): void
{
    $npiNumber = $this->getRequest()->getData('npi_number');
    
    $existingEntity = $this->ClientEmployees
        ->find()
        ->where(['npi_number' => $npiNumber])
        ->first();

    if ($existingEntity) {
        $this->setResponse([
            'error' => 'NPI number already exists in the database',
            'existing_entity' => $existingEntity
        ]);
        return;
    }

    $entity = $this->ClientEmployees->newEntity($this->getRequest()->getData(), [
        'fields' => [
            'active',
            'first_name',
            'last_name',
            'facility_id',
            'npi_number',
            'state',
            'title',
            'email',
            'mobile_phone',
            'work_phone',
			'gender',
			'enumeration_type',
			'address_1',
			'address_2',
			'locationPhoneNumber',
			'mailingPhoneNumber',
			'primaryTaxonomy',
			'additionalTaxonomies',
			'othername',
			'enumeration_type',
			'proprietor',
			'selectedFacilityIds',
        ],
        'associated' => [],
    ]);

    try {
		
        $this->ClientEmployees->saveOrFail($entity);
        $entity = $this->ClientEmployees->getFull($entity->id);
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
		$this->set('data', $this->ClientEmployees->getFull($id));
	}

	/**
	 * Index method
	 *
	 * @return void
	 */
	public function index(): void
	{
		$this->crudIndex();
	}

	/**
	 * All method
	 *
	 * @return void
	 */
	public function all(): void
	{
		$entities = $this->ClientEmployees
			->find('all')
			->find('ordered')
			->all();

		$this->set('data', $entities);
	}

	/**
	 * Active method
	 *
	 * @return void
	 */
	public function active(): void
	{
		$entities = $this->ClientEmployees
			->find('active')
			->find('ordered')
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
		$entity = $this->ClientEmployees->get($id);

		try {
			$entity = $this->ClientEmployees->patchEntity($entity, $this->getRequest()->getData(), [
				'associated' => [],
			]);
			$this->ClientEmployees->saveOrFail($entity);
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
		$entity = $this->ClientEmployees->getFull($id);

		try {
			$this->ClientEmployees->deleteOrFail($entity);
			$this->set('data', $entity);
			$this->set('success', true);
		} catch (PersistenceFailedException $e) {
			$this->Log->deleteFailed($e, $entity);
			$this->setResponse($this->ApiError->entity($e, $entity));
		}
	}

	/**
	 * Lookup from NPI Service method
	 *
	 * @return void
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 * @throws \Cake\ORM\Exception\PersistenceFailedException When rules check fails.
	 */
	public function lookup(NpiServiceInterface $npiService): void
{
    $this->getRequest()->allowMethod('post');

	$npiNumber = $this->getRequest()->getData('npi_number', '');
    $firstName = $this->getRequest()->getData('first_name', '');
    $lastName = $this->getRequest()->getData('last_name', '');
    $state = $this->getRequest()->getData('state', '');
    $city = $this->getRequest()->getData('city', '');
    $postalCode = $this->getRequest()->getData('zip', '');
    $exact = $this->getRequest()->getData('exact', false);

	
	
	
	$npiNumber = !empty($npiNumber) ? intval($npiNumber) : null;
	// Check if NPI number is provided
    if (!empty($npiNumber)) {
        // Search by NPI number
        $results = $npiService->searchIndividualByNumber($npiNumber);
    } else{

    $cacheKey = 'ind_' .
        Text::slug(strtoupper($state)) . '__' .
        Text::slug(strtoupper($city)) . '__' .
        Text::slug(strtoupper($postalCode)) . '__' .
        Text::slug(strtolower($lastName)) . '__' .
        Text::slug(strtolower($firstName));

    // Including city and zip in the cache key
    $cacheKey .= '__' . Text::slug(strtoupper($city)) . '__' . Text::slug(strtoupper($postalCode));

    // Fetching or caching results
    $results = Cache::remember(
        $cacheKey,
        function () use ($npiService, $firstName, $lastName, $state, $city, $postalCode, $exact) {
            return $npiService->searchIndividualByNameAndState($firstName, $lastName, $state, $city, $postalCode, $exact);
        },
        'npi'
    );
}

    // Setting data for view
    $this->set('data', $results);
}

}