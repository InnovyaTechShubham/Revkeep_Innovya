<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ContractStatus Model
 *
 * @method \App\Model\Entity\ContractStatus newEmptyEntity()
 * @method \App\Model\Entity\ContractStatus newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\ContractStatus[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ContractStatus get($primaryKey, $options = [])
 * @method \App\Model\Entity\ContractStatus findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\ContractStatus patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ContractStatus[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ContractStatus|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ContractStatus saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ContractStatus[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ContractStatus[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\ContractStatus[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ContractStatus[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ContractStatusTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('contract_status');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('contract_status')
            ->maxLength('contract_status', 20)
            ->allowEmptyString('contract_status');

        return $validator;
    }
}
