<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FacilityAddContacts Model
 *
 * @method \App\Model\Entity\FacilityAddContact newEmptyEntity()
 * @method \App\Model\Entity\FacilityAddContact newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\FacilityAddContact[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FacilityAddContact get($primaryKey, $options = [])
 * @method \App\Model\Entity\FacilityAddContact findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\FacilityAddContact patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FacilityAddContact[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\FacilityAddContact|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FacilityAddContact saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FacilityAddContact[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\FacilityAddContact[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\FacilityAddContact[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\FacilityAddContact[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class FacilityAddContactsTable extends Table
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

        $this->setTable('facility_add_contacts');
        $this->setDisplayField('title');
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
            ->maxLength('first_name', 255)
            ->allowEmptyString('first_name');

        $validator
            ->scalar('last_name')
            ->maxLength('last_name', 255)
            ->allowEmptyString('last_name');

        $validator
            ->scalar('mobile_no')
            ->maxLength('mobile_no', 10)
            ->allowEmptyString('mobile_no');

        $validator
            ->scalar('contact_type')
            ->maxLength('contact_type', 255)
            ->allowEmptyString('contact_type');

        $validator
            ->email('email')
            ->allowEmptyString('email');

        $validator
            ->scalar('title')
            ->maxLength('title', 255)
            ->allowEmptyString('title');

        return $validator;
    }
}
