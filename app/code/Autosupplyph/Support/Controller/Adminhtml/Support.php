<?php

namespace Autosupplyph\Support\Controller\Adminhtml;

abstract class Support extends \Autosupplyph\Support\Controller\Adminhtml\AbstractAction
{
    const PARAM_CRUD_ID = 'id';

    
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Autosupplyph_Support::support_support');
    }
}