<?php

namespace App\Controller\Client;

use App\Model\Table\FacilityContactsTable;
use App\Model\Table\FacilitiesTable;
use App\Controller\AppController;
use App\Model\Entity\FacilityContact;
use Cake\Http\Exception\MethodNotAllowedException;
use Cake\ORM\TableRegistry;


class FacilityAddFormController extends AppController
{
    public function index()
    {
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $facilityContactTable = new FacilityContactsTable();
            $facilitiesTable = TableRegistry::getTableLocator()->get('Facilities');
            
            
            try{
                $facilitiesName = (string)$data[0]['facility_name'];
                $facility = $facilitiesTable->find()
                    ->where(['name' => $facilitiesName])
                    ->first(); 
            
                
                    // Extract the 'id' column value and store it in a variable
                    $facilityId = $facility->get('id');
                
                foreach ($data as $object) {
                    $facilityContactEntity = $facilityContactTable->newEmptyEntity();
                    // Accessing elements of each object
                    $firstName = (string)$object['f_name'];
                    $lastName = (string)$object['l_name'];
                    $titleId = (string)$object['title_id']; // This will be null
                    $contactId = (string)$object['contact_id']; // This will be null
                    $phoneNo = (string)$object['phone_no'];
                    $email = (string)$object['email'];
                                                        
                    // Create a new entity and populate it with the extracted data
                    // $entity = new FacilityContact(); // Replace YourEntity with your actual entity name
                    $facilityContactEntity->first_name = $firstName;
                    $facilityContactEntity->last_name = $lastName;
                    $facilityContactEntity->title_id = $titleId;
                    $facilityContactEntity->contact_id = $contactId;
                    $facilityContactEntity->phone = $phoneNo;
                    $facilityContactEntity->email = $email;
                    $facilityContactEntity->facility_id = $facilityId;
                    // $entity->id = 1;
                    $facilityContactTable->save($facilityContactEntity);

                    $responseMessage = ['message' => $facilitiesName]; // Customize the response message as needed
                    
                }
            }
        catch (\Exception $e){
            $responseMessage = ['error' => $e->getMessage()];
            return $this->response
                        ->withType('application/json')
                        ->withStringBody(json_encode($responseMessage));
        }
            return $this->response->withType('application/json')
                            ->withStringBody(json_encode($responseMessage));
        }
    }

    public function edit() {
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            // $filePath = 'D:\xampp\htdocs\Insurance_mergerd\final_revkeep\example.json';
            // $id = $data[0]['id'];
            // $jsonContent = json_encode($data, JSON_PRETTY_PRINT);
            // $file = fopen($filePath, 'w');
            // fwrite($file, $jsonContent);
            // fclose($file);
            try{
                foreach ($data as $object) {
                    $id = $object['id'];            
                    if ($id == null) {
                        $facilitiesTable = TableRegistry::getTableLocator()->get('Facilities');
                        $facilitiesName = $object['facility_name'];
                        // $jsonContent = json_encode($facilitiesName, JSON_PRETTY_PRINT);
                        // $file = fopen($filePath, 'w');
                        // fwrite($file, $jsonContent);
                        // fclose($file);
                        $facility = $facilitiesTable->find()
                        ->where(['name' => $facilitiesName])
                        ->first(); 
                        // Extract the 'id' column value and store it in a variable
                        $facilityId = $facility->get('id');
                        $facilityContactTable = new FacilityContactsTable();
                        $facilityContactEntity = $facilityContactTable->newEmptyEntity();
                        // Accessing elements of each object
                        $firstName = (string)$object['first_name'];
                        $lastName = (string)$object['last_name'];
                        $titleId = (string)$object['title_id']; // This will be null
                        $contactId = (string)$object['contact_id']; // This will be null
                        $phoneNo = (string)$object['phone'];
                        $email = (string)$object['email'];
    
                        $facilityContactEntity->first_name = $firstName;
                        $facilityContactEntity->last_name = $lastName;
                        $facilityContactEntity->title_id = $titleId;
                        $facilityContactEntity->contact_id = $contactId;
                        $facilityContactEntity->phone = $phoneNo;
                        $facilityContactEntity->email = $email;
                        $facilityContactEntity->facility_id = $facilityId;
                        $facilityContactTable->save($facilityContactEntity);
                    }    
                    else{
                        $facilityContactTable = TableRegistry::getTableLocator()->get('FacilityContacts');
                        $facilityContact = $facilityContactTable->get($id);
                        $facilityContact->first_name =$object['first_name']; 
                        $facilityContact->last_name = $object['last_name']; ;
                        $facilityContact->title_id = $object['title_id']; 
                        $facilityContact->contact_id = $object['contact_id']; 
                        $facilityContact->phone = $object['phone']; 
                        $facilityContact->email =$object['email']; 
                        $facilityContact->facility_id = $object['facility_id'];
                        $facilityContactTable->save($facilityContact);
                    }
                }
                $responseMessage = ['message' => $facilitiesName]; // Customize the response message as needed
                return $this->response->withType('application/json')
                                ->withStringBody(json_encode($responseMessage));
            }
            catch (\Exception $e){
                $responseMessage = ['error' => $e->getMessage()];
            }
        }
    }
}