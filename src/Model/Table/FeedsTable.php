<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Cake\I18n\Time;

/**
 * Feeds Model
 *
 * @method \App\Model\Entity\Feed get($primaryKey, $options = [])
 * @method \App\Model\Entity\Feed newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Feed[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Feed|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Feed patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Feed[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Feed findOrCreate($search, callable $callback = null, $options = [])
 */
class FeedsTable extends Table
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

        $this->setTable('feeds');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
    }

    public function getSummary($limit=false, $order=false, $orderBy=false)
    {
        $todos = TableRegistry::get('Feeds');
        $query = $todos->find();

        $query->select($todos);

        if ($order) {
            $orderBy = ($orderBy) ? $orderBy : 'DESC';
            $query->order(['Feeds.' . $order => $orderBy]);
        } else {
            $query->order(['Feeds.id' => 'DESC']);
        }

        if ($limit) {
            $query->limit($limit);
        }

        return $query;
    }

    /**
     * Save the feed
     * @param  [array] $data ['type', 'page', 'user', 'action']
     */
    public function saveFeed($data)
    {
        $feeds = TableRegistry::get('Feeds');

        $query = $feeds->query();
        $query->insert(['type', 'page', 'user', 'action', 'date'])
            ->values([
                'type' => $data['type'],
                'page' => $data['page'],
                'user' => $data['user'],
                'action' => $data['action'],
                'date' => Time::now()
            ])
            ->execute();
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
            ->requirePresence('type', 'create')
            ->notEmpty('type');

        $validator
            ->requirePresence('page', 'create')
            ->notEmpty('page');

        $validator
            ->requirePresence('user', 'create')
            ->notEmpty('user');

        $validator
            ->requirePresence('action', 'create')
            ->notEmpty('action');

        $validator
            ->dateTime('date')
            ->requirePresence('date', 'create')
            ->notEmpty('date');

        return $validator;
    }
}
