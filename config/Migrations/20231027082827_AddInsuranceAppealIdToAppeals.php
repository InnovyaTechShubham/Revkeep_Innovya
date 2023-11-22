<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddInsuranceAppealIdToAppeals extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function up()
    {
        $table = $this->table('appeals');
        $table->addColumn('insurance_appeal_id', 'integer', [
            'default' => null,
            'null' => true,
        ]);
        $table->update();
    }
}
