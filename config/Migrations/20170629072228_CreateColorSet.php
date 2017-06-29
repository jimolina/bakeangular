<?php
use Migrations\AbstractMigration;

class CreateColorSet extends AbstractMigration
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
        $table = $this->table('color_set');
        $table->addColumn('user_id', 'integer')
            ->addColumn('value', 'string', ['limit' => 50]);

        // Add a unique key
        $table->addIndex(['user_id'], ['unique' => true]);
        
        $table->create();
    }
}
