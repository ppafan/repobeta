<?php
/**
 * Copyright © 2017 Acommerce. All rights reserved.
 */
namespace Acommerce\Address\Block\Adminhtml\Importaddress;

class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * Initialize form
     * Add standard buttons
     * Add "Save and Continue" button
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_controller = 'adminhtml_importaddress';
        $this->_blockGroup = 'Acommerce_Address';

        parent::_construct();
        $this->buttonList->update('save', 'label', __('Import'));
    }

    /**
     * Getter for form header text
     *
     * @return \Magento\Framework\Phrase
     */
    public function getHeaderText()
    {
        return __('Import Address');
    }
}
