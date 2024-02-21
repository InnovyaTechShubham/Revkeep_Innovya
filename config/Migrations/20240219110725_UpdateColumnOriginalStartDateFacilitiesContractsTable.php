<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class UpdateColumnOriginalStartDateFacilitiesContractsTable extends AbstractMigration
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
            ->changeColumn('original_start_date', 'date', [
                'default' => null,
                'null' => true,
            ])
            ->changeColumn('term_date', 'date', [
                'default' => null,
                'null' => true,
            ])
            ->changeColumn('expiration_date', 'date', [
                'default' => null,
                'null' => true,
            ])
            ->changeColumn('contract_effective_date', 'date', [
                'default' => null,
                'null' => true,
            ])
            ->update();
    }
}
