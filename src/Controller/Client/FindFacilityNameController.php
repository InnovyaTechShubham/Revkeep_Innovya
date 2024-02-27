<?php

namespace App\Controller\Client;

use App\Controller\AppController;
use Cake\Http\Response;
use App\Model\Table\FacilitiesTable;

class FindFacilityNameController extends AppController
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
            $ids = $this->request->getQuery('ids'); // Retrieve 'ids' instead of 'id'
            
            // Write the query result to a JSON file
            // $filePath = 'C:/xampp/htdocs/Insurace-provider-Merged/example.json';
            // $jsonData = json_encode($ids, JSON_PRETTY_PRINT);
            // $file = fopen($filePath, 'w');
            // fwrite($file, $jsonData);
            // fclose($file);
    
            // Convert the comma-separated string of IDs to an array
            $idsArray = explode(',', $ids);
    
            // Query facilities based on the search parameter
            $query = $this->facilitiesTable->find()->where(['id IN' => $idsArray]);
    
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
