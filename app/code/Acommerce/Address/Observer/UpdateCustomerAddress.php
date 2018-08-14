<?php

namespace Acommerce\Address\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;

/**
 * UpdateCustomerAddress Observer
 */
class UpdateCustomerAddress implements ObserverInterface
{
    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $request;

    /**
     * @var \Magento\Framework\App\ResourceConnection
     */
    protected $resource;


    /**
     * @var \Magento\Framework\Registry
     */

    protected $_registry;

    /**
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Magento\Framework\App\ResourceConnection $request
     */
    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\App\ResourceConnection $resource,
        \Magento\Framework\Registry $registry
    ) {
        $this->request = $request;
        $this->resource = $resource;
        $this->_registry = $registry;
    }

    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        $customerAddress = $observer->getCustomerAddress();
        $params = $this->request->getParams();
        if(array_key_exists('city_id', $params) && array_key_exists('subdistrict', $params) && array_key_exists('subdistrict_id', $params)){
            $connection = $this->resource->getConnection();
            $table = $this->resource->getTableName('customer_address_entity');
            $data = ['city_id' => $params['city_id'],'subdistrict' => $params['subdistrict'],'subdistrict_id' => $params['subdistrict_id']];
            $where = ['entity_id = ?' => $customerAddress->getId()];
            $connection->update($table, $data, $where);
        }
        $addressId = $customerAddress->getId();
        $x = $this->_registry->registry('acom_newaddress_number')?$this->_registry->registry('acom_newaddress_number'):0;
        if(isset($params['address'][$addressId])){
           $addressData = $params['address'][$addressId];
           if(array_key_exists('city_id', $addressData) && array_key_exists('subdistrict', $addressData) && array_key_exists('subdistrict_id', $addressData)){
               $connection = $this->resource->getConnection();
               $table = $this->resource->getTableName('customer_address_entity');
               $data = ['city_id' => $addressData['city_id'],'subdistrict' => $addressData['subdistrict'],'subdistrict_id' => $addressData['subdistrict_id'],'zipcode' => $addressData['zipcode']];
               $where = ['entity_id = ?' => $customerAddress->getId()];
               $connection->update($table, $data, $where);
           }
        }else if($addressId && isset($params['address']['new_'.$x]) && !$customerAddress->getOrigData()){
            $addressData = $params['address']['new_'.$x];
            if(array_key_exists('city_id', $addressData) && array_key_exists('subdistrict', $addressData) && array_key_exists('subdistrict_id', $addressData)){
                $connection = $this->resource->getConnection();
                $table = $this->resource->getTableName('customer_address_entity');
                $data = ['city_id' => $addressData['city_id'],'subdistrict' => $addressData['subdistrict'],'subdistrict_id' => $addressData['subdistrict_id'],'zipcode' => $addressData['zipcode']];
                $where = ['entity_id = ?' => $customerAddress->getId()];
                $connection->update($table, $data, $where);
            }
            $this->_registry->unregister('acom_newaddress_number');
            $this->_registry->register('acom_newaddress_number',$x+1);
        }
    }
}
