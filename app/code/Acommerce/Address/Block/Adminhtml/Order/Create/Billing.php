<?php

/**
 * Created by PhpStorm.
 * User: dathq
 * Date: 28/11/2017
 * Time: 16:17
 */
namespace Acommerce\Address\Block\Adminhtml\Order\Create;

use Magento\Framework\Convert\ConvertArray;
use Magento\Framework\Pricing\PriceCurrencyInterface;


class Billing extends \Magento\Sales\Block\Adminhtml\Order\Create\Billing\Address
{

    /**
     * Return array of additional form element renderers by element id
     *
     * @return array
     */
    protected function _getAdditionalFormElementRenderers()
    {
        return [
            'region' => $this->getLayout()->createBlock('Magento\Customer\Block\Adminhtml\Edit\Renderer\Region'),
            'city'   => $this->getLayout()->createBlock('Acommerce\Address\Block\Adminhtml\Edit\Renderer\City'),
            'subdistrict' => $this->getLayout()->createBlock('Acommerce\Address\Block\Adminhtml\Edit\Renderer\Subdistrict'),
            'postcode'    => $this->getLayout()->createBlock('Acommerce\Address\Block\Adminhtml\Edit\Renderer\Postcode'),
        ];
    }


    /**
     * Add rendering EAV attributes to Form element
     *
     * @param \Magento\Customer\Api\Data\AttributeMetadataInterface[] $attributes
     * @param \Magento\Framework\Data\Form\AbstractForm $form
     * @return $this
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    protected function _addAttributesToForm($attributes, \Magento\Framework\Data\Form\AbstractForm $form)
    {
        // add additional form types
        $types = $this->_getAdditionalFormElementTypes();
        foreach ($types as $type => $className) {
            $form->addType($type, $className);
        }
        $renderers = $this->_getAdditionalFormElementRenderers();

        foreach ($attributes as $attribute) {
            $inputType = $attribute->getFrontendInput();

            if ($inputType) {
                $element = $form->addField(
                    $attribute->getAttributeCode(),
                    $inputType,
                    [
                        'name' => $attribute->getAttributeCode(),
                        'label' => __($attribute->getStoreLabel()),
                        'class' => $attribute->getFrontendClass(),
                        'required' => $attribute->isRequired()
                    ]
                );

                if ($inputType == 'multiline') {
                    $element->setLineCount($attribute->getMultilineCount());
                }
                $element->setEntityAttribute($attribute);
                $this->_addAdditionalFormElementData($element);
                if($attribute->getAttributeCode() == 'city_id' || $attribute->getAttributeCode() == 'subdistrict_id' || $attribute->getAttributeCode() == 'zipcode'){
                    $element->setNoDisplay(true);
                }
                if (!empty($renderers[$attribute->getAttributeCode()])) {
                    $element->setRenderer($renderers[$attribute->getAttributeCode()]);
                }

                if ($inputType == 'select' || $inputType == 'multiselect') {
                    $options = [];
                    foreach ($attribute->getOptions() as $optionData) {
                        $options[] = ConvertArray::toFlatArray(
                            $this->dataObjectProcessor->buildOutputDataArray(
                                $optionData,
                                '\Magento\Customer\Api\Data\OptionInterface'
                            )
                        );
                    }
                    $element->setValues($options);
                } elseif ($inputType == 'date') {
                    $format = $this->_localeDate->getDateFormat(
                        \IntlDateFormatter::SHORT
                    );
                    $element->setDateFormat($format);
                }
            }
        }

        return $this;
    }

}