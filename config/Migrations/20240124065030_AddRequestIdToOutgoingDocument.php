<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddRequestIdToOutgoingDocument extends AbstractMigration
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

        
        $table->addColumn('request_id', 'string', [
            'default' => null,
            'null' => true,
        ]);


        $table->update();
    }
}
