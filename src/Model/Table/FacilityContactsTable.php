<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FacilityContacts Model
 *
 * @method \App\Model\Entity\FacilityContact newEmptyEntity()
 * @method \App\Model\Entity\FacilityContact newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\FacilityContact[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FacilityContact get($primaryKey, $options = [])
 * @method \App\Model\Entity\FacilityContact findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\FacilityContact patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FacilityContact[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\FacilityContact|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FacilityContact saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FacilityContact[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\FacilityContact[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\FacilityContact[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\FacilityContact[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class FacilityContactsTable extends Table
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

        $this->setTable('facility_contacts');
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
            ->scalar('first_name')
            ->maxLength('first_name', 50)
            ->requirePresence('first_name', 'create')
            ->notEmptyString('first_name');

        $validator
            ->scalar('last_name')
            ->maxLength('last_name', 50)
            ->requirePresence('last_name', 'create')
            ->notEmptyString('last_name');

        $validator
            ->email('email')
            ->allowEmptyString('email');

        $validator
            ->scalar('phone')
            ->maxLength('phone', 50)
            ->allowEmptyString('phone');

        $validator
            ->scalar('contact_id')
            ->maxLength('contact_id', 50)
            ->allowEmptyString('contact_id');

        $validator
            ->scalar('title_id')
            ->maxLength('title_id', 50)
            ->allowEmptyString('title_id');

        return $validator;
    }
}
