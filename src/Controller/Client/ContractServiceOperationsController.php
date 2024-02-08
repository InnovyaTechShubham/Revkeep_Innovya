<?php

namespace App\Controller\Client;

use App\Controller\AppController;
use App\Model\Table\ContractServiceOperationsTable;
use Cake\Network\Exception\MethodNotAllowedException;

class ContractServiceOperationsController extends AppController
{
    private $contractServiceOperationsTable;

    public function initialize(): void
    {
        parent::initialize();
        $this->contractServiceOperationsTable = new ContractServiceOperationsTable();
    }

    public function index()
    {
        $serviceOperations = $this->contractServiceOperationsTable->find()->toArray();

        $response = $this->response->withType('application/json');
        $response = $response->withStringBody(json_encode($serviceOperations));
        
        return $response;
    }

    // Add other CRUD actions (add, edit, view, delete) as needed
}
