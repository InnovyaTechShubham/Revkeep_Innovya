<?php

namespace App\Controller\Client;

use App\Model\Table\FacilitiesReceivingMethodsTable;
use App\Controller\AppController;
use Cake\Network\Exception\MethodNotAllowedException;

class ReceivingMethodsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }

    public function add() 
    {
        $this->request->allowMethod(['post']);

        $facilityId = $this->request->getData('facility_id');
        $receivingEmailId = $this->request->getData('receiving_email_id');
        $receivingFaxId = $this->request->getData('receiving_fax_id');

        // Validate the data (you can add more validations here)
        if (empty($facilityId) || empty($receivingEmailId) || empty($receivingFaxId)) {
            $this->response = $this->response->withStatus(400);
            $this->set(['success' => false, 'message' => 'Facility ID, Receiving Email ID, and Receiving Fax ID are required.', '_serialize' => ['success', 'message']]);
            return;
        }

        // Assuming you have a FacilitiesReceivingMethodsTable with the appropriate model
        $receivingMethodsTable = new FacilitiesReceivingMethodsTable();
        
        // Create a new entity and save it
        $receivingEntry = $receivingMethodsTable->newEmptyEntity();
        $receivingEntry->facility_id = $facilityId;
        $receivingEntry->receiving_email_id = $receivingEmailId;
        $receivingEntry->receiving_fax_id = $receivingFaxId;
        $receivingEntry->created_at = now(); // Use the current timestamp

        try {
            if ($receivingMethodsTable->save($receivingEntry)) {
                $this->set(['success' => true, 'message' => 'Receiving Method saved successfully.', '_serialize' => ['success', 'message']]);
            } else {
                $this->response = $this->response->withStatus(500);
                $this->set(['success' => false, 'message' => 'Internal server error.', '_serialize' => ['success', 'message']]);
            }
        } catch (\Exception $e) {
            $responseMessage = ['error' => $e->getMessage()];
            $this->response = $this->response->withStatus(500);
            $this->set(['success' => false, 'message' => $responseMessage, '_serialize' => ['success', 'message']]);
        }
    }
}
