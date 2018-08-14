<?php

namespace Acommerce\Address\Controller\Adminhtml\Subdistrict;

class Delete extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Acommerce_Address::subdistrict_delete';
    /**
     *
     * @return \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        // check if we know what should be deleted
        $subdistrict_id = $this->getRequest()->getParam('subdistrict_id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($subdistrict_id) {
            $subdistrict_name = '';
            try {
                // init model and delete
                $model = $this->_objectManager->create('Acommerce\Address\Model\Subdistrict');
                $model->load($subdistrict_id);
                $subdistrict_name = $model->getDefaultName();
                $model->delete();
                $this->messageManager->addSuccess(__('The '.$subdistrict_name.' subdistrict has been deleted.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addError($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['subdistrict_id' => $subdistrict_id]);
            }
        }
        // display error message
        $this->messageManager->addError(__('Subdistrict to delete was not found.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
