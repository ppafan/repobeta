<?php

/**
 * Created by PhpStorm.
 * User: dathq
 * Date: 22/12/2017
 * Time: 11:31
 */
namespace Acommerce\Address\Controller\Adminhtml;

class LoadBlock extends \Magento\Sales\Controller\Adminhtml\Order\Create\LoadBlock
{

    /**
     * Loading page block
     *
     * @return \Magento\Backend\Model\View\Result\Redirect|\Magento\Framework\Controller\Result\Raw
     */
    public function execute()
    {
        $request = $this->getRequest();
        try {
            $this->_initSession()->_processData();
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->_reloadQuote();
            $this->messageManager->addError($e->getMessage());
        } catch (\Exception $e) {
            $this->_reloadQuote();
            $this->messageManager->addException($e, $e->getMessage());
        }

        $asJson = $request->getParam('json');
        $block = $request->getParam('block');

        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        if ($asJson) {
            $resultPage->addHandle('sales_order_create_load_block_json');
        } else {
            $resultPage->addHandle('sales_order_create_load_block_plain');
        }

        if ($block) {
            $blocks = explode(',', $block);
            if ($asJson && !in_array('message', $blocks)) {
                $blocks[] = 'message';
            }

            foreach ($blocks as $block) {
                $resultPage->addHandle('sales_order_create_load_block_' . $block);
            }
        }

        $result = $resultPage->getLayout()->renderElement('content');
        $sresult = json_decode($result,true);
        if(isset($sresult['shipping_address_custom'])){
            $sresult['shipping_address'] = $sresult['shipping_address_custom'];
            unset($sresult['shipping_address_custom']);
            //$result = json_encode($sresult);
        }
        if(isset($sresult['billing_address_custom'])){
            $sresult['billing_address'] = $sresult['billing_address_custom'];
            unset($sresult['billing_address_custom']);
            //$result = json_encode($sresult);
        }
        if (json_last_error() === 0) {
            $result = json_encode($sresult);
        }
        if ($request->getParam('as_js_varname')) {
            $this->_objectManager->get('Magento\Backend\Model\Session')->setUpdateResult($result);
            return $this->resultRedirectFactory->create()->setPath('sales/*/showUpdateResult');
        }
        return $this->resultRawFactory->create()->setContents($result);
    }

}