<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateReceivingEmails extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('receiving_emails');
        $table->addColumn('email', 'string', ['limit' => 255, 'null' => false]);
        $table->addColumn('created_at', 'datetime', ['default' => null, 'null' => false]);
        $table->addColumn('description', 'text', ['default' => null, 'null' => false]);
        $table->create();
    }
}
