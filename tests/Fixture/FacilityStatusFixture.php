<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * FacilityStatusFixture
 */
class FacilityStatusFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'facility_status';
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
                'status' => 'Lorem ipsum dolor sit amet',
                'created' => '2024-02-06 06:35:35',
                'modified' => '2024-02-06 06:35:35',
            ],
        ];
        parent::init();
    }
}
