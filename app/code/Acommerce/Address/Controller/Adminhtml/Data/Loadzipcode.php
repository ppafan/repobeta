<?php

namespace Acommerce\Address\Controller\Adminhtml\Data;
class Loadzipcode extends \Magento\Backend\App\Action
{
    protected $_resultPageFactory;
    protected $_scopeConfig;
    protected $_ahelper;
    protected $_json;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Acommerce\Address\Helper\Data $ahelper,
        \Magento\Framework\Controller\Result\JsonFactory $json
    )
    {
        $this->_scopeConfig 		  = $scopeConfig;
        $this->_resultPageFactory 	  = $resultPageFactory;
        $this->_ahelper 				  = $ahelper;
        $this->_json 	 			  = $json;
        parent::__construct($context);
    }

    public function execute()
    {
        $subdistrictid = $this->getRequest()->getParam('subdistrictid');
        $dataZipcode = $this->_ahelper->getPostcodeJson($subdistrictid);
        print_r($dataZipcode);
    }

}