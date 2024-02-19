<?php
namespace App\Controller\Client;

use App\Model\Table\FacilitiesReceivingMethodsTable;
use App\Model\Table\ReceivingEmailsTable;

use App\Controller\AppController;
use Cake\Network\Exception\MethodNotAllowedException;


class FacilitiesReceivingMethodsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        // $facilitiesReceivingMethodsTable = new FacilitiesReceivingMethodsTable();

        // $this->loadModel('FacilitiesReceivingMethods'); // Load the model for the FacilitiesReceivingMethods table
    }

    public function add() 
    {

        $this->request->allowMethod(['post']);

        $facilityId = $this->request->getData('facility_id');
        $receivingEmailId = $this->request->getData('receiving_email_id');
        $receivingFaxId = $this->request->getData('receiving_fax_id');

        // Add more fields as needed

        //  // Insert debugging code
        //  $filePath = 'C:\xampp\htdocs\Revkeep_Innovya\example1.json';
        
        
        //  $jsonContent = json_encode($receivingEmailId, JSON_PRETTY_PRINT);
        //  $file = fopen($filePath, 'w');
        //  fwrite($file, $jsonContent);
        //  fclose($file);

        // Validate the data (you can add more validations here)
        if (empty($facilityId)) {
            $this->response = $this->response->withStatus(400);
            $this->set(['success' => false, 'message' => 'facility_id is required.', '_serialize' => ['success', 'message']]);
            return;
        }

        // Assuming you have a FacilitiesReceivingMethodsTable with the appropriate model
        $facilitiesReceivingMethodsTable = new FacilitiesReceivingMethodsTable();
        // Create a new entity and save it
        $facilitiesReceivingMethodsEntry = $facilitiesReceivingMethodsTable->newEmptyEntity();
        $facilitiesReceivingMethodsEntry->facility_id = $facilityId;
        $facilitiesReceivingMethodsEntry->receiving_email_id = $receivingEmailId;
        $facilitiesReceivingMethodsEntry->receiving_fax_id = $receivingFaxId;
        $facilitiesReceivingMethodsEntry->created_at = ' ';

        // $facilitiesReceivingMethodsTable = $FacilitiesReceivingMethodsTable->newEntity([
        //     'facility_id' => $facilityId,
        //     'receiving_email_id' => $receivingEmailId,
        //     'receiving_fax_id' => $receivingFaxId,
        //     'created_at' => ''
        // ]);

        // $FacilitiesReceivingMethodsTable->save($facilitiesReceivingMethodsTable);

        // // Insert debugging code
        // $filePath = 'C:\xampp\htdocs\Revkeep_Innovya\example1.json';
        
        
        // $jsonContent = json_encode($facilitiesReceivingMethodsEntry, JSON_PRETTY_PRINT);
        // $file = fopen($filePath, 'w');
        // fwrite($file, $jsonContent);
        // fclose($file);
        try {
            // if ($facilitiesReceivingMethodsTable->save($facilitiesReceivingMethodsEntry)) {
            //     $this->set(['success' => true, 'message' => 'Facility receiving method saved successfully.', '_serialize' => ['success', 'message']]);
            // } else {
            //     $this->response = $this->response->withStatus(500);
            //     $this->set(['success' => false, 'message' => 'Internal server error.', '_serialize' => ['success', 'message']]);
            // }
            $facilitiesReceivingMethodsTable->save($facilitiesReceivingMethodsEntry);
            return $this->response
                    ->withType('application/json')
                    ->withStringBody(json_encode($facilitiesReceivingMethodsEntry));
        } catch (\Exception $e) {
            // $this->log($e->getMessage(), 'error');
            // $responseMessage = ['error' => $e->getMessage()];
            // $this->response = $this->response->withStatus(500);
            // $this->set(['success' => false, 'message' => $responseMessage, '_serialize' => ['success', 'message']]);
            $responseMessage = ['error' => $e->getMessage()];
             return $this->response
                    ->withType('application/json')
                    ->withStringBody(json_encode($responseMessage));
        }

        // $this->viewBuilder()->setOption('serialize', ['success', 'message']);
    }

    public function index()
    {
        $this->facilityReceivingEmails = new FacilitiesReceivingMethodsTable();
        $this->Emails = new ReceivingEmailsTable();

        $facilityEmails = $this->facilityReceivingEmails->find()->toArray();
        $emails = $this->Emails->find()->toArray();

        $data = array('emails' => $emails, 'facilityEmails' => $facilityEmails);
        // Create a response object with JSON data
        $response = $this->response->withType('application/json');
        $response = $response->withStringBody(json_encode($data));
        
        return $response;
    }
}
