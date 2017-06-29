<?php
use Migrations\AbstractMigration;

class CreateUsers extends AbstractMigration
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
        $table = $this->table('users');
        $table->addColumn('first_name', 'string', ['limit' => 50])
            ->addColumn('last_name', 'string', ['limit' => 50])
            ->addColumn('username', 'string', ['limit' => 50, 'null' => true])
            ->addColumn('password', 'string', ['null' => true])
            ->addColumn('role', 'enum', ['values' => 'admin, author, newsletter'])
            ->addColumn('email', 'string', ['limit' => 50])
            ->addColumn('status_id', 'integer')
            ->addColumn('created', 'datetime')
            ->addColumn('modified', 'datetime', ['null' => true]);

        // Add a unique key
        $table->addIndex(['username', 'email'], ['unique' => true]);
        
        $table->create();
    }
}
