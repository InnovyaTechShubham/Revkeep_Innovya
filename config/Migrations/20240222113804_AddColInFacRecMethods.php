<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddColInFacRecMethods extends AbstractMigration
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
        $table->addColumn('email_desc', 'string', [
            'default' => null,
            'limit' => 500,
            'null' => true,
        ]);
        $table->update();
        $table->addColumn('fax_desc', 'string', [
            'default' => null,
            'limit' => 500,
            'null' => true,
        ]);
        $table->update();
    }
}
