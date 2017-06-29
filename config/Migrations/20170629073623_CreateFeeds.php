<?php
use Migrations\AbstractMigration;

class CreateFeeds extends AbstractMigration
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
        $table = $this->table('feeds');
        $table->addColumn('type', 'enum', ['values' => 'activities, system'])
            ->addColumn('page', 'string', ['limit' => 50])
            ->addColumn('user', 'string', ['limit' => 50])
            ->addColumn('action', 'string')
            ->addColumn('date', 'datetime')
            ->create();
    }
}
