<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddSubmitColumnsToOutgoingDocuments extends AbstractMigration
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

        // Add 'name_of_submit_to' column
        $table->addColumn('name_of_submit_to', 'string', [
            'default' => null,
            'null' => true,
        ]);

        // Add 'request_id' column
        $table->addColumn('request_id', 'integer', [
            'default' => null,
            'null' => true,
        ]);

        // Add 'submit_to' column
        $table->addColumn('submit_to', 'string', [
            'default' => null,
            'null' => true,
        ]);

        // Add 'facility_name' column
        $table->addColumn('facility_name', 'string', [
            'default' => null,
            'null' => true,
        ]);

        $table->update();
    }
}
