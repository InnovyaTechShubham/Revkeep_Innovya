<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddFaxColumnToOutgoingDocuments extends AbstractMigration
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

        
        $table->addColumn('fax', 'string', [
            'default' => null,
            'null' => true,
        ]);


        $table->update();
}

}
