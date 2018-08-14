<?php

namespace Acommerce\Address\Model\ResourceModel;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\AbstractModel;

class City extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * construct
     * @return void
     */
    protected function _construct()
    {
        $this->_init('directory_country_region_city', 'city_id');
    }

    /**
     * Perform operations before object save
     *
     * @param AbstractModel $object
     * @return $this
     * @throws LocalizedException
     */
    protected function _beforeSave(AbstractModel $object)
    {
        if ($this->checkCityAlreadyExist($object)) {
            throw new LocalizedException(
                __('The city already exists.')
            );
        }
    }

    protected function checkCityAlreadyExist(AbstractModel $object)
    {
        $select = $this->getConnection()->select()
            ->from(['dcrc' => $this->getMainTable()])
            ->where('dcrc.default_name = ?', $object->getData('default_name'));
        if ($this->getConnection()->fetchRow($select)) {
            return true;
        }
        return false;
    }
}
