<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ClientemployeesFacilityTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ClientemployeesFacilityTable Test Case
 */
class ClientemployeesFacilityTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ClientemployeesFacilityTable
     */
    protected $ClientemployeesFacility;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.ClientemployeesFacility',
        'app.Facilities',
        'app.Clients',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ClientemployeesFacility') ? [] : ['className' => ClientemployeesFacilityTable::class];
        $this->ClientemployeesFacility = $this->getTableLocator()->get('ClientemployeesFacility', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ClientemployeesFacility);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ClientemployeesFacilityTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\ClientemployeesFacilityTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
