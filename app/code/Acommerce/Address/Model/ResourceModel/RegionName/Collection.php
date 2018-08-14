<?php

namespace Acommerce\Address\Model\ResourceModel\RegionName;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'region_id';
    /**
     * Define resource model.
     */
    protected function _construct()
    {
        $this->_init('Acommerce\Address\Model\RegionName', 'Acommerce\Address\Model\ResourceModel\RegionName');
    }
}
