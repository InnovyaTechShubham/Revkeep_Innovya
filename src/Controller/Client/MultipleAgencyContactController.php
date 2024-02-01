<?php
declare(strict_types=1);

namespace App\Controller\Client;

use App\Controller\AppController;
use App\Model\Table\MultiAgencyContactsTable;

class MultipleAgencyContactController extends AppController
{
    public function index()
    {
        if ($this->request->is('post')) {
            try {
                // Load the MultiAgencyContactsTable using dependency injection
                $MultiAgencyContactsTableobj = new MultiAgencyContactsTable();
                
                // Get data from the request
                $data = $this->request->getData();
                
                

                // Process contacts
                foreach ($data['contacts'] as $contactData) {
                    $multiAgencyContactsTable = $MultiAgencyContactsTableobj->newEmptyEntity();
                    $multiAgencyContactsTable->agency_id = $data['id'];
                    $multiAgencyContactsTable->agency_name = $data['name'];
                   

                    if ($contactData['type'] === 'fax') {
                        $multiAgencyContactsTable->agency_email = "NULL";
                        $multiAgencyContactsTable->desc_email = "NULL ";
                        $multiAgencyContactsTable->agency_fax = $contactData['value'];  // Corrected this line
                        $multiAgencyContactsTable->desc_fax = $contactData['description'];  // Corrected this line
                    } elseif ($contactData['type'] === 'email') {
                        $multiAgencyContactsTable->agency_email = $contactData['value'];
                        $multiAgencyContactsTable->desc_email = $contactData['description'];
                        $multiAgencyContactsTable->agency_fax = null;
                        $multiAgencyContactsTable->desc_fax = null;
                    }
                   
                
                    if (!$MultiAgencyContactsTableobj->save($multiAgencyContactsTable)) {
                        throw new \Exception('Error saving contact data');
                    }
                }
                // Return success message
                return $this->response->withStatus(200)->withStringBody(json_encode(['message' => 'Successfully saved data']));
            } catch (\Exception $e) {
                $responseMessage = ['error' => $e->getMessage()];
                return $this->response->withStatus(500)->withStringBody(json_encode($responseMessage));
            }
        }
    }
}
