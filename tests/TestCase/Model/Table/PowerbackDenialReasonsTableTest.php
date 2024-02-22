<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PowerbackDenialReasonsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PowerbackDenialReasonsTable Test Case
 */
class PowerbackDenialReasonsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PowerbackDenialReasonsTable
     */
    protected $PowerbackDenialReasons;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.PowerbackDenialReasons',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('PowerbackDenialReasons') ? [] : ['className' => PowerbackDenialReasonsTable::class];
        $this->PowerbackDenialReasons = $this->getTableLocator()->get('PowerbackDenialReasons', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->PowerbackDenialReasons);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\PowerbackDenialReasonsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
