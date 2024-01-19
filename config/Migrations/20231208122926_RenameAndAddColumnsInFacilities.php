<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class RenameAndAddColumnsInFacilities extends AbstractMigration
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
            ->renameColumn('location_address', 'street_address_1')
            ->addColumn('location_address', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->update();
    }
}
