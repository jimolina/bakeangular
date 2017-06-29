<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\I18n\Time;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        // Allow users to register and logout.
        // You should not add the "login" action to allow list. Doing so would
        // cause problems with normal functioning of AuthComponent.
        $this->set('titlePage', $this->request->controller);
        $this->set('descriptionPage', __('Manage all the records for this table.'));
        $this->Auth->allow(['logout']);
    }

    public function login()
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if (($user) && ($user['role'] === 'admin')) {
                $this->Auth->setUser($user);                
                return $this->redirect($this->Auth->redirectUrl());
            } else {
                $user = '';
            }
            $this->Flash->error(__('Invalid username or password, try again'));
        }
    }

    public function logout()
    {
        session_unset ();
        return $this->redirect($this->Auth->logout());
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
     * Return the values option for the Status Combobox
     * @return [type] [description]
     */
    public function getStatusOptions()
    {
        //Static data for the Combobox
        $this->RequestHandler->renderAs($this, 'json');
        $this->loadModel('Status');
        $query = $this->paginate($this->Status);

        $this->set('listOptions', $query);
        $this->set('_serialize', ['listOptions']);
    }

    /**
     * Summary Json method
     *
     * @return \Cake\Network\Response|null
     */
    public function summaryJson()
    {
        $this->RequestHandler->renderAs($this, 'json');
        $query = $this->Users->getSummary();

        foreach ($query as $row) {
            $row['password'] = '';
        }

        $this->set('grid', $query);
        $this->set('_serialize', ['grid']);        
    }

    /**
     * View Json method
     */
    public function viewJson($id = null)
    {
        $this->RequestHandler->renderAs($this, 'json');

        $query = $this->Users->getRecord($id);

        $this->set('dataDetail', $query);
        $this->set('_serialize', ['dataDetail']);
    }

    /**
     * Save/Edit Json method
     *
     * @param string|null $id Page id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function saveJson($id = null)
    {
        $data = $this->Users->get($id, [
            'contain' => []
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->Users->patchEntity($data, $this->request->getData());

            if (count($data->errors()) == 0) {
                $data->created = $this->DatesConvert->utcToDateTime($data->created);
                $data->modified = Time::now();

                if ($this->Users->save($data)) {
                    $this->FeedsManage->saveFeed([
                        'type' => 'activities', 
                        'page' => 'users',
                        'user' => $this->Auth->user("first_name") . " " . $this->Auth->user("last_name"),
                        'action' => 'Update: [' . $data->id . '] ' . $data->first_name . ' ' . $data->last_name . ' (' . $data->email . ')'
                    ]);

                    $msn = ['type' => 'success', 'content' => 'The user has been saved.'];
                } else {
                    $msn = ['type' => 'danger', 'content' => 'The user could not be saved. Please, try again.'];
                }
            } else {
                $msn = ['type' => 'danger', 'content' => 'The user could not be saved. Please, check the errors and try again.', 'errors' => $data->errors()];
            }
        } else {
            $msn = ['type' => 'danger', 'content' => 'The user could not be saved. Please, try again.'];
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
        $data = $this->Users->newEntity();

        if ($this->request->is('post')) {
            $data = $this->Users->patchEntity($data, $this->request->getData());

            if (count($data->errors()) == 0) {
                $data->user_id = $this->Auth->user("id");
                $data->created = Time::now();
               
                if ($result = $this->Users->save($data)) {
                    $this->FeedsManage->saveFeed([
                        'type' => 'activities', 
                        'page' => 'users',
                        'user' => $this->Auth->user("first_name") . " " . $this->Auth->user("last_name"),
                        'action' => 'Create: [' . $result->id . '] ' . $data->first_name . ' ' . $data->last_name . ' (' . $data->email . ')'
                    ]);

                    $msn = ['type' => 'success', 'content' => 'The user has been saved.'];
                } else {
                    $msn = ['type' => 'danger', 'content' => 'The user could not be saved. Please, try again.'];
                }
            } else {
                $msn = ['type' => 'danger', 'content' => 'The user could not be saved. Please, check the errors and try again.', 'errors' => $data->errors()];
            }
        } else {
            $msn = ['type' => 'danger', 'content' => 'The user could not be saved. Please, try again.'];
        }

        $this->RequestHandler->renderAs($this, 'json');
        $this->set('msn', $msn);
    }

  /**
     * Delete Json method
     *
     * @param string|null $id Users id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function deleteJson($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $data = $this->Users->get($id);

        if ($this->Users->delete($data)) {
            $this->FeedsManage->saveFeed([
                'type' => 'activities', 
                'page' => 'users',
                'user' => $this->Auth->user("first_name") . " " . $this->Auth->user("last_name"),
                'action' => 'Delete: [' . $data->id . '] ' . $data->first_name . ' ' . $data->last_name . ' (' . $data->email . ')'
            ]);

            $msn = ['type' => 'success', 'content' => 'The user has been deleted.'];
        } else {
            $msn = ['type' => 'danger', 'content' => 'The user could not be deleted. Please, try again.'];
        }

        $this->RequestHandler->renderAs($this, 'json');

        $this->set('msn', $msn);
    }

    public function export() 
    {
        $_title = 'Users';
        $_header = ['ID', 'First Name', 'Last Name', 'Email', 'Role', 'Created', 'Modified', 'Status'];
        $_fields = ['id', 'first_name', 'last_name', 'email', 'role', 'created', 'modified'];

        $fileName = 'user-' . time() . '.csv';

        $this->response->type('application/vnd.ms-excel');
        $this->response->download($fileName);
        $data = $this->Users->export($_fields);

        $this->viewBuilder()->setLayout('export');
        $this->set(compact('data', '_header', '_fields', '_title'));
        $this->render(false);
        
        return;
    }
}
