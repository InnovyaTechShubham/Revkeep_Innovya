<?php
 
namespace App\Controller\Client;
 
use App\Model\Table\IncomingDocumentsTable;
use App\Controller\AppController;
use Dompdf\Dompdf;
use Dompdf\Options;

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

            $file_path = "../storage/incoming-documents/$fileName";

            $url = 'https://api.edination.com/v2/x12/read';

            $api_key = '3ecf6b1c5cf34bd797a5f4c57951a1cf';
            $headers = [
                'http' => [
                    'header' => "Ocp-Apim-Subscription-Key: $api_key",
                    'method' => 'POST',
                    'content' => file_get_contents($file_path),
                ],
            ];
            // $context = stream_context_create($headers);
            // $response = file_get_contents($url, false, $context);
            $response= true;
            $fileContents = file_get_contents('../storage/835_1700471401_sample.json'); // Read the JSON file
            $json_data = json_decode($fileContents, true); // Decode JSON data into PHP array
            if ($response === FALSE) {
                echo 'Error reading the file or making the request';
            } else {
                // $json_data = json_decode($response, true);

                // $output_file_path = "../storage/$originalNameBase.json";
                // file_put_contents($output_file_path, json_encode($json_data, JSON_PRETTY_PRINT));

                // echo json_encode($json_data, JSON_PRETTY_PRINT);
                
                $iteration = 1; // Initialize iteration counter

                foreach ($json_data[0]['Groups'][0]['Transactions'][0]['Loop2000'][0]['Loop2100'] as $item) {
                    $fileName=$item['Loop2110'][0]['DTM_ServiceDate'][0]['Date_02'].$item['AllNM1']['NM1_PatientName']['ResponseContactFirstName_04'].$item['AllNM1']['NM1_PatientName']['ResponseContactMiddleName_05'].$item['AllNM1']['NM1_PatientName']['ResponseContactLastorOrganizationName_03'];
                    $output_file_path = "../storage/$fileName.json";
                    file_put_contents($output_file_path, json_encode($item, JSON_PRETTY_PRINT));
                    
                    $options = new Options();
                    $options->set('isHtml5ParserEnabled', true);
                    $options->set('isPhpEnabled', true);

                    $dompdf = new Dompdf($options);
                    $dompdf->loadHtml('<h1>' . print_r($item['AllNM1'], true) . '</h1>');
                    $dompdf->setPaper('A4', 'portrait');
                    $dompdf->render();
                    
                    $pdf_file_name = $item['Loop2110'][0]['DTM_ServiceDate'][0]['Date_02'].$item['AllNM1']['NM1_PatientName']['ResponseContactFirstName_04'].$item['AllNM1']['NM1_PatientName']['ResponseContactMiddleName_05'].$item['AllNM1']['NM1_PatientName']['ResponseContactLastorOrganizationName_03'];
                    $pdf_final = $pdf_file_name.".pdf";
                    $pdf_file_path = "../storage/incoming-documents/$pdf_final";
                    file_put_contents($pdf_file_path, $dompdf->output());

                    // Save the PDF entry to the database
                    $incomingDocument = new IncomingDocumentsTable();
                    $newDocument = $incomingDocument->newEntity([
                        'original_name' => $pdf_final,
                        'file_name' => $pdf_final
                    ]);

                    if ($incomingDocument->save($newDocument)) {
                        echo "PDF '$pdf_file_name' saved successfully.\n";
                    } else {
                        echo "Error saving PDF '$pdf_file_name' entry to the database.\n";
                    }

                    $iteration++;
                }
            }
        } else {
            echo "Some Problem Occurred.";
        }
    }
}
