<?php

namespace Autosupplyph\Inquiry\Controller\Index;

use Magento\Framework\Controller\ResultFactory;

class Noshipping extends \Magento\Framework\App\Action\Action
{
    /**
     * Contact action
     *
     * @return void
     */


    public function execute()
    {

            $orderId = 000000122;
            $objectManager =  \Magento\Framework\App\ObjectManager::getInstance();
            $orderData = $objectManager->create('Magento\Sales\Model\Order')->loadByIncrementId($orderId);
            $cEmail = $orderData->getCustomerEmail();

            // Retrieve your form data
            $fullname   = "Fullname";
            $email      = $cEmail;

            // Doing-something with...
            $receiverInfo = [
                'name' => $fullname,

                'email' => $email,
            ];

            $senderInfo = [
                'name' => $this->_objectManager->get('Autosupplyph\Inquiry\Block\Inquiry')->getStoreName(),

                'email' => $this->_objectManager->get('Autosupplyph\Inquiry\Block\Inquiry')->getStoreEmail(),
            ];
            
            $emailTemplateVariables = array();
            $emailTempVariables['email']    = $email;
            $emailTempVariables['fullname'] = $fullname;

          $emailtemplatefield = 'inquiry/cars/noshippingtemplate'; 
          $this->_objectManager->get('Autosupplyph\Inquiry\Helper\Email')->yourCustomMailSendMethod(

             $emailtemplatefield,

             $emailTempVariables,

             $senderInfo,

             $receiverInfo

            );


        // Render the page 
        $this->_view->loadLayout();
        $this->_view->renderLayout();
    }
}