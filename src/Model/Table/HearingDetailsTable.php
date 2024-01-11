<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * HearingDetails Model
 *
 * @method \App\Model\Entity\HearingDetail newEmptyEntity()
 * @method \App\Model\Entity\HearingDetail newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\HearingDetail[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\HearingDetail get($primaryKey, $options = [])
 * @method \App\Model\Entity\HearingDetail findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\HearingDetail patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\HearingDetail[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\HearingDetail|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\HearingDetail saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\HearingDetail[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\HearingDetail[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\HearingDetail[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\HearingDetail[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class HearingDetailsTable extends Table
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

        $this->setTable('hearing_details');
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
            ->integer('appealLevelId')
            ->requirePresence('appealLevelId', 'create')
            ->notEmptyString('appealLevelId');

        $validator
            ->date('hearingDate')
            ->allowEmptyDate('hearingDate');

        $validator
            ->time('hearingTime')
            ->allowEmptyTime('hearingTime');

        $validator
            ->scalar('meetingType')
            ->maxLength('meetingType', 255)
            ->allowEmptyString('meetingType');

        return $validator;
    }
}
