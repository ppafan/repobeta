<?php

namespace Acommerce\Address\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\LocalizedException;

class UpdateOrderAddress implements ObserverInterface
{
    /**
     * @var \Magento\Framework\App\ResourceConnection
     */
    protected $resource;
    /**
     * @var \Magento\Sales\Api\OrderAddressRepositoryInterface
     */
    protected $orderAddressRepository;
    /**
     * @var \Magento\Sales\Api\OrderRepositoryInterface
     */
    protected $orderRepository;
    /**
     * @param \Magento\Sales\Api\OrderAddressRepositoryInterface $orderAddressRepository
     */
    public function __construct(
        \Magento\Framework\App\ResourceConnection $resource,
        \Magento\Sales\Api\OrderAddressRepositoryInterface $orderAddressRepository,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository
    ) {
        $this->resource = $resource;
        $this->orderAddressRepository = $orderAddressRepository;
        $this->orderRepository = $orderRepository;
    }

    /**
     * Execute observer
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(
        \Magento\Framework\Event\Observer $observer
    ) {
        /** @var \Magento\Sales\Model\Order $orderInstance */
        $orderInstance = $observer->getEvent()->getOrder();
        /** @var \Magento\Quote\Model\Quote $quoteInstance */
        $quoteInstance = $observer->getEvent()->getQuote();

        $connection = $this->resource->getConnection();
        $quoteAddressTable = $this->resource->getTableName('quote_address');
        $select = $connection->select()->from(['qa' => $quoteAddressTable], ['address_type','city_id','subdistrict','subdistrict_id'])->where('quote_id = ?', $quoteInstance->getId());
        $addrs = $connection->fetchAll($select);

        foreach ($addrs as $addr) {
            $data[$addr['address_type']] = [
                    'city_id' => $addr['city_id'],
                    'subdistrict' => $addr['subdistrict'],
                    'subdistrict_id' => $addr['subdistrict_id']
                ];
        }
        
        $orderShippingAddress = $orderInstance->getShippingAddress();
        $orderBillingAddress = $orderInstance->getBillingAddress();
        if ($orderShippingAddress !== null) {
            $orderShippingAddress->setData('city_id',$data['shipping']['city_id']);
            $orderShippingAddress->setData('subdistrict',$data['shipping']['subdistrict']);
            $orderShippingAddress->setData('subdistrict_id',$data['shipping']['subdistrict_id']);
        }
        if ($orderBillingAddress !== null) {
            $orderBillingAddress->setData('city_id',$data['billing']['city_id']);
            $orderBillingAddress->setData('subdistrict',$data['billing']['subdistrict']);
            $orderBillingAddress->setData('subdistrict_id',$data['billing']['subdistrict_id']);
        }
    }
}
