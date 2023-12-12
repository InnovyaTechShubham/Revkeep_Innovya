<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class RenameColumnsInFacilities extends AbstractMigration
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
        $table
            ->renameColumn('street_address_1', 'location_address')
            ->update(); 
    }
}
