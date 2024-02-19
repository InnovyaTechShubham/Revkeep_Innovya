<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AllowNullallIdColumninFacilityContract extends AbstractMigration
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
        $this->table('facilities_contracts')
        ->dropForeignKey('contract_bill_type_id') // Drop the foreign key constraint
        ->update();
    
        $this->table('facilities_contracts')
        ->changeColumn('contract_bill_type_id', 'integer', [
            'default' => null,
            'null' => true,
        ])
        ->update();

        $this->table('facilities_contracts')
        ->dropForeignKey('contract_type_id') // Drop the foreign key constraint
        ->update();
    
        $this->table('facilities_contracts')
        ->changeColumn('contract_type_id', 'integer', [
            'default' => null,
            'null' => true,
        ])
        ->update();

        $this->table('facilities_contracts')
        ->dropForeignKey('service_operation_id') // Drop the foreign key constraint
        ->update();
    
        $this->table('facilities_contracts')
        ->changeColumn('service_operation_id', 'integer', [
            'default' => null,
            'null' => true,
        ])
        ->update();

        $this->table('facilities_contracts')
        ->dropForeignKey('ownership_type_id') // Drop the foreign key constraint
        ->update();
    
        $this->table('facilities_contracts')
        ->changeColumn('ownership_type_id', 'integer', [
            'default' => null,
            'null' => true,
        ])
        ->update();
    }
}
