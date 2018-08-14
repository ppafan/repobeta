<?php

namespace Acommerce\Address\Model\ResourceModel\Region;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'region_id';
    /**
     * Define resource model.
     */
    protected function _construct()
    {
        $this->_init('Acommerce\Address\Model\Region', 'Acommerce\Address\Model\ResourceModel\Region');
    }
}
