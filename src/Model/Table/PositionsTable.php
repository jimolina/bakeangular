<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * Positions Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Statuses
 * @property \Cake\ORM\Association\HasMany $Postulations
 *
 * @method \App\Model\Entity\Position get($primaryKey, $options = [])
 * @method \App\Model\Entity\Position newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Position[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Position|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Position patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Position[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Position findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PositionsTable extends Table
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

        $this->setTable('positions');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Status', [
            'foreignKey' => 'status_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Postulations', [
            'foreignKey' => 'position_id'
        ]);
    }

    public function getPositionsOptions()
    {
        $positions = TableRegistry::get('Positions');
        $query = $positions->find();

        $query->select(['id', 'title'])
            ->where(['status_id = 2'])
            ->order(['Positions.title' => 'DESC']);

        return $query;
    }

    public function getSummary()
    {
        $positions = TableRegistry::get('Positions');
        $query = $positions->find();

        $query->select(['status' => 'Status.status'])
            ->select($positions)
            ->contain('Status')
            ->order(['Positions.id' => 'DESC']);

        return $query;
    }

    public function export($fields)
    {
        $positions = TableRegistry::get('Positions');
        $query = $positions->find();

        $query->select($fields)
            ->select(['status' => 'Status.status'])
            ->contain('Status')
            ->order(['Positions.id' => 'DESC']);

        return $query;
    }

    public function getRecord($id)
    {
        $positions = TableRegistry::get('Positions');
        $query = $positions->find();

        $query->select(['status' => 'Status.status'])
            ->select($positions)
            ->contain('Status')
            ->where([
                'positions.id = :id'
            ])
            ->bind(':id', $id, 'integer')
            ->order(['Positions.id' => 'DESC']);

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
            ->requirePresence('location', 'create')
            ->notEmpty('location');

        $validator
            ->requirePresence('type', 'create')
            ->notEmpty('type');

        $validator
            ->requirePresence('summary', 'create')
            ->notEmpty('summary');

        $validator
            ->requirePresence('responsibilities', 'create')
            ->notEmpty('responsibilities');

        $validator
            ->requirePresence('skills', 'create')
            ->notEmpty('skills');

        $validator
            ->requirePresence('experience', 'create')
            ->notEmpty('experience');

        $validator
            ->requirePresence('education', 'create')
            ->notEmpty('education');

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
        $rules->add($rules->existsIn(['status_id'], 'Status'));

        return $rules;
    }
}
