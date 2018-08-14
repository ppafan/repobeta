<?php



namespace Autosupplyph\Support\Block\Adminhtml;


class Support extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Constructor.
     */
    protected function _construct()
    {
        $this->_controller = 'adminhtml_support';
        $this->_blockGroup = 'Autosupplyph_Support';
        $this->_headerText = __('Ticket Listing');
     
        parent::_construct();
    }
}
