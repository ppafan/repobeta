<?php

namespace Autosupplyph\Inquiry\Controller\Index;

use Magento\Framework\Controller\ResultFactory;

class Checkticket extends \Magento\Framework\App\Action\Action
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
            $fullname         = $post['fullname'];
            // $email              = $post['email'];
            $ticketnumber     = $post['ticketnumber'];
            
            $objectManager_resource = \Magento\Framework\App\ObjectManager::getInstance(); // Instance of object manager
            $resource = $objectManager_resource->get('Magento\Framework\App\ResourceConnection');
            $connection = $resource->getConnection();

            $sql = "SELECT * FROM inquiry_openticket WHERE ticketnumber = '$ticketnumber' AND fullname LIKE '$fullname'";
            $result = $connection->fetchRow($sql);

            if($result['entity_id'] == ''){
                $redirectURL = '/inquiry/index/notexist?ticket='.$ticketnumber;
            }else{
                $redirectURL = '/inquiry/index/ticketvalid?ticket='.$ticketnumber;
            }


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