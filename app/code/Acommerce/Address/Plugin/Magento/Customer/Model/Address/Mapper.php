<?php

namespace Acommerce\Address\Plugin\Magento\Customer\Model\Address;

class Mapper
{
	protected $helperData;

    public function __construct(
        \Acommerce\Address\Helper\Data $helperData
    ) {
        $this->helperData = $helperData;
    }

    public function afterToFlatArray(
        \Magento\Customer\Model\Address\Mapper $subject,
        $result
    ) {
    	if($result['id']){
        	$addressData = $this->helperData->getAddressData($result['id']);
        	$result['subdistrict'] = $addressData['subdistrict'];
    	}
    	return $result;
    }
}