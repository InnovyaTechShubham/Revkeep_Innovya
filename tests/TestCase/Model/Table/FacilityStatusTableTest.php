<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FacilityStatusTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FacilityStatusTable Test Case
 */
class FacilityStatusTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FacilityStatusTable
     */
    protected $FacilityStatus;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.FacilityStatus',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('FacilityStatus') ? [] : ['className' => FacilityStatusTable::class];
        $this->FacilityStatus = $this->getTableLocator()->get('FacilityStatus', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->FacilityStatus);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\FacilityStatusTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
