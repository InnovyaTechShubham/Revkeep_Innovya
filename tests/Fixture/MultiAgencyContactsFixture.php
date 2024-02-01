<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MultiAgencyContactsFixture
 */
class MultiAgencyContactsFixture extends TestFixture
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
                'agency_email' => 'Lorem ipsum dolor sit amet',
                'agency_fax' => 'Lorem ipsum dolor ',
                'desc_email' => 'Lorem ipsum dolor sit amet',
                'desc_fax' => 'Lorem ipsum dolor ',
            ],
        ];
        parent::init();
    }
}
