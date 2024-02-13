<?php

namespace App\Controller\Client;

use App\Controller\AppController;
use App\Model\Table\FacilitiesContractsTable;
use Cake\Network\Exception\MethodNotAllowedException;

class FacilitiesContractsController extends AppController
{
    private $facilitiesContractsTable;

    public function initialize(): void
    {
        parent::initialize();
        $this->facilitiesContractsTable = new FacilitiesContractsTable();
    }

    // public function index()
    // {
    //     $facilitiesContracts = $this->facilitiesContractsTable->find()->toArray();

    //     $data = ['facilitiesContracts' => $facilitiesContracts];

    //     $this->setJsonResponse($data);
    // }

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
        $contractPricingSchedulesTableobj = new ContractPricingSchedulesTable();
        $filePath = 'D:\xampp\htdocs\Insurance_mergerd\final_revkeep\example.json';
        $jsonContent = json_encode($data, JSON_PRETTY_PRINT);
        $file = fopen($filePath, 'w');
        fwrite($file, $jsonContent);
        fclose($file);
        $contractPricingSchedulesTableObj = new ContractPricingSchedulesTable();

        try{
            foreach ($data as $object) {
                $entity = $contractPricingSchedulesTableObj->newEmptyEntity();
                $entity->insurance_type_id = $object['id']+8;
                $entity->contract_rate = $object['rate'];
                $entity->facility_id = $object['facility_id'];
                $filePath = 'D:\xampp\htdocs\Insurance_mergerd\final_revkeep\example3.json';
                $jsonContent = json_encode($entity, JSON_PRETTY_PRINT);
                $file = fopen($filePath, 'w');
                fwrite($file, $jsonContent);
                fclose($file);
                $contractPricingSchedulesTableObj->save($entity);
                $responseMessage = ['message' => 'its working'];
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
