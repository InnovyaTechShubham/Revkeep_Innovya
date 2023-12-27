<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddColumnsToClientEmployees extends AbstractMigration
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
        $table = $this->table('client_employees');

        $table->addColumn('gender', 'string', [
            'default' => null,
            'null' => true,
        ]);

        $table->addColumn('enumeration_type', 'string', [
            'default' => null,
            'null' => true,
        ]);

        $table->addColumn('address_1', 'string', [
            'default' => null,
            'null' => true,
        ]);

        $table->addColumn('address_2', 'string', [
            'default' => null,
            'null' => true,
        ]);

        $table->addColumn('taxonomy_code', 'string', [
            'default' => null,
            'null' => true,
        ]);

        $table->addColumn('taxonomy_desc', 'string', [
            'default' => null,
            'null' => true,
        ]);

        $table->addColumn('taxonomy_license', 'string', [
            'default' => null,
            'null' => true,
        ]);

        $table->addColumn('taxonomy_state', 'string', [
            'default' => null,
            'null' => true,
        ]);

        $table->addColumn('taxonomy_group', 'string', [
            'default' => null,
            'null' => true,
        ]);

        $table->update();
    }
}
