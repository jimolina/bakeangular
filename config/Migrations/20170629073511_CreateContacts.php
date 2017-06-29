<?php
use Migrations\AbstractMigration;

class CreateContacts extends AbstractMigration
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
        $table = $this->table('contacts');
        $table->addColumn('name', 'string', ['limit' => 50])
            ->addColumn('phone', 'string', ['limit' => 20])
            ->addColumn('email', 'string', ['limit' => 50])
            ->addColumn('category', 'enum', ['values' => 'support, general info'])
            ->addColumn('comments', 'text')
            ->addColumn('created', 'datetime')
            ->addColumn('modified', 'datetime', ['null' => true])            
            ->create();
    }
}
