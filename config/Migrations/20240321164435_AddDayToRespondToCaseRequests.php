<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddDayToRespondToCaseRequests extends AbstractMigration
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
        $table = $this->table('case_requests');
        $table
            ->addColumn('day_to_respond', 'integer', [
                'default' => 0,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('day_to_decision', 'integer', [
                'default' => 0,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('estimated', 'boolean', [
                'default' => false, // Assuming default value is false
                'null' => false,
            ])
        ->update();
    }
}
