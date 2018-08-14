<?php

namespace Acommerce\Address\Block\Adminhtml;

/**
 * Adminhtml cms blocks content block
 */
class City extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_blockGroup = 'Acommerce_Address';
        $this->_controller = 'adminhtml_city';
        $this->_headerText = __('City Manager');
        $this->_addButtonLabel = __('Add New City');
        parent::_construct();
    }
}
