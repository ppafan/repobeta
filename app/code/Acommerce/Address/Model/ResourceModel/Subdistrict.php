<?php

namespace Acommerce\Address\Model\ResourceModel;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\AbstractModel;

class Subdistrict extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * construct
     * @return void
     */
    protected function _construct()
    {
        $this->_init('directory_country_region_city_subdistrict', 'subdistrict_id');
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
        if ($this->checkSubdistrictAlreadyExist($object)) {
            throw new LocalizedException(
                __('The subdistrict already exists.')
            );
        }
    }

    protected function checkSubdistrictAlreadyExist(AbstractModel $object)
    {
        $select = $this->getConnection()->select()
            ->from(['dcrcs' => $this->getMainTable()])
            ->where('dcrcs.default_name = ?', $object->getData('default_name'));
        if ($this->getConnection()->fetchRow($select)) {
            return true;
        }
        return false;
    }
}
