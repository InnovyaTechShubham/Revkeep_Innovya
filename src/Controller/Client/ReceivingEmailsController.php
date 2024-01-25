<?php

namespace App\Controller\Client;

use App\Model\Table\ReceivingEmailsTable;
use App\Controller\AppController;
use Cake\Network\Exception\MethodNotAllowedException;

class ReceivingEmailsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }

    public function add() 
    {
        $this->request->allowMethod(['post']);

        $email = $this->request->getData('email');
        $description = $this->request->getData('description');

       

        // Validate the data (you can add more validations here)
        if (empty($email)) {
            $this->response = $this->response->withStatus(400);
            $this->set(['success' => false, 'message' => 'Email is required.', '_serialize' => ['success', 'message']]);
            return;
        }

        // Assuming you have a ReceivingEmailsTable with the appropriate model
        // $ReceivingEmailsTable = $this->getTableLocator()->get('ReceivingEmails');
        $ReceivingEmailsTable = new ReceivingEmailsTable();
        // Create a new entity and save it
        $receivingEntry = $ReceivingEmailsTable->newEmptyEntity();
        $receivingEntry->email = $email;
        $receivingEntry->description = $description;
        $receivingEntry->created_at = ' ';

        // Insert debugging code
        $filePath = 'C:\xampp\htdocs\Revkeep_Innovya\example1.json';
        
        
        $jsonContent = json_encode($receivingEntry, JSON_PRETTY_PRINT);
        $file = fopen($filePath, 'w');
        fwrite($file, $jsonContent);
        fclose($file);
        try{
            // if ($ReceivingEmailsTable->save($receivingEntry)) {
            //     $this->set(['success' => true, 'message' => 'Email saved successfully.', '_serialize' => ['success', 'message']]);
            // } else {
            //     $this->response = $this->response->withStatus(500);
            //     $this->set(['success' => false, 'message' => 'Internal server error.', '_serialize' => ['success', 'message']]);
            // }
            $ReceivingEmailsTable->save($receivingEntry);
            return $this->response
                    ->withType('application/json')
                    ->withStringBody(json_encode($receivingEntry));
                
    }
    catch (\Exception $e){
        $responseMessage = ['error' => $e->getMessage()];
        return $this->response
                    ->withType('application/json')
                    ->withStringBody(json_encode($responseMessage));
    }

    }
    
}