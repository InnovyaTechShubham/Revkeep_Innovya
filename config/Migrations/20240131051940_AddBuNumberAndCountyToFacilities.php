<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddBuNumberAndCountyToFacilities extends AbstractMigration
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
        $table = $this->table('facilities');
        $table->addColumn('bu_number', 'string', [
            'default' => null,
            'limit' => 60,
            'null' => true,
        ]);
        $table->addColumn('county', 'string', [
            'default' => null,
            'limit' => 60,
            'null' => true,
        ]);
        $table->update();
    }
}
