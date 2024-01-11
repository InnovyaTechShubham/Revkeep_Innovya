<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FacilityAddFormsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FacilityAddFormsTable Test Case
 */
class FacilityAddFormsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FacilityAddFormsTable
     */
    protected $FacilityAddForms;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.FacilityAddForms',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('FacilityAddForms') ? [] : ['className' => FacilityAddFormsTable::class];
        $this->FacilityAddForms = $this->getTableLocator()->get('FacilityAddForms', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->FacilityAddForms);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\FacilityAddFormsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
