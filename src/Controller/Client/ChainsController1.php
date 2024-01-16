<?php
declare(strict_types=1);

namespace App\Controller\Client;

use Cake\Log\Log;


use App\Controller\AppController;
use Cake\I18n\FrozenTime;
use Cake\ORM\Exception\PersistenceFailedException;
use App\Model\Table\ChainsTable; // Make sure to adjust the namespace

use Cake\Filesystem\File;
use Cake\Filesystem\Folder;


/**
 * Chains Controller
 *
 * @property \App\Model\Table\ChainsTable $Chains
 * @method \App\Model\Entity\Chain[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ChainsController extends AppController{


    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Flash');
        // Load other necessary components here
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $chains = $this->paginate($this->Chains);

        $this->set(compact('chains'));
    }

    // /**
    //  * View method
    //  *
    //  * @param string|null $id Chain id.
    //  * @return \Cake\Http\Response|null|void Renders view
    //  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
    //  */
    // public function view($id = null)
    // {
    //     $chain = $this->Chains->get($id, [
    //         'contain' => [],
    //     ]);

    //     $this->set(compact('chain'));
    // }

    // /**
	//  * Add method
	//  *
	//  * @return void
	//  * @throws \Cake\ORM\Exception\PersistenceFailedException When not valid.
	//  */
	// public function add(): void
	// {

	// 	$entity = $this->Chains->newEntity($this->getRequest()->getData());
    //     // $requestData = $this->request->getData();
    //     // $this->log(print_r($requestData, true), 'debug');
	// 	try {
	// 		$this->Chains->saveOrFail($entity);
	// 		$entity = $this->Chains->getFull($entity->id);
	// 		$this->set('data', $entity);
    //         // axios return application/json
	// 	} catch (PersistenceFailedException $e) {
	// 		$this->Log->saveFailed($e, $entity);
	// 		$this->setResponse($this->ApiError->entity($e, $entity));
	// 	}


    //     // $data = ['key' => 'value', 'another_key' => 'another_value'];
    //     // $jsonString = json_encode($data, JSON_PRETTY_PRINT);

    //     // // Specify the directory path and file path
    //     // $directoryPath = WWW_ROOT . 'json';
    //     // $filePath = $directoryPath . DS . 'status_log.json';

    //     // // Create the directory if it doesn't exist
    //     // $folder = new Folder();
    //     // $folder->create($directoryPath);

    //     // // Write the JSON data to the file
    //     // $file = new File($filePath, true, 0644);
    //     // $file->write($jsonString);
    //     // $file->close();

    //     // // Optionally, you can provide feedback or perform other actions.
    //     // $this->Flash->success(__('JSON file has been written.'));
	// }

}
