<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FacilitiesReceivingmethods Model
 */
class FacilitiesReceivingMethodsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('facilities_receivingmethods');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ReceivingEmails', [
            'foreignKey' => 'receiving_email_id',
            'joinType' => 'INNER',
        ]);

        $this->belongsTo('ReceivingFaxes', [
            'foreignKey' => 'receiving_fax_id',
            'joinType' => 'INNER',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->integer('facility_id')
            ->requirePresence('facility_id', 'create')
            ->notEmptyString('facility_id');

        return $validator;
    }
}
