<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddNullableToFacilitiesContractsAssociations extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('facilities_contracts');

        // Remove existing foreign keys
        $table->dropForeignKey('contract_bill_type_id')
            ->dropForeignKey('contract_type_id')
            ->dropForeignKey('service_operation_id')
            ->dropForeignKey('ownership_type_id')
            ->dropForeignKey('pricing_schedule_id')
            ->save();

        // Alter columns to make them nullable
        $table->changeColumn('contract_bill_type_id', 'integer', ['null' => true, 'default' => null])
            ->changeColumn('contract_type_id', 'integer', ['null' => true, 'default' => null])
            ->changeColumn('service_operation_id', 'integer', ['null' => true, 'default' => null])
            ->changeColumn('ownership_type_id', 'integer', ['null' => true, 'default' => null])
            ->changeColumn('pricing_schedule_id', 'integer', ['null' => true, 'default' => null])
            ->save();

        // Add foreign keys
        $table->addForeignKey('contract_bill_type_id', 'contract_bill_types', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
            ->addForeignKey('contract_type_id', 'contract_types', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
            ->addForeignKey('service_operation_id', 'contract_service_operations', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
            ->addForeignKey('ownership_type_id', 'contract_ownership_types', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
            ->addForeignKey('pricing_schedule_id', 'contract_pricing_schedules', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
            ->save();
    }
}
