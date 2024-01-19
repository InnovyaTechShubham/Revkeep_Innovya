<?php
namespace App\Controller\Client;

use App\Controller\AppController;
use Cake\Log\Log;

class MultiplefacilityController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel('ClientemployeesFacility');
    }

    public function index()
    {
        if ($this->request->is('post')) {
            // Get data from the request
            $data = $this->request->getData();

            // Check if the required keys are present
            if (!isset($data['id'], $data['selectedFacilityIds'], $data['selectedFacilityNames'])) {
                // Return an error response or handle the missing keys as needed
                return $this->response->withStatus(400)->withStringBody(json_encode(['message' => 'Missing required data']));
            }

            // Access the id and selectedFacilityIds
            $id = $data['id'];
            $selectedFacilityIds = $data['selectedFacilityIds'];
            $selectedFacilityNames = $data['selectedFacilityNames'];

            // Existing facility IDs in the database
            $existingFacilityIds = $this->ClientemployeesFacility->find()
                ->where(['client_id' => $id])
                ->extract('facility_id')
                ->toArray();

            // Facilities to be removed
            $facilitiesToRemove = array_diff($existingFacilityIds, $selectedFacilityIds);

            try {
                // Remove facilities
                foreach ($facilitiesToRemove as $facilityId) {
                    $entity = $this->ClientemployeesFacility->find()
                        ->where(['client_id' => $id, 'facility_id' => $facilityId])
                        ->first();

                    if ($entity) {
                        if ($this->ClientemployeesFacility->delete($entity)) {
                            // Record deleted successfully
                        } else {
                            // Handle deletion errors
                            Log::error('Error deleting facility ID: ' . $facilityId);
                        }
                    }
                }

                // Add facilities only if they don't already exist
                foreach ($selectedFacilityIds as $facilityId) {
                    if (!in_array($facilityId, $existingFacilityIds, true)) {
                        $entity = $this->ClientemployeesFacility->newEntity([
                            'facility_id' => $facilityId,
                            'client_id' => $id,
                            'name' => "testing"
                        ]);

                        if ($this->ClientemployeesFacility->save($entity)) {
                            // Record saved successfully
                        } else {
                            // Handle validation errors
                            $errors = $entity->getErrors();
                            Log::error('Validation Errors: ' . print_r($errors, true));
                        }
                    }
                }

                return $this->response->withStatus(200)->withStringBody(json_encode(['message' => 'Facilities updated successfully']));

            } catch (\Exception $e) {
                Log::error('Exception: ' . $e->getMessage());
                return $this->response->withStatus(500)->withStringBody(json_encode(['message' => 'Failed to update facilities']));
            }
        }
    }
}
