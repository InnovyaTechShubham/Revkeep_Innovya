<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateContractBillTypes extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('contract_bill_types');
        $table->addColumn('bill_type', 'string', ['limit' => 255]);
        $table->create();
    }

    public function down()
    {
        $this->table('contract_bill_types')->drop()->save();
    }
}