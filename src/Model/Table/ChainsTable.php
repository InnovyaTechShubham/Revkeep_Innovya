<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Chains Model
 *
 * @method \App\Model\Entity\Chain newEmptyEntity()
 * @method \App\Model\Entity\Chain newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Chain[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Chain get($primaryKey, $options = [])
 * @method \App\Model\Entity\Chain findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Chain patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Chain[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Chain|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Chain saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Chain[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Chain[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Chain[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Chain[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ChainsTable extends Table
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

        $this->setTable('chains');
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
            ->scalar('chain_name')
            ->maxLength('chain_name', 255)
            ->requirePresence('chain_name', 'create')
            ->notEmptyString('chain_name');

        $validator
            ->scalar('chain_type')
            ->maxLength('chain_type', 255)
            ->allowEmptyString('chain_type');

        return $validator;
    }
}
