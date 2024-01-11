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
            $filePath = 'D:\xampp\htdocs\Insurance_mergerd\final_revkeep\example.json';
            $jsonContent = json_encode($data, JSON_PRETTY_PRINT);
            $file = fopen($filePath, 'w');
            fwrite($file, $jsonContent);
            fclose($file);
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
}