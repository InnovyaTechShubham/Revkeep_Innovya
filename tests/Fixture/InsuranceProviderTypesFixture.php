<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * InsuranceProviderTypesFixture
 */
class InsuranceProviderTypesFixture extends TestFixture
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
                'insurance_provider_type' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
