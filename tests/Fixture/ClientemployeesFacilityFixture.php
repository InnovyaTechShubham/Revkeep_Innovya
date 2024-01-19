<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ClientemployeesFacilityFixture
 */
class ClientemployeesFacilityFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'clientemployees_facility';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'created' => '2023-12-22 02:35:23',
                'deleted' => '2023-12-22 02:35:23',
                'facility_id' => 1,
                'client_id' => 1,
            ],
        ];
        parent::init();
    }
}
