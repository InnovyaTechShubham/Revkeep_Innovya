<?php

declare(strict_types=1);

use Migrations\AbstractMigration;

class UpdatePrimaryTaxonomyLimit extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('facilities');
        $table->changeColumn('primary_taxonomy', 'string', [
            'limit' => 255,
            'null' => true,
        ]);
        $table->save();
    }
}
