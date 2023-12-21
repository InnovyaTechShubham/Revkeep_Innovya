<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FacilityAddContactsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FacilityAddContactsTable Test Case
 */
class FacilityAddContactsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FacilityAddContactsTable
     */
    protected $FacilityAddContacts;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.FacilityAddContacts',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('FacilityAddContacts') ? [] : ['className' => FacilityAddContactsTable::class];
        $this->FacilityAddContacts = $this->getTableLocator()->get('FacilityAddContacts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->FacilityAddContacts);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\FacilityAddContactsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
