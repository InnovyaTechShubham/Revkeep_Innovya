<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateReceivingFaxes extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('receiving_faxes', ['id' => false, 'primary_key' => ['id']]);
        $table->addColumn('id', 'biginteger', ['autoIncrement' => true, 'default' => null, 'limit' => 20, 'null' => false])
            ->addColumn('fax', 'string', ['default' => null, 'limit' => 255, 'null' => false])
            ->addColumn('created_at', 'datetime', ['default' => null, 'null' => false])
            ->create();
    }

    public function down()
    {
        $this->table('receiving_faxes')->drop()->save();
    }
}
