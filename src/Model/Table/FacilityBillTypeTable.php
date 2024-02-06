<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FacilityBillType Model
 *
 * @method \App\Model\Entity\FacilityBillType newEmptyEntity()
 * @method \App\Model\Entity\FacilityBillType newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\FacilityBillType[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FacilityBillType get($primaryKey, $options = [])
 * @method \App\Model\Entity\FacilityBillType findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\FacilityBillType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FacilityBillType[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\FacilityBillType|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FacilityBillType saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FacilityBillType[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\FacilityBillType[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\FacilityBillType[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\FacilityBillType[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class FacilityBillTypeTable extends Table
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

        $this->setTable('facility_bill_type');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->scalar('bill_type')
            ->maxLength('bill_type', 255)
            ->requirePresence('bill_type', 'create')
            ->notEmptyString('bill_type');

        return $validator;
    }
}
