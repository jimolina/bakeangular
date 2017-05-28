<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\I18n\Time;

/**
 * Contacts Controller
 *
 * @property \App\Model\Table\ContactsTable $Contacts
 */
class ContactsController extends AppController
{
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
     *
     * @return \Cake\Network\Response|null
     */
    public function summaryJson($limit=false)
    {
        $this->RequestHandler->renderAs($this, 'json');
        $query = $this->Contacts->getSummary();

        if ($limit) {
            $query->limit($limit);
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

        $query = $this->Contacts->getRecord($id);

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
        $data = $this->Contacts->get($id, [
            'contain' => []
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->Contacts->patchEntity($data, $this->request->getData());

            if (count($data->errors()) == 0) {
                $data->created = $this->DatesConvert->utcToDateTime($data->created);
                $data->modified = Time::now();

                if ($this->Contacts->save($data)) {
                    $this->FeedsManage->saveFeed([
                        'type' => 'activities', 
                        'page' => 'contacts',
                        'user' => $this->Auth->user("first_name") . " " . $this->Auth->user("last_name"),
                        'action' => 'Update: [' . $data->id . '] ' . $data->name . ' (' . $data->email . ')'
                    ]);

                    $msn = ['type' => 'success', 'content' => 'The contact has been saved.'];
                } else {
                    $msn = ['type' => 'danger', 'content' => 'The contact could not be saved. Please, try again.'];
                }
            } else {
                $msn = ['type' => 'danger', 'content' => 'The contact could not be saved. Please, check the errors and try again.', 'errors' => $data->errors()];
            }
        } else {
            $msn = ['type' => 'danger', 'content' => 'The contact could not be saved. Please, try again.'];
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
        $data = $this->Contacts->newEntity();

        if ($this->request->is('post')) {
            $data = $this->Contacts->patchEntity($data, $this->request->getData());

            if (count($data->errors()) == 0) {
                $data->user_id = $this->Auth->user("id");
                $data->created = Time::now();
               
                if ($result = $this->Contacts->save($data)) {
                    $this->FeedsManage->saveFeed([
                        'type' => 'activities', 
                        'page' => 'contacts',
                        'user' => $this->Auth->user("first_name") . " " . $this->Auth->user("last_name"),
                        'action' => 'Create: [' . $result->id . '] ' . $data->name . ' (' . $data->email . ')'
                    ]);

                    $msn = ['type' => 'success', 'content' => 'The contact has been saved.'];
                } else {
                    $msn = ['type' => 'danger', 'content' => 'The contact could not be saved. Please, try again.'];
                }
            } else {
                $msn = ['type' => 'danger', 'content' => 'The contact could not be saved. Please, check the errors and try again.', 'errors' => $data->errors()];
            }
        } else {
            $msn = ['type' => 'danger', 'content' => 'The contact could not be saved. Please, try again.'];
        }

        $this->RequestHandler->renderAs($this, 'json');
        $this->set('msn', $msn);
    }

  /**
     * Delete Json method
     *
     * @param string|null $id Contacts id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function deleteJson($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $data = $this->Contacts->get($id);

        if ($this->Contacts->delete($data)) {
            $this->FeedsManage->saveFeed([
                'type' => 'activities', 
                'page' => 'contacts',
                'user' => $this->Auth->user("first_name") . " " . $this->Auth->user("last_name"),
                'action' => 'Delete: [' . $data->id . '] ' . $data->name . ' (' . $data->email . ')'
            ]);

            $msn = ['type' => 'success', 'content' => 'The contact has been deleted.'];
        } else {
            $msn = ['type' => 'danger', 'content' => 'The contact could not be deleted. Please, try again.'];
        }

        $this->RequestHandler->renderAs($this, 'json');

        $this->set('msn', $msn);
    }

    public function export() 
    {
        $_title = 'Contacts';
        $_header = ['ID', 'Name', 'Phone', 'Email', 'Category', 'Comments', 'Created', 'Modified'];
        $_fields = ['id', 'name', 'phone', 'email', 'category', 'comments', 'created', 'modified'];

        $fileName = 'contacts-' . time() . '.csv';

        $this->response->type('application/vnd.ms-excel');
        $this->response->download($fileName);
        $data = $this->Contacts->export($_fields);

        $this->viewBuilder()->setLayout('export');
        $this->set(compact('data', '_header', '_fields', '_title'));
        $this->render(false);
        
        return;
    }
}
