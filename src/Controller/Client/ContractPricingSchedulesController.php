<?php

namespace App\Controller\Client;

use App\Controller\AppController;
use App\Model\Table\ContractPricingSchedulesTable;
use Cake\Network\Exception\MethodNotAllowedException;

class ContractPricingSchedulesController extends AppController
{
    private $contractPricingSchedulesTable;

    public function initialize(): void
    {
        parent::initialize();
        // $this->contractPricingSchedulesTable = new ContractPricingSchedulesTable();
    }

    // public function index()
    // {
    //     $pricingSchedules = $this->contractPricingSchedulesTable->find()->toArray();

    //     $response = $this->response->withType('application/json');
    //     $response = $response->withStringBody(json_encode($pricingSchedules));
        
    //     return $response;

    // }

   /**
	 * Add method
	 *
	 * @return void
	 * @throws \Cake\ORM\Exception\PersistenceFailedException
	 */
	public function add()
	{
		// $entity = $this->contractPricingSchedulesTable->newEntity($this->getRequest()->getData());
		// $entity->set('insurance_type_id', $this->getRequest()->getParam('insurance_type_id'));
        $this->request->allowMethod(['post']);

        $data = $this->request->getData();
        // $facility_id = $this->request->getData('facility_id');
        // $rate = $this->request->getData('rate');
        
        

        $contractPricingSchedulesTableobj = new ContractPricingSchedulesTable();
        // Create a new entity and save it
        // $entity = $contractPricingSchedulesTable->newEmptyEntity();
        // $entity->ins_id = $ins_id;
        // $entity->facility_id = $facility_id;
        // $entity->rate = $rate;

        $filePath = 'C:\xampp\htdocs\Revkeep_Innovya\example.json';
        $jsonContent = json_encode($data, JSON_PRETTY_PRINT);
        $file = fopen($filePath, 'w');
        fwrite($file, $jsonContent);
        fclose($file);

		try {
            // $filePath = 'C:\xampp\htdocs\Revkeep_Innovya\example.json';
            //     $jsonContent = json_encode($data, JSON_PRETTY_PRINT);
            //     $file = fopen($filePath, 'w');
            //     fwrite($file, $jsonContent);
            //     fclose($file);
			foreach ($data as $object) {
                // $facilityContactEntity = $facilityContactTable->newEmptyEntity();
                
		        $entity =$contractPricingSchedulesTableobj->newEmptyEntity();
                
                $ins_id = (string)$object['id'];
                $facility_id = (string)$object['facility_id'];
                $rate = (string)$object['rate'];                             
                // Create a new entity and populate it with the extracted data
                // $entity = new FacilityContact(); // Replace YourEntity with your actual entity name
                $entity->ins_id = $ins_id;
                $entity->facility_id = $facility_id;
                $entity->rate = $rate;
                // $facilityContactEntity->contact_id = $contactId;
                // $facilityContactEntity->phone = $phoneNo;
                // $facilityContactEntity->email = $email;
                // $facilityContactEntity->facility_id = $facilityId;
                // $entity->id = 1;
                // $filePath = 'C:\xampp\htdocs\Revkeep_Innovya\example1.json';
                // $jsonContent = json_encode($entity, JSON_PRETTY_PRINT);
                // $file = fopen($filePath, 'w');
                // fwrite($file, $jsonContent);
                // fclose($file);
                $contractPricingSchedulesTable->save($entity);
                

                $responseMessage = ['message' => $entity]; // Customize the response message as needed
                return $this->response
                        ->withType('application/json')
                        ->withStringBody(json_encode($responseMessage));
                
			
		} 
        catch (\Exception $e){
            $responseMessage = ['error' => $e->getMessage()];
            $filePath = 'C:\xampp\htdocs\Revkeep_Innovya\example1.json';
                $jsonContent = json_encode($e, JSON_PRETTY_PRINT);
                $file = fopen($filePath, 'w');
                fwrite($file, $jsonContent);
                fclose($file);
            return $this->response
                        ->withType('application/json')
                        ->withStringBody(json_encode($responseMessage));
        }
    
	}

   
}
