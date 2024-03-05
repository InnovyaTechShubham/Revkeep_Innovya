<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddisEncoreColumnToFacilities extends AbstractMigration
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
        $table->addColumn('is_encore', 'integer', [
            'default' => 0,
            'null' => false,
        ]);
        $table->update();
    }
}
