<?php
use Migrations\AbstractMigration;

class CreateTodos extends AbstractMigration
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
        $table = $this->table('todos');
        $table->addColumn('title', 'string', ['limit' => 50])
            ->addColumn('description', 'text')
            ->addColumn('deadline', 'datetime')
            ->addColumn('status', 'enum', ['values' => 'Done, Pending, Cancel'])
            ->addColumn('user_id', 'integer')
            ->create();
    }
}
