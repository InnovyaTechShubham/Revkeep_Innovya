<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddNulltoStatusinFacilityContract extends AbstractMigration
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
        $this->table('facilities_contracts')
        ->changeColumn('status', 'string', [
            'default' => null,
            'null' => true,
        ])
        ->update();
    }
}
