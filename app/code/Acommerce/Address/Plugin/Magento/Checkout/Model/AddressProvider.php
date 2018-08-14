<?php

namespace Acommerce\Address\Plugin\Magento\Checkout\Model;

class AddressProvider
{
    protected $customerSession;
    protected $customerRepository;
    protected $helperData;

    public function __construct(
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        \Acommerce\Address\Helper\Data $helperData
    ) {
        $this->customerSession = $customerSession;
        $this->customerRepository = $customerRepository;
        $this->helperData = $helperData;
    }

    public function afterGetConfig(
        \Magento\Checkout\Model\DefaultConfigProvider $subject,
        $result
    ) {
        if($this->customerSession->isLoggedIn()){
            foreach ($result['customerData']['addresses'] as $key => $address) {
                $additionalData = $this->helperData->getAddressData($address['id']);
                $result['customerData']['addresses'][$key]['city_id'] = $additionalData['city_id'];
                $result['customerData']['addresses'][$key]['subdistrict'] = $additionalData['subdistrict'];
                $result['customerData']['addresses'][$key]['subdistrict_id'] = $additionalData['subdistrict_id'];
            }
        }
        return $result;
    }
}