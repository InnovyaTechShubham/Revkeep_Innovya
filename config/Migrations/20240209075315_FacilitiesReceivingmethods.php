<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class FacilitiesReceivingmethods extends AbstractMigration
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
        $table = $this->table('facilities_receivingmethods');
    
        // Modify the columns as needed
        $table
            ->changeColumn('receiving_email_id', 'biginteger', [
                'default' => null,
                'null' => true,
            ])
            ->changeColumn('receiving_fax_id', 'biginteger', [
                'default' => null,
                'null' => true,
            ])
            ->update();
    }
}
