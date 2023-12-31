<?php


namespace App\Controller\Client;

use App\Controller\AppController;
use Cake\Http\Response;
use App\Model\Table\AgenciesTable; // Make sure to adjust the namespace

class AgencyListController extends AppController
{
    protected $CaseRequests;

    public function initialize(): void
    {
        parent::initialize();
        $this->Agency = new AgenciesTable();
    }

    public function index()
    {
        // Query all the information from the case_requests table
        $Agency = $this->Agency->find()->toArray();
        
        // Create a response object with JSON data
        $response = $this->response->withType('application/json');
        $response = $response->withStringBody(json_encode($Agency));
        
        return $response;
    }
}







