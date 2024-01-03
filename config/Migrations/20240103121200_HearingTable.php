<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class HearingTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    
     // Inside the migration file
public function change()
{
    $table = $this->table('hearing_details');
    $table
        ->addColumn('appealLevelId', 'integer', [
            'default' => null,
            'null' => false,
        ])
        ->addColumn('hearingDate', 'date', [
            'default' => null,
            'null' => true,
        ])
        ->addColumn('hearingTime', 'time', [
            'default' => null,
            'null' => true,
        ])
        ->addColumn('meetingType', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ])
        ->create();
}

}
