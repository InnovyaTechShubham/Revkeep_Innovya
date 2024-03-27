<?php


namespace App\Controller\Client;

use App\Controller\AppController;
use Cake\Http\Response;
use App\Model\Table\CaseRequestsTable; // Make sure to adjust the namespace

class RequestController extends AppController
{
    protected $CaseRequests;

    public function initialize(): void
    {
        parent::initialize();
        $this->CaseRequests = new CaseRequestsTable();
    }

    public function index()
    {
        // Query all the information from the case_requests table
        $caseRequests = $this->CaseRequests->find()->toArray();
        
        // Create a response object with JSON data
        $response = $this->response->withType('application/json');
        $response = $response->withStringBody(json_encode($caseRequests));
        
        return $response;
    }

    
	// update response recieved status for request using id
	public function updateResponseReceived()
    {
        $this->request->allowMethod('post');
        $requestData = $this->request->getData();

        try {
            // Extract the ID from the request data
            $id = $requestData['id'];
            $filePath = WWW_ROOT . 'json/powerback_denial_reasons.json';
            $jsonContent = json_encode($id, JSON_PRETTY_PRINT);
            $file = fopen($filePath, 'w');
            fwrite($file, $jsonContent);
            fclose($file);

            // Load the corresponding CaseRequest entity
            $caseRequest = $this->CaseRequests->get($id);

            // Update the request_status column to "resp_received"
            $caseRequest->request_status = 'Completed';

            // Save the changes to the database
            if ($this->CaseRequests->save($caseRequest)) {
                // If the update was successful, send a success response
                // $this->set([
                //     'message' => 'Request status updated successfully',
                //     '_serialize' => ['message']
                // ]);
                // Create a response object with JSON data
                
                $filePath = WWW_ROOT . 'json/powerback_denial_reasons.json';
                $jsonContent = json_encode('successfully stored data in caseRequest table.', JSON_PRETTY_PRINT);
                $file = fopen($filePath, 'w');
                fwrite($file, $jsonContent);
                fclose($file);

                $this->response = $this->response->withType('application/json')
                ->withStringBody(json_encode($caseRequest));
                return $this->response;
                // $this->set([
                //     'success' => true,
                //     'message' => 'Response received successfully',
                //     '_serialize' => ['success', 'message']
                // ]);
            } else {
                $filePath = WWW_ROOT . 'json/powerback_denial_reasons.json';
                $jsonContent = json_encode('inside else condtion', JSON_PRETTY_PRINT);
                $file = fopen($filePath, 'w');
                fwrite($file, $jsonContent);
                fclose($file);
                // If the update failed, send an error response
                throw new \Exception('Failed to update request status');
            }
        } catch (\Exception $e) {
           // If an error occurs, send a 500 error response

           $this->response = $this->response->withStatus(500); // Not Found
           return $this->response;
        }
    }
}







