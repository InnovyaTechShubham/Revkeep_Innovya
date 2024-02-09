<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class ChangeColumnTypeInCases extends AbstractMigration
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
        $this->table('cases')
        ->changeColumn('contract_paid_amt_est', 'decimal', [
           
            'default' => null,
			'null' => true,
			'precision' => 19,
			'scale' => 4,
        ])
        ->update();
    }
}
