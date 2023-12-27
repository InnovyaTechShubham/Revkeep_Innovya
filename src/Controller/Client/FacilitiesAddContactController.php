<?php
declare(strict_types=1);

namespace App\Controller\Client;

use App\Model\Table\FacilityAddContactsTable;
use App\Controller\AppController;
use Cake\Http\Response;

/**
 * FacilitiesAddContact Controller
 *
 * @method \App\Model\Entity\FacilitiesAddContact[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FacilitiesAddContactController extends AppController
{
    protected $CaseRequests;

    public function initialize(): void
    {
        parent::initialize();
        $this->Agency = new FacilityAddContactsTable();
    }

    public function index()
    {
        // Query all the information from the case_requests table
        $Agency = $this->Agency->find()->toArray();


        // Create a response object with JSON data
        $response = $this->response->withType('application/json');
        $response = $response->withStringBody(json_encode($Agency));

        return $response;
    } 
    }

        
        
