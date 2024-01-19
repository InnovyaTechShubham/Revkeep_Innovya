<?php

namespace App\Controller\Client;
use App\Controller\AppController;
use Cake\Http\Response;
use App\Model\Table\UsersTable;


class UsersListController extends AppController
{
   
    public function initialize(): void
    {
        parent::initialize();
        $this->client = new UsersTable();
    }

    public function index()
    {
        // Query all the information from the ClientEmployees_facility table
        $client = $this->client->find()->toArray();
        
        // Create a response object with JSON data
        $response = $this->response->withType('application/json');
        $response = $response->withStringBody(json_encode($client));
        
        return $response;
    }
}
