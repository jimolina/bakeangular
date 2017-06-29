<?php
use Migrations\AbstractMigration;

class CreatePages extends AbstractMigration
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
        $table = $this->table('pages');
        $table->addColumn('title', 'string')
            ->addColumn('body', 'text')
            ->addColumn('user_id', 'integer')
            ->addColumn('status_id', 'integer')
            ->create();
    }
}
