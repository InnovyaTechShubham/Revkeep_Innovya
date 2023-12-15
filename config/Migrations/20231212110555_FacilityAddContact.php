<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class FacilityAddContact extends AbstractMigration
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
        $table = $this->table('facility_add_contacts');
$table
  //  ->addColumn('column1', 'string', ['limit' => 255])
  //  ->addColumn('column2', 'text', ['null' => true])
  ->addColumn('first_name', 'string', [
    'default' => null,
    'limit' => 255,
    'null' => true,
])
->addColumn('last_name', 'string', [
    'default' => null,
    'limit' => 255,
    'null' => true,
])

->addColumn('mobile_no', 'string', [
    'default' => null,
    'limit' => 10,
    'null' => true,
])

->addColumn('contact_type', 'string', [
    'values' => ['Mobile', 'Landline', 'Phone'],
    'default' => 'Mobile',
    'null' => true,
])

->addColumn('email', 'string', [
    'default' => null,
    'limit' => 255,
    'null' => true,
])

->addColumn('title', 'string', [
    'values' => ['Doctor', 'Nurse', 'Driver', 'Engineer'],
    'default' => 'Engineer',
    'null' => true,
])

    ->create();
    }
    
}
