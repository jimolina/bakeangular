<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * ColorSet Controller
 *
 * @property \App\Model\Table\ColorSetTable $ColorSet
 *
 * @method \App\Model\Entity\ColorSet[] paginate($object = null, array $settings = [])
 */
class ColorSetController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        $this->set('titlePage', $this->request->controller);
        $this->set('descriptionPage', __('Set the color combination for your BackEnd.'));
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->set('colorSetAvailable', ['default', 'orange', 'green']);
    }

    /**
     * Add Json method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function addJson()
    {
        $data = $this->ColorSet->newEntity();

        if ($this->request->is('post')) {
            $data = $this->ColorSet->patchEntity($data, $this->request->getData());

            if (count($data->errors()) == 0) {
                $data->user_id = $this->Auth->user("id");

                $this->delete();

                if ($result = $this->ColorSet->save($data)) {
                    $_SESSION["colorSet"] = ["colorSetId" => $result->id, "colorSet" => $data->value];

                    $this->FeedsManage->saveFeed([
                        'type' => 'activities', 
                        'page' => 'colorset',
                        'user' => $this->Auth->user("first_name") . " " . $this->Auth->user("last_name"),
                        'action' => 'Update: [' . $result->id . '] ' . $data->name . ' (' . $data->value . ')'
                    ]);

                    $msn = ['type' => 'success', 'content' => 'The color set has been saved.'];
                } else {
                    $msn = ['type' => 'danger', 'content' => 'The color set could not be saved. Please, try again.'];
                }

            } else {
                $msn = ['type' => 'danger', 'content' => 'The color set could not be saved. Please, check the errors and try again.', 'errors' => $data->errors()];
            }
        } else {
            $msn = ['type' => 'danger', 'content' => 'The color set could not be saved. Please, try again.'];
        }

        $this->RequestHandler->renderAs($this, 'json');
        $this->set('msn', $msn);
    }

    /**
     * Delete method
     *
     * @param string|null $id ColorSet id.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    private function delete()
    {
        $query = $this->ColorSet->query();
        $query->delete()
            ->where(['user_id' => $this->Auth->user("id")])
            ->execute();

        return '';
    }

}
