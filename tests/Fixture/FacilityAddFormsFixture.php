<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * FacilityAddFormsFixture
 */
class FacilityAddFormsFixture extends TestFixture
{
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
                'f_name' => 'Lorem ipsum dolor sit amet',
                'l_name' => 'Lorem ipsum dolor sit amet',
                'phone_no' => 'Lorem ip',
                'contact_id' => 'Lorem ipsum dolor sit amet',
                'email' => 'Lorem ipsum dolor sit amet',
                'title_id' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
