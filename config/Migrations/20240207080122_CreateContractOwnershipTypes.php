<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateContractOwnershipTypes extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('contract_ownership_types');
        $table->addColumn('ownership_type', 'string', ['limit' => 255]);
        $table->create();
    }

    public function down()
    {
        $this->table('contract_ownership_types')->drop()->save();
    }
}