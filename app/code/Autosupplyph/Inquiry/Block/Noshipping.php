<?php



namespace Autosupplyph\Inquiry\Block;



class Noshipping extends \Magento\Framework\View\Element\Template

{



     public function __construct(

        \Magento\Framework\View\Element\Template\Context $context,

        \Magento\Framework\App\Config\ScopeConfigInterface $_scopeConfig



    ) {

        $this->_scopeConfig = $_scopeConfig;

        parent::__construct($context);

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



        return '/inquiry/index/noshipping';

        // here controller_name is manage, action is contact

    }



}