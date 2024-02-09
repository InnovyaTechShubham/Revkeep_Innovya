<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateFacilityStatus extends AbstractMigration
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
        $table = $this->table('facility_status');
        $table
        ->addColumn('status', 'string', [
            'limit' => 255,
            'null' => false,
        ])
        ->addColumn('created', 'datetime', [
            'default' => null,
            'null' => true,
        ])
        ->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => true,
        ])
        ->create();

    }
    public function seed()
{
    $data = [
        ['status' => 'Active'],
        ['status' => 'Inactive'],
        ['status' => 'Pending Term'],
    ];

    $table = $this->table('facility_status');
    $table->insert($data)->saveData();
}
}
