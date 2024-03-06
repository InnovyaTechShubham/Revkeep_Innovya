<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddManagedByToCases extends AbstractMigration
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
        $table
        ->addColumn('managed_by', 'integer', ['null' => true, 'default' => null])
        ->addColumn('insurance_provider_type', 'integer', ['null' => true, 'default' => null])
        ->update();
    }
}
