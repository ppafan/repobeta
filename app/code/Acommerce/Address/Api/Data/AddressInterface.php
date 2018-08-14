<?php

namespace Acommerce\Address\Api\Data;

/**
 * Interface AddressInterface
 * @api
 */
interface AddressInterface extends \Magento\Quote\Api\Data\AddressInterface
{
    /**#@+
     * Constants defined for keys of array, makes typos less likely
     */
    const KEY_CITY_ID = 'city_id';

    const KEY_SUBDISTRICT = 'subdistrict';

    const KEY_SUBDISTRICT_ID = 'subdistrict_id';

    /**
     * Get city_id
     *
     * @return string
     */
    public function getCityId();

    /**
     * Set city_id
     *
     * @param string $city_id
     * @return $this
     */
    public function setCityId($city_id);

    /**
     * Get subdistrict
     *
     * @return string
     */
    public function getSubdistrict();

    /**
     * Set subdistrict
     *
     * @param string $subdistrict
     * @return $this
     */
    public function setSubdistrict($subdistrict);

    /**
     * Get subdistrict_id
     *
     * @return string
     */
    public function getSubdistrictId();

    /**
     * Set subdistrict_id
     *
     * @param string $subdistrict_id
     * @return $this
     */
    public function setSubdistrictId($subdistrict_id);
}
