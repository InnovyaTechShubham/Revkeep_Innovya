<?php
declare(strict_types=1);

namespace App\Controller\Client;


use App\Controller\AppController;

/**
 * InsuranceProviderTypes Controller
 *
 * @property \App\Model\Table\InsuranceProviderTypesTable $InsuranceProviderTypes
 * @method \App\Model\Entity\InsuranceProviderType[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class InsuranceProviderTypesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $insuranceProviderTypes = $this->paginate($this->InsuranceProviderTypes);

        $this->set(compact('insuranceProviderTypes'));
    }

    /**
     * View method
     *
     * @param string|null $id Insurance Provider Type id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $insuranceProviderType = $this->InsuranceProviderTypes->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('insuranceProviderType'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $insuranceProviderType = $this->InsuranceProviderTypes->newEmptyEntity();
        if ($this->request->is('post')) {
            $insuranceProviderType = $this->InsuranceProviderTypes->patchEntity($insuranceProviderType, $this->request->getData());
            if ($this->InsuranceProviderTypes->save($insuranceProviderType)) {
                $this->Flash->success(__('The insurance provider type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The insurance provider type could not be saved. Please, try again.'));
        }
        $this->set(compact('insuranceProviderType'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Insurance Provider Type id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $insuranceProviderType = $this->InsuranceProviderTypes->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $insuranceProviderType = $this->InsuranceProviderTypes->patchEntity($insuranceProviderType, $this->request->getData());
            if ($this->InsuranceProviderTypes->save($insuranceProviderType)) {
                $this->Flash->success(__('The insurance provider type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The insurance provider type could not be saved. Please, try again.'));
        }
        $this->set(compact('insuranceProviderType'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Insurance Provider Type id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $insuranceProviderType = $this->InsuranceProviderTypes->get($id);
        if ($this->InsuranceProviderTypes->delete($insuranceProviderType)) {
            $this->Flash->success(__('The insurance provider type has been deleted.'));
        } else {
            $this->Flash->error(__('The insurance provider type could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function getAll()
    {
        try {
            $this->autoRender = false;

            $insuranceProviderTypes = $this->InsuranceProviderTypes->find('all')->toArray();

            // Return JSON response
            $this->response = $this->response->withType('application/json')
            ->withStringBody(json_encode($insuranceProviderTypes));

            return $this->response;

            // $this->set([
            //     'insuranceProviderTypes' => $insuranceProviderTypes,
            //     '_serialize' => ['insuranceProviderTypes'],
            // ]);
        } catch (\Exception $e) {

            $filePath = WWW_ROOT . 'json/powerback_denial_reasons.json';
            $jsonContent = json_encode($e->getMessage(), JSON_PRETTY_PRINT);
            $file = fopen($filePath, 'w');
            fwrite($file, $jsonContent);
            fclose($file);

            $this->log($e->getMessage(), 'error');
            $this->response = $this->response->withStatus(500);
        }	 
    }
}
