<?php
use Migrations\AbstractMigration;

class CreateStatus extends AbstractMigration
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
        $table = $this->table('status');
        $table->addColumn('status', 'string', ['limit' => 50])
            ->create();
    }
}
