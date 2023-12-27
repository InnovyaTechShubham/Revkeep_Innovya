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
            // $data = $this->request->getData();
            // $facilityArray = $this->request->getData('Facility_data');
             $clientId =  $this->request->getData('client_id');
             $facilityArray = $this->request->getData('facility_ids');
            // $filePath = 'C:\xampp\htdocs\Insurace-provider-Merged\example.json';
            // $jsonContent = json_encode($data, JSON_PRETTY_PRINT);
            // $file = fopen($filePath, 'w');
            // fwrite($file, $jsonContent);
            // fclose($file);

            try {
                $clientemployeesFacilityTable = new ClientemployeesFacilityTable();               
                    try {
                        foreach ($facilityArray as $facilityId) {
                            $newclientemployeesFacility = $clientemployeesFacilityTable->newEntity([
                                'client_id' =>$clientId,
                                'facility_id' => $facilityId,
                                
                            ]);
                            // $entity->facility_id = $facilityId;
                            // $entity->client_id = $clientId;
                            // $clientemployeesFacilityTable->save($entity);
                            $clientemployeesFacilityTable->save($newclientemployeesFacility);
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

//  // Iterate over the arrays and create entries in chainOrganizations table
//  foreach ($facilityArray as $facilityId) {
//     foreach ($serviceArray as $serviceId) {
//         $newChainOrganization = $chainOrganizationsTable->newEntity([
//             'chain_id' => $chainId,
//             'facility_id' => $facilityId['id'],
//             'service_id' => $serviceId['id'],
//         ]);

//         $chainOrganizationsTable->save($newChainOrganization);
//     }
// }
