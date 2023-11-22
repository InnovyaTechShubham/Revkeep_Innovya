<?php

namespace App\Controller\Client;

use App\Model\Table\ProfessionTypesTable;
use App\Controller\AppController;
use Cake\Network\Exception\MethodNotAllowedException;

class ProfessiontypeController extends AppController
{
    public function index()
    {
        $this->autoRender = false; 
        $type = new ProfessionTypesTable();
        if ($this->request->is('post')) {
         $newType = $this->request->getData('newType');
         
         $new = $type->newEntity([

            'name' => $newType,
            
        ]);
        if ($type->save($new)) {
            $response = [

                'success' => 'true',

                'message' => 'Document entry saved.',

            ];

        }

    }
    
    }
}
