<?php

declare(strict_types=1);

namespace App\Controller\Client\Api;

use Cake\ORM\Exception\PersistenceFailedException;
use App\Controller\Client\Api\ApiController;
use Cake\Http\Response;
use App\Model\Table\FacilitiesServicesTable;
use App\Model\Table\ServicesTable;


// /**
//  * ServiceList Controller
//  *
//  * @property \App\Model\Table\FacilitiesServicesTable $FacilitiesServices
//  */
class ServiceListController extends ApiController
{
    protected $Services;

    public function initialize(): void
    {
        parent::initialize();
        $this->facilityServices = new FacilitiesServicesTable();
        $this->Services = new ServicesTable();

    }


    public function index()
    {
        
        // // Query all the information from the services table
        $Services = $this->Services->find()->toArray();
        $facilityServices = $this->facilityServices->find()->toArray();
        
        
        $data = array('services' => $Services, 'facilityservices' => $facilityServices);
        // Create a response object with JSON data
        $response = $this->response->withType('application/json');
        $response = $response->withStringBody(json_encode($data));
        
        return $response;
        // $this->autoRender = false;

       
    }


    
}
