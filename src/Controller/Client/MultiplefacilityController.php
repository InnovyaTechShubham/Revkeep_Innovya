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
          //    $data['id'] = 1;
           $id = $data['id'];
           $selectedFacilityIds = $data['selectedFacilityIds'];
           $filePath = 'C:\xampp\htdocs\Insurace-provider-Merged\example.json';
            $jsonContent = json_encode($data, JSON_PRETTY_PRINT);
            $file = fopen($filePath, 'w');
            fwrite($file, $jsonContent);
            fclose($file);


            try {
                $clientemployeesFacilityTable = new ClientemployeesFacilityTable();  
                           
                    try {
                        // foreach ($facilityArray as $facilityId) {
                        //     $newclientemployeesFacility = $clientemployeesFacilityTable->newEntity([
                        //         'client_id' =>$clientId,
                        //         'facility_id' => $facilityId,
                                
                        //     ]);
                        //     // $entity->facility_id = $facilityId;
                        //     // $entity->client_id = $clientId;
                        //     // $clientemployeesFacilityTable->save($entity);
                        //     $clientemployeesFacilityTable->save($newclientemployeesFacility);
                        // }
                        foreach ($selectedFacilityIds as $facilityId) {
                                        $entity = $clientemployeesFacilityTable->newEntity([
                                            'facility_id' => $facilityId,
                                            'client_id' => $id,
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


    // public function getClientFacilities($clientId)
    // {
    //     $this->autoRender = false; // Disable view rendering for JSON response
    //     $this->response = $this->response->withType('application/json');

    //     try {
    //         $clientemployeesFacilityTable = new ClientemployeesFacilityTable();
    //         $facilities = $clientemployeesFacilityTable
    //             ->find()
    //             ->where(['client_id' => $clientId])
    //             ->contain(['Facilities']) // Adjust the association name based on your setup
    //             ->toArray();

    //         return $this->response->withStringBody(json_encode(['facilities' => $facilities]));
    //     } catch (\Exception $e) {
    //         Log::error('Exception: ' . $e->getMessage());
    //         return $this->response->withStatus(500)->withStringBody(json_encode(['message' => 'Failed to fetch facilities']));
    //     }
    // }

}

