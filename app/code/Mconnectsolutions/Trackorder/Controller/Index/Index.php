<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Mconnectsolutions\Trackorder\Controller\Index;

use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\Context;
use Mconnectsolutions\Trackorder\Block\Trackorder;

class Index extends \Magento\Framework\App\Action\Action
{
        
    /**
     * @var \Mconnectsolutions\Trackorder\Block\Trackorder
     */
    private $trackUrl;
    
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    private $resultPageFactory;
    
    public function __construct(
        Context $context,
        Trackorder $trackUrl,
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->trackUrl = $trackUrl;
        parent::__construct($context);
    }
    
    private function _initAction()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Track Order'));
        return $resultPage;
    }
    
    /**
     * Index action
     *
     * @return $this
     */
    public function execute()
    {
        if (!$this->trackUrl->getEnableTrackOrder()) {
            $this->_redirect('404');
        }
        


        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $customerSession = $objectManager->create('Magento\Customer\Model\Session');
        if($customerSession->isLoggedIn()) { //customer is loggedin or not
                $this->_view->loadLayout();
            $resultPage = $this->_initAction();
            $this->_view->renderLayout();
        }else{
            $this->_redirect('customer/account/login');
        }

    }
}
