<?php
namespace Niks\LayeredNavigation\Plugin;

/**
 * Class CategoryViewBlock
 * @package Niks_LayeredNavigation
 */
class CategoryViewBlock
{
    const PRODUCT_LIST_WRAPPER = 'niks-ajax-wrapper';

    /**
     * Wrap products block for ajax
     *
     * @param \Magento\Catalog\Block\Category\View $subject
     * @param string $result
     * @return string
     */
    public function afterToHtml(\Magento\Catalog\Block\Product\ListProduct $subject, $result)
    {
        if ($subject->getNameInLayout() == 'category.products.list' || $subject->getNameInLayout() == 'search_result_list') {
            $result = '<div class="' . self::PRODUCT_LIST_WRAPPER . '">' . $result . '</div>';
        }
        return $result;
    }
}
