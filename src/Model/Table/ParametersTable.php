<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * Parameters Model
 *
 * @method \App\Model\Entity\Parameter get($primaryKey, $options = [])
 * @method \App\Model\Entity\Parameter newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Parameter[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Parameter|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Parameter patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Parameter[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Parameter findOrCreate($search, callable $callback = null, $options = [])
 */
class ParametersTable extends Table
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

        $this->setTable('parameters');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');
    }

    public function getSummary()
    {
        $parameters = TableRegistry::get('Parameters');
        $query = $parameters->find();

        $query->select($parameters)
            ->order(['Parameters.id' => 'DESC']);

        return $query;
    }

    public function export($fields)
    {
        $parameters = TableRegistry::get('Parameters');
        $query = $parameters->find();

        $query->select($fields)
            ->order(['Parameters.id' => 'DESC']);

        return $query;
    }

    public function getRecord($id)
    {
        $parameters = TableRegistry::get('Parameters');
        $query = $parameters->find();

        $query->select($parameters)
            ->where([
                'Parameters.id = :id'
            ])
            ->bind(':id', $id, 'integer')
            ->order(['Parameters.id' => 'DESC']);

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
            ->requirePresence('value', 'create')
            ->notEmpty('value');

        return $validator;
    }
}
