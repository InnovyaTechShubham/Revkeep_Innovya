<?php

declare(strict_types=1);

namespace App\Controller\Client\Api;



class ReceivingFaxesController extends ApiController
{
    public function index()
    {
        // Action for listing receiving faxes
        $receivingFaxes = $this->ReceivingFaxes->find('all');
        $this->set(compact('receivingFaxes'));
    }

    public function add()
    {
        // Action for adding a new receiving fax
        $receivingFax = $this->receivingFaxes->newEmptyEntity();
        if ($this->request->is('post')) {
            $receivingFax = $this->receivingFaxes->patchEntity($receivingFax, $this->request->getData());
            if ($this->receivingFaxes->save($receivingFax)) {
                $this->Flash->success(__('The receiving fax has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add the receiving fax.'));
        }
        $this->set(compact('receivingFax'));
    }

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
