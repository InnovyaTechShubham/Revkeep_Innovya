<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddMoreColumnsToOutgoingDocuments extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function up()
    {
        $table = $this->table('outgoing_documents');

        // Add 'carrier' column
        $table->addColumn('carrier', 'string', [
            'default' => null,
            'null' => true,
        ]);

        // Add 'tracking' column
        $table->addColumn('tracking', 'string', [
            'default' => null,
            'null' => true,
        ]);

        // Add 'date/time' column
        $table->addColumn('sent_date_time', 'datetime', [
            'default' => null,
            'null' => true,
        ]);

        $table->update();
    }

}
