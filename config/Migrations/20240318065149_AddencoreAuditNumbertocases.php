<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddencoreAuditNumbertocases extends AbstractMigration
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
        $table = $this->table('cases');
        $table->addColumn('encore_audit_number', 'string', [
            'default' => null,
            'limit' => 50,
            'null' => true,
        ])
        ->update();
    }
}
