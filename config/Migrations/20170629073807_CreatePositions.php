<?php
use Migrations\AbstractMigration;

class CreatePositions extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
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
