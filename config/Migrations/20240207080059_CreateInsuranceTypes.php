<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateInsuranceTypes extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('contract_insurance_types');
        $table->addColumn('insurance_type', 'string', ['limit' => 255]);
        $table->create();
    }

    public function down()
    {
        $this->table('insurance_types')->drop()->save();
    }
}