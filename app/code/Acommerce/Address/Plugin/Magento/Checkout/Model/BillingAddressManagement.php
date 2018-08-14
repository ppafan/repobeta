<?php

namespace Acommerce\Address\Plugin\Magento\Checkout\Model;


class BillingAddressManagement
{
    protected $checkoutSession;
    protected $addressHelper;

    public function __construct(
        \Magento\Checkout\Model\Session $checkoutSession,
        \Acommerce\Address\Helper\Data $addressHelper
    ) {
        $this->checkoutSession = $checkoutSession;
        $this->addressHelper = $addressHelper;
    }

    /**
     * @param \Magento\Checkout\Model\ShippingInformationManagement $subject
     * @param $cartId
     * @param \Magento\Checkout\Api\Data\ShippingInformationInterface $addressInformation
     */
    public function aroundAssign(
        \Magento\Quote\Model\BillingAddressManagement $subject,
        \Closure $proceed,
        $cartId,
        \Magento\Quote\Api\Data\AddressInterface $addressInformation,
        $useForShipping = false
    ) {
        $extAttributes = null;
        $addr = ['city_id' => '','subdistrict' => '','subdistrict_id' => ''];

        if($extAttributes = $addressInformation->getExtensionAttributes()) {
            $addr['city_id'] = $extAttributes->getCityId();
            $addr['subdistrict'] = $extAttributes->getSubdistrict();
            $addr['subdistrict_id'] = $extAttributes->getSubdistrictId();
            $addressInformation->setData('city_id', $addr['city_id']);
            $addressInformation->setData('subdistrict', $addr['subdistrict']);
            $addressInformation->setData('subdistrict_id', $addr['subdistrict_id']);
        }

        return $proceed($cartId, $addressInformation, $useForShipping);
    }
}
