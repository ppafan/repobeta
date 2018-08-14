<?php

namespace Acommerce\Address\Plugin\Magento\Checkout\Block;

class LayoutProcessor
{
    protected $jsonHelper;
    protected $addressHelper;

    public function __construct(
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Acommerce\Address\Helper\Data $addressHelper
    ) {
        $this->jsonHelper = $jsonHelper;
        $this->addressHelper = $addressHelper;
    }

    /**
     * @param \Magento\Checkout\Block\Checkout\LayoutProcessor $subject
     * @param array $jsLayout
     * @return array
     */
    public function afterProcess(
        \Magento\Checkout\Block\Checkout\LayoutProcessor $subject,
        array  $jsLayout
    ) {
        $shippingAddressData = $this->jsonHelper->jsonDecode($this->addressHelper->prepareAddressData());
        $cityOpt = [];
        $cityOpt[] = ['value' => '', 'label' => __('Please select a city.')];
        if($shippingAddressData['city']){
            foreach ($shippingAddressData['city'] as $key => $value) {
                $cityOpt[] = ['value' => $key, 'label' => $value];
            }
        }

        $subdistrictOpt = [];
        $subdistrictOpt[] = ['value' => '', 'label' => __('Please select a barangay.')];
        if($shippingAddressData['subdistrict']){
            foreach ($shippingAddressData['subdistrict'] as $key => $value) {
                $subdistrictOpt[] = ['value' => $key, 'label' => $value];
            }
        }

        $postcodeOpt = [];
        $postcodeOpt[] = ['value' => '', 'label' => __('Please select a postcode.')];
        if($shippingAddressData['postcode']){
            foreach ($shippingAddressData['postcode'] as $key => $value) {
                $postcodeOpt[] = ['value' => $value, 'label' => $value];
            }
        }

        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['city_id'] = [
            'component' => 'Magento_Ui/js/form/element/select',
            'config' => [
                'customScope' => 'shippingAddress',
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/select',
                'id' => 'city_id'
            ],
            'dataScope' => 'shippingAddress.city_id',
            'label' => __('City/Municipality'),
            'provider' => 'checkoutProvider',
            'visible' => true,
            'validation' => ['validate-select' => false],
            'sortOrder' => 110,
            'id' => 'city_id',
            'additionalClasses' => 'required',
            'options' => $cityOpt
        ];
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['subdistrict'] = [
            'component' => 'Magento_Ui/js/form/element/abstract',
            'config' => [
                'customScope' => 'shippingAddress',
                'template' => 'ui/form/field',
                'options' => [],
                'id'=>'subdistrict'
            ],
            'dataScope' => 'shippingAddress.subdistrict',
            'label' => __('Barangay'),
            'provider' => 'checkoutProvider',
            'visible' => true,
            'validation' => false,
            'sortOrder' => 111,
            'id' => 'subdistrict',
            'additionalClasses' => 'required',
        ];
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['subdistrict_id'] = [
            'component' => 'Magento_Ui/js/form/element/select',
            'config' => [
                'customScope' => 'shippingAddress',
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/select',
                'id' => 'subdistrict_id',
            ],
            'dataScope' => 'shippingAddress.subdistrict_id',
            'label' => __('Barangay'),
            'provider' => 'checkoutProvider',
            'visible' => true,
            'validation' => ['validate-select' => false],
            'sortOrder' => 112,
            'id' => 'subdistrict_id',
            'additionalClasses' => 'required',
            'options' => $subdistrictOpt
        ];
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['zipcode'] = [
            'component' => 'Magento_Ui/js/form/element/select',
            'config' => [
                'customScope' => 'shippingAddress',
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/select',
                'id' => 'zipcode',
            ],
            'dataScope' => 'shippingAddress.zipcode',
            'label' => __('Zip/Postal Code'),
            'provider' => 'checkoutProvider',
            'visible' => true,
            'validation' => ['validate-select' => false],
            'sortOrder' => 113,
            'id' => 'zipcode',
            'additionalClasses' => 'required',
            'options' => $postcodeOpt
        ];
        $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']['payment']
        ['children']['afterMethods']['children']['billing-address-form']['children']['form-fields']['children']['city_id'] = [
            'component' => 'Magento_Ui/js/form/element/select',
            'config' => [
                'customScope' => 'billingAddressshared',
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/select',
                'id' => 'city_id',
            ],
            'dataScope' => 'billingAddressshared.city_id',
            'label' => __('City/Municipality'),
            'provider' => 'checkoutProvider',
            'visible' => true,
            'validation' => ['validate-select' => true],
            'sortOrder' => 110,
            'id' => 'city_id',
            'additionalClasses' => 'required',
            'options' => [
                [
                    'value' => '',
                    'label' => __('Please select a city.'),
                ]
            ]
        ];
        $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']['payment']
        ['children']['afterMethods']['children']['billing-address-form']['children']['form-fields']['children']['subdistrict'] = [
            'component' => 'Magento_Ui/js/form/element/abstract',
            'config' => [
                'customScope' => 'billingAddressshared',
                'template' => 'ui/form/field',
                'options' => [],
                'id'=>'subdistrict'
            ],
            'dataScope' => 'billingAddressshared.subdistrict',
            'label' => __('Barangay'),
            'provider' => 'checkoutProvider',
            'visible' => true,
            'validation' => false,
            'sortOrder' => 111,
            'id' => 'subdistrict',
            'additionalClasses' => 'required',
        ];
        $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']['payment']
        ['children']['afterMethods']['children']['billing-address-form']['children']['form-fields']['children']['subdistrict_id'] = [
            'component' => 'Magento_Ui/js/form/element/select',
            'config' => [
                'customScope' => 'billingAddressshared',
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/select',
                'id' => 'subdistrict_id',
            ],
            'dataScope' => 'billingAddressshared.subdistrict_id',
            'label' => __('Barangay'),
            'provider' => 'checkoutProvider',
            'visible' => true,
            'validation' => ['validate-select' => true],
            'sortOrder' => 112,
            'id' => 'subdistrict_id',
            'additionalClasses' => 'required',
            'options' => [
                [
                    'value' => '',
                    'label' => __('Please select a barangay.'),
                ]
            ]
        ];
        $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']['payment']
        ['children']['afterMethods']['children']['billing-address-form']['children']['form-fields']['children']['zipcode'] = [
            'component' => 'Magento_Ui/js/form/element/select',
            'config' => [
                'customScope' => 'billingAddressshared',
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/select',
                'id' => 'zipcode',
            ],
            'dataScope' => 'billingAddressshared.zipcode',
            'label' => __('Zip/Postal Code'),
            'provider' => 'checkoutProvider',
            'visible' => true,
            'validation' => ['validate-select' => true],
            'sortOrder' => 113,
            'id' => 'zipcode',
            'additionalClasses' => 'required',
            'options' => [
                [
                    'value' => '',
                    'label' => __('Please select a postcode.'),
                ]
            ]
        ];
        $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']['payment']
        ['children']['afterMethods']['children']['billing-address-form']['children']['form-fields']['children']['telephone']=[
            'component' => 'Magento_Ui/js/form/element/abstract',
            'config' => [
                'customScope' => 'billingAddressshared',
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/input',
                'options' => [],
                'id' => 'telephone'
            ],
            'dataScope' => 'billingAddressshared.telephone',
            'label' => 'Phone Number',
            'provider' => 'checkoutProvider',
            'visible' => true,
            'placeholder' => '0919736202',
            'validation' => [
                'required-entry' => true,
                'validate-number' => true
            ],
            'id' => 'telephone'
        ]
        ;
        
        return $jsLayout;
    }
}