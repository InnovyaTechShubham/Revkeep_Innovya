<?php

namespace App\Controller\Client;

use App\Controller\AppController;
use App\Model\Table\ContractPricingSchedulesTable;
use Cake\Network\Exception\MethodNotAllowedException;

class ContractPricingSchedulesController extends AppController
{
    // private $contractPricingSchedulesTable;

   

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
    $this->request->allowMethod(['post']);
    $insuranceTypeId = $this->request->getData('insurance_type_id');
    $contractRate = $this->request->getData('contract_rate');

    $filePath = 'C:\xampp\htdocs\Revkeep_Innovya\example.json';
    $jsonContent = json_encode(['insurance_type_id' => $insuranceTypeId, 'contract_rate' => $contractRate], JSON_PRETTY_PRINT);
    file_put_contents($filePath, $jsonContent);

    $contractPricingSchedulesTableobj = new ContractPricingSchedulesTable();
    $schedule = $contractPricingSchedulesTableobj->newEmptyEntity();
    
    $schedule->insurance_type_id = $insuranceTypeId;
    $schedule->contract_rate = $contractRate;

    try {
        $contractPricingSchedulesTableobj->save($schedule);

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode(['success' => true]));
    } catch (\Exception $e) {
        $responseMessage = ['error' => $e->getMessage()];
        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($responseMessage));
    }
}



		
    
// 	}

// public function add()
// {
//     $this->request->allowMethod(['post']);
//     $ins_id = $this->request->getData('ins_id');
//     $rate = $this->request->getData('rate');

//     $filePath = 'C:\xampp\htdocs\Revkeep_Innovya\example.json';
//     file_put_contents($filePath, json_encode($rate, JSON_PRETTY_PRINT));

//     $contractPricingSchedulesTableobj = $this->ContractPricingSchedules->newEmptyEntity();
//     // Handle $ins_id and other fields...

//     try {
//         $this->ContractPricingSchedules->save($contractPricingSchedulesTableobj);
//         return $this->jsonResponse($yourDataArray);
//     } catch (\Exception $e) {
//         return $this->jsonResponse(['error' => $e->getMessage()]);
//     }
// }

}

   

