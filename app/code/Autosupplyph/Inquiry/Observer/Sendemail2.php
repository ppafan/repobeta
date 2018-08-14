<?php

namespace Autosupplyph\Inquiry\Observer;

use \Magento\Framework\Event\Observer;
use \Magento\Framework\Event\ObserverInterface;

class Sendemail implements ObserverInterface
{

   protected $_redirect;
    protected $_url;

    public function __construct(

        \Magento\Framework\App\ResponseFactory $responseFactory,
        \Magento\Framework\UrlInterface $url
    ) {
        $this->_responseFactory = $responseFactory;
        $this->_url = $url;
    }

	public function execute(\Magento\Framework\Event\Observer $observer)
	{

		// execute send email

             $event = $observer->getEvent();
             $CustomRedirectionUrl = $this->_url->getUrl('inquiry/index/contactus');
             $this->_redirect->setRedirect($CustomRedirectionUrl);


		// 

	}
}