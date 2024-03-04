<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InsuranceProviderTypesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InsuranceProviderTypesTable Test Case
 */
class InsuranceProviderTypesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\InsuranceProviderTypesTable
     */
    protected $InsuranceProviderTypes;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.InsuranceProviderTypes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('InsuranceProviderTypes') ? [] : ['className' => InsuranceProviderTypesTable::class];
        $this->InsuranceProviderTypes = $this->getTableLocator()->get('InsuranceProviderTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->InsuranceProviderTypes);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\InsuranceProviderTypesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
