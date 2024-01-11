<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateChains extends AbstractMigration
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
        $table = $this->table('chains');
        $table
            ->addColumn('chain_name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('chain_type', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true, // Adjust as needed
            ])
            ->addIndex(['id'], ['unique' => true])
            ->create();
    }
}
