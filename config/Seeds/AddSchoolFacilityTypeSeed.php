<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * AddSchoolFacilityType seed.
 */
class AddSchoolFacilityTypeSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     *
     * @return void
     */
    public function run(): void
    {
        $date = date('Y-m-d H:i:s');

		$data = [
			[
				'created' => $date,
				'modified' => $date,
				'name' => 'School',
			],
        ];
        $table = $this->table('facility_types');
        $table->insert($data)->save();
    }
}
