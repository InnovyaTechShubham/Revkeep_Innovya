<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FacilityAddForms Model
 *
 * @method \App\Model\Entity\FacilityAddForm newEmptyEntity()
 * @method \App\Model\Entity\FacilityAddForm newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\FacilityAddForm[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FacilityAddForm get($primaryKey, $options = [])
 * @method \App\Model\Entity\FacilityAddForm findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\FacilityAddForm patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FacilityAddForm[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\FacilityAddForm|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FacilityAddForm saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FacilityAddForm[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\FacilityAddForm[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\FacilityAddForm[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\FacilityAddForm[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class FacilityAddFormsTable extends Table
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

        $this->setTable('facility_add_forms');
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
            ->scalar('f_name')
            ->maxLength('f_name', 255)
            ->allowEmptyString('f_name');

        $validator
            ->scalar('l_name')
            ->maxLength('l_name', 255)
            ->allowEmptyString('l_name');

        $validator
            ->scalar('phone_no')
            ->maxLength('phone_no', 10)
            ->allowEmptyString('phone_no');

        $validator
            ->scalar('contact_id')
            ->maxLength('contact_id', 255)
            ->allowEmptyString('contact_id');

        $validator
            ->email('email')
            ->allowEmptyString('email');

        $validator
            ->scalar('title_id')
            ->maxLength('title_id', 255)
            ->allowEmptyString('title_id');

        return $validator;
    }
}
