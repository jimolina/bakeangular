<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * ColorSet Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\ColorSet get($primaryKey, $options = [])
 * @method \App\Model\Entity\ColorSet newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ColorSet[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ColorSet|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ColorSet patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ColorSet[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ColorSet findOrCreate($search, callable $callback = null, $options = [])
 */
class ColorSetTable extends Table
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

        $this->setTable('color_set');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
    }

    public function getRecordByUser($user)
    {
        $colorSet = TableRegistry::get('color_set');
        $query = $colorSet->find();

        $query->select($colorSet)
            ->where([
                'color_set.user_id = :user'
            ])
            ->bind(':user', $user, 'integer')
            ->first();

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
            ->requirePresence('value', 'create')
            ->notEmpty('value');

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
        $rules->add($rules->isUnique(['id']));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
