<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

class FeedsManageComponent extends Component
{
  	public function initialize(array $config) 
    {
        $this->Feeds = TableRegistry::get('Feeds');
    }

	/**
	 * Call the Model Method to Save the feed
	 * @param  [array] $data ['type', 'page', 'user', 'action']
	 */
    public function saveFeed($data)
    {
        $this->Feeds->saveFeed($data);
    }
}