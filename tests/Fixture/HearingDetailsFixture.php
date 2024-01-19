<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * HearingDetailsFixture
 */
class HearingDetailsFixture extends TestFixture
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
                'appealLevelId' => 1,
                'hearingDate' => '2024-01-03',
                'hearingTime' => '07:19:54',
                'meetingType' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
