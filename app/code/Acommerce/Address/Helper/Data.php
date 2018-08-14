<?php
namespace Acommerce\Address\Helper;

use Acommerce\Address\Model\ResourceModel\City\Collection as CityCollection;
use Acommerce\Address\Model\ResourceModel\Subdistrict\Collection as SubdistrictCollection;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    protected $cityJson;
    protected $subdistrictJson;
    protected $postcodeJson;
    protected $storeManager;
    protected $configCacheType;
    protected $jsonHelper;
    protected $resource;
    protected $checkoutSession;
    protected $cityCollection;
    protected $subdistrictCollection;
    protected $coreRegistry;
    protected $_customerFactory;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\App\Cache\Type\Config $configCacheType,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Magento\Framework\App\ResourceConnection $resource,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Acommerce\Address\Model\ResourceModel\City\Collection $cityCollection,
        \Acommerce\Address\Model\ResourceModel\Subdistrict\Collection $subdistrictCollection
    ){
        parent::__construct($context);
        $this->storeManager = $storeManager;
        $this->configCacheType = $configCacheType;
        $this->jsonHelper = $jsonHelper;
        $this->resource = $resource;
        $this->checkoutSession = $checkoutSession;
        $this->cityCollection = $cityCollection;
        $this->subdistrictCollection = $subdistrictCollection;
        $this->coreRegistry = $coreRegistry;
        $this->_customerFactory = $customerFactory;
    }

    public function getCityJson($region = null)
    {
        if (!$this->cityJson) {
            $cacheKey = 'DIRECTORY_CITIES_JSON_STORE' . $this->storeManager->getStore()->getId();
            $json = $this->configCacheType->load($cacheKey);
            if (empty($json)) {
                $cities = [];
                foreach ($this->cityCollection as $city) {
                    $cities[$city->getRegionId()][$city->getId()] = $city->getDefaultName();
                }
                $json = $this->jsonHelper->jsonEncode($cities);
                if ($json === false) {
                    $json = 'false';
                }
                $this->configCacheType->save($json, $cacheKey);
            }
            $this->cityJson = $json;
        }
        if($region != null && $region != '' && $region != 0){
            $cities_data = $this->jsonHelper->jsonDecode($this->cityJson);
            return $this->jsonHelper->jsonEncode($cities_data[$region]);

        }
        return $this->cityJson;
    }

    public function getSubdistrictJson($city = null)
    {
        if (!$this->subdistrictJson) {
            $cacheKey = 'DIRECTORY_SUBDISTRICT_JSON_STORE' . $this->storeManager->getStore()->getId();
            $json = $this->configCacheType->load($cacheKey);
            if (empty($json)) {
                $subdistricts = [];
                foreach ($this->subdistrictCollection as $subdistrict) {
                    $subdistricts[$subdistrict->getCityId()][$subdistrict->getId()] = $subdistrict->getDefaultName();
                }
                $json = $this->jsonHelper->jsonEncode($subdistricts);
                if ($json === false) {
                    $json = 'false';
                }
                $this->configCacheType->save($json, $cacheKey);
            }
            $this->subdistrictJson = $json;
        }
        if($city != null && $city != '' && $city != 0){
            $subdistricts_data = $this->jsonHelper->jsonDecode($this->subdistrictJson);
            return $this->jsonHelper->jsonEncode($subdistricts_data[$city]);
        }
        return $this->subdistrictJson;
    }

    public function getPostcodeJson($subdistrict = null)
    {
        if (!$this->postcodeJson) {
            $cacheKey = 'DIRECTORY_POSTCODE_JSON_STORE' . $this->storeManager->getStore()->getId();
            $json = $this->configCacheType->load($cacheKey);
            if (empty($json)) {
                $postcodes = [];
                foreach ($this->subdistrictCollection as $subdistricts) {
                    $postcodes[$subdistricts->getId()] = explode(",",$subdistricts->getPostcode());
                }
                $json = $this->jsonHelper->jsonEncode($postcodes);
                if ($json === false) {
                    $json = 'false';
                }
                $this->configCacheType->save($json, $cacheKey);
            }
            $this->postcodeJson = $json;
        }
        if($subdistrict != null && $subdistrict != '' && $subdistrict != 0){
            $postcodes_data = $this->jsonHelper->jsonDecode($this->postcodeJson);
            return $this->jsonHelper->jsonEncode($postcodes_data[$subdistrict]);
        }
        return $this->postcodeJson;
    }

    public function getAddressData($addressId)
    {
        $connection = $this->resource->getConnection();
        $select = $connection->select()->from(['cae' => 'customer_address_entity'], ['city_id','subdistrict','subdistrict_id'])->where('entity_id = ?', $addressId);
        return $connection->fetchRow($select);
    }

    public function prepareAddressData()
    {
        $result = [];
        $quote = $this->checkoutSession->getQuote();
        $shippingAddress = $quote->getShippingAddress();

        $result['city'] = $shippingAddress->getRegionId() ? $this->jsonHelper->jsonDecode($this->getCityJson($shippingAddress->getRegionId())) : [];
        $city_data = $shippingAddress->getCity() ? array_flip($result['city']) : [];

        if($shippingAddress->getCityId()){
            $result['city_id'] = $shippingAddress->getCityId();
        } else {
            $result['city_id'] = array_key_exists($shippingAddress->getCity(), $city_data) ? $city_data[$shippingAddress->getCity()] : '';
        }

        $result['subdistrict'] = ($result['city_id'] != '') ? $this->jsonHelper->jsonDecode($this->getSubdistrictJson($result['city_id'])) : [];
        $subdistrict_data = $shippingAddress->getSubdistrict() ? array_flip($result['subdistrict']) : [];

        if($shippingAddress->getCityId()){
            $result['subdistrict_id'] = $shippingAddress->getSubdistrictId();
        } else {
            $result['subdistrict_id'] = array_key_exists($shippingAddress->getSubdistrict(), $subdistrict_data) ? $subdistrict_data[$shippingAddress->getSubdistrict()] : '';
        }

        $result['postcode'] = ($result['subdistrict_id'] != '') ? $this->jsonHelper->jsonDecode($this->getPostcodeJson($result['subdistrict_id'])) : [];
        $result['postcode_id'] = $shippingAddress->getPostcode();

        return $this->jsonHelper->jsonEncode($result);
    }

    public function getCustomerAddresses(){
        $result = array();
        $customerId = $this->coreRegistry->registry('current_customer_id');
        $isExistingCustomer = (bool)$customerId;
        for ($i=0; $i<=20; $i++){
            $result['new_' . $i] = array(
                'appliedchange'=>0,
                'city'=>'',
                'barangay'=>''
            );
        }
        if ($isExistingCustomer) {
            try {
                $customer = $this->_customerFactory->create();
                $customer->load($customerId);
                $addresses = $customer->getAddresses();
                foreach ($addresses as $address) {
                    $address->setAppliedchange(0);
                    $result[$address->getId()] = $address->getData();
                }

            } catch (\Exception $e) {

            }
        }
        return $this->jsonHelper->jsonEncode($result);
    }
}