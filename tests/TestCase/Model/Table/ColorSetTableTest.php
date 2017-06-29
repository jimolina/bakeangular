<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ColorSetTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ColorSetTable Test Case
 */
class ColorSetTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ColorSetTable
     */
    public $ColorSet;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.color_set',
        'app.users',
        'app.status',
        'app.articles'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ColorSet') ? [] : ['className' => 'App\Model\Table\ColorSetTable'];
        $this->ColorSet = TableRegistry::get('ColorSet', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ColorSet);

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
