<?php
/**
 * Copyright © 2017 Acommerce. All rights reserved.
 */
namespace Acommerce\Address\Block\Adminhtml\Importaddress\Edit;

use \Magento\Backend\Block\Widget\Form\Generic;

class Form extends Generic
{
    protected $countryFactory;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Customer\Model\ResourceModel\Address\Attribute\Source\CountryWithWebsites $countryFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Customer\Model\ResourceModel\Address\Attribute\Source\CountryWithWebsites $countryFactory,
        array $data = []
    ) {
        parent::__construct($context, $registry, $formFactory, $data);
        $this->countryFactory = $countryFactory;
    }

    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('acommerce_import_address_form');
        $this->setTitle(__('Import Address'));
    }

    /**
     * Prepare form before rendering HTML
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            [
                'data' => [
                    'id' => 'edit_form',
                    'action' => $this->getUrl('*/*/save'),
                    'method' => 'post',
                    'enctype' => 'multipart/form-data'
                ],
            ]
        );

        $form->setHtmlIdPrefix('imp_');

        $fieldset = $form->addFieldset(
            'base_fieldset',
            [
                'legend' => __('General Information'),
                'class' => 'fieldset-wide'
            ]
        );

        $fieldset->addField(
            'import_type',
            'select',
            [
                'name' => 'import_type',
                'label' => __('Import Type'),
                'title' => __('Import Type'),
                'required' => true,
                'values' => [0 => __('Region'), 1 => __('City'), 2 => __('Subdistrict')],
                'after_element_html' => '
                    <ul>
                        <li><a href="'.$this->getUrl('*/*/sampleCsv', ['code' => 'region']).'">sample_region.csv</a></li>
                        <li><a href="'.$this->getUrl('*/*/sampleCsv', ['code' => 'city']).'">sample_city.csv</a></li>
                        <li><a href="'.$this->getUrl('*/*/sampleCsv', ['code' => 'subdistrict']).'">sample_subdistrict.csv</a></li>
                    </ul>
                '
            ]
        );

        $fieldset->addField(
            'country_id',
            'select',
            [
                'name' => 'country_id',
                'label' => __('Country'),
                'title' => __('Country'),
                'required' => true,
                'values' => $this->countryFactory->getAllOptions()
            ]
        );

        $fieldset->addField(
            'import_address',
            'file',
            [
                'name' => 'import_address', 
                'label' => __('Import Address'), 
                'title' => __('Import Address'), 
                'required' => true
            ]
        );

        $form->setUseContainer(true);
        $form->setMethod('post');
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
