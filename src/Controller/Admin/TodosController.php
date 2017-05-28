<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Todos Controller
 *
 * @property \App\Model\Table\TodosTable $Todos
 */
class TodosController extends AppController
{
    public function initialize() {
        parent::initialize();
        $this->loadComponent('RequestHandler');/*This line loads the required RequestHandler Component*/
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        $this->set('titlePage', $this->request->controller);
        $this->set('descriptionPage', __('Manage all the records for this table.'));
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        //Angular execute a ajax call to get the records: data-ng-init
    }

    /**
     * Summary Json method
     * @param int|null $limit to be apply as Limit in the query.
     * @param varchar|null $order to be apply as Order in the query.
     * @return \Cake\Network\Response|null
     */
    public function summaryJson($limit=false, $order=false, $orderbBy=false)
    {
        $this->RequestHandler->renderAs($this, 'json');
        $query = $this->Todos->getSummary($this->Auth->user("id"), $limit, $order, $orderbBy);

        $this->set('grid', $query);
        $this->set('_serialize', ['grid']);        
    }

    /**
     * View Json method
     */
    public function viewJson($id = null)
    {
        $this->RequestHandler->renderAs($this, 'json');

        $query = $this->Todos->getRecord($id, $this->Auth->user("id"));

        $this->set('dataDetail', $query);
        $this->set('_serialize', ['dataDetail']);
    }

    public function doneStatusTodo($id) {
        $query = $this->Todos->doneStatusTodo($id, $this->Auth->user("id"));
        $this->autoRender = false;
    }

    /**
     * Save/Edit Json method
     *
     * @param string|null $id Todos id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function saveJson($id = null)
    {
        $data = $this->Todos->get($id, [
            'contain' => []
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->Todos->patchEntity($data, $this->request->getData());

            if (count($data->errors()) == 0) {
                $data->deadline = $this->DatesConvert->utcToDateTime($data->deadline);

                if ($this->Todos->save($data)) {
                    $this->FeedsManage->saveFeed([
                        'type' => 'activities', 
                        'page' => 'todos',
                        'user' => $this->Auth->user("first_name") . " " . $this->Auth->user("last_name"),
                        'action' => 'Update: [' . $data->id . '] ' . $data->title
                    ]);

                    $msn = ['type' => 'success', 'content' => 'The todo has been saved.'];
                } else {
                    $msn = ['type' => 'danger', 'content' => 'The todo could not be saved. Please, try again.'];
                }
            } else {
                $msn = ['type' => 'danger', 'content' => 'The todo could not be saved. Please, check the errors and try again.', 'errors' => $data->errors()];
            }
        } else {
            $msn = ['type' => 'danger', 'content' => 'The todo could not be saved. Please, try again.'];
        }

        $this->RequestHandler->renderAs($this, 'json');
        $this->set('msn', $msn);
    }

    /**
     * Add Json method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function addJson()
    {
        $data = $this->Todos->newEntity();

        if ($this->request->is('post')) {
            $data = $this->Todos->patchEntity($data, $this->request->getData());

            if (count($data->errors()) == 0) {
                $data->deadline = $this->DatesConvert->utcToDateTime($data->deadline);
                $data->user_id = $this->Auth->user("id");

                if ($result = $this->Todos->save($data)) {
                    $this->FeedsManage->saveFeed([
                        'type' => 'activities', 
                        'page' => 'todos',
                        'user' => $this->Auth->user("first_name") . " " . $this->Auth->user("last_name"),
                        'action' => 'Create: [' . $result->id . '] ' . $data->title
                    ]);

                    $msn = ['type' => 'success', 'content' => 'The todo has been saved.'];
                } else {
                    $msn = ['type' => 'danger', 'content' => 'The todo could not be saved. Please, try again.'];
                }
            } else {
                $msn = ['type' => 'danger', 'content' => 'The todo could not be saved. Please, check the errors and try again.', 'errors' => $data->errors()];
            }
        } else {
            $msn = ['type' => 'danger', 'content' => 'The todo could not be saved. Please, try again.'];
        }

        $this->RequestHandler->renderAs($this, 'json');
        $this->set('msn', $msn);
    }

  /**
     * Delete Json method
     *
     * @param string|null $id Todos id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function deleteJson($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $data = $this->Todos->get($id);

        if ($this->Todos->delete($data)) {
            $this->FeedsManage->saveFeed([
                'type' => 'activities', 
                'page' => 'todos',
                'user' => $this->Auth->user("first_name") . " " . $this->Auth->user("last_name"),
                'action' => 'Delete: [' . $data->id . '] ' . $data->title
            ]);

            $msn = ['type' => 'success', 'content' => 'The todo has been deleted.'];
        } else {
            $msn = ['type' => 'danger', 'content' => 'The todo could not be deleted. Please, try again.'];
        }

        $this->RequestHandler->renderAs($this, 'json');

        $this->set('msn', $msn);
    }

    public function export() 
    {
        $_title = 'Todos';
        $_header = ['ID', 'Title', 'Description', 'Deadline', 'Status'];
        $_fields = ['id', 'title', 'description', 'deadline', 'status'];

        $fileName = 'todos-' . time() . '.csv';

        $this->response->type('application/vnd.ms-excel');
        $this->response->download($fileName);
        $data = $this->Todos->export($_fields, $this->Auth->user("id"));

        $this->viewBuilder()->setLayout('export');
        $this->set(compact('data', '_header', '_fields', '_title'));
        $this->render(false);
        
        return;
    }
}
