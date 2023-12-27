<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddExtraColumnsToFacilities extends AbstractMigration
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
        $table = $this->table('facilities');
        $table
            ->addColumn('other_name', 'string', ['default' => null, 'limit' => 255, 'null' => true])
            ->addColumn('organization_subpart', 'boolean', ['default' => true, 'null' => true])
            ->addColumn('mailing_address', 'text', ['default' => null, 'null' => true])
            ->addColumn('mailing_phone', 'string', ['default' => null, 'limit' => 20, 'null' => true])
            ->addColumn('location_phone', 'string', ['default' => null, 'limit' => 20, 'null' => true])
            ->addColumn('additional_taxonomies', 'text', ['default' => null, 'null' => true])
            ->update();
    }
}
