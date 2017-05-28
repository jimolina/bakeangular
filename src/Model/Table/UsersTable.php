<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

class UsersTable extends Table
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

        $this->setTable('users');
        $this->setDisplayField('first_name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Status', [
            'foreignKey' => 'status_id',
            'joinType' => 'INNER'
        ]);

        $this->addBehavior('Timestamp');
    }

    public function getTotals($role)
    {
        return $this->getUsersByRole($role)->count();
    }

    public function getUsersByRole($role)
    {
        $users = TableRegistry::get('Users');
        $query = $users->find();

        $query->select(['status' => 'Status.status'])
            ->select($users)
            ->contain('Status')
            ->where([
                'users.role = :role'
            ])
            ->bind(':role', $role, 'string')
            ->order(['Users.id' => 'DESC']);

        return $query;
    }

    public function getSummary()
    {
        $users = TableRegistry::get('Users');
        $query = $users->find();

        $query->select(['status' => 'Status.status'])
            ->select($users)
            ->contain('Status')
            ->order(['Users.id' => 'DESC']);

        return $query;
    }

    public function export($fields)
    {
        $users = TableRegistry::get('Users');
        $query = $users->find();

        $query->select($fields)
            ->select(['status' => 'Status.status'])
            ->contain('Status')
            ->order(['Users.id' => 'DESC']);

        return $query;
    }

    public function getRecord($id)
    {
        $users = TableRegistry::get('Users');
        $query = $users->find();

        $query->select(['status' => 'Status.status'])
            ->select($users)
            ->contain('Status')
            ->where([
                'users.id = :id'
            ])
            ->bind(':id', $id, 'integer')
            ->order(['Users.id' => 'DESC']);

        return $query;
    }

    public function validationDefault(Validator $validator)
    {
        return $validator
            ->notEmpty('username', 'A username is required')
            ->notEmpty('password', 'A password is required')
            ->notEmpty('role', 'A role is required')
            ->add('role', 'inList', [
                'rule' => ['inList', ['admin', 'author', 'newsletter']],
                'message' => 'Please enter a valid role'
            ]);
    }

}