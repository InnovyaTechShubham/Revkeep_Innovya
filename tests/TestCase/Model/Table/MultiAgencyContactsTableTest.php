<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MultiAgencyContactsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MultiAgencyContactsTable Test Case
 */
class MultiAgencyContactsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MultiAgencyContactsTable
     */
    protected $MultiAgencyContacts;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.MultiAgencyContacts',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('MultiAgencyContacts') ? [] : ['className' => MultiAgencyContactsTable::class];
        $this->MultiAgencyContacts = $this->getTableLocator()->get('MultiAgencyContacts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->MultiAgencyContacts);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\MultiAgencyContactsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
