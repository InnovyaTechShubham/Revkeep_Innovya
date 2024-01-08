<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddNameColumnToClientFacility extends AbstractMigration
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
        $table = $this->table('clientemployees_facility');
        $table->addColumn('name', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);

        $table->update();
    }
}
