<?php
declare(strict_types=1);

namespace App\Controller\Client;

use Cake\Http\Exception\NotFoundException;
use App\Controller\AppController;
use App\Model\Table\PowerbackDenialReasonsTable;
use Cake\ORM\TableRegistry;

/**
 * PowerbackDenialReasons Controller
 *
 * @method \App\Model\Entity\PowerbackDenialReason[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 * @property \App\Model\Table\PowerbackDenialReasonsTable $PowerbackDenialReasons
 */
class PowerbackDenialReasonsController extends AppController
{
    // public function initialize(): void
    // {
    //     parent::initialize();
    //     $this->loadModel('PowerbackDenialReasons');
    // }

    public function getAllRecord()
    {
        $this->autoRender = false;

        // Get the PowerbackDenialReasonsTable instance
        $PowerbackDenialReasonsTable = $this->getTableLocator()->get('PowerbackDenialReasons');

        // Retrieve all records from the "powerback_denial_reasons" table
        $records = $PowerbackDenialReasonsTable->find('all')->toArray();

        // Check if there are any records
        if (!empty($records)) {
            // // Convert records to JSON
            $jsonRecords = json_encode($records, JSON_PRETTY_PRINT);

            // Write JSON data to a file
            $filePath = WWW_ROOT . 'json/powerback_denial_reasons.json';
            file_put_contents($filePath, $jsonRecords);

            // Return JSON response
            // $this->response = $this->response->withType('application/json')
            //                                 ->withStringBody(json_encode(['data' => 'Reason1']));
            $this->response = $this->response->withType('application/json')
                                            ->withStringBody(json_encode($records));

            return $this->response;
        } else {
            // Handle case when there are no records
            $this->response = $this->response->withType('application/json')
                                            ->withStringBody(json_encode(['error' => 'No records found']));
        }

        return $this->response;
    }


}
