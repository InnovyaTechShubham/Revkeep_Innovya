<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AllowNullinFacilityTypesinFacilities extends AbstractMigration
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
        ->dropForeignKey('facility_type_id') // Drop the foreign key constraint
        ->update();
    
        $this->table('facilities')
        ->changeColumn('facility_type_id', 'integer', [
            'default' => null,
            'null' => true,
        ])
        ->update();
    }
}
