<?php

namespace App\Controller\Client;

// use App\Model\Table\ReceivingEmailsTable;
use App\Model\Table\FacilitiesReceivingMethodsTable;
use Cake\ORM\TableRegistry;
use App\Controller\AppController;
use Cake\Network\Exception\MethodNotAllowedException;

class ReceivingEmailsController extends AppController
{
    public function add(){
        $this->request->allowMethod(['post']);
        $data = $this->request->getData();
        if($data['add'] == true){
            $facilitiesTable = TableRegistry::getTableLocator()->get('Facilities');
            $facilitiesName = $data['name'];
            $facility = $facilitiesTable->find()
                ->where(['name' => $facilitiesName])
                ->first(); 
            $facilityId = $facility->get('id');

            
            $facilitiesReceivingMethodsTable = new FacilitiesReceivingMethodsTable();
            foreach ($data['emails'] as $email) {
                try{
                    $entity = $facilitiesReceivingMethodsTable->newEmptyEntity();
                    $entity->facility_id = $facilityId;
                    $entity->receiving_email_id = $email['email'];
                    $entity->email_desc = $email['description'];
                    $entity->created_at = date('m/d/y H:i:s');

                    $facilitiesReceivingMethodsTable->save($entity);
                    
                }
                catch (\Exception $e){
                    $responseMessage = ['error' => $e->getMessage()];
                    
                }
            }
            foreach ($data['faxes'] as $fax) {
                try{
                    $entity = $facilitiesReceivingMethodsTable->newEmptyEntity();
                    $entity->facility_id = $facilityId;
                    $entity->receiving_fax_id = $fax['fax'];
                    $entity->created_at = date('m/d/y H:i:s');
                    $entity->fax_desc = $fax['description'];
                    $facilitiesReceivingMethodsTable->save($entity);
                    
                }
                catch (\Exception $e){
                    $responseMessage = ['error' => $e->getMessage()];
                }
            }
            return $this->response
                ->withType('application/json')
                ->withStringBody(json_encode($responseMessage));
        } 

        if ($data['fetch'] == true) {
            $data = $this->request->getData();
           
            $id = $data['id'];
            try{
                $facilitiesContractsTable = TableRegistry::getTableLocator()->get('facilities_receivingmethods');
                $facilityContract = $facilitiesContractsTable->find()
                    ->where(['facility_id' => $id]);
                    
               
                $response = $this->response->withType('application/json');
                $response = $response->withStringBody(json_encode($facilityContract, JSON_PRETTY_PRINT));
                }
                catch (\Exception $e){
                    $responseMessage = ['error' => $e->getMessage()];
                   
                }
    
                 return $this->response
                ->withType('application/json')
                ->withStringBody(json_encode($facilityContract));
        }

        
        if($data['edit'] == true){
            $data = $this->request->getData();
            
            $id = $data['id'];
            $facilitiesContactsTable = TableRegistry::getTableLocator()->get('facilities_receivingmethods');
            $facilityContact = $facilitiesContactsTable->find()
                    ->where(['facility_id' => $id]);
            
            foreach ($data['emails'] as $email) {
                if (isset($email['id'])) {
                    foreach ($facilityContact as $contact) {
                        if($contact['receiving_fax_id'] == null && $contact['id'] == $email['id']){
                            try{
                                $contact->receiving_email_id = $email['email'];
                                $contact->email_desc = $email['description'];
                                $facilitiesContactsTable->save($contact);
                        }catch (\Exception $e){
                            $responseMessage = ['error' => $e->getMessage()];
                           
                        }
                    }
                }} else {
                    try{
                        $facilitiesReceivingMethodsTable = new FacilitiesReceivingMethodsTable();
                        $entity = $facilitiesReceivingMethodsTable->newEmptyEntity();
                        $entity->facility_id = $id;
                        $entity->receiving_email_id = $email['email'];
                        $entity->email_desc = $email['description'];
                        $entity->created_at = date('m/d/y H:i:s');
                        $facilitiesReceivingMethodsTable->save($entity);
                    }catch (\Exception $e){
                        $responseMessage = ['error' => $e->getMessage()];
                        
                    }
                }
            }
            foreach ($data['faxes'] as $fax) {
                if (isset($fax['id'])) {
                    foreach ($facilityContact as $contact) {
                        if($contact['receiving_email_id'] == null && $contact['id'] == $fax['id']){
                            try{
                                $contact->receiving_fax_id = $fax['fax'];
                                $contact->fax_desc = $fax['description'];
                                $facilitiesContactsTable->save($contact);
                            }catch (\Exception $e){
                                $responseMessage = ['error' => $e->getMessage()];
                                
                            }
                        }
                    }
                }else{
                    try{
                        $facilitiesReceivingMethodsTable = new FacilitiesReceivingMethodsTable();
                        $entity = $facilitiesReceivingMethodsTable->newEmptyEntity();
                        $entity->facility_id = $id;
                        $entity->receiving_fax_id = $fax['fax'];
                        $entity->fax_desc = $fax['description'];
                        $entity->created_at = date('m/d/y H:i:s');
                        $facilitiesReceivingMethodsTable->save($entity);
                    }catch (\Exception $e){
                        $responseMessage = ['error' => $e->getMessage()];
                        
                    }
                }
            }

            

        }
        if($data['delete'] == true){
            $data = $this->request->getData();
            $filePath = 'D:\xampp\htdocs\Insurance_mergerd\final_revkeep\example.json';
                            $jsonContent = json_encode($data, JSON_PRETTY_PRINT);
                            $file = fopen($filePath, 'w');
                            fwrite($file, $jsonContent);
                            fclose($file);
            $id = $data['data'][0]['id'];
            $facilitiesContactsTable = TableRegistry::getTableLocator()->get('facilities_receivingmethods');
            $facilityContact = $facilitiesContactsTable->find()
                    ->where(['id' => $id])
                    ->first();
            $result = $facilitiesContactsTable->delete($facilityContact);
            $filePath = 'D:\xampp\htdocs\Insurance_mergerd\final_revkeep\example4.json';
            $jsonContent = json_encode($result, JSON_PRETTY_PRINT);
            $file = fopen($filePath, 'w');
            fwrite($file, $jsonContent);
            fclose($file);
        }
    }

   
}