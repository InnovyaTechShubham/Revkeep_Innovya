<?php

namespace App\Controller\Client;
use App\Controller\AppController;
use Cake\Http\Response;
use App\Model\Table\FacilitiesTable;


class FacilityListController extends AppController
{
   
    public function initialize(): void
    {
        parent::initialize();
        $this->client = new FacilitiesTable();
    }

    public function index()
    {
        // Query all the information from the facility table
        $client = $this->client->find()->toArray();
        
        // Create a response object with JSON data
        $response = $this->response->withType('application/json');
        $response = $response->withStringBody(json_encode($client));
        
        return $response;
    }

    // searchFacility
    public function searchFacility()
    {
        try {
            $this->autoRender = false;

            // Get the ChainsTable instance
            $facilitiesTable = $this->getTableLocator()->get('Facilities');

            $searchTerm = $this->request->getQuery('search', '');

            // Build conditions based on the search term
            $conditions = [];
            if (!empty($searchTerm)) {
                $conditions['name LIKE'] = "%$searchTerm%";
            }

            // Retrieve records from the "facilities" table based on conditions
            $records = $facilitiesTable->find('all', [
                'conditions' => $conditions,
            ])->toArray();

            // Return JSON response
            $this->response = $this->response->withType('application/json')
                ->withStringBody(json_encode($records));

            return $this->response;


        }catch (\Exception $e) {

            $filePath = WWW_ROOT . 'json/powerback_denial_reasons.json';
            $jsonContent = json_encode($e->getMessage(), JSON_PRETTY_PRINT);
            $file = fopen($filePath, 'w');
            fwrite($file, $jsonContent);
            fclose($file);

            $this->log($e->getMessage(), 'error');
            $this->response = $this->response->withStatus(500);
        }	 
    }
}