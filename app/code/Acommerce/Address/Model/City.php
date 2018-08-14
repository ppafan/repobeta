<?php

namespace Acommerce\Address\Model;

class City extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Cache tag
     *
     * @var string
     */
    const CACHE_TAG = 'directory_country_region_city';
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Acommerce\Address\Model\ResourceModel\City');
    }
}
