<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ColorSetFixture
 *
 */
class ColorSetFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'color_set';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'users_id' => ['type' => 'integer', 'length' => 10, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'value' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => 'default', 'collate' => 'latin1_spanish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        '_indexes' => [
            'UserId' => ['type' => 'index', 'columns' => ['users_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'id' => ['type' => 'unique', 'columns' => ['id'], 'length' => []],
            'users_id' => ['type' => 'unique', 'columns' => ['users_id'], 'length' => []],
            'DelSetColor' => ['type' => 'foreign', 'columns' => ['users_id'], 'references' => ['users', 'id'], 'update' => 'noAction', 'delete' => 'cascade', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'latin1_spanish_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 1,
            'users_id' => 1,
            'value' => 'Lorem ipsum dolor sit amet'
        ],
    ];
}
