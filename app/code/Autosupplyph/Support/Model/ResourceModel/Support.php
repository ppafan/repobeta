<?php

namespace Autosupplyph\Support\Model\ResourceModel;


class Support extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * construct
     * @return void
     */
    protected function _construct()
    {
        $this->_init('autosupplyph_support_support', 'id');
    }
}
