<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class EmployeeFacility extends AbstractMigration
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
        $table = $this->table('employee_facilities');
        $table
            ->addColumn('client_id', 'integer', [
                'default' => null,
                'null' => false,
            ])
            ->addColumn('facility_id', 'integer', [
                'default' => null,
                'null' => false,
            ])
            ->addIndex(['client_id', 'facility_id'])
            ->create();
    }
}
