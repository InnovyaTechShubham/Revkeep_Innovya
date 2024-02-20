<?php

namespace App\Controller\Client;

use App\Controller\AppController;
use App\Model\Table\FacilitiesContractsTable;
use App\Model\Table\ContractBillTypesTable;
use App\Model\Table\ContractTypesTable;
use App\Model\Table\ContractServiceOperationsTable;
use App\Model\Table\ContractOwnershipTypesTable;
use App\Model\Entity\FacilityContact;
use Cake\ORM\TableRegistry;


use Cake\Network\Exception\MethodNotAllowedException;

class FacilitiesContractsController extends AppController
{
    private $facilitiesContractsTable;
    private $contractBillTypesTable;
    private $contractTypesTable;
    private $contractServiceOperationsTable;
    private $contractOwnershipTypesTable;

    public function initialize(): void
    {
        parent::initialize();
        $this->facilitiesContractsTable = new FacilitiesContractsTable();
        $this->contractBillTypesTable = new ContractBillTypesTable();
        $this->contractTypesTable = new ContractTypesTable();
        $this->contractServiceOperationsTable = new ContractServiceOperationsTable();
        $this->contractOwnershipTypesTable = new ContractOwnershipTypesTable();
    }

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
        $contractBillTypes = $this->contractBillTypesTable->find()->toArray();
        $contractTypes = $this->contractTypesTable->find()->toArray();
        $contractServiceOprations = $this->contractServiceOperationsTable->find()->toArray();
        $contractOwnershipTypes = $this->contractOwnershipTypesTable->find()->toArray();
        $contractBillTypesId = 0;
        $contractTypesId = 0;
        $serviceOperationId =0;
        $contractOwnershipTypesId=0;
        foreach ($contractBillTypes as $billType) {
            if($billType['bill_type'] == $data['data']['contract_bill_type']) {
                $contractBillTypesId = $billType['id'];
            }
        }
        foreach ($contractTypes as $conType) {
            if($conType['contract_type'] == $data['data']['contract_type']) {
                $contractTypesId = $conType['id'];
            }
        }
        foreach ($contractServiceOprations as $seriveType) {
            if($seriveType['operation'] == $data['data']['serviceOperation']) {
                $serviceOperationId = $seriveType['id'];
            }
        }
        foreach ($contractOwnershipTypes as $contOwnType) {
            if($contOwnType['ownership_type'] == $data['data']['ownership_type']) {
                $contractOwnershipTypesId = $contOwnType['id'];
            }
        }

        $facilitiesName = (string)$data['name'];
        // Adding a delay of 2 seconds so that new facility is added in database & it's id is available for this method to execute
        sleep(2);
        $facility = $facilitiesTable->find()
            ->where(['name' => $facilitiesName])
            ->first(); 
    
        
            // Extract the 'id' column value and store it in a variable
        $facilityId = $facility->get('id');
        

        $facilitiesContractsTable = new FacilitiesContractsTable();
        
        try{
            
                $entity = $facilitiesContractsTable->newEmptyEntity();
                $entity->facility_id = $facilityId;
                $entity->original_start_date = $data['data']['original_start_date'];
                $entity->term_date = $data['data']['term_date'];
                $entity->status = $data['data']['contract_status'];
                $entity->expiration_date = $data['data']['contract_end_date'];
                $entity->contract_effective_date = $data['data']['contract_start_date'];
                $entity->renewal_date = $data['data']['renewal_date'];
                $entity->contract_bill_type_id = $contractBillTypesId;
                $entity->contract_type_id = $contractTypesId;
                $entity->indemnification_days = $data['data']['indemnification_days'];
                $entity->max_return_days = $data['data']['max_return_work_days'];
                $entity->service_operation_id = $serviceOperationId;
                $entity->ownership_type_id = $contractOwnershipTypesId;
                


   				
                $facilitiesContractsTable->save($entity);
                $responseMessage = ['message' => 'its working'];
            
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
                $contractBillTypes = $this->contractBillTypesTable->find()->toArray();
                $contractTypes = $this->contractTypesTable->find()->toArray();
                $contractServiceOprations = $this->contractServiceOperationsTable->find()->toArray();
                $contractOwnershipTypes = $this->contractOwnershipTypesTable->find()->toArray();
            }
            catch (\Exception $e){
                $responseMessage = ['error' => $e->getMessage()];
                
            }
            $contractBillTypesId = 0;
            $contractTypesId = 0;
            $serviceOperationId =0;
            $contractOwnershipTypesId=0;
            foreach ($contractBillTypes as $billType) {
                if($billType['bill_type'] == $data['data']['contract_bill_type']) {
                    $contractBillTypesId = $billType['id'];
                }
            }
            foreach ($contractTypes as $conType) {
                if($conType['contract_type'] == $data['data']['contract_type']) {
                    $contractTypesId = $conType['id'];
                }
            }
            foreach ($contractServiceOprations as $seriveType) {
                if($seriveType['operation'] == $data['data']['serviceOperation']) {
                    $serviceOperationId = $seriveType['id'];
                }
            }
            foreach ($contractOwnershipTypes as $contOwnType) {
                if($contOwnType['ownership_type'] == $data['data']['ownership_type']) {
                    $contractOwnershipTypesId = $contOwnType['id'];
                }
            }
            try{
                // Load the FacilitiesContractsTable
                $facilitiesContractsTable = TableRegistry::getTableLocator()->get('facilities_contracts');

                // Query to find the row with 'facility_id' = $id
                $facilityContract = $facilitiesContractsTable->find()
                    ->where(['facility_id' => $id])
                    ->first();
                   

                $facilityContract->original_start_date = $data['data']['original_start_date'];
                $facilityContract->term_date = $data['data']['term_date'];
                $facilityContract->status = $data['data']['contract_status'];
                $facilityContract->status = $data['data']['contract_status'];
                $facilityContract->expiration_date = $data['data']['contract_end_date'];
                $facilityContract->contract_effective_date = $data['data']['contract_start_date'];
                $facilityContract->renewal_date = $data['data']['renewal_date'];
                $facilityContract->contract_bill_type_id = $contractBillTypesId;
                $facilityContract->contract_type_id = $contractTypesId;
                $facilityContract->indemnification_days = $data['data']['indemnification_days'];
                $facilityContract->max_return_days = $data['data']['max_return_work_days'];
                $facilityContract->service_operation_id = $serviceOperationId;
                $facilityContract->ownership_type_id = $contractOwnershipTypesId;
                
                $facilitiesContractsTable->save($facilityContract);
                $responseMessage = ['message' => 'edit functionality working'];
                $facilitiesContractsTable->save($facilityContract);
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
            // $filePath = 'D:\xampp\htdocs\Insurance_mergerd\final_revkeep\example4.json';
            // $jsonContent = json_encode($data, JSON_PRETTY_PRINT);
            //             $file = fopen($filePath, 'w');
            //             fwrite($file, $jsonContent);
            //             fclose($file);
            try{
            $facilitiesContractsTable = TableRegistry::getTableLocator()->get('facilities_contracts');
            $facilityContract = $facilitiesContractsTable->find()
                ->where(['facility_id' => $id])
                ->first();
            // $filePath = 'D:\xampp\htdocs\Insurance_mergerd\final_revkeep\example4.json';
            // $jsonContent = json_encode($facilityContract, JSON_PRETTY_PRINT);
            // $file = fopen($filePath, 'w');
            // fwrite($file, $jsonContent);
            // fclose($file);
            $response = $this->response->withType('application/json');
            $response = $response->withStringBody(json_encode($facilityContract, JSON_PRETTY_PRINT));
            }
            catch (\Exception $e){
                $responseMessage = ['error' => $e->getMessage()];
                // $filePath = 'D:\xampp\htdocs\Insurance_mergerd\final_revkeep\example4.json';
                // $jsonContent = json_encode($e, JSON_PRETTY_PRINT);
                // $file = fopen($filePath, 'w');
                // fwrite($file, $jsonContent);
                // fclose($file);
            }

             return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($facilityContract));
        }
    }

}
