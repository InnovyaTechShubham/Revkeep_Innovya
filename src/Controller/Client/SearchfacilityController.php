<?php

namespace App\Controller\Client;

use App\Controller\AppController;
use Cake\Http\Response;
use App\Model\Table\FacilitiesTable;

class SearchfacilityController extends AppController
{
    private $facilitiesTable;

    public function initialize(): void
    {
        parent::initialize();
        $this->facilitiesTable = new FacilitiesTable();
    }

    public function index()
    {
        try {
            // Check if the search parameter is passed
            $search = $this->request->getQuery('search');

            
            // Query facilities based on the search parameter
            $query = $this->facilitiesTable->find()->where(['name LIKE' => "%$search%"]);


            // Convert the query result to an array
            $facilities = $query->toArray();

            // Create a response object with JSON data
            $response = $this->response->withType('application/json');
            $response = $response->withStringBody(json_encode($facilities));

            return $response;
        } catch (\Exception $e) {
            // Handle exceptions, perhaps log the error
            $this->log($e->getMessage(), 'error');
            $this->response = $this->response->withStatus(500); // Internal Server Error
            return $this->response;
        }
    }
}

