<?php


/**
 * Created by PhpStorm.
 * User: dathq
 * Date: 28/11/2017
 * Time: 17:21
 */
namespace Acommerce\Address\Block\Adminhtml\Edit\Renderer;

class Subdistrict extends \Magento\Backend\Block\AbstractBlock implements
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
        if ($cityId = $element->getForm()->getElement('city_id')) {
            $cityId = $cityId;
        } else {
            return $element->getDefaultHtml();
        }

        $subdistrict = $element->getForm()->getElement('subdistrict')->getValue();
        $subdistrict = $subdistrict?$subdistrict:$element->getForm()->getElement('subdistrict_id')->getValue();
        $html = '<div class="field field-state required admin__field _required">';
        $element->setClass('input-text admin__control-text');
        $element->setRequired(true);
        $html .= $element->getLabelHtml() . '<div class="control admin__field-control">';
        $html .= $element->getElementHtml();

        $selectName = str_replace('subdistrict', 'subdistrict_id', $element->getName());
        $selectId = $element->getHtmlId() . '_id';
        $html .= '<select id="' .
            $selectId .
            '" name="' .
            $selectName .
            '" class="select required-entry admin__control-select" >';
        $html .= '<option value="">' . __('Please select a barangay') . '</option>';
        $html .= '</select>';

        $html .= '<script>' . "\n";
        $html .= 'require(["prototype", "acommerceform"], function(){';
        $html .= '$("' . $selectId . '").setAttribute("defaultValue", "' . $subdistrict . '");' . "\n";
        $html .= 'new SubdistrictUpdater("' .
            $cityId->getHtmlId() .
            '", "' .
            $element->getHtmlId() .
            '", "' .
            $selectId .
            '", ' .
            $this->_directoryHelper->getSubdistrictJson() .
            ');' .
            "\n";

        $html .= '});';
        $html .= '</script>' . "\n";

        $html .= '</div></div>' . "\n";

        return $html;
    }

}