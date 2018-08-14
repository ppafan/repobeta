<?php

namespace Acommerce\Address\Block\Adminhtml;

/**
 * Adminhtml cms blocks content block
 */
class Subdistrict extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_blockGroup = 'Acommerce_Address';
        $this->_controller = 'adminhtml_subdistrict';
        $this->_headerText = __('Subdistrict Manager');
        $this->_addButtonLabel = __('Add New Subdistrict');
        parent::_construct();
    }
}
