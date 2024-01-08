<?php

declare(strict_types=1);

use Migrations\AbstractMigration;

class NewFieldsForCasesAndAppeals extends AbstractMigration
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
		$this->table('cases')
			->addColumn('discipline_id', 'integer', [
				'default' => null,
				'limit' => 10,
				'null' => true,
			])
			->save();

		$this->table('appeals')
			->addColumn('audit_reviewer_id', 'integer', [
				'default' => null,
				'limit' => 10,
				'null' => true,
			])
			->save();
	}
}
