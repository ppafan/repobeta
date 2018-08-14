<?php







namespace Autosupplyph\Inquiry\Controller\Index;







use Magento\Framework\Controller\ResultFactory;







class Index extends \Magento\Framework\App\Action\Action



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

            $topic      = "cars";

            $fullname   = $post['fullname'];

            $mobile     = $post['mobile'];

            $email      = $post['email'];

            $inquiry    = $post['inquiry'];

            $prodid     = $post['prodid'];

            $prod_name  = $post['prod_name'];

            $prod_price = $post['prod_price'];

            $prod_img   = $post['prod_img'];

            $status = "In process";
            $date = date('Y-m-d');
            $time = date('H:i:s');

            $objectManager_resource = \Magento\Framework\App\ObjectManager::getInstance(); // Instance of object manager
            $resource = $objectManager_resource->get('Magento\Framework\App\ResourceConnection');
            $connection = $resource->getConnection();

            $sql = "INSERT INTO inquiry_openticket (topic, productid, fullname, email, mobile, message, status, created_at, update_time) values('$topic', '$prodid', '$fullname', '$email', '$mobile', '$inquiry', '$status', '$date', '$time')";
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



      $emailTempVariables['prodid'] = $prodid;



      $emailTempVariables['prod_name'] = $prod_name;



      $emailTempVariables['prod_price'] = $prod_price;



      $emailTempVariables['prod_img'] = $prod_img;





      $emailtemplatefield = 'inquiry/cars/cartemplate'; 

      $this->_objectManager->get('Autosupplyph\Inquiry\Helper\Email')->yourCustomMailSendMethod(



         $emailtemplatefield,



         $emailTempVariables,



         $senderInfo,



         $receiverInfo



        );


            // Display the succes form validation message

            // $this->messageManager->addSuccessMessage('Success Car Inquiry!');

            // Redirect to your form page (or anywhere you want...)

             $redirectURL = '/inquiry?id=success';

            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

            $resultRedirect->setUrl($redirectURL);

            return $resultRedirect;



        }



        // Render the page 



        $this->_view->loadLayout();



        $this->_view->renderLayout();



    }



}