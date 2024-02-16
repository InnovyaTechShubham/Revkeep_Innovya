<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class FacilitiesContractsTable extends Table
{
    public function initialize(array $config): void
    {
        $this->setTable('facilities_contracts');
        $this->belongsTo('Facilities', [
            'foreignKey' => 'facility_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('ContractBillTypes', [
            'foreignKey' => 'contract_bill_type_id',
            'joinType' => 'INNER',
            'nullable' => true, // Allow nulls
        ]);
        $this->belongsTo('ContractTypes', [
            'foreignKey' => 'contract_type_id',
            'joinType' => 'INNER',
            'nullable' => true, // Allow nulls
        ]);
        $this->belongsTo('ContractServiceOperations', [
            'foreignKey' => 'service_operation_id',
            'joinType' => 'INNER',
            'nullable' => true, // Allow nulls
        ]);
        $this->belongsTo('ContractOwnershipTypes', [
            'foreignKey' => 'ownership_type_id',
            'joinType' => 'INNER',
            'nullable' => true, // Allow nulls
        ]);
        $this->belongsTo('ContractPricingSchedules', [
            'foreignKey' => 'pricing_schedule_id',
            'joinType' => 'INNER',
            'nullable' => true, // Allow nulls
        ]);
    }
}
