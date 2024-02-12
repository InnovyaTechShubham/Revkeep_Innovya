<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddAgencyNameToMultiAgencyContacts extends AbstractMigration
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
        $table = $this->table('multi_agency_contacts');
        $table
            ->addColumn('agency_name', 'string', ['limit' => 255, 'after' => 'desc_fax'])
            ->update();
    }
}