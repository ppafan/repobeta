<?php

namespace Autosupplyph\Inquiry\Controller\Index;

use Magento\Framework\Controller\ResultFactory;

class Careers extends \Magento\Framework\App\Action\Action
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
            $topic      = "careers";
            $fullname   = $post['fullname'];
            $email      = $post['email'];
            $mobile     = $post['mobile'];
            $message    = $post['message'];
            

            $status = "In process";
            $date = date('Y-m-d');
            $time = date('H:i:s');

            $objectManager_resource = \Magento\Framework\App\ObjectManager::getInstance(); // Instance of object manager
            $resource = $objectManager_resource->get('Magento\Framework\App\ResourceConnection');
            $connection = $resource->getConnection();

            $sql = "INSERT INTO inquiry_openticket (topic, fullname, email, mobile, message, status, created_at, update_time) values('$topic', '$fullname', '$email', '$mobile', '$message', '$status', '$date', '$time')";
            $result = $connection->query($sql);


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
            $emailTempVariables['mobile']   = $mobile;
            $emailTempVariables['message']   = $message;

          $emailtemplatefield = 'inquiry/cars/careerstemplate'; 
          $this->_objectManager->get('Autosupplyph\Inquiry\Helper\Email')->yourCustomMailSendMethod(

             $emailtemplatefield,

             $emailTempVariables,

             $senderInfo,

             $receiverInfo

            );


            $redirectURL = '/inquiry/index/careers?success=true';
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