<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\HearingDetailsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\HearingDetailsTable Test Case
 */
class HearingDetailsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\HearingDetailsTable
     */
    protected $HearingDetails;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.HearingDetails',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('HearingDetails') ? [] : ['className' => HearingDetailsTable::class];
        $this->HearingDetails = $this->getTableLocator()->get('HearingDetails', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->HearingDetails);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\HearingDetailsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
