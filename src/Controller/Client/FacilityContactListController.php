<?php

namespace App\Controller\Client;

use App\Controller\AppController;
use Cake\Http\Response;
use App\Model\Table\FacilityContactsTable;
use Cake\ORM\TableRegistry;

class FacilityContactListController extends AppController
{
    protected $facilityContactsTable;

    public function initialize(): void
    {
        parent::initialize();
        $this->facilityContactsTable = TableRegistry::getTableLocator()->get('FacilityContacts'); // Adjust table name accordingly
    }

    public function index()
    {
        $response = $this->response->withType('application/json');
        
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $id = $data['id'];            
            $facilityContacts = $this->facilityContactsTable->find()
                ->where(['facility_id' => $id])
                ->toArray();
            
            $response = $response->withStringBody(json_encode($facilityContacts, JSON_PRETTY_PRINT));
        } else {
            // If not a POST request, return empty response or handle accordingly
            $response = $response->withStatus(400)->withStringBody('Bad request');
        }
        
        return $response;
    }
}
