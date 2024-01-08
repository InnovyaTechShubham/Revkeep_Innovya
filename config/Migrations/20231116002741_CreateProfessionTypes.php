<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateProfessionTypes extends AbstractMigration
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
        $table = $this->table('profession_types');
        $table
            ->addColumn('created', 'datetime', ['default' => null])
            ->addColumn('modified', 'datetime', ['default' => null])
            ->addColumn('deleted', 'datetime', ['null' => true, 'default' => null])
            ->addColumn('name', 'string')
            ->addColumn('audit_reviewer_id', 'integer',['null' => true, 'default' => null])
            ->insert([
                ['name' => 'Contact', 'created' => date('Y-m-d H:i:s'), 'modified' => date('Y-m-d H:i:s')],
                ['name' => 'Doctor', 'created' => date('Y-m-d H:i:s'), 'modified' => date('Y-m-d H:i:s')],
                ['name' => 'Judge', 'created' => date('Y-m-d H:i:s'), 'modified' => date('Y-m-d H:i:s')],
            ])
            ->create();
    }
}
