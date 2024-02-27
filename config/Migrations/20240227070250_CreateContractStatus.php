<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateContractStatus extends AbstractMigration
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
        $table = $this->table('contract_status');
        $table
            ->addColumn('contract_status', 'string', [
                'limit' => 20,
                'default' => 'Active', // Optional: Set default value
                'null' => true // Optional: Set to false if this column cannot be null
            ])
            ->create();
    }

}
