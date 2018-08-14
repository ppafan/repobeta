<?php

namespace Autosupplyph\Inquiry\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ObjectManager;


class Sendemail implements ObserverInterface
{

    
   protected $_order;
   protected $_logger;
   protected $customerSession;


    public function __construct(
        \Magento\Sales\Model\Order $order,
        \Magento\Framework\App\ResponseFactory $responseFactory,
        \Magento\Framework\UrlInterface $url,
         \Magento\Customer\Model\Session $customerSession

    ) {
    	 // $this->_scopeConfig = $_scopeConfig;
      //    $this->_order = $order; 
      $this->order = $order;  
      $this->_responseFactory = $responseFactory;
      $this->_url = $url; 
      $this->customerSession = $customerSession;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
      $orderids = $observer->getEvent()->getOrderIds();

        $order = $this->order->load($orderids);

        //get Order All Item
        $itemCollection = $order->getItemsCollection();
        $customerid = $order->getCustomerId(); // using this id you can get customer name
        $customeremail = $order->getCustomerEmail(); // using this id you can get customer name

        $addressObj = $order->getShippingAddress();

        $shippingregionid = $addressObj->getRegionId();

        if($shippingregionid != 580){ //ID of Metromanila
        	//safe

          $this->customerSession->setCustomeremail($customerid);
          $getthis = $this->customerSession->getCustomeremail();
          print_r($getthis);
        }else{
        	//send email
            $this->customerSession->setCustomeremail($customeremail);
            $customerBeforeAuthUrl = $this->_url->getUrl('inquiry/index/noshipping');
            $this->_responseFactory->create()->setRedirect($customerBeforeAuthUrl)->sendResponse();
        	
        }

    }


}