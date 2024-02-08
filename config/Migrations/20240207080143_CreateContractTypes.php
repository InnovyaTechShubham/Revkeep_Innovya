<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateContractTypes extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('contract_types');
        $table->addColumn('contract_type', 'string', ['limit' => 255]);
        $table->create();
    }

    public function down()
    {
        $this->table('contract_types')->drop()->save();
    }
}