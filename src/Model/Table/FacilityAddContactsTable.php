<?php

declare(strict_types=1);
// src/Model/Table/FacilityAddContactsTable.php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class FacilityAddContactsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('facility_add_contacts');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

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
            ->allowEmptyString('contact_type')
            ->inList('contact_type', ['Mobile', 'Landline', 'Phone']);

        $validator
            ->scalar('email')
            ->maxLength('email', 255)
            ->allowEmptyString('email');

        $validator
            ->scalar('title')
            ->maxLength('title', 255)
            ->allowEmptyString('title')
            ->inList('title', ['Doctor', 'Nurse', 'Driver', 'Engineer']);

        return $validator;
    }
}
