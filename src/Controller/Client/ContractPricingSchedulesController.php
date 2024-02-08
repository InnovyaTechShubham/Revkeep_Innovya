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
        $this->contractPricingSchedulesTable = new ContractPricingSchedulesTable();
    }

    public function index()
    {
        $pricingSchedules = $this->contractPricingSchedulesTable->find()->toArray();

        $response = $this->response->withType('application/json');
        $response = $response->withStringBody(json_encode($pricingSchedules));
        
        return $response;

    }

    public function add()
    {
        if ($this->request->is('post')) {
            $requestData = $this->request->getData();

            // Assuming 'insurance_type_id' and 'contract_rate' are present in the form data
            $newSchedule = $this->contractPricingSchedulesTable->newEmptyEntity();
            $newSchedule = $this->contractPricingSchedulesTable->patchEntity($newSchedule, $requestData);

            if ($this->contractPricingSchedulesTable->save($newSchedule)) {
                $this->setJsonResponse(['success' => true, 'message' => 'Contract Pricing Schedule added successfully.']);
            } else {
                $this->setJsonResponse(['success' => false, 'message' => 'Failed to add Contract Pricing Schedule.']);
            }
        } else {
            throw new MethodNotAllowedException('POST method required');
        }
    }

   
}
