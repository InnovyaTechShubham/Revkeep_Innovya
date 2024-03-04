<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateInsuranceProviderTypes extends AbstractMigration
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
        $table = $this->table('insurance_provider_types');
        $table
        ->addColumn('insurance_provider_type', 'string', ['null' => false])
        ->addIndex(['insurance_provider_type'], ['unique' => true])
        ->create();
    }
}
