<?php

declare(strict_types=1);
namespace App\Model\Table;

use Cake\ORM\Table;

class ContractPricingSchedulesTable extends Table
{
    public function initialize(array $config): void
    {
        $this->setTable('contract_pricing_schedules');
        $this->belongsTo('InsuranceTypes', [
            'foreignKey' => 'insurance_type_id',
            'joinType' => 'INNER',
        ]);
    }
}
