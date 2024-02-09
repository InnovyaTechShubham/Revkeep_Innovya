<?php

namespace App\Controller\Client;

use App\Model\Table\ReceivingFaxesTable;
use App\Controller\AppController;
use Cake\Network\Exception\MethodNotAllowedException;

class ReceivingFaxesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }

    public function add() 
    {
        $this->request->allowMethod(['post']);

        $fax = $this->request->getData('fax');
        $description = $this->request->getData('description');

        // $filePath = 'C:\xampp\htdocs\Revkeep_Innovya\example1.json';
        
        
        // $jsonContent = json_encode($fax, JSON_PRETTY_PRINT);
        // $file = fopen($filePath, 'w');
        // fwrite($file, $jsonContent);
        // fclose($file);

        // Validate the data (you can add more validations here)
        if (empty($fax)) {
            $this->response = $this->response->withStatus(400);
            $this->set(['success' => false, 'message' => 'Fax is required.', '_serialize' => ['success', 'message']]);
            return;
        }

        // Assuming you have a ReceivingFaxesTable with the appropriate model
        // $ReceivingFaxesTable = $this->getTableLocator()->get('ReceivingFaxes');
        $ReceivingFaxesTable = new ReceivingFaxesTable();
        // var_dump($fax, $description);

        // Create a new entity and save it
        $receivingEntry = $ReceivingFaxesTable->newEmptyEntity();
        $receivingEntry->fax = $fax;
        $receivingEntry->description = $description;
        $receivingEntry->created_at = ' ';

        // // Insert debugging code
        // $filePath = 'C:\xampp\htdocs\Revkeep_Innovya\example1.json';
        
        
        // $jsonContent = json_encode($receivingEntry, JSON_PRETTY_PRINT);
        // // echo $jsonContent;
        // $file = fopen($filePath, 'w');
        // fwrite($file, $jsonContent);
        // fclose($file);
        try{
           
            $ReceivingFaxesTable->save($receivingEntry);
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

    public function index()
    {
        $this->facilityReceivingFaxes = new ReceivingFaxesTable();

        $receivingFaxes = $this->facilityReceivingFaxes->find()->toArray();

        $response = $this->response->withType('application/json');
        $response = $response->withStringBody(json_encode($receivingFaxes));
        
        return $response;
    }
    
}