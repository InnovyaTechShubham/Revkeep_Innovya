<?php

namespace App\Controller\Client;

use App\Controller\AppController;
use App\Model\Table\ContractTypesTable;

class ContractTypesController extends AppController
{
    private $contractTypesTable;

    public function initialize(): void
    {
        parent::initialize();
        $this->contractTypesTable = new ContractTypesTable();
    }

    public function index()
    {
        $contractTypes = $this->contractTypesTable->find()->toArray();

        $response = $this->response->withType('application/json');
        $response = $response->withStringBody(json_encode($contractTypes));
        
        return $response;
    }

    // Add other CRUD actions (add, edit, view, delete) as needed
}
