<?php

namespace App\Controller\Client;

use App\Controller\AppController;
use App\Model\Table\ContractInsuranceTypesTable;

class ContractInsuranceTypesController extends AppController
{
    private $contractinsuranceTypesTable;

    public function initialize(): void
    {
        parent::initialize();
        $this->contractinsuranceTypesTable = new ContractInsuranceTypesTable();
    }

    public function index()
    {
        $insuranceTypes = $this->contractinsuranceTypesTable->find()->toArray();

        $response = $this->response->withType('application/json');
        $response = $response->withStringBody(json_encode($insuranceTypes));
        
        return $response;
    }

    // Add other CRUD actions (add, edit, view, delete) as needed
}
