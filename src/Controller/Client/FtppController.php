<?php

namespace App\Controller\Client;

use App\Model\Table\IncomingDocumentsTable;
use App\Controller\AppController;
use Cake\Http\Exception\MethodNotAllowedException;

class FtppController extends AppController
{
    public function index()
    {
        if ($this->request->is('post')) {
            $data = $this->request->getData();

            // Fetching and validating inputs
            $ftp_server = $data["ftpPortalUrl"] ?? null;
            $ftp_username = $data["ftpUsername"] ?? null;
            $ftp_password = $data["ftpPassword"] ?? null;
            $insid = $data["insid"] ?? null;
            $file_name = $insid.".pdf";
            $local_file_path = "../storage/appeal-packets/" . $file_name;

            if ($ftp_server && $ftp_username && $ftp_password) {
                $file_name = basename($local_file_path);
                $file_temp = $local_file_path;
                $upload_dir = "/htdocs/"; 

                $conn_id = ftp_connect($ftp_server);

                if ($conn_id) {
                    $login_result = ftp_login($conn_id, $ftp_username, $ftp_password);

                    if ($login_result) {
                        $upload_result = ftp_put($conn_id, $upload_dir . $file_name, $file_temp, FTP_BINARY);

                        if ($upload_result) {
                            $response = ["message" => "File uploaded successfully"];
                            $statusCode = 201; // Created
                        } else {
                            $response = ["message" => "Upload failed"];
                            $statusCode = 500; // Internal Server Error
                        }
                    } else {
                        $response = ["message" => "FTP login failed"];
                        $statusCode = 401; // Unauthorized
                    }

                    ftp_close($conn_id);
                } else {
                    $response = ["message" => "Could not connect to FTP server"];
                    $statusCode = 500; // Internal Server Error
                }
            } else {
                $response = ["message" => "Incomplete or invalid data provided"];
                $statusCode = 400; // Bad Request
            }

            $this->response = $this->response->withType('application/json')
                ->withStatus($statusCode)
                ->withStringBody(json_encode($response));
            return $this->response;
        } else {
            // Handle if the request is not a POST
            $response = ["message" => "Method Not Allowed"];
            $statusCode = 405; // Method Not Allowed
            $this->response = $this->response->withType('application/json')
                ->withStatus($statusCode)
                ->withStringBody(json_encode($response));
            return $this->response;
        }
    }
}