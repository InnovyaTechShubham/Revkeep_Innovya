<?php 
namespace App\Controller\Client;
use App\Controller\AppController;
use App\Model\Table\ClientemployeesFacilityTable;
use Cake\Log\Log;

class MultiplefacilityController extends AppController
{
    public function index()
    {
        if ($this->request->is('post')) {
           // Get data from the request
           $data = $this->request->getData();

          // Access the id and selectedFacilityIds
          
           $id = $data['id'];
           $selectedFacilityIds = $data['selectedFacilityIds'];
           $selectedFacilityNames = $data['selectedFacilityNames'];
           $filePath = 'C:\xampp\htdocs\Insurace-provider-Merged\example3.json';
            $jsonContent = json_encode($data, JSON_PRETTY_PRINT);
            $file = fopen($filePath, 'w');
            fwrite($file, $jsonContent);
            fclose($file);

            try {
                $clientemployeesFacilityTable = new ClientemployeesFacilityTable();  
                           
                    try {
                       
                        foreach ($selectedFacilityIds as $facilityId) {
                                        $entity = $clientemployeesFacilityTable->newEntity([
                                            'facility_id' => $facilityId,
                                            'client_id' => $id,
                                            'name' => "testing"
                                        ]);
                                        if ($clientemployeesFacilityTable->save($entity)) {
                                            // Record saved successfully
                                        } else {
                                            // Handle validation errors
                                            $errors = $entity->getErrors();
                                            Log::error('Validation Errors: ' . print_r($errors, true));
                                        }
                                    }
                    } catch (\Exception $e) {
                        Log::error('Error saving facility IDs: ' . $e->getMessage());
                        $responseMessage = ['error' => $e->getMessage()];
                        return $this->response
                            ->withType('application/json')
                            ->withStringBody(json_encode($responseMessage));
                    }
                
                return $this->response->withStatus(200)->withStringBody(json_encode(['message' => 'Facilities created successfully']));
            } catch (\Exception $e) {
                Log::error('Exception: ' . $e->getMessage());
                return $this->response->withStatus(500)->withStringBody(json_encode(['message' => 'Failed to create facilities']));
            }
        }
    }
}

