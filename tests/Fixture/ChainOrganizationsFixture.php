<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ChainOrganizationsFixture
 */
class ChainOrganizationsFixture extends TestFixture
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
                'chain_id' => 'Lorem ipsum dolor sit amet',
                'facility_id' => 'Lorem ipsum dolor sit amet',
                'service_id' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
