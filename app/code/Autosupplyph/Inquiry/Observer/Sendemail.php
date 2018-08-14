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

        if($shippingregionid == 580){ //ID of Metromanila
        	//safe

        }else{
        	//send email
            // $this->customerSession->setCustomeremail($customeremail);
            // $customerBeforeAuthUrl = $this->_url->getUrl('inquiry/index/noshipping');
            // $this->_responseFactory->create()->setRedirect($customerBeforeAuthUrl)->sendResponse();


            // Retrieve your form data
            $objectManager =  \Magento\Framework\App\ObjectManager::getInstance();
            $inquiryblockinstance = $objectManager->create('Autosupplyph\Inquiry\Block\Inquiry');

            //$fullname   = "Fullname111";
            $fullname = "";

            // Doing-something with...
            $receiverInfo = [
                'name' => $fullname,

                'email' => $customeremail,
            ];

            $senderInfo = [

                'name' => $inquiryblockinstance->getStoreName(),

                'email' => $inquiryblockinstance->getStoreEmail(),
            ];

            $emailTemplateVariables = array();
            $emailTempVariables['email']    = $customeremail;
            $emailTempVariables['fullname'] = $fullname;

          $objectManager2 =  \Magento\Framework\App\ObjectManager::getInstance();
          $inquiryhelperinstance = $objectManager2->create('Autosupplyph\Inquiry\Helper\Email');

          $emailtemplatefield = 'inquiry/cars/noshippingtemplate';
          $inquiryhelperinstance->yourCustomMailSendMethod(

             $emailtemplatefield,

             $emailTempVariables,

             $senderInfo,

             $receiverInfo

            );






        }

    }


}