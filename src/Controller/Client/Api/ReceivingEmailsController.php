<?php

declare(strict_types=1);

namespace App\Controller\Client\Api;



class ReceivingEmailsController extends ApiController
{
    public function index()
    {
        // Action for listing receiving emails
        $receivingEmails = $this->ReceivingEmails->find('all');
        $this->set(compact('receivingEmails'));
    }


    public function add(): void
	{
		$entity = $this->ReceivingEmails->newEntity($this->getRequest()->getData(), [
			// 'associated' => [
			// 	'Services',
			// 	// 'Chains'
			// ],
		]);

		try {
			$this->ReceivingEmails->saveOrFail($entity);
			$entity = $this->ReceivingEmails->getFull($entity->id);

			$this->set('data', $entity);
			// $data = $this->request->getData();

			// Insert debugging code
			$filePath = 'C:\xampp\htdocs\Revkeep_Innovya\example.json';
			// $demo = array
			// (    
			// 'name'
			// =>
			// 'John'
			// ,    
			// 'age'
			// =>
			// 30
			// ,    
			// 'city'
			// =>
			// 'New York'
			// );
			
			$jsonContent = json_encode($entity, JSON_PRETTY_PRINT);
			$file = fopen($filePath, 'w');
			fwrite($file, $jsonContent);
			fclose($file);

		} catch (PersistenceFailedException $e) {
			$this->Log->saveFailed($e, $entity);
			$this->setResponse($this->ApiError->entity($e, $entity));
		}
	}
    // public function add()
    // {
    //     // Action for adding a new receiving email
    //     $receivingEmail = $this->ReceivingEmails->newEmptyEntity();
    //     if ($this->request->is('post')) {
    //         $receivingEmail = $this->ReceivingEmails->patchEntity($receivingEmail, $this->request->getData());
    //         if ($this->ReceivingEmails->save($receivingEmail)) {
    //             $this->Flash->success(__('The receiving email has been saved.'));
    //             return $this->redirect(['action' => 'index']);
    //         }
    //         $this->Flash->error(__('Unable to add the receiving email.'));
    //     }
    //     $this->set(compact('receivingEmail'));
    // }

    // public function edit($id)
    // {
    //     // Action for editing a receiving email
    //     $receivingEmail = $this->ReceivingEmails->get($id);
    //     if ($this->request->is(['patch', 'post', 'put'])) {
    //         $receivingEmail = $this->ReceivingEmails->patchEntity($receivingEmail, $this->request->getData());
    //         if ($this->ReceivingEmails->save($receivingEmail)) {
    //             $this->Flash->success(__('The receiving email has been saved.'));
    //             return $this->redirect(['action' => 'index']);
    //         }
    //         $this->Flash->error(__('Unable to update the receiving email.'));
    //     }
    //     $this->set(compact('receivingEmail'));
    // }
}
