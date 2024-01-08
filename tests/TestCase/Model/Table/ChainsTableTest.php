<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ChainsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ChainsTable Test Case
 */
class ChainsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ChainsTable
     */
    protected $Chains;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Chains',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Chains') ? [] : ['className' => ChainsTable::class];
        $this->Chains = $this->getTableLocator()->get('Chains', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Chains);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ChainsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
