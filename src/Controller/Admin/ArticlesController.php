<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Articles Controller
 *
 * @property \App\Model\Table\ArticlesTable $Articles
 */
class ArticlesController extends AppController
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
        $query = $this->Articles->getSummary();

        foreach ($query as $row) {
            if ($row['image'] && ($row['image'] !== "")) {
                $row['imgError'] = $this->FilesAction->setFileError($row['image']);
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

        $query = $this->Articles->getRecord($id);

        foreach ($query as $row) {
            if ($row['image'] && ($row['image'] !== "")) {
                $row['imgError'] = $this->FilesAction->setFileError($row['image']);
            }
        }

        $this->set('dataDetail', $query);
        $this->set('_serialize', ['dataDetail']);
    }

    /**
     * Save/Edit Json method
     *
     * @param string|null $id Article id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function saveJson($id = null)
    {
        $article = $this->Articles->get($id, [
            'contain' => []
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $article = $this->Articles->patchEntity($article, $this->request->getData());

            if (count($article->errors()) == 0) {
                $article->created = $this->DatesConvert->utcToDateTime($article->created);
                $article->modified = $this->DatesConvert->utcToDateTime($article->modified);

                $file = $article->file;

                if ($file && ($file !== "")) {
                    $file['name'] =  time() . '-' . str_replace(' ', '_', $file['name']); // timestamp files to prevent clobber

                    if (move_uploaded_file($file['tmp_name'], WWW_ROOT . 'upload/img/' . $file['name'])) {
                        if ($article->image !== "") {
                            $this->FilesAction->deleteFile($article->image);
                        }

                        $article->image = $file['name'];

                        if ($this->Articles->save($article)) {
                            $this->FeedsManage->saveFeed([
                                'type' => 'activities', 
                                'page' => 'articles',
                                'user' => $this->Auth->user("first_name") . " " . $this->Auth->user("last_name"),
                                'action' => 'Update: [' . $article->id . '] ' . $article->title
                            ]);

                            $msn = ['type' => 'success', 'content' => 'The article has been saved.'];
                        } else {
                            $msn = ['type' => 'danger', 'content' => 'The article could not be saved. Please, try again.'];
                        }
                    } else {
                        $msn = ['type' => 'danger', 'content' => 'Could not upload the file.'];
                    }
                } else {
                    if ($this->Articles->save($article)) {
                        $msn = ['type' => 'success', 'content' => 'The article has been saved.'];
                    } else {
                        $msn = ['type' => 'danger', 'content' => 'The article could not be saved. Please, try again.'];
                    }
                }
            } else {
                $msn = ['type' => 'danger', 'content' => 'The article could not be saved. Please, check the errors and try again.', 'errors' => $article->errors()];
            }
        } else {
            $msn = ['type' => 'danger', 'content' => 'The article could not be saved. Please, try again.'];
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
        $article = $this->Articles->newEntity();

        if ($this->request->is('post')) {
            $article = $this->Articles->patchEntity($article, $this->request->getData());

            if (count($article->errors()) == 0) {
                $article->user_id = $this->Auth->user("id");
                $article->created = $this->DatesConvert->utcToDateTime($article->created);
               
                $file = $article->file;

                if ($file && ($file !== "")) {
                    $file['name'] =  time() . '-' . str_replace(' ', '_', $file['name']); // timestamp files to prevent clobber
                    $article->image = $file['name'];

                    if (move_uploaded_file($file['tmp_name'], WWW_ROOT . 'upload/img/' . $file['name'])) {
                        if ($result = $this->Articles->save($article)) {

                            $this->FeedsManage->saveFeed([
                                'type' => 'activities', 
                                'page' => 'articles',
                                'user' => $this->Auth->user("first_name") . " " . $this->Auth->user("last_name"),
                                'action' => 'Create: [' . $result->id . '] ' . $article->title
                            ]);

                            $msn = ['type' => 'success', 'content' => 'The article has been saved.'];
                        } else {
                            $msn = ['type' => 'danger', 'content' => 'The article could not be saved. Please, try again.'];
                        }
                    } else {
                        $msn = ['type' => 'danger', 'content' => 'Could not upload the file.'];
                    }
                } else {
                    if ($this->Articles->save($article)) {
                        $msn = ['type' => 'success', 'content' => 'The article has been saved.'];
                    } else {
                        $msn = ['type' => 'danger', 'content' => 'The article could not be saved. Please, try again.'];
                    }
                }
            } else {
                $msn = ['type' => 'danger', 'content' => 'The article could not be saved. Please, check the errors and try again.', 'errors' => $article->errors()];
            }
        } else {
            $msn = ['type' => 'danger', 'content' => 'The article could not be saved. Please, try again.'];
        }

        $this->RequestHandler->renderAs($this, 'json');
        $this->set('msn', $msn);
    }

  /**
     * Delete Json method
     *
     * @param string|null $id Article id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function deleteJson($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $article = $this->Articles->get($id);

        if ($this->Articles->delete($article)) {
            if ($article->image !== "") {
                $this->FilesAction->deleteFile($article->image);
            }

            $this->FeedsManage->saveFeed([
                'type' => 'activities', 
                'page' => 'articles',
                'user' => $this->Auth->user("first_name") . " " . $this->Auth->user("last_name"),
                'action' => 'Delete: [' . $article->id . '] ' . $article->title
            ]);

            $msn = ['type' => 'success', 'content' => 'The article has been deleted.'];
        } else {
            $msn = ['type' => 'danger', 'content' => 'The article could not be deleted. Please, try again.'];
        }

        $this->RequestHandler->renderAs($this, 'json');
        $this->set('msn', $msn);
    }

    public function export() 
    {
        $_title = 'Articles';
        $_header = ['ID', 'Title', 'Body', 'Image', 'Created', 'Modified', 'Owner', 'Status'];
        $_fields = ['id', 'title', 'body', 'image', 'created', 'modified'];

        $fileName = 'articles-' . time() . '.csv';

        $this->response->type('application/vnd.ms-excel');
        $this->response->download($fileName);
        $data = $this->Articles->export($_fields);

        $this->viewBuilder()->setLayout('export');
        
        $this->set(compact('data', '_header', '_fields', '_title'));
        $this->render(false);
        
        return;

    }


    // /**
    //  * Set Error when Img don't exist
    //  * @param [varchar] $image Name
    //  */
    // private function setImgError($image) 
    // {
    //     if ($image) {
    //         $file = new File(WWW_ROOT . 'upload/img/' . $image);
    //         $imgError = ($file->exists()) ? false : true;
    //         $file->close();
    //     } else {
    //         $imgError = false;
    //     }

    //     return $imgError;
    // }

    /**
     * View method
     *
     * @param string|null $id Article id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    // public function view($id = null)
    // {
    //     $article = $this->Articles->get($id, [
    //         'contain' => []
    //     ]);

    //     $this->set('article', $article);
    //     $this->set('_serialize', ['article']);
    // }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    // public function add()
    // {
    //     $article = $this->Articles->newEntity();
    //     if ($this->request->is('post')) {
    //         $article = $this->Articles->patchEntity($article, $this->request->getData());
    //         if ($this->Articles->save($article)) {
    //             $this->Flash->success(__('The article has been saved.'));

    //             return $this->redirect(['action' => 'index']);
    //         }
    //         $this->Flash->error(__('The article could not be saved. Please, try again.'));
    //     }
    //     $this->set(compact('article'));
    //     $this->set('_serialize', ['article']);
    // }

    /**
     * Edit method
     *
     * @param string|null $id Article id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    // public function edit($id = null)
    // {
    //     $article = $this->Articles->get($id, [
    //         'contain' => []
    //     ]);
    //     if ($this->request->is(['patch', 'post', 'put'])) {
    //         $article = $this->Articles->patchEntity($article, $this->request->getData());
    //         if ($this->Articles->save($article)) {
    //             $this->Flash->success(__('The article has been saved.'));

    //             return $this->redirect(['action' => 'index']);
    //         }
    //         $this->Flash->error(__('The article could not be saved. Please, try again.'));
    //     }
    //     $this->set(compact('article'));
    //     $this->set('_serialize', ['article']);
    // }

    /**
     * Delete method
     *
     * @param string|null $id Article id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    // public function delete($id = null)
    // {
    //     $this->request->allowMethod(['post', 'delete']);
    //     $article = $this->Articles->get($id);
    //     if ($this->Articles->delete($article)) {
    //         $this->Flash->success(__('The article has been deleted.'));
    //     } else {
    //         $this->Flash->error(__('The article could not be deleted. Please, try again.'));
    //     }

    //     return $this->redirect(['action' => 'index']);
    // }
}
