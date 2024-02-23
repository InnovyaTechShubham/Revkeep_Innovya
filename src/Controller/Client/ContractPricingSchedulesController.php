<?php

namespace App\Controller\Client;

use App\Controller\AppController;
use App\Model\Table\ContractPricingSchedulesTable;
use Cake\Network\Exception\MethodNotAllowedException;
use Cake\ORM\TableRegistry;

class ContractPricingSchedulesController extends AppController
{
   /**
	 * Add method
	 *
	 * @return void
	 * @throws \Cake\ORM\Exception\PersistenceFailedException
	 */
    public function add()
    {
        $this->request->allowMethod(['post']);
        $data = $this->request->getData();
        $facilitiesTable = TableRegistry::getTableLocator()->get('Facilities');
        $facilitiesName = $data['name'];
        $facility = $facilitiesTable->find()
        ->where(['name' => $facilitiesName])
        ->first(); 
        // Extract the 'id' column value and store it in a variable
        $facilityId = $facility->get('id');
        $contractPricingSchedulesTable = new ContractPricingSchedulesTable();
        try{
            $insuraceTypeId = 0;
            foreach ($data['first'] as $rate) {
                $insuraceTypeId =$insuraceTypeId+1;
                $entity = $contractPricingSchedulesTable->newEmptyEntity();
                $entity->insurance_type_id =  $insuraceTypeId;
                $entity->contract_rate = $rate;
                $entity->facility_id = $facilityId;
                $contractPricingSchedulesTable->save($entity);
            }
            foreach ($data['second'] as $rate) {
                $insuraceTypeId =$insuraceTypeId+1;
                $entity = $contractPricingSchedulesTable->newEmptyEntity();
                $entity->insurance_type_id = $insuraceTypeId;
                $entity->contract_rate = $rate;
                $entity->facility_id = $facilityId;
                $contractPricingSchedulesTable->save($entity);
            }
            $responseMessage = ['message' => 'pricing scheduled working'];
        }
        catch (\Exception $e){
            $responseMessage = ['error' => $e->getMessage()];
        }

        return $this->response
        ->withType('application/json')
        ->withStringBody(json_encode($responseMessage));
    }

    public function edit(){
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $id = $data['id'];
            
            
            try{
                $contractPricingScheduleTable = TableRegistry::getTableLocator()->get('contract_pricing_schedules');
                $facilityContract = $contractPricingScheduleTable->find()
                    ->where(['facility_id' => $id]);
                
                foreach ($data['first'] as $key => $value) {
                    foreach($facilityContract as $row) {
                        if($row['insurance_type_id']==(int)$key){
                            $row['contract_rate'] = $value;
                            $contractPricingScheduleTable->save($row);
                            break;
                        }
                    }
                }
                foreach ($data['second'] as $key => $value) {
                    foreach($facilityContract as $row) {
                        if($row['insurance_type_id']==(int)$key+6){
                            $row['contract_rate'] = $value;
                            $contractPricingScheduleTable->save($row);
                            break;
                        }
                    }
                }
            }
            catch (\Exception $e){
                $responseMessage = ['error' => $e->getMessage()];
                
            }
            return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($responseMessage));
            
        }
    }

    public function list(){
        if ($this->request->is('post')){
            $data = $this->request->getData();
            $id = $data['id'];
            $contractPricingScheduleTable = TableRegistry::getTableLocator()->get('contract_pricing_schedules');
            $facilityContract = $contractPricingScheduleTable->find()
                ->where(['facility_id' => $id]);
            return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($facilityContract));
        }
    }

    

}

   

