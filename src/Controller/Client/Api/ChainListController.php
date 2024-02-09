<?php

declare(strict_types=1);

namespace App\Controller\Client\Api;

use Cake\ORM\Exception\PersistenceFailedException;
use App\Controller\Client\Api\ApiController;
use Cake\Http\Response;
use App\Model\Table\ChainOrganizationsTable;
use App\Model\Table\ChainsTable;


// /**
//  * ServiceList Controller
//  *
//  * @property \App\Model\Table\FacilitiesServicesTable $FacilitiesServices
//  */
class ChainListController extends ApiController
{
    protected $Services;

    public function initialize(): void
    {
        parent::initialize();
        $this->facilityChains = new ChainOrganizationsTable();
        $this->chains = new ChainsTable();

    }


    public function index()
    {
        
        // // Query all the information from the services table
        $Chains = $this->chains->find()->toArray();
        $facilityChains = $this->facilityChains->find()->toArray();
        
        
        $data = array('chains' => $Chains, 'facilityChains' => $facilityChains);
        // Create a response object with JSON data
        $response = $this->response->withType('application/json');
        $response = $response->withStringBody(json_encode($data));
        
        return $response;
        // $this->autoRender = false;

       
    }


    
}
