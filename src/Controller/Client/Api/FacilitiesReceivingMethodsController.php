<?php

declare(strict_types=1);

namespace App\Controller\Client\Api;

class FacilitiesReceivingMethodsController extends ApiController
{
    public function index()
    {
        // Action for listing facilities receiving methods
        $facilitiesReceivingMethods = $this->FacilitiesReceivingMethods->find('all');
        $this->set(compact('facilitiesReceivingMethods'));
    }

    public function add()
    {
        // Action for adding a new facility receiving method
        $facilitiesReceivingMethod = $this->FacilitiesReceivingMethods->newEmptyEntity();
        if ($this->request->is('post')) {
            $facilitiesReceivingMethod = $this->FacilitiesReceivingMethods->patchEntity($facilitiesReceivingMethod, $this->request->getData());
            if ($this->FacilitiesReceivingMethods->save($facilitiesReceivingMethod)) {
                $this->Flash->success(__('The facility receiving method has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add the facility receiving method.'));
        }
        $this->set(compact('facilitiesReceivingMethod'));
    }

    // public function edit($id)
    // {
    //     // Action for editing a facility receiving method
    //     $facilitiesReceivingMethod = $this->FacilitiesReceivingMethods->get($id);
    //     if ($this->request->is(['patch', 'post', 'put'])) {
    //         $facilitiesReceivingMethod = $this->FacilitiesReceivingMethods->patchEntity($facilitiesReceivingMethod, $this->request->getData());
    //         if ($this->FacilitiesReceivingMethods->save($facilitiesReceivingMethod)) {
    //             $this->Flash->success(__('The facility receiving method has been saved.'));
    //             return $this->redirect(['action' => 'index']);
    //         }
    //         $this->Flash->error(__('Unable to update the facility receiving method.'));
    //     }
    //     $this->set(compact('facilitiesReceivingMethod'));
    // }
}
