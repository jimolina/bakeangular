<?php
namespace App\View\Helper;

use Cake\View\Helper;

class AdminBreadcrumbHelper extends Helper
{
	public $helpers = ['Html'];

    public function breadcrumb()
    {
		$breadcrumb = $this->Html->link(__('Home',true),'/admin', ['class' => 'breadcrumb-item']);

		if ($this->request->controller !== 'Home') {
			if ($this->request->action !== 'index') {
				$breadcrumb .= $this->Html->link(__($this->request->controller,true),'/admin/'.$this->request->controller, ['class' => 'breadcrumb-item']);
				$breadcrumb .= $this->Html->link(__($this->request->action,true),'/admin/'.$this->request->action, ['class' => 'breadcrumb-item active']);
			} else {
				$breadcrumb .= $this->Html->link(__($this->request->controller,true),'/admin/'.$this->request->controller, ['class' => 'breadcrumb-item active']);
			}
			
		}

		return $breadcrumb;
    }
}