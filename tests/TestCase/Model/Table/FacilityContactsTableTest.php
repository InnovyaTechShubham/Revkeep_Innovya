<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FacilityContactsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FacilityContactsTable Test Case
 */
class FacilityContactsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FacilityContactsTable
     */
    protected $FacilityContacts;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.FacilityContacts',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('FacilityContacts') ? [] : ['className' => FacilityContactsTable::class];
        $this->FacilityContacts = $this->getTableLocator()->get('FacilityContacts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->FacilityContacts);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\FacilityContactsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
