<?php


namespace App\Controller\Client;

use App\Controller\AppController;
use Cake\Http\Response;
use App\Model\Table\IncomingDocumentsTable; // Make sure to adjust the namespace

class IncomingController extends AppController
{
    protected $IncomingDocuments;

    public function initialize(): void
    {
        parent::initialize();
        $this->IncomingDocuments = new IncomingDocumentsTable();
    }

    public function index()
    {
        // // Query all the information from the case_requests table
        // $IncomingDocuments = $this->IncomingDocuments->find()->toArray();
        
        // // Create a response object with JSON data
        // $response = $this->response->withType('application/json');
        // $response = $response->withStringBody(json_encode($IncomingDocuments));
        
        // return $response;

        return $this->redirect('/');
    }
}







