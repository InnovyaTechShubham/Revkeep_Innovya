<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ClientemployeesFacility Model
 *
 * @property \App\Model\Table\FacilitiesTable&\Cake\ORM\Association\BelongsTo $Facilities
 * @property \App\Model\Table\ClientsTable&\Cake\ORM\Association\BelongsTo $Clients
 *
 * @method \App\Model\Entity\ClientemployeesFacility newEmptyEntity()
 * @method \App\Model\Entity\ClientemployeesFacility newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\ClientemployeesFacility[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ClientemployeesFacility get($primaryKey, $options = [])
 * @method \App\Model\Entity\ClientemployeesFacility findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\ClientemployeesFacility patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ClientemployeesFacility[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ClientemployeesFacility|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ClientemployeesFacility saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ClientemployeesFacility[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ClientemployeesFacility[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\ClientemployeesFacility[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ClientemployeesFacility[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ClientemployeesFacilityTable extends Table
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

        $this->setTable('clientemployees_facility');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Facilities', [
            'foreignKey' => 'facility_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Clients', [
            'foreignKey' => 'client_id',
            'joinType' => 'INNER',
        ]);
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
            ->dateTime('deleted')
            ->allowEmptyDateTime('deleted');

        $validator
            ->integer('facility_id')
            ->notEmptyString('facility_id');

        $validator
            ->integer('client_id')
            ->notEmptyString('client_id');

        return $validator;

         // Add the 'name' column to the validation rules
         $validator
          ->maxLength('name', 255)
          ->allowEmptyString('name');

     return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
       // $rules->add($rules->existsIn('facility_id', 'Facilities'), ['errorField' => 'facility_id']);
       // $rules->add($rules->existsIn('client_id', 'Clients'), ['errorField' => 'client_id']);

        return $rules;
    }
}