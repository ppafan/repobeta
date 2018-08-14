<?php

namespace Acommerce\Address\Model\Quote;

class Address extends \Magento\Quote\Model\Quote\Address implements \Acommerce\Address\Api\Data\AddressInterface
{
	/**
     * {@inheritdoc}
     */
    public function getCityId()
    {
        return $this->getData(self::KEY_CITY_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setCityId($city_id)
    {
        return $this->setData(self::KEY_CITY_ID, $city_id);
    }

    /**
     * {@inheritdoc}
     */
    public function getSubdistrict()
    {
        return $this->getData(self::KEY_SUBDISTRICT);
    }

    /**
     * {@inheritdoc}
     */
    public function setSubdistrict($subdistrict)
    {
        return $this->setData(self::KEY_SUBDISTRICT, $subdistrict);
    }

    /**
     * {@inheritdoc}
     */
    public function getSubdistrictId()
    {
        return $this->getData(self::KEY_SUBDISTRICT_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setSubdistrictId($subdistrict_id)
    {
        return $this->setData(self::KEY_SUBDISTRICT_ID, $subdistrict_id);
    }
}