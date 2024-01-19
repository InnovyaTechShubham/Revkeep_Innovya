<?php

namespace App\Controller\Client;

use App\Model\Table\ReceivingEmailsTable;
use App\Controller\AppController;
use Cake\Network\Exception\MethodNotAllowedException;

class ReceivingEmailsController extends AppController
{
    // public function index()
    // {
    //     $this->autoRender = false; 
    //     $receivingEmail = new ReceivingEmailsTable();
    //     if ($this->request->is('post')) {
    //      $email = $this->request->getData('email');
    //      $description = $this->request->getData('description');
    //      $new = $receivingEmail->newEntity([

    //         'email' => $email,
    //         'description' => $description
    //     ]);
    //     if ($receivingEmail->save($new)) {
    //         $response = [

    //             'success' => 'true',

    //             'message' => 'Document entry saved.',

    //         ];

    //     }

    // }
    
    // }
    public function index()
    {
        $this->autoRender = false;
        $receivingEmail = new ReceivingEmailsTable();
        // $chainOrganizationsTable = $ChainOrganizationsTable->newEmptyEntity();
        // $chainOrganizationsTable = $this->ChainsOrganizations;
        // $chainOrganizationsTable = new ChainOrganizationsTable();
 
        if ($this->request->is('post')) {
            $email = $this->request->getData('email');
            $description = $this->request->getData('description');
             // Check if email already exists
            $existingEmail = $receivingEmail->exists(['email' => $email]);
            // if chain_name is empty
            // if (empty($email) || empty( $description)) {
            //     // Handle the case where $chain_name is undefined, null, or empty
            //     $response = [
            //         'success' => false,
            //         'message' => 'Chain name and Chain Type is required.',
            //     ];
           
                // Send the JSON response back to the client
                // echo json_encode($response);
                // Optionally, you can use "die();" to terminate further script execution
                // die();
            }
            if ($existingEmail) {
                // Handle the case where the chain_name already exists
                $response = [
                    'success' => false,
                    'message' => 'Email Already exists.',
                ];
                // Send the JSON response back to the client
                echo json_encode($response);
                // Optionally, you can use "die();" to terminate further script execution
                die();
            }else{
                // $chain_name = $this->request->getData('chain_name');
                // $chain_type = $this->request->getData('chain_type');
               
 
                //  get facility and services data
                // $facilityArray = $this->request->getData('Facility_data');
                // $serviceArray = $this->request->getData('Service_data');
 
 
                $new = $receivingEmail->newEntity([
                   
                    'email' => $email,
                    'description' => $description
                ]);
           
                if ($receivingEmail->save($new)) {
                    $receivingEmail = $new->id;
 
                   
                } else {
                    $response = [
                        'success' => false,
                        'message' => 'Error saving data in Chains table.',
                    ];
                    // Send the JSON response back to the client
                    echo json_encode($response);
                    // Optionally, you can use "die();" to terminate further script execution
                    die();
                }
            }
           
        }
    
}
