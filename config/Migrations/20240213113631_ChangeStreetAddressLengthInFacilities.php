<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class ChangeStreetAddressLengthInFacilities extends AbstractMigration
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
        $this->table('facilities')
        ->changeColumn('street_address_1', 'string', [
            'length' => 255,
            'null' => false,
        ])
        ->update();
    }
}
