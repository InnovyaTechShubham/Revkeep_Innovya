<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class DropforiegnkeyconstrainsinContPriSch extends AbstractMigration
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
        $this->table('contract_pricing_schedules')
        ->dropForeignKey('insurance_type_id')
        ->update();
    }
}