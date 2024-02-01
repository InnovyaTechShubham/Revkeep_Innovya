<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MultiAgencyContacts Model
 *
 * @method \App\Model\Entity\MultiAgencyContact newEmptyEntity()
 * @method \App\Model\Entity\MultiAgencyContact newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\MultiAgencyContact[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MultiAgencyContact get($primaryKey, $options = [])
 * @method \App\Model\Entity\MultiAgencyContact findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\MultiAgencyContact patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MultiAgencyContact[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\MultiAgencyContact|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MultiAgencyContact saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MultiAgencyContact[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\MultiAgencyContact[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\MultiAgencyContact[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\MultiAgencyContact[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class MultiAgencyContactsTable extends Table
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

        $this->setTable('multi_agency_contacts');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
    }

    // /**
    //  * Default validation rules.
    //  *
    //  * @param \Cake\Validation\Validator $validator Validator instance.
    //  * @return \Cake\Validation\Validator
    //  */
    // public function validationDefault(Validator $validator): Validator
    // {
    //     $validator
    //         ->scalar('agency_email')
    //         ->maxLength('agency_email', 255)
    //         ->requirePresence('agency_email', 'create')
    //         ->notEmptyString('agency_email');

    //     $validator
    //         ->scalar('agency_fax')
    //         ->maxLength('agency_fax', 20)
    //         ->allowEmptyString('agency_fax');

    //     $validator
    //         ->scalar('desc_email')
    //         ->maxLength('desc_email', 255)
    //         ->requirePresence('desc_email', 'create')
    //         ->notEmptyString('desc_email');

    //     $validator
    //         ->scalar('desc_fax')
    //         ->maxLength('desc_fax', 20)
    //         ->allowEmptyString('desc_fax');

    //     return $validator;
    // }
}
