<?php

use Phinx\Migration\AbstractMigration;

class CreatePositionsTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $table = $this->table('positions');
        $table->addColumn('title', 'string', ['limit' => 50])
            ->addColumn('location', 'string', ['limit' => 50])
            ->addColumn('type', 'enum', ['values' => 'Part Time, Full Time, Contract, Contract - to Hire'])
            ->addColumn('summary', 'text')
            ->addColumn('responsibilities', 'text')
            ->addColumn('skills', 'text')
            ->addColumn('experience', 'text')
            ->addColumn('education', 'text')
            ->addColumn('status_id', 'integer')
            ->addColumn('created', 'datetime')
            ->addColumn('modified', 'datetime', ['null' => true]) 
            ->create();
    }
}
