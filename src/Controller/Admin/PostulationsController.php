<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\I18n\Time;

/**
 * Postulations Controller
 *
 * @property \App\Model\Table\PostulationsTable $Postulations
 */
class PostulationsController extends AppController
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
     * Return the values option for the Status Combobox
     * @return [type] [description]
     */
    public function getPositionOptions()
    {
        //Static data for the Combobox
        $this->RequestHandler->renderAs($this, 'json');
        $this->loadModel('Positions');
        $query = $this->Positions->getPositionsOptions();

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
        $query = $this->Postulations->getSummary();

        foreach ($query as $row) {
            if ($row['resume'] && ($row['resume'] !== "")) {
                $row['fileError'] = $this->FilesAction->setFileError($row['resume'], "upload/resumes/");
            }
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

        $query = $this->Postulations->getRecord($id);

        foreach ($query as $row) {
            if ($row['resume'] && ($row['resume'] !== "")) {
                $row['fileError'] = $this->FilesAction->setFileError($row['resume'], "upload/resumes/");
            }
        }

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
        $data = $this->Postulations->get($id, [
            'contain' => []
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->Postulations->patchEntity($data, $this->request->getData());

            if (count($data->errors()) == 0) {
                $data->created = $this->DatesConvert->utcToDateTime($data->created);
                $data->modified = Time::now();

                $file = $data->file;

                if ($file && ($file !== "")) {
                    $file['name'] =  time() . '-' . str_replace(' ', '_', $file['name']); // timestamp files to prevent clobber

                    if (move_uploaded_file($file['tmp_name'], WWW_ROOT . 'upload/resumes/' . $file['name'])) {
                        if ($data->resume !== "") {
                            $this->FilesAction->deleteFile($article->resume, 'upload/resumes/');
                        }
                        
                        $data->resume = $file['name'];

                        if ($this->Postulations->save($data)) {
                            $this->FeedsManage->saveFeed([
                                'type' => 'activities', 
                                'page' => 'postulations',
                                'user' => $this->Auth->user("first_name") . " " . $this->Auth->user("last_name"),
                                'action' => 'Update: [' . $data->id . '] ' . $data->name . ' (' . $data->email . ')'
                            ]);

                            $msn = ['type' => 'success', 'content' => 'The postulation has been saved.'];
                        } else {
                            $msn = ['type' => 'danger', 'content' => 'The postulation could not be saved. Please, try again.'];
                        }
                    } else {
                        $msn = ['type' => 'danger', 'content' => 'Could not upload the file.'];
                    }
                } else {
                    if ($this->Postulations->save($data)) {
                        $msn = ['type' => 'success', 'content' => 'The postulation has been saved.'];
                    } else {
                        $msn = ['type' => 'danger', 'content' => 'The postulation could not be saved. Please, try again.'];
                    }
                }
            } else {
                $msn = ['type' => 'danger', 'content' => 'The postulation could not be saved. Please, check the errors and try again.', 'errors' => $data->errors()];
            }
        } else {
            $msn = ['type' => 'danger', 'content' => 'The postulation could not be saved. Please, try again.'];
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
        $data = $this->Postulations->newEntity();

        if ($this->request->is('post')) {
            $data = $this->Postulations->patchEntity($data, $this->request->getData());

            if (count($data->errors()) == 0) {
                $data->created = Time::now();
               
                $file = $data->file;

                if ($file && ($file !== "")) {
                    $file['name'] =  time() . '-' . str_replace(' ', '_', $file['name']); // timestamp files to prevent clobber
                    $data->resume = $file['name'];

                    if (move_uploaded_file($file['tmp_name'], WWW_ROOT . 'upload/resumes/' . $file['name'])) {
                        if ($result = $this->Postulations->save($data)) {
                            $this->FeedsManage->saveFeed([
                                'type' => 'activities', 
                                'page' => 'postulations',
                                'user' => $this->Auth->user("first_name") . " " . $this->Auth->user("last_name"),
                                'action' => 'Create: [' . $result->id . '] ' . $data->name . ' (' . $data->email . ')'
                            ]);

                            $msn = ['type' => 'success', 'content' => 'The postulation has been saved.'];
                        } else {
                            $msn = ['type' => 'danger', 'content' => 'The postulation could not be saved. Please, try again.'];
                        }
                    } else {
                        $msn = ['type' => 'danger', 'content' => 'Could not upload the file.'];
                    }
                } else {
                    if ($this->Postulations->save($data)) {
                        $msn = ['type' => 'success', 'content' => 'The postulation has been saved.'];
                    } else {
                        $msn = ['type' => 'danger', 'content' => 'The postulation could not be saved. Please, try again.'];
                    }
                }
            } else {
                $msn = ['type' => 'danger', 'content' => 'The postulation could not be saved. Please, check the errors and try again.', 'errors' => $data->errors()];
            }
        } else {
            $msn = ['type' => 'danger', 'content' => 'The postulation could not be saved. Please, try again.'];
        }

        $this->RequestHandler->renderAs($this, 'json');
        $this->set('msn', $msn);
    }

  /**
     * Delete Json method
     *
     * @param string|null $id Postulations id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function deleteJson($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $data = $this->Postulations->get($id);

        if ($this->Postulations->delete($data)) {
            if ($data->resume !== "") {
                $this->FilesAction->deleteFile($data->resume, 'upload/resumes/');
            }

            $this->FeedsManage->saveFeed([
                'type' => 'activities', 
                'page' => 'postulations',
                'user' => $this->Auth->user("first_name") . " " . $this->Auth->user("last_name"),
                'action' => 'Delete: [' . $data->id . '] ' . $data->name . ' (' . $data->email . ')'
            ]);

            $msn = ['type' => 'success', 'content' => 'The postulation has been deleted.'];
        } else {
            $msn = ['type' => 'danger', 'content' => 'The postulation could not be deleted. Please, try again.'];
        }

        $this->RequestHandler->renderAs($this, 'json');

        $this->set('msn', $msn);
    }

    public function export() 
    {
        $_title = 'Postulations';
        $_header = ['ID', 'Name', 'Email', 'Resume', 'Linkedin', 'Created', 'Modified', 'Position'];
        $_fields = ['id', 'name', 'email', 'resume', 'linkedin', 'created', 'modified'];

        $fileName = 'postulations-' . time() . '.csv';

        $this->response->type('application/vnd.ms-excel');
        $this->response->download($fileName);
        $data = $this->Postulations->export($_fields);

        $this->viewBuilder()->setLayout('export');
        $this->set(compact('data', '_header', '_fields', '_title'));
        $this->render(false);
        
        return;
    }
}
