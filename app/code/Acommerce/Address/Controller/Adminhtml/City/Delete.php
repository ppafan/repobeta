<?php

namespace Acommerce\Address\Controller\Adminhtml\City;

class Delete extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Acommerce_Address::city_delete';
    /**
     *
     * @return \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        // check if we know what should be deleted
        $city_id = $this->getRequest()->getParam('city_id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($city_id) {
            $city_name = '';
            try {
                // init model and delete
                $model = $this->_objectManager->create('Acommerce\Address\Model\City');
                $model->load($city_id);
                $city_name = $model->getDefaultName();
                $model->delete();
                $this->messageManager->addSuccess(__('The '.$city_name.' city has been deleted.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addError($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['city_id' => $city_id]);
            }
        }
        // display error message
        $this->messageManager->addError(__('City to delete was not found.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
