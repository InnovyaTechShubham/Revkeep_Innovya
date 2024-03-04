<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class UpdateDefaultValueColinContractInsuranceTypes extends AbstractMigration
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
        $table = $this->table('contract_insurance_types');
        $table->changeColumn('default_value', 'float', [
            'default' => null,
            'null' => true,
        ]);
        $table->update();
    }
}
