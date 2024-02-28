<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddTermDateToCasesTable extends AbstractMigration
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
        $table = $this->table('cases');

        // Add column1
        $table->addColumn('term_date', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);

        // Add column2
        $table->addColumn('insuranceRateType', 'integer', [
            'default' => null,
            'null' => true,
        ]);

        // Add column3
        $table->addColumn('pwrbackDenialReason', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);

        $table->update();
    }
}
