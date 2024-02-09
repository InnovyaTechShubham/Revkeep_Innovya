<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateFacilitiesReceivingmethods extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('facilities_receivingmethods', ['id' => false, 'primary_key' => ['id']]);
        $table->addColumn('id', 'biginteger', ['autoIncrement' => true, 'default' => null, 'limit' => 20, 'null' => false])
            ->addColumn('facility_id', 'biginteger', ['default' => null, 'limit' => 20, 'null' => false])
            ->addColumn('receiving_email_id', 'biginteger', ['default' => null, 'limit' => 20, 'null' => false])
            ->addColumn('receiving_fax_id', 'biginteger', ['default' => null, 'limit' => 20, 'null' => false])
            ->addColumn('created_at', 'datetime', ['default' => null, 'null' => false])
            ->create();
    }

    public function down()
    {
        $this->table('facilities_receivingmethods')->drop()->save();
    }
}
