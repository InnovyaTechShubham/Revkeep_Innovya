<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class FacilityContactsTable extends AbstractMigration
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
        $this->table('facility_contacts')
			

			->addColumn('first_name', 'string', [
				'default' => null,
				'limit' => 50,
				'null' => false,
			])
            ->addColumn('last_name', 'string', [
				'default' => null,
				'limit' => 50,
				'null' => false,
			])
			->addColumn('email', 'string', [
				'default' => null,
				'limit' => 50,
				'null' => true,
			])
			->addColumn('phone', 'string', [
				'default' => null,
				'limit' => 50,
				'null' => true,
			])
			->addColumn('contact_id', 'string', [
				'default' => null,
				'limit' => 50,
				'null' => true,
			])
			->addColumn('title_id', 'string', [
				'default' => null,
				'limit' => 50,
				'null' => true,
			])
			->create();
    }
}
