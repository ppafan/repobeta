<?php

namespace Acommerce\Address\Model\ResourceModel\City;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'city_id';
    /**
     * Define resource model.
     */
    protected function _construct()
    {
        $this->_init('Acommerce\Address\Model\City', 'Acommerce\Address\Model\ResourceModel\City');
    }

    public function toOptionArray()
    {
        $options = [];
        foreach ($this as $item) {
            $option = [];
            $option['value'] = $item->getData('city_id');
            $option['region_id'] = $item->getData('region_id');
            $option['title'] = $item->getData('default_name');
            $option['label'] = $item->getData('default_name');
            $options[] = $option;
        }

        if (count($options) > 0) {
            array_unshift(
                $options,
                ['title' => null, 'value' => null, 'label' => __('Please select a city.')]
            );
        }
        return $options;
    }
}
