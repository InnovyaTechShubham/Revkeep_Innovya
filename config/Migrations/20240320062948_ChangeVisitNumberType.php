<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class ChangeVisitNumberType extends AbstractMigration
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
        // Change the datatype of visit_number from nvarchar to string
        $this->table('cases')
            ->changeColumn('visit_number', 'string', [
                'default' => null,
                'limit' => 255, 
                'null' => true,
            ])
            ->update();
    }
}
