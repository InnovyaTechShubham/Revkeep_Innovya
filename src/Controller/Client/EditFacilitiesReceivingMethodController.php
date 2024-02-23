<?php

namespace App\Controller\Client;

use App\Controller\AppController;

use Cake\ORM\TableRegistry;


use Cake\Network\Exception\MethodNotAllowedException;

class EditFacilitiesReceivingMethodController extends AppController
{
    public function index()
	{
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $filePath = 'D:\xampp\htdocs\Insurance_mergerd\final_revkeep\example4.json';
            $jsonContent = json_encode($data, JSON_PRETTY_PRINT);
            $file = fopen($filePath, 'w');
            fwrite($file, $jsonContent);
            fclose($file);
        }
    }

}