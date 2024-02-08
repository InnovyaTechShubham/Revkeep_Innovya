<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateContractServiceOperations extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('contract_service_operations');
        $table->addColumn('operation', 'string', ['limit' => 255]);
        $table->create();
    }

    public function down()
    {
        $this->table('contract_service_operations')->drop()->save();
    }
}