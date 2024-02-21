<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class DropfinalColumnpricingScheduleIdFacilitiesContractsTable extends AbstractMigration
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
        ->dropForeignKey('pricing_schedule_id') // Drop the foreign key constraint
        ->update();
    
    $this->table('facilities_contracts')
        ->removeColumn('pricing_schedule_id') // Remove the column
        ->update();
    }
}
