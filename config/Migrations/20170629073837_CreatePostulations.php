<?php
use Migrations\AbstractMigration;

class CreatePostulations extends AbstractMigration
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
        $table = $this->table('postulations');
        $table->addColumn('position_id', 'integer')
            ->addColumn('name', 'string', ['limit' => 50])
            ->addColumn('email', 'string', ['limit' => 50])
            ->addColumn('resume', 'string', ['limit' => 100])
            ->addColumn('created', 'datetime')
            ->addColumn('modified', 'datetime', ['null' => true]) 
            ->create();
    }
}
