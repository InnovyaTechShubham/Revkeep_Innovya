<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddForeignKeyToContractPricingSchedules extends AbstractMigration
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
        $table = $this->table('contract_pricing_schedules');
        $table->addColumn('facility_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->update();
        
        $table->addForeignKey(
            'facility_id',
            'facilities',
            'id',
            ['delete' => 'CASCADE', 'update' => 'CASCADE']
        );
    }
}