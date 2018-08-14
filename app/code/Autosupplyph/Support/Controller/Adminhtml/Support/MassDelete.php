<?php



namespace Autosupplyph\Support\Controller\Adminhtml\Support;


class MassDelete extends \Autosupplyph\Support\Controller\Adminhtml\Support
{
    
    public function execute()
    {
        $collection = $this->_massActionFilter->getCollection($this->_createMainCollection());
        $collectionSize = $collection->getSize();

        foreach ($collection as $item) {
            $item->delete();
        }

        $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $collectionSize));

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        return $resultRedirect->setPath('*/*/');
    }
}
