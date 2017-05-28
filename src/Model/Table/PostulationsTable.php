<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * Postulations Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Positions
 *
 * @method \App\Model\Entity\Postulation get($primaryKey, $options = [])
 * @method \App\Model\Entity\Postulation newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Postulation[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Postulation|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Postulation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Postulation[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Postulation findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PostulationsTable extends Table
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

        $this->setTable('postulations');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Positions', [
            'foreignKey' => 'position_id',
            'joinType' => 'INNER'
        ]);
    }

    public function getTotals()
    {
        return $this->getSummary()->count();
    }
    
    public function getSummary()
    {
        $postulations = TableRegistry::get('Postulations');
        $query = $postulations->find();

        $query->select(['position' => 'Positions.title'])
            ->select($postulations)
            ->contain('Positions')
            ->order(['Postulations.id' => 'DESC']);

        return $query;
    }

    public function export($fields)
    {
        $postulations = TableRegistry::get('Postulations');
        $query = $postulations->find();

        $query->select($fields)
            ->select(['titlePosition' => 'Positions.title'])
            ->contain('Positions')
            ->order(['Postulations.id' => 'DESC']);

        return $query;
    }

    public function getRecord($id)
    {
        $postulations = TableRegistry::get('postulations');
        $query = $postulations->find();

        $query->select(['titlePosition' => 'Positions.title'])
            ->select($postulations)
            ->contain('Positions')
            ->where([
                'Postulations.id = :id'
            ])
            ->bind(':id', $id, 'integer')
            ->order(['Postulations.id' => 'DESC']);

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
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmpty('email');

        $validator
            ->requirePresence('file', 'create')
            ->notEmpty('file')
            ->add('file', [
                'Invalid-Extension' => [
                    'rule' => ['extension',['doc', 'docx', 'pdf']],
                    'message' => __('Only these files extension are allowed: .doc, .pdf')
                ]
            ]);

        $validator
            ->allowEmpty('file', 'update')
            ->add('file', [
                'Invalid-Extension' => [
                    'rule' => ['extension',['doc', 'docx', 'pdf']],
                    'message' => __('Only these files extension are allowed: .doc, .pdf')
                ]
            ]);

        $validator
            ->requirePresence('linkedin', 'create')
            ->notEmpty('linkedin');

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
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->existsIn(['position_id'], 'Positions'));

        return $rules;
    }
}
