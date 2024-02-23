<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class UpdateColumnTypeinFacRecMethods extends AbstractMigration
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
        $this->table('facilities_receivingmethods')
            ->changeColumn('receiving_email_id', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->update();
        $this->table('facilities_receivingmethods')
        ->changeColumn('receiving_fax_id', 'string', [
            'default' => null,
            'null' => true,
        ])
        ->update();
    }
}
