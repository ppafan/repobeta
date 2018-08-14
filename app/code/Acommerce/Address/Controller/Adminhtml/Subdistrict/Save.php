<?php

namespace Acommerce\Address\Controller\Adminhtml\Subdistrict;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\TestFramework\Inspection\Exception;

class Save extends \Magento\Backend\App\Action
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;
    /**
     * @param Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Context $context,
        \Magento\Framework\Registry $coreRegistry
    ) {
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        $data = $this->getRequest()->getPostValue();
        if ($data) {

            $subdistrict_id = $this->getRequest()->getParam('subdistrict_id');

            /** @var \Acommerce\Address\Model\Subdistrict $model */
            $model = $this->_objectManager->create('Acommerce\Address\Model\Subdistrict')->load($subdistrict_id);
            if (!$model->getSubdistrictId() && $subdistrict_id) {
                $this->messageManager->addError(__('This subdistrict no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }

            $model->setData($data);

            try {
                $model->save();
                $this->messageManager->addSuccess(__('You saved the subdistrict.'));

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['subdistrict_id' => $model->getSubdistrictId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the subdistrict.'));
            }

            $this->_getSession()->setFormData($data);
            if ($this->getRequest()->getParam('subdistrict_id')) {
                return $resultRedirect->setPath('*/*/edit', ['subdistrict_id' => $this->getRequest()->getParam('subdistrict_id')]);
            }
            return $resultRedirect->setPath('*/*/new');
        }
        return $resultRedirect->setPath('*/*/');
    }
}
