<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ReceivingEmailsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('receiving_emails');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp'); // Adds created_at and modified_at fields
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->requirePresence('email')
            ->notEmptyString('email', 'Email cannot be empty')
            ->add('email', 'validFormat', [
                'rule' => 'email',
                'message' => 'Please enter a valid email address'
            ]);

        $validator
            ->allowEmptyString('description')
            ->add('description', 'maxLength', [
                'rule' => ['maxLength', 255],
                'message' => 'Description cannot be longer than 255 characters'
            ]);

        return $validator;
    }
}