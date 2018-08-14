<?php

namespace Acommerce\Address\Model;

class CheckoutManagement implements \Acommerce\Address\Api\CheckoutManagementInterface
{
    protected $quoteRepository;
    protected $resource;
    protected $customerSession;
    protected $addressFactory;
    
    /**
     * Constructs a shipping method read service object.
     *
     * @param \Magento\Quote\Api\CartRepositoryInterface $quoteRepository
     * @param \Magento\Framework\App\ResourceConnection $resource
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Customer\Model\AddressFactory $addressFactory
     */
    public function __construct(
        \Magento\Quote\Api\CartRepositoryInterface $quoteRepository,
        \Magento\Framework\App\ResourceConnection $resource,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Customer\Model\AddressFactory $addressFactory
    ) {
        $this->quoteRepository = $quoteRepository;
        $this->resource = $resource;
        $this->customerSession = $customerSession;
        $this->addressFactory = $addressFactory;
    }
    
    public function addShippingAddress($cartId, \Acommerce\Address\Api\Data\AddressInterface $address) 
    {
        /** @var \Magento\Quote\Model\Quote $quote */
        $quote = $this->quoteRepository->getActive($cartId);
        
        // no methods applicable for empty carts or carts with virtual products
        if (0 == $quote->getItemsCount()) {
            return [];
        }

        $connection = $this->resource->getConnection();
        $table = $this->resource->getTableName('quote_address');
        $data = ['city_id' => $address->getCityId(), 'subdistrict' => $address->getSubdistrict(), 'subdistrict_id' => $address->getSubdistrictId(), 'postcode' => $address->getPostcode(), 'country_id' => $address->getCountryId()];
        $where = ['quote_id = ?' => $quote->getId(), 'address_type = "?"' => 'shipping'];
        $connection->update($table, $data, $where);
    }

    public function addBillingAddress($cartId, \Acommerce\Address\Api\Data\AddressInterface $address) 
    {
        /** @var \Magento\Quote\Model\Quote $quote */
        $quote = $this->quoteRepository->getActive($cartId);
        
        // no methods applicable for empty carts or carts with virtual products
        if (0 == $quote->getItemsCount()) {
            return [];
        }

        $connection = $this->resource->getConnection();
        $table = $this->resource->getTableName('quote_address');
        $data = ['city_id' => $address->getCityId(), 'subdistrict' => $address->getSubdistrict(), 'subdistrict_id' => $address->getSubdistrictId(), 'postcode' => $address->getPostcode(), 'country_id' => $address->getCountryId()];
        $where = ['quote_id = ?' => $quote->getId(), 'address_type = "?"' => 'billing'];
        $connection->update($table, $data, $where);
    }
}