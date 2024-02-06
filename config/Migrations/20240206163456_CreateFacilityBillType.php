<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateFacilityBillType extends AbstractMigration
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
        $table = $this->table('facility_bill_type');
        $table
        ->addColumn('bill_type', 'string', [
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
            ['bill_type' => 'Direct Bill'],
            ['bill_type' => 'Contract Bill'],
            ['bill_type' => 'GHC'],
            ['bill_type' => 'Synergy'],
            ['bill_type' => 'Others'],
        ];

        $table = $this->table('facility_bill_type');
        $table->insert($data)->saveData();
    }
}




