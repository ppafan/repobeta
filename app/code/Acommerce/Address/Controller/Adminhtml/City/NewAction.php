<?php

namespace Acommerce\Address\Controller\Adminhtml\City;

class NewAction extends \Magento\Backend\App\Action
{
    /**
     * Create new Region
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $this->_forward('edit');
    }
}
