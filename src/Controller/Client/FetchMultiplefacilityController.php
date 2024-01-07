<?php 
// namespace App\Controller\Client;
// use App\Controller\AppController;
// use App\Model\Table\ClientemployeesFacilityTable;
// use Cake\Log\Log;

// class MultiplefacilityController extends AppController
// {
//     public function index($id)
//     {
//         $this->autoRender = false; // Disable view rendering for JSON response
//         $this->response = $this->response->withType('application/json');
    
//         try {
//             $clientemployeesFacilityTable = new ClientemployeesFacilityTable();
//             $facilities = $clientemployeesFacilityTable
//                 ->find()
//                 ->select(['facility_id']) // Select only the facility_id field
//                 ->where(['client_id' => $id])
//                 ->toArray();
    
//             $facilityIds = [];
//             foreach ($facilities as $facility) {
//                 $facilityIds[] = $facility->facility_id;
//             }
    
//             return $this->response->withStringBody(json_encode(['facilityIds' => $facilityIds]));
//         } catch (\Exception $e) {
//             Log::error('Exception: ' . $e->getMessage());
//             return $this->response->withStatus(500)->withStringBody(json_encode(['message' => 'Failed to fetch facilities']));
//         }
//     }
// }

namespace App\Controller\Client;

use App\Controller\AppController;
use App\Model\Table\ClientemployeesFacilityTable;
use Cake\Log\Log;

class MultiplefacilityController extends AppController
{
    public function index()
    {
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $clientId= $data['data'];
            $clientemployeesFacilityTable = new ClientemployeesFacilityTable();
        try {
            $facilities = $this->clientemployeesFacilityTable
                ->find()
                ->select(['facility_id'])
                ->where(['client_id' => $clientId])
                ->toArray();

            $facilityIds = array_column($facilities, 'facility_id');

           // return $this->response->withStringBody(json_encode(['facilityIds' => $facilityIds]));
           return $this->response->withStatus(200)->withStringBody(json_encode(['message' => 'Random']));
        } catch (\Exception $e) {
            Log::error('Exception: ' . $e->getMessage());
            return $this->response->withStatus(500)->withStringBody(json_encode(['message' => 'Failed to fetch facilities']));
        }
    }
}
}
