<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddExtraColumnsToOutgoingDocuments extends AbstractMigration
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
    
            $table->addColumn('packageSentViaSnailMail', 'boolean', [
                'default' => null,
                'null' => true,
            ]);
    
            $table->addColumn('mailNotes', 'string', [
                'default' => null,
                'null' => true,
            ]);
    
            $table->addColumn('ftpPortalUrl', 'string', [
                'default' => null,
                'null' => true,
            ]);
    
            $table->addColumn('ftpUsername', 'string', [
                'default' => null,
                'null' => true,
            ]);
    
            $table->addColumn('ftpPassword', 'string', [
                'default' => null,
                'null' => true,
            ]);
    
            $table->addColumn('EsmdPortalUrl', 'string', [
                'default' => null,
                'null' => true,
            ]);
    
            $table->addColumn('EsmdUsername', 'string', [
                'default' => null,
                'null' => true,
            ]);
    
            $table->addColumn('EsmdPassword', 'string', [
                'default' => null,
                'null' => true,
            ]);
    
            $table->addColumn('email', 'string', [
                'default' => null,
                'null' => true,
            ]);
    
            $table->addColumn('website', 'string', [
                'default' => null,
                'null' => true,
            ]);
    
            $table->addColumn('contactNumber', 'string', [
                'default' => null,
                'null' => true,
            ]);

    
            $table->update();
    }
}
