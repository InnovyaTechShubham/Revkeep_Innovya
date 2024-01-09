<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class ModifyClientEmployees extends AbstractMigration
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
        $table = $this->table('client_employees');

        // Remove existing columns
        $table->removeColumn('taxonomy_code')
            ->removeColumn('taxonomy_desc')
            ->removeColumn('taxonomy_group')
            ->removeColumn('taxonomy_license')
            ->removeColumn('taxonomy_state');

        // Add new columns
        $table->addColumn('othername', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('proprietor', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('locationPhoneNumber', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('mailingPhoneNumber', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('primaryTaxonomy', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('additionalTaxonomies', 'text', [
                'default' => null,
                'null' => true,
            ])
            ->update();
    }
}
