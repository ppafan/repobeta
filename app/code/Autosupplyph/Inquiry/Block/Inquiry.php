<?php

namespace Autosupplyph\Inquiry\Block;

class Inquiry extends \Magento\Framework\View\Element\Template
{
	 protected $_productloader;  

	 public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $_scopeConfig,
        \Magento\Catalog\Model\ProductFactory $_productloader

    ) {
        $this->_scopeConfig = $_scopeConfig;
        $this->_productloader = $_productloader;
        parent::__construct($context);
    }

    public function getLoadProduct($id)
    {
        return $this->_productloader->create()->load($id);
    }

    public function getStoreName()
    {
        //$myvalue = $this->_scopeConfig->getValue('general/store_information/name', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $myvalue = $this->_scopeConfig->getValue('trans_email/ident_general/name', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        return $myvalue;
    }

    public function getStoreEmail()
    {
        $myvalue = $this->_scopeConfig->getValue('trans_email/ident_general/email', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        return $myvalue;
    }

    public function getFormAction()
    {
            // companymodule is given in routes.xml
            // controller_name is folder name inside controller folder
            // action is php file name inside above controller_name folder

        return '/inquiry/index/index';
        // here controller_name is manage, action is contact
    }

}