<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class ContractInsuranceTypesTable extends Table
{
    public function initialize(array $config): void
    {
        $this->setTable('contract_insurance_types');
        $this->setDisplayField('insurance_type');
        $this->hasMany('ContractPricingSchedules', [
            'foreignKey' => 'insurance_type_id',
        ]);
    }
}
