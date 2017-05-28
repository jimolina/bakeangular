<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Contacts Controller
 *
 * @property \App\Model\Table\ContactsTable $Contacts
 */
class FeedsController extends AppController
{
    /**
     * Summary Json method
     * @param int|null $limit to be apply as Limit in the query.
     * @param varchar|null $order to be apply as Order in the query.
     * @param varchar|null $orderBy to be apply as Order ASC or DESC in the query.
     * @return \Cake\Network\Response|null
     */
    public function summaryJson($limit=false, $order=false, $orderbBy=false)
    {
        $this->RequestHandler->renderAs($this, 'json');
        $query = $this->Feeds->getSummary($limit, $order, $orderbBy);

        $this->set('grid', $query);
        $this->set('_serialize', ['grid']);        
    }
}
