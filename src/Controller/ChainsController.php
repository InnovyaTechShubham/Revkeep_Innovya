<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Chains Controller
 *
 * @property \App\Model\Table\ChainsTable $Chains
 * @method \App\Model\Entity\Chain[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ChainsController extends AppController
{
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

    /**
     * View method
     *
     * @param string|null $id Chain id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $chain = $this->Chains->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('chain'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $chain = $this->Chains->newEmptyEntity();
        if ($this->request->is('post')) {
            $chain = $this->Chains->patchEntity($chain, $this->request->getData());
            if ($this->Chains->save($chain)) {
                $this->Flash->success(__('The chain has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The chain could not be saved. Please, try again.'));
        }
        $this->set(compact('chain'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Chain id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $chain = $this->Chains->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $chain = $this->Chains->patchEntity($chain, $this->request->getData());
            if ($this->Chains->save($chain)) {
                $this->Flash->success(__('The chain has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The chain could not be saved. Please, try again.'));
        }
        $this->set(compact('chain'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Chain id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $chain = $this->Chains->get($id);
        if ($this->Chains->delete($chain)) {
            $this->Flash->success(__('The chain has been deleted.'));
        } else {
            $this->Flash->error(__('The chain could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
