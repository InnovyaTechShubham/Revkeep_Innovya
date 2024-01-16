<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class ChainOrganizations extends AbstractMigration
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
        $table = $this->table('chain_organizations');
        $table
            ->renameColumn('facility_id', 'org_id', ['default' => null, 'null' => true])
            ->renameColumn('service_id', 'desc', ['default' => null, 'null' => true])
            ->update();
    }
}
