<?php


namespace Autosupplyph\Support\Model\ResourceModel\Support;


class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'id';

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('Autosupplyph\Support\Model\Support', 'Autosupplyph\Support\Model\ResourceModel\Support');
    }
}
