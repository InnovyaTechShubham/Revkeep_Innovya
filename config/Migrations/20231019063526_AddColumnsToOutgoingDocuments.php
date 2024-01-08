<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddColumnsToOutgoingDocuments extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('outgoing_documents');
        $table
        ->addColumn('tracking_id', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ])
        ->addColumn('services', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ])
        ->addColumn('delivery_date', 'date', [
            'default' => null,
            'null' => true,
        ])
        ->addColumn('email', 'string', [
            'default' => null,
            'null' => true,
        ])
        ->update();
    }
}
