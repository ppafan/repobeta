<?php

namespace Autosupplyph\Inquiry\Controller\Index;

use Magento\Framework\Controller\ResultFactory;

class Notexist extends \Magento\Framework\App\Action\Action
{
    /**
     * Contact action
     *
     * @return void
     */
    public function execute()
    {
        // Render the page 
        $this->_view->loadLayout();
        $this->_view->renderLayout();
    }
}