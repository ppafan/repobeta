<?php



namespace Autosupplyph\Support\Model;


class Support extends \Magento\Framework\Model\AbstractModel
{
   
    protected $_supportCollectionFactory;

   
    protected $_storeViewId = null;

    
    protected $_supportFactory;

   
    protected $_formFieldHtmlIdPrefix = 'page_';

    
    protected $_storeManager;

   
    protected $_monolog;

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Autosupplyph\Support\Model\ResourceModel\Support $resource,
        \Autosupplyph\Support\Model\ResourceModel\Support\Collection $resourceCollection,
        \Autosupplyph\Support\Model\SupportFactory $supportFactory,
        
        \Autosupplyph\Support\Model\ResourceModel\Support\CollectionFactory $supportCollectionFactory,
    
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Logger\Monolog $monolog
    ) {
        parent::__construct(
            $context,
            $registry,
            $resource,
            $resourceCollection
        );
        $this->_supportFactory = $supportFactory;
       
      
        $this->_storeManager = $storeManager;
        $this->_supportCollectionFactory = $supportCollectionFactory;

        $this->_monolog = $monolog;

        if ($storeViewId = $this->_storeManager->getStore()->getId()) {
            $this->_storeViewId = $storeViewId;
        }
    }

   

    
}
