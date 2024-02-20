<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class Addappealcolfinance extends AbstractMigration
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
        $table = $this->table('appeals');
          // Add 'outstanding_amount' column
          $table->addColumn('outstanding_amount', 'decimal', [
            'default' => null,
            'null' => true,
        ]);

        // Add 'disputed_amount' column
        $table->addColumn('disputed_amount', 'decimal', [  
            'default' => null,
            'null' => true,
        ]);

        // Add 'reimbursed_amount' column
        $table->addColumn('reimbursed_amount', 'decimal', [
            'default' => null,
            'null' => true,
        ]);
        
        $table->update();
    }
}
