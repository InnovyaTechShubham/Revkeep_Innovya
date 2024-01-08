<?php

namespace App\Controller\Client;

use App\Model\Table\IncomingDocumentsTable;
use App\Controller\AppController;

class ParserPostRequestController extends AppController
{
    public function index()
    {
        $this->autoRender = false;
        if ($this->request->is('post')) {

            $data = $this->request->getData();
            $docName = $data['docName'];
            $fileName = $data['fileName'];
            $originalNameBase = $data['originalNameBase'];
            $originalNameExtension = $data['originalNameExtension'];
        
        $file_path = "../storage/incoming-documents/835_1700471401_sample.txt";

        
        $url = 'https://api.edination.com/v2/x12/read';

        
        $api_key = '3ecf6b1c5cf34bd797a5f4c57951a1cf';
        $headers = [
            'http' => [
                'header' => "Ocp-Apim-Subscription-Key: $api_key",
                'method' => 'POST',
                'content' => file_get_contents($file_path),
            ],
        ];
        $context = stream_context_create($headers);
        $response = file_get_contents($url, false, $context);

        if ($response === FALSE) {
            echo 'Error reading the file or making the request';
        } else {
            $json_data = json_decode($response, true);
            
            $output_file_path = "../storage/$originalNameBase.json";

            file_put_contents($output_file_path, json_encode($json_data, JSON_PRETTY_PRINT));

            echo json_encode($json_data, JSON_PRETTY_PRINT);
        }
    }
    else{
        echo("Some Problem Occured.");
        }
    }
}
