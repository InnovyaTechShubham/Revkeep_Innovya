<?php


namespace App\Controller\Client\Api;

use App\Controller\AppController;
use Cake\Http\Response;
use App\Model\Table\ContractStatusTable; // Make sure to adjust the namespace

class FetchContractStatusController extends AppController
{
    protected $CaseRequests;

    public function initialize(): void
    {
        parent::initialize();
        $this->Agency = new ContractStatusTable();
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







