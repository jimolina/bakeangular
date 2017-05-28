<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * Pages Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users\BelongsTo $Status
 *
 * @method \App\Model\Entity\Page get($primaryKey, $options = [])
 * @method \App\Model\Entity\Page newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Page[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Page|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Page patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Page[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Page findOrCreate($search, callable $callback = null, $options = [])
 */
class PagesTable extends Table
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

        $this->setTable('pages');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('Status', [
            'foreignKey' => 'status_id',
            'joinType' => 'INNER'
        ]);
    }

    public function getSummary()
    {
        $pages = TableRegistry::get('Pages');
        $query = $pages->find();

        $query->select(['owner' => $query->func()->concat($this->setOwnerName()), 'status' => 'Status.status'])
            ->select($pages)
            ->contain('Users')
            ->contain('Status')
            ->order(['Pages.id' => 'DESC']);

        return $query;
    }

    public function export($fields)
    {
        $pages = TableRegistry::get('Pages');
        $query = $pages->find();

        $query->select($fields)
            ->select(['owner' => $query->func()->concat($this->setOwnerName()), 'status' => 'Status.status'])
            ->contain('Users')
            ->contain('Status')
            ->order(['Pages.id' => 'DESC']);

        return $query;
    }

    public function getRecord($id)
    {
        $pages = TableRegistry::get('Pages');
        $query = $pages->find();

        $query->select(['owner' => $query->func()->concat($this->setOwnerName()), 'status' => 'Status.status'])
            ->select($pages)
            ->contain('Users')
            ->contain('Status')
            ->where([
                'pages.id = :id'
            ])
            ->bind(':id', $id, 'integer')
            ->order(['Pages.id' => 'DESC']);

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
            ->requirePresence('body', 'create')
            ->notEmpty('body');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['status_id'], 'Status'));

        return $rules;
    }

    private function setOwnerName() 
    {
        return ['Users.first_name' => 'identifier', ' ', 'Users.last_name' => 'identifier'];
    }
}
