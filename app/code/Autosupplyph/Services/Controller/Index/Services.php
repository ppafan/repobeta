<?php
namespace Autosupplyph\Services\Controller\Index;
use Magento\Framework\Controller\ResultFactory;

class Services extends \Magento\Framework\App\Action\Action
{
    public function execute()
    {
		// Render the page 
        $this->_view->loadLayout();
        $this->_view->renderLayout();

	}
	
}