<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ReceivingFaxes Model
 */
class ReceivingFaxesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('receiving_faxes');
        $this->setDisplayField('fax');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('fax')
            ->requirePresence('fax', 'create')
            ->notEmptyString('fax');

        return $validator;
    }
}
