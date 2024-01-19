<?php

namespace App\Controller\Client;

use App\Model\Table\IncomingDocumentsTable;
use App\Controller\AppController;
use TCPDF; // Import the TCPDF library 

class PatientParsedInfoController extends AppController
{
    public function index()
    {
        $this->autoRender = false;
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $docName = strtoupper(str_replace(" ", "", $data['fullName']));
            // $admitDate = $data['admit_date']
            // $date = $data['admit_date'];
            $admitDate = str_replace("-", "", $data['admitDate']);

             // Read data from a JSON file
            $jsonFile = '../storage/'.$admitDate.$docName.'.json'; 
            $jsonData = file_get_contents($jsonFile);
             // Check if JSON data was successfully retrieved
             if ($jsonData !== false) {
                 // Set the response type as JSON
                 $this->response = $this->response->withType('application/json');
                 
                 // Set the JSON data as the response body
                 $this->response = $this->response->withStringBody($jsonData);
                // $loc = '../storage/'.$admitDate.$docName.'.json';
                // $this->response = $this->response->withStringBody($loc);
             } else {
                 // Handle error if JSON data couldn't be retrieved
                 $this->response = $this->response->withStatus(500); // Internal Server Error
                 $this->response = $this->response->withStringBody('Error reading JSON file');
             }
             
             return $this->response;

        }
    }
}