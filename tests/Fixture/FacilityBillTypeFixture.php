<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * FacilityBillTypeFixture
 */
class FacilityBillTypeFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'facility_bill_type';
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
                'bill_type' => 'Lorem ipsum dolor sit amet',
                'created' => '2024-02-06 11:53:19',
                'modified' => '2024-02-06 11:53:19',
            ],
        ];
        parent::init();
    }
}
