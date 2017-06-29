<?php
use Migrations\AbstractMigration;

class CreateParameters extends AbstractMigration
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
        $table = $this->table('parameters');
        $table->addColumn('name', 'string', ['limit' => 50])
            ->addColumn('value', 'text')
            ->create();
    }
}
