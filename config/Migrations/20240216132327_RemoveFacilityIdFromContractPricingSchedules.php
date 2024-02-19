<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class RemoveFacilityIdFromContractPricingSchedules extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * @return void
     */
    public function change()
    {
        $table = $this->table('contract_pricing_schedules');
        $table->removeColumn('facility_id');
        $table->update();
    }
}
