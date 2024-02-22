<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PowerbackDenialReasons Model
 *
 * @method \App\Model\Entity\PowerbackDenialReason newEmptyEntity()
 * @method \App\Model\Entity\PowerbackDenialReason newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\PowerbackDenialReason[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PowerbackDenialReason get($primaryKey, $options = [])
 * @method \App\Model\Entity\PowerbackDenialReason findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\PowerbackDenialReason patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PowerbackDenialReason[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\PowerbackDenialReason|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PowerbackDenialReason saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PowerbackDenialReason[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PowerbackDenialReason[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\PowerbackDenialReason[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PowerbackDenialReason[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class PowerbackDenialReasonsTable extends Table
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

        $this->setTable('powerback_denial_reasons');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->setEntityClass('App\Model\Entity\PowerbackDenialReason'); // Add this line
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
            ->scalar('reason')
            ->maxLength('reason', 500)
            ->requirePresence('reason', 'create')
            ->notEmptyString('reason');

        return $validator;
    }
}
