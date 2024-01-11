<?php

namespace App\Controller\Client;
use App\Model\Table\HearingDetailsTable;
use App\Controller\AppController;
use Cake\Http\Exception\MethodNotAllowedException;
use Cake\ORM\TableRegistry;


class HearingCaseController extends AppController
{
    public function index()
    {
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $filePath = 'D:\xampp\htdocs\Insurance_mergerd\final_revkeep\example.json';
            $jsonContent = json_encode($data, JSON_PRETTY_PRINT);
            $file = fopen($filePath, 'w');
            fwrite($file, $jsonContent);
            fclose($file);
            // $facilitiesTable = new HearingDetailsTable();
            $hearingDetailsTable =  new HearingDetailsTable();
            // $facilitiesTable = TableRegistry::getTableLocator()->get('Facilities');
            
            try{
                $hearingDetailsEntity = $hearingDetailsTable->newEmptyEntity();
                $hearingDetailsEntity->appealLevelId = $data['appealLevelId'];
                $hearingDetailsEntity->hearingDate = $data['hearingDate'];
                $hearingDetailsEntity->hearingTime = $data['hearingTime'];
                $hearingDetailsEntity->meetingType = $data['meetingType'];
                $hearingDetailsTable->save($hearingDetailsEntity);
                $responseMessage = ['message' => 'Saved Successfully']; // Customize the response message as needed
            }
        catch (\Exception $e){
            $responseMessage = ['error' => $e->getMessage()];
            return $this->response
                        ->withType('application/json')
                        ->withStringBody(json_encode($responseMessage));
        }
            return $this->response->withType('application/json')
                            ->withStringBody(json_encode($responseMessage));
        }
    }
}