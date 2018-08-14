<?php
/**
*@api
*/
namespace Acommerce\Address\Api;

interface CheckoutManagementInterface
{
    /**
     * Add new shipping address to address book
     * @param mixed $cartId
     * @param \Acommerce\Address\Api\Data\AddressInterface $address
     * @return \Magento\Quote\Api\Data\ShippingMethodInterface[] An array of shipping methods
     */
    public function addShippingAddress($cartId, \Acommerce\Address\Api\Data\AddressInterface $address);

    /**
     * Add new billing address to address book
     * @param mixed $cartId
     * @param \Acommerce\Address\Api\Data\AddressInterface $address
     * @return \Magento\Quote\Api\Data\ShippingMethodInterface[] An array of shipping methods
     */
    public function addBillingAddress($cartId, \Acommerce\Address\Api\Data\AddressInterface $address);
}