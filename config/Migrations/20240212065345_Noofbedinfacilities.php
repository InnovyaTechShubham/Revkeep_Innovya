<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class Noofbedinfacilities extends AbstractMigration
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
        $table->addColumn('skilled', 'integer', [
            'default' => null,
            'limit' => 11, 
            'null' => true,
        ]);
        $table->addColumn('ltc', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);
        $table->addColumn('ai', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);
        $table->addColumn('il', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);
        
        $table->update();
    }
}
