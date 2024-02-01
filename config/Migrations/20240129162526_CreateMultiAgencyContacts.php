<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateMultiAgencyContacts extends AbstractMigration
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
            ->addColumn('agency_email', 'string', ['limit' => 255])
            ->addColumn('agency_fax', 'string', ['limit' => 20, 'null' => true])
            ->addColumn('desc_email', 'string', ['limit' => 255])
            ->addColumn('desc_fax', 'string', ['limit' => 20, 'null' => true])
            ->create();
    }
}
