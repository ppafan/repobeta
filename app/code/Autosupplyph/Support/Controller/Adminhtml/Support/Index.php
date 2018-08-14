<?php

namespace Autosupplyph\Support\Controller\Adminhtml\Support;


class Index extends \Autosupplyph\Support\Controller\Adminhtml\Support
{
    
    public function execute()
    {

        $resultPage = $this->_resultPageFactory->create();

        return $resultPage;
    }
}
