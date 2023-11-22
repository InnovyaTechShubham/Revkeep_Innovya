<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProfessionTypesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProfessionTypesTable Test Case
 */
class ProfessionTypesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProfessionTypesTable
     */
    protected $ProfessionTypes;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.ProfessionTypes',
        'app.AuditReviewers',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ProfessionTypes') ? [] : ['className' => ProfessionTypesTable::class];
        $this->ProfessionTypes = $this->getTableLocator()->get('ProfessionTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ProfessionTypes);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ProfessionTypesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\ProfessionTypesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
