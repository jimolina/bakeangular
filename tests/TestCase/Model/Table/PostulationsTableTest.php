<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PostulationsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PostulationsTable Test Case
 */
class PostulationsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PostulationsTable
     */
    public $Postulations;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.postulations',
        'app.positions',
        'app.statuses'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Postulations') ? [] : ['className' => 'App\Model\Table\PostulationsTable'];
        $this->Postulations = TableRegistry::get('Postulations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Postulations);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
