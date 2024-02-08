<?php

namespace App\Controller\Client;

use App\Controller\AppController;
use App\Model\Table\FacilitiesContractsTable;
use Cake\Network\Exception\MethodNotAllowedException;

class FacilitiesContractsController extends AppController
{
    private $facilitiesContractsTable;

    public function initialize(): void
    {
        parent::initialize();
        $this->facilitiesContractsTable = new FacilitiesContractsTable();
    }

    public function index()
    {
        $facilitiesContracts = $this->facilitiesContractsTable->find()->toArray();

        $data = ['facilitiesContracts' => $facilitiesContracts];

        $this->setJsonResponse($data);
    }

    // Add other CRUD actions (add, edit, view, delete) as needed
}
