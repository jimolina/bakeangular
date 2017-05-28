<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Event\Event;

/**
 * Home Controller
 *
 */
class HomeController extends AppController
{
	public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

    	$this->set('titlePage', $this->request->controller);
    	$this->set('descriptionPage', __('General view about all the backend'));
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->loadModel('Articles');
        $articlesTot = $this->Articles->getTotals();

        $this->loadModel('Postulations');
        $postulationsTot = $this->Postulations->getTotals();

        $this->loadModel('Users');
        $newsletterUsersTot = $this->Users->getTotals('newsletter');

        $this->loadModel('Contacts');
        $contactsTot = $this->Contacts->getTotals();
        
        $this->set(compact('articlesTot', 'postulationsTot', 'newsletterUsersTot', 'contactsTot'));
    }

}
