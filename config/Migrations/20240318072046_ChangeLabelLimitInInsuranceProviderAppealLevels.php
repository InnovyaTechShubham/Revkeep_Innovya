<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class ChangeLabelLimitInInsuranceProviderAppealLevels extends AbstractMigration
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
        $table = $this->table('insurance_provider_appeal_levels');
        $table->changeColumn('label', 'string', [
            'default' => null,
            'limit' => 30, // Change the limit to 30
            'null' => true,
        ])
        ->update();
    }
}
