<?php

namespace Acommerce\Address\Model\ResourceModel\Subdistrict;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'subdistrict_id';
    /**
     * Define resource model.
     */
    protected function _construct()
    {
        $this->_init('Acommerce\Address\Model\Subdistrict', 'Acommerce\Address\Model\ResourceModel\Subdistrict');
    }

    public function toOptionArray()
    {
        $options = [];
        foreach ($this as $item) {
            $option = [];
            $option['value'] = $item->getData('subdistrict_id');
            $option['city_id'] = $item->getData('city_id');
            $option['postcode'] =  $item->getData('postcode');
            $option['title'] = $item->getData('default_name');
            $option['label'] = $item->getData('default_name');
            $options[] = $option;
        }

        if (count($options) > 0) {
            array_unshift(
                $options,
                ['title' => null, 'value' => null, 'label' => __('Please select a barangay')]
            );
        }
        return $options;
    }

    public function zipcodetoOptionArray()
    {
        $options = [];
        $postcodes = [];
        foreach ($this as $item) {
            if(!in_array($item->getData('postcode'),$postcodes)){
                $postcodes[] = $item->getData('postcode');
                $option = [];
                $option['value'] = $item->getData('postcode');
                $option['zipcode'] = $item->getData('postcode');
                $option['title'] = $item->getData('postcode');
                $option['label'] = $item->getData('postcode');
                $options[] = $option;
            }
        }

        if (count($options) > 0) {
            array_unshift(
                $options,
                ['title' => null, 'value' => null, 'label' => __('Please select a postcode')]
            );
        }
        return $options;
    }

}
