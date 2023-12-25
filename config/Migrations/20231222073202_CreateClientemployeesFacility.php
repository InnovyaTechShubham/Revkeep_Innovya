<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateClientemployeesFacility extends AbstractMigration
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
        $table = $this->table('clientemployees_facility');
        $table
            ->addColumn('created', 'datetime', [
                'default' => null,
                'null' => false,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('facility_id', 'integer', [
                'default' => null,
                'null' => false,
            ])
            ->addColumn('client_id', 'integer', [
                'default' => null,
                'null' => false,
            ])
            ->create();
    }
}
