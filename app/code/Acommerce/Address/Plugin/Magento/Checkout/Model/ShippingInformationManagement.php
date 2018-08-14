<?php

namespace Acommerce\Address\Plugin\Magento\Checkout\Model;

class ShippingInformationManagement
{
    protected $checkoutSession;
    protected $jsonHelper;
    protected $addressHelper;

    public function __construct(
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Acommerce\Address\Helper\Data $addressHelper
    ) {
        $this->checkoutSession = $checkoutSession;
        $this->jsonHelper = $jsonHelper;
        $this->addressHelper = $addressHelper;
    }

    /**
     * @param \Magento\Checkout\Model\ShippingInformationManagement $subject
     * @param $cartId
     * @param \Magento\Checkout\Api\Data\ShippingInformationInterface $addressInformation
     */
    public function aroundSaveAddressInformation(
        \Magento\Checkout\Model\ShippingInformationManagement $subject,
        \Closure $proceed,
        $cartId,
        \Magento\Checkout\Api\Data\ShippingInformationInterface $addressInformation
    ) {
        $extAttributes = null;
        $addr = ['city_id' => '','subdistrict' => '','subdistrict_id' => ''];
        $billingAddress = $addressInformation->getBillingAddress();
        $shippingAddress = $addressInformation->getShippingAddress();
        if($addressId = $shippingAddress->getCustomerAddressId()){
            $addr = $this->addressHelper->getAddressData($addressId);
        } elseif($extAttributes = $shippingAddress->getExtensionAttributes()) {
            $addr['city_id'] = $extAttributes->getCityId();
            $addr['subdistrict'] = $extAttributes->getSubdistrict();
            $addr['subdistrict_id'] = $extAttributes->getSubdistrictId();
        }
        if($billingAddress){
            $billingAddress->setData('city_id', $addr['city_id']);
            $billingAddress->setData('subdistrict', $addr['subdistrict']);
            $billingAddress->setData('subdistrict_id', $addr['subdistrict_id']);
//            $shippingAddress->setData('save_in_address_book', 1);
            $addressInformation->setBillingAddress($billingAddress);
        }

        if($shippingAddress){
            $addressData = $this->jsonHelper->jsonDecode($this->addressHelper->prepareAddressData());
            if($addr['city_id'] == ''){
                $addr['city_id'] = $addressData['city_id'];
            }
            if($addr['subdistrict_id'] == ''){
                $addr['subdistrict_id'] = $addressData['subdistrict_id'];
            }

            if($addr['subdistrict_id'] && $addr['subdistrict'] == NULL){
                $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
                $subdistrictModel = $objectManager->create('\Acommerce\Address\Model\Subdistrict');
                $subdistrictModel->load($addr['subdistrict_id']);
                $addr['subdistrict'] = $subdistrictModel->getData('default_name');
            }

            $shippingAddress->setData('city_id', $addr['city_id']);
            $shippingAddress->setData('subdistrict', $addr['subdistrict']);
            $shippingAddress->setData('subdistrict_id', $addr['subdistrict_id']);
//            $shippingAddress->setData('save_in_address_book', 1);
            $addressInformation->setShippingAddress($shippingAddress);
        }

        return $proceed($cartId, $addressInformation);
    }
}
