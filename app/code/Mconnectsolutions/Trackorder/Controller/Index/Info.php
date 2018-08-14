<?php
namespace Mconnectsolutions\Trackorder\Controller\Index;

use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Shipping\Block\Tracking\Link;
use Magento\Shipping\Model\InfoFactory;

class Info extends \Magento\Framework\App\Action\Action
{
    private $link;
    
    private $shippingInfoFactory;
    
    private $trackingData;

    public function __construct(
        Context $context,
        Link $link,
        InfoFactory $shippingInfoFactory
    ) {
        $this->link = $link;
        $this->shippingInfoFactory = $shippingInfoFactory;
        parent::__construct($context);
    }
    
    public function execute()
    {
        $post = $this->getRequest()->getParams();
        if ($post) {
            try {
                if (empty($post['order'])) {
                    $error = true;
                }
                if (empty($post['email'])) {
                    $error = true;
                }
                if ($error = '') {
                    throw new \Exception();
                }

                $order = $this->getOrder($post);
                if ($order && $order->getId()) {
                    $this->getBlockHtml();
                    return;
                } else {
                    $this->messageManager->addError('Order Not Found. Please try again later');
                    return;
                }
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError('Please Enter');
            } catch (\Exception $e) {
                $this->messageManager->addError(__('Cannot get order information.'));
            }
        }
    }
    
    private function getOrder()
    {
        if ($data = $this->getRequest()->getParams()) {
            $orderId = $data["order"];
            $email = $data["email"];
            $objectManager =  \Magento\Framework\App\ObjectManager::getInstance();
            $orderData = $objectManager->create('Magento\Sales\Model\Order')->loadByIncrementId($orderId);
            $cEmail = $orderData->getCustomerEmail();

            if ($cEmail == $email) {
                $url = $this->link->getWindowUrl($orderData);
                $parts = parse_url($url);
                parse_str($parts['query'], $query);
                $hash = $query['hash'];

                if ($hash && $hash != '') {
                    $shippingInfoModel = $this->shippingInfoFactory->create()->loadByHash($hash);
                    $this->trackingData = $shippingInfoModel;
                }
                return $orderData;
            } else {
                return null;
            }
        }
    }
    
    private function getBlockHtml()
    {
        $layout = $this->_view->getLayout();
        $block = $layout->createBlock('Magento\Shipping\Block\Tracking\Popup')
            ->setTrackingData($this->trackingData)
            ->setTemplate('Mconnectsolutions_Trackorder::trackorderdetails.phtml')->toHtml();
        $this->getResponse()->setBody($block);
    }
}
