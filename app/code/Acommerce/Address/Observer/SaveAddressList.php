<?php

namespace Acommerce\Address\Observer;

class SaveAddressList implements \Magento\Framework\Event\ObserverInterface
{
    protected $resource;
    
    public function __construct(
        \Magento\Framework\App\ResourceConnection $resource
    ) {
        $this->resource = $resource;
    }
    /**
     * {@inheritdoc}
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /** @var \Magento\Quote\Model\Quote $quoteInstance */
        $quoteInstance = $observer->getEvent()->getQuote();
        $quoteShippingAddress = $quoteInstance->getShippingAddress();
        $quoteBillingAddress = $quoteInstance->getBillingAddress();
        
        $connection = $this->resource->getConnection();
        $table = $this->resource->getTableName('customer_address_entity');
        
        if($quoteShippingAddress->getData('save_in_address_book') == 1){
            $data = ['city_id' => $quoteShippingAddress->getData('city_id'),'subdistrict' => $quoteShippingAddress->getData('subdistrict'),'subdistrict_id' => $quoteShippingAddress->getData('subdistrict_id')];
            $where = ['entity_id = ?' => $quoteShippingAddress->getData('customer_address_id')];
            $connection->update($table, $data, $where);
        }

        if($quoteBillingAddress->getData('save_in_address_book') == 1){
            $data = ['city_id' => $quoteBillingAddress->getData('city_id'),'subdistrict' => $quoteBillingAddress->getData('subdistrict'),'subdistrict_id' => $quoteBillingAddress->getData('subdistrict_id')];
            $where = ['entity_id = ?' => $quoteBillingAddress->getData('customer_address_id')];
            $connection->update($table, $data, $where);
        }
    }
}