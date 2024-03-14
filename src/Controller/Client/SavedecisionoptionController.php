<?php

namespace App\Controller\Client;

use App\Model\Table\AppealsTable;
use App\Controller\AppController;
use Cake\Log\Log;

class SavedecisionoptionController extends AppController
{
    public function index()
    {
        $this->autoRender = false;
        if ($this->request->is('post')) {
            // Extract data from the request
            $appealId = $this->request->getData('appealId');
            $decisionOption = $this->request->getData('decisionOption');
            $riskAmount = $this->request->getData('riskAmount');

            try {
                // Load the AppealsTable model
                $appealsTable = new AppealsTable();

                // Find the appeal by ID
                $appeal = $appealsTable->get($appealId);

                // Ensure disputed_amount, reimbursed_amount, and outstanding_amount are not null
                if ($appeal->disputed_amount === null) {
                    $appeal->disputed_amount = 0;
                }
                if ($appeal->reimbursed_amount === null) {
                    $appeal->reimbursed_amount = 0;
                }
                if ($appeal->outstanding_amount === null) {
                    $appeal->outstanding_amount = 0;
                }

                // Update the appeal_decision column
                $appeal->appeal_decision = $decisionOption;

                // on updation of appeal decision, set appeal_status to 'Closed'
                $appeal->appeal_status = 'Closed';

                // Update the disputed_amount, reimbursed_amount, and outstanding_amount based on the decision option
                if ($decisionOption !== 'Favorable') {
                    $previousDisputedAmount = $appeal->disputed_amount;
                    $appeal->disputed_amount = $riskAmount;
                    $appeal->reimbursed_amount = $previousDisputedAmount - $appeal->disputed_amount;
                    $appeal->outstanding_amount = $appeal->disputed_amount;
                }

                // Save the updated appeal
                if ($appealsTable->save($appeal)) {
                    $response = [
                        'success' => true,
                        'message' => 'Document entry saved.',
                    ];
                } else {
                    $response = [
                        'success' => false,
                        'message' => 'Failed to save document entry.',
                    ];
                }
            } catch (\Exception $e) {
                // Log any errors
                Log::error('Exception: ' . $e->getMessage());

                // Respond with error message
                $response = [
                    'success' => false,
                    'message' => 'Failed to update decision options.',
                ];
            }

            // Set the response format to JSON
            $this->response = $this->response->withType('application/json')
                ->withStringBody(json_encode($response));
        }
    }
}
