<?php

namespace App\Controller\Client;

use App\Controller\AppController;
use App\Model\Table\ContractOwnershipTypesTable;

class ContractOwnershipTypesController extends AppController
{
    private $contractOwnershipTypesTable;

    public function initialize(): void
    {
        parent::initialize();
        $this->contractOwnershipTypesTable = new ContractOwnershipTypesTable();
    }

    public function index()
    {
        $ownershipTypes = $this->contractOwnershipTypesTable->find()->toArray();

        $response = $this->response->withType('application/json');
        $response = $response->withStringBody(json_encode($ownershipTypes));
        
        return $response;
    }

    // Add other CRUD actions (add, edit, view, delete) as needed
}
