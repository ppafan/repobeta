<?php
namespace Acommerce\Address\Controller\Data;
class Loaddistrict extends \Magento\Framework\App\Action\Action
{
    protected $_resultPageFactory;
    protected $_scopeConfig;
    protected $_helper;
    protected $_json;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
		\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
		\Acommerce\Address\Helper\Data $helper,
		\Magento\Framework\Controller\Result\JsonFactory $json
    )
    {
        $this->_scopeConfig 		  = $scopeConfig;
        $this->_resultPageFactory 	  = $resultPageFactory;
		$this->_helper 				  = $helper;
        $this->_json 	 			  = $json;
        parent::__construct($context);
    }
	
	public function execute()
    {
		$cityid = $this->getRequest()->getParam('cityid');
		$dataDistrict = $this->_helper->getSubdistrictJson($cityid);
		print_r($dataDistrict);
    }

}
