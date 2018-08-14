<?php

namespace Autosupplyph\Inquiry\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Message\ManagerInterface;


class Sendemail implements ObserverInterface
{


/**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager;
 
    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $_urlInterface;
     
    /**
     * [__construct ]
     *
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param \Magento\Framework\UrlInterface           $urlInterface
     */
    public function __construct(
        \Magento\Framework\App\ResponseFactory $responseFactory,
        \Magento\Framework\UrlInterface $url
    ) {
        $this->_responseFactory = $responseFactory;
        $this->_url = $url;
    }

	public function execute(\Magento\Framework\Event\Observer $observer)
	{


		//get order details
		    // $order = $observer->getEvent()->getOrder();
		    // $order_id = $order->getID();
		    // $order_number = $order->getIncrementId();


		    // echo $order_number;
		    // die();
		//


		// execute send email

		// 

		// trial

        $event = $observer->getEvent();

       	$customerBeforeAuthUrl = $this->_url->getUrl('inquiry/index/contactus');
      	$this->_responseFactory->create()->setRedirect($customerBeforeAuthUrl)->sendResponse();

      return $this;


	}
}