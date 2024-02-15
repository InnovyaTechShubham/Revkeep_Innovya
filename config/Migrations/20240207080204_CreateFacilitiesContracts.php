<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateFacilitiesContracts extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('facilities_contracts');
        $table->addColumn('facility_id', 'integer');
        $table->addColumn('original_start_date', 'date');
        $table->addColumn('term_date', 'date');
        $table->addColumn('status', 'string', ['limit' => 50]);
        $table->addColumn('expiration_date', 'date');
        $table->addColumn('contract_effective_date', 'date');
        $table->addColumn('renewal_date', 'date');
        $table->addColumn('contract_bill_type_id', 'integer');
        $table->addColumn('contract_type_id', 'integer');
        $table->addColumn('indemnification_days', 'integer');
        $table->addColumn('max_return_days', 'integer');
        $table->addColumn('service_operation_id', 'integer');
        $table->addColumn('ownership_type_id', 'integer');
        $table->addColumn('pricing_schedule_id', 'integer');
        
        $table->addForeignKey('facility_id', 'facilities', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE']);
        $table->addForeignKey('contract_bill_type_id', 'contract_bill_types', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE']);
        $table->addForeignKey('contract_type_id', 'contract_types', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE']);
        $table->addForeignKey('service_operation_id', 'contract_service_operations', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE']);
        $table->addForeignKey('ownership_type_id', 'contract_ownership_types', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE']);
        $table->addForeignKey('pricing_schedule_id', 'contract_pricing_schedules', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE']);
        
        $table->create();
    }

    public function down()
    {
        $this->table('facilities_contracts')->drop()->save();
    }
}

