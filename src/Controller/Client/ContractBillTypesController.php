<?php

namespace App\Controller\Client;

use App\Controller\AppController;
use App\Model\Table\ContractBillTypesTable;

class ContractBillTypesController extends AppController
{
    private $contractBillTypesTable;

    public function initialize(): void
    {
        parent::initialize();
        $this->contractBillTypesTable = new ContractBillTypesTable();
    }

    public function index()
    {
        $billTypes = $this->contractBillTypesTable->find()->toArray();

        $response = $this->response->withType('application/json');
        $response = $response->withStringBody(json_encode($billTypes));
        
        return $response;
    }

    // Add other CRUD actions (add, edit, view, delete) as needed
}
