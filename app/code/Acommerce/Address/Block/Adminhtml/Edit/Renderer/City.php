<?php

/**
 * Created by PhpStorm.
 * User: dathq
 * Date: 28/11/2017
 * Time: 17:21
 */
namespace Acommerce\Address\Block\Adminhtml\Edit\Renderer;

class City extends \Magento\Backend\Block\AbstractBlock implements
    \Magento\Framework\Data\Form\Element\Renderer\RendererInterface
{
    /**
     * @var \Magento\Directory\Helper\Data
     */
    protected $_directoryHelper;

    /**
     * @param \Magento\Backend\Block\Context $context
     * @param \Magento\Directory\Helper\Data $directoryHelper
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Context $context,
        \Acommerce\Address\Helper\Data $directoryHelper,
        array $data = []
    ) {
        $this->_directoryHelper = $directoryHelper;
        parent::__construct($context, $data);
    }


    /**
     * Output the region element and javasctipt that makes it dependent from country element
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     *
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        if ($regionId = $element->getForm()->getElement('region_id')) {
            $regionId = $regionId;
        } else {
            return $element->getDefaultHtml();
        }

        $cityId = $element->getForm()->getElement('city')->getValue();

        $html = '<div class="field field-state required admin__field _required">';
        $element->setClass('input-text admin__control-text');
        $element->setRequired(true);
        $html .= $element->getLabelHtml() . '<div class="control admin__field-control">';
        $html .= $element->getElementHtml();

        $selectName = str_replace('city', 'city_id', $element->getName());
        $selectId = $element->getHtmlId() . '_id';
        $html .= '<select id="' .
            $selectId .
            '" name="' .
            $selectName .
            '" class="select required-entry admin__control-select" >';
        $html .= '<option value="">' . __('Please select a city') . '</option>';
        $html .= '</select>';

        $html .= '<script>' . "\n";
        $html .= 'require(["prototype", "acommerceform"], function(){';
        $html .= '$("' . $selectId . '").setAttribute("defaultValue", "' . $cityId . '");' . "\n";
        $html .= 'new CityUpdater("' .
            $regionId->getHtmlId() .
            '", "' .
            $element->getHtmlId() .
            '", "' .
            $selectId .
            '", ' .
            $this->_directoryHelper->getCityJson() .
            ');' .
            "\n";

        $html .= '});';
        $html .= '</script>' . "\n";

        $html .= '</div></div>' . "\n";

        return $html;
    }

}