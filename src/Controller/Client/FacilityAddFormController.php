<?php

namespace App\Controller\Client;

use App\Model\Table\FacilityContactsTable;
use App\Controller\AppController;
use App\Model\Entity\FacilityContact;
use Cake\Http\Exception\MethodNotAllowedException;


class FacilityAddFormController extends AppController
{
    public function index()
    {
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            
            $facilityContactTable = new FacilityContactsTable();
            $facilityContactEntity = $facilityContactTable->newEmptyEntity();

            foreach ($data as $object) {
                // Accessing elements of each object
                $firstName = (string)$object['f_name'];
                $lastName = (string)$object['l_name'];
                $titleId = (string)$object['title_id']; // This will be null
                $contactId = (string)$object['contact_id']; // This will be null
                $phoneNo = (string)$object['phone_no'];
                $email = (string)$object['email'];
                									
                // Create a new entity and populate it with the extracted data
                $entity = new FacilityContact(); // Replace YourEntity with your actual entity name
                $facilityContactEntity->first_name = $firstName;
                $facilityContactEntity->last_name = $lastName;
                $facilityContactEntity->title_id = $titleId;
                $facilityContactEntity->contact_id = $contactId;
                $facilityContactEntity->phone = $phoneNo;
                $facilityContactEntity->email = $email;
                // $entity->id = 1;
                $facilityContactTable->save($facilityContactEntity);

                $responseMessage = ['message' => 'Entities created successfully']; // Customize the response message as needed
                return $this->response->withType('application/json')
                            ->withStringBody(json_encode($responseMessage));

            }
        }
    }
}