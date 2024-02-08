<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateContractPricingSchedules extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('contract_pricing_schedules');
        $table->addColumn('insurance_type_id', 'integer');
        $table->addColumn('contract_rate', 'decimal', ['precision' => 10, 'scale' => 2]);
        $table->addForeignKey('insurance_type_id', 'insurance_types', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE']);
        $table->create();
    }

    public function down()
    {
        $this->table('contract_pricing_schedules')->drop()->save();
    }
}
