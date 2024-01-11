<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProfessionTypesFixture
 */
class ProfessionTypesFixture extends TestFixture
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
                'created' => '2023-11-16 06:36:52',
                'modified' => '2023-11-16 06:36:52',
                'deleted' => '2023-11-16 06:36:52',
                'name' => 'Lorem ipsum dolor sit amet',
                'audit_reviewer_id' => 1,
            ],
        ];
        parent::init();
    }
}
