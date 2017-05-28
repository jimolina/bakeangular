<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

class ArticlesTable extends Table
{
    public function initialize(array $config)
    {
    	$this->belongsTo('Users');
    	$this->belongsTo('Status');
        $this->addBehavior('Timestamp');
    }

    public function getTotals()
    {
        return $this->getSummary()->count();
    }

    public function getSummary()
    {
    	$articles = TableRegistry::get('Articles');
        $query = $articles->find();

        $query->select(['owner' => $query->func()->concat($this->setOwnerName()), 'status' => 'Status.status'])
        	->select($articles)
        	->contain('Users')
        	->contain('Status')
        	->order(['Articles.id' => 'DESC']);

        return $query;
    }

    public function export($fields)
    {
    	$articles = TableRegistry::get('Articles');
        $query = $articles->find();

        $query->select($fields)
        	->select(['owner' => $query->func()->concat($this->setOwnerName()), 'status' => 'Status.status'])
        	->contain('Users')
        	->contain('Status')
        	->order(['Articles.id' => 'DESC']);

        return $query;
    }

    public function getRecord($id)
    {
    	$articles = TableRegistry::get('Articles');
        $query = $articles->find();

        $query->select(['owner' => $query->func()->concat($this->setOwnerName()), 'status' => 'Status.status'])
        	->select($articles)
        	->contain('Users')
        	->contain('Status')
        	->where([
        		'articles.id = :id'
    		])
    		->bind(':id', $id, 'integer')
        	->order(['Articles.id' => 'DESC']);

        return $query;
    }

	public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('title', 'create')
            ->notEmpty('title');

        $validator
            ->requirePresence('body', 'create')
            ->notEmpty('body');

        $validator
            ->allowEmpty('file')
            ->add('file', [
                'Invalid-Extension' => [
                    'rule' => ['extension',['gif', 'jpeg', 'png', 'jpg']], // default  ['gif', 'jpeg', 'png', 'jpg']
                    'message' => __('Only these files extension are allowed: .gif, .jpeg, .png, .jpg')
                ]
            ]);

        return $validator;
    }

    private function setOwnerName() 
    {
    	return ['Users.first_name' => 'identifier', ' ', 'Users.last_name' => 'identifier'];
    }
}