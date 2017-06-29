<?php
use Migrations\AbstractMigration;

class CreateArticles extends AbstractMigration
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
        $table = $this->table('articles');
        $table->addColumn('title', 'string')
            ->addColumn('body', 'text')
            ->addColumn('image', 'string', ['limit' => 100, 'null' => true])
            ->addColumn('user_id', 'integer')
            ->addColumn('status_id', 'integer')
            ->addColumn('created', 'datetime')
            ->addColumn('modified', 'datetime', ['null' => true])            
            ->create();
    }
}
