<?php

namespace Autosupplyph\Inquiry\Controller\Index;

use Magento\Framework\Controller\ResultFactory;

class Contactus extends \Magento\Framework\App\Action\Action
{
    /**
     * Contact action
     *
     * @return void
     */
    public function execute()
    {
        $post = (array) $this->getRequest()->getPost();

        if (!empty($post)) {
            // Retrieve your form data
            $fullname   = $post['fullname'];
            $email      = $post['email'];
            $inquiry    = $post['message'];
            $mobile    = $post['mobile'];
            


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
            $emailTempVariables['inquiry']   = $inquiry;
            $emailTempVariables['mobile']   = $mobile;

          $emailtemplatefield = 'inquiry/cars/contactustemplate'; 
          $this->_objectManager->get('Autosupplyph\Inquiry\Helper\Email')->yourCustomMailSendMethod(

             $emailtemplatefield,

             $emailTempVariables,

             $senderInfo,

             $receiverInfo

            );

            $redirectURL = '/inquiry/index/contactus?success=true';

            // Redirect to your form page (or anywhere you want...)
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $resultRedirect->setUrl($redirectURL);

            return $resultRedirect;
        }
        // Render the page 
        $this->_view->loadLayout();
        $this->_view->renderLayout();
    }
}