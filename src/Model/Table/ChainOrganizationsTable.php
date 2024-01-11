<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ChainOrganizations Model
 *
 * @property \App\Model\Table\ChainsTable&\Cake\ORM\Association\BelongsTo $Chains
 * @property \App\Model\Table\FacilitiesTable&\Cake\ORM\Association\BelongsTo $Facilities
 * @property \App\Model\Table\ServicesTable&\Cake\ORM\Association\BelongsTo $Services
 *
 * @method \App\Model\Entity\ChainOrganization newEmptyEntity()
 * @method \App\Model\Entity\ChainOrganization newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\ChainOrganization[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ChainOrganization get($primaryKey, $options = [])
 * @method \App\Model\Entity\ChainOrganization findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\ChainOrganization patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ChainOrganization[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ChainOrganization|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ChainOrganization saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ChainOrganization[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ChainOrganization[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\ChainOrganization[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ChainOrganization[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ChainOrganizationsTable extends Table
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

        $this->setTable('chain_organizations');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Chains', [
            'foreignKey' => 'chain_id',
            'joinType' => 'INNER',
        ]);
        // $this->belongsTo('Facilities', [
        //     'foreignKey' => 'facility_id',
        // ]);
        // $this->belongsTo('Services', [
        //     'foreignKey' => 'service_id',
        // ]);
        // In ChainOrganizationsTable.php
        $this->belongsTo('Facilities', [
            'foreignKey' => 'org_id',
            'conditions' => ['desc' => 'Facility'],
        ]);

        $this->belongsTo('Services', [
            'foreignKey' => 'org_id',
            'conditions' => ['desc' => 'Service'],
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
            ->scalar('chain_id')
            ->maxLength('chain_id', 255)
            ->notEmptyString('chain_id');

            $validator
            ->scalar('org_id')   // Updated from 'facility_id' to 'org_id'
            ->maxLength('org_id', 255)
            ->allowEmptyString('org_id'); // Updated from 'facility_id' to 'org_id'

            $validator
            ->scalar('desc')   // Updated from 'service_id' to 'desc'
            ->maxLength('desc', 255)
            ->allowEmptyString('desc'); // Updated from 'service_id' to 'desc'


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
        $rules->add($rules->existsIn('chain_id', 'Chains'), ['errorField' => 'chain_id']);
        // $rules->add($rules->existsIn('facility_id', 'Facilities'), ['errorField' => 'facility_id']);
        // $rules->add($rules->existsIn('service_id', 'Services'), ['errorField' => 'service_id']);

        return $rules;
    }
}
