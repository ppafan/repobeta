<?php

namespace Acommerce\Address\Model;

class CountriesDataProvider implements \Magento\Checkout\Model\ConfigProviderInterface
{
    protected $directoryHelper;

    public function __construct(
        \Magento\Directory\Helper\Data $directoryHelper
    ) {
        $this->directoryHelper = $directoryHelper;
    }

    public function getConfig()
    {
        $result = [];
        $output = [];
        $regionsData = $this->directoryHelper->getRegionData();
        /**
         * @var string $code
         * @var \Magento\Directory\Model\Country $data
         */
        foreach ($this->directoryHelper->getCountryCollection() as $code => $data) {
            $output[$code]['name'] = $data->getName();
            if (array_key_exists($code, $regionsData)) {
                foreach ($regionsData[$code] as $key => $region) {
                    $output[$code]['regions'][$key]['code'] = $region['code'];
                    $output[$code]['regions'][$key]['name'] = $region['name'];
                }
            }

        }
        $result['customerData']['directory_data'] = $output;
        return $result;
    }
}
