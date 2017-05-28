<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * Todos Model
 *
 * @method \App\Model\Entity\Todo get($primaryKey, $options = [])
 * @method \App\Model\Entity\Todo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Todo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Todo|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Todo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Todo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Todo findOrCreate($search, callable $callback = null, $options = [])
 */
class TodosTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('todos');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');
    }

    public function doneStatusTodo($id, $userID) {
        $todos = TableRegistry::get('Todos');
        $query = $todos->query();
        $query->update()
            ->set(['Todos.status' => 'done'])
            ->where(['Todos.id' => $id, 'Todos.user_id' => $userID])
            ->execute();

        return $query;
    }

    public function getSummary($userID, $limit=false, $order=false, $orderBy=false)
    {
        $todos = TableRegistry::get('Todos');
        $query = $todos->find();

        $query->select($todos)
            ->where([
                'Todos.user_id = :user'
            ])
            ->bind(':user', $userID, 'integer');

        if ($order) {
            $orderBy = ($orderBy) ? $orderBy : 'DESC';
            $query->order(['Todos.' . $order => $orderBy]);
        } else {
            $query->order(['Todos.id' => 'DESC']);
        }

        if ($limit) {
            $query->limit($limit);
        }

        return $query;
    }

    public function export($fields, $UserID)
    {
        $todos = TableRegistry::get('Todos');
        $query = $todos->find();

        $query->select($fields)
            ->where([
                'Todos.user_id = :user'
            ])
            ->bind(':user', $UserID, 'integer')
            ->order(['Todos.id' => 'DESC']);

        return $query;
    }

    public function getRecord($id, $UserID)
    {
        $todos = TableRegistry::get('Todos');
        $query = $todos->find();

        $query->select($todos)
            ->where([
                'Todos.id = :id',
                'Todos.user_id = :user'
            ])
            ->bind(':id', $id, 'integer')
            ->bind(':user', $UserID, 'integer')
            ->order(['Todos.id' => 'DESC']);

        return $query;
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('title', 'create')
            ->notEmpty('title');

        $validator
            ->requirePresence('description', 'create')
            ->notEmpty('description');

        $validator
            ->requirePresence('deadline', 'create')
            ->notEmpty('deadline');

        $validator
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        return $validator;
    }
}
