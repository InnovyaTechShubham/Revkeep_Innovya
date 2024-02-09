<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FacilityBillTypeTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FacilityBillTypeTable Test Case
 */
class FacilityBillTypeTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FacilityBillTypeTable
     */
    protected $FacilityBillType;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.FacilityBillType',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('FacilityBillType') ? [] : ['className' => FacilityBillTypeTable::class];
        $this->FacilityBillType = $this->getTableLocator()->get('FacilityBillType', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->FacilityBillType);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\FacilityBillTypeTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
