<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreatePowerbackDenialReasons extends AbstractMigration
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
        $table = $this->table('powerback_denial_reasons');
        $table->addColumn('reason', 'string', ['limit' => 500]);
        $table->create();
    }
}
