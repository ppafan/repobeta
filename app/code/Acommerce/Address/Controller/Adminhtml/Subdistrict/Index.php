<?php

namespace Acommerce\Address\Controller\Adminhtml\Subdistrict;

class Index extends \Acommerce\Address\Controller\Adminhtml\Region
{
    /**
     * @return \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb('Subdistrict Manager','Subdistrict Manager');
        $resultPage->getConfig()->getTitle()->prepend(__('Customers'));
        $resultPage->getConfig()->getTitle()->prepend('Subdistrict Manager');
        return $resultPage;
    }
}
