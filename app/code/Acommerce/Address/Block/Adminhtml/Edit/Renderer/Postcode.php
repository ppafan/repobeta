<?php
/**
 * Created by PhpStorm.
 * User: dathq
 * Date: 29/11/2017
 * Time: 11:25
 */


namespace Acommerce\Address\Block\Adminhtml\Edit\Renderer;

class Postcode extends \Magento\Backend\Block\AbstractBlock implements
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
    )
    {
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
        if ($subdistrictId = $element->getForm()->getElement('subdistrict_id')) {
            $subdistrictId = $subdistrictId;
        } else {
            return $element->getDefaultHtml();
        }

        $postcode = $element->getForm()->getElement('postcode')->getValue();

        $html = '<div class="field field-state required admin__field _required">';
        $element->setClass('input-text admin__control-text');
        $element->setRequired(false);
        $html .= $element->getLabelHtml() . '<div class="control admin__field-control">';
        $html .= $element->getElementHtml();

        $selectName = str_replace('postcode', 'postcode_id', $element->getName());
        $selectId = $element->getHtmlId() . '_id';
        $html .= '<select id="' .
            $selectId .
            '" name="' .
            $selectName .
            '" class="select required-entry admin__control-select" >';
        $html .= '<option value="">' . __('Please select a postcode') . '</option>';
        $html .= '</select>';

        $html .= '<script>' . "\n";
        $html .= 'require(["prototype", "acommerceform"], function(){';
        $html .= '$("' . $selectId . '").setAttribute("defaultValue", "' . $postcode . '");' . "\n";
        $html .= 'new ZipcodeUpdater("' .
            $subdistrictId->getHtmlId() .
            '", "' .
            $element->getHtmlId() .
            '", "' .
            $selectId .
            '", ' .
            $this->_directoryHelper->getPostcodeJson() .
            ');' .
            "\n";

        $html .= '});';
        $html .= '</script>' . "\n";

        $html .= '</div></div>' . "\n";

        return $html;
    }

}
