<?php

namespace App\Controller\Client;

use App\Model\Table\OutgoingDocumentsTable;
use App\Controller\AppController;
use App\Model\Entity\OutgoingDocument;
use Cake\Http\Exception\MethodNotAllowedException;


class OutgoingDetailsController extends AppController
{
    public function index()
    {
        if ($this->request->is('post')) {
            $outgoingDocument = new OutgoingDocumentsTable();
            $lastRow = $outgoingDocument->find('all', [
                'order' => ['id' => 'DESC'],
            ])->first();
            if ($lastRow) {
                // Update the 'services' and 'tracking_id' columns
                $data = $this->request->getData();
                $lastRow->email = $data['email'];
                $lastRow->packageSentViaSnailMail = $data['packageSentViaSnailMail'];
                $lastRow->mailNotes=$data['mailNotes'];
                $lastRow->ftpPortalUrl=$data['ftpPortalUrl'];
                $lastRow->ftpUsername=$data['ftpUsername'];
                $lastRow->ftpPassword=$data['ftpPassword'];
                $lastRow->EsmdPortalUrl=$data['EsmdPortalUrl'];
                $lastRow->EsmdUsername=$data['EsmdUsername'];
                $lastRow->EsmdPassword=$data['EsmdPassword'];
                $lastRow->fax=$data['fax'];
                $lastRow->website=$data['$lastRow->'];
                $lastRow->contactNumber=$data['contactNumber'];
                $lastRow->agency_id=$data['agency_id'];
                $lastRow->delivery_method=$data['delivery_method'];
                if ($outgoingDocument->save($lastRow)) {
                    // Successfully updated the last row
                    // Redirect or return a success response
                } else {
                    // Handle the case where the update fails
                    // You might want to log errors or return an error response
                }
            } else {
                // Handle the case where there are no rows in the table
                // You might want to log this or return an error response
            }
        }
    }
}