<?php
namespace App\Controller\Client;

use App\Controller\AppController;

class GetprofessiontypeController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->viewBuilder()->setClassName('Json');
        $this->loadModel('ProfessionTypes');
    }

    public function index()
    {
        $professionTypes = $this->ProfessionTypes->find('list', [
            'keyField' => 'id',
            'valueField' => 'name',
        ])->toArray();

        // Extract only values (names) from the associative array
        $professionTypeNames = array_values($professionTypes);

        $this->set([
            'success' => true,
            'data' => $professionTypeNames,
        ]);

        $this->viewBuilder()->setOption('serialize', ['success', 'data']);
    }
}
