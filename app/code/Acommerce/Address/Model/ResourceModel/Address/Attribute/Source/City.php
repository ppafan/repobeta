<?php

namespace Acommerce\Address\Model\ResourceModel\Address\Attribute\Source;

class City extends \Magento\Eav\Model\Entity\Attribute\Source\Table
{
    /**
     * @var \Magento\Directory\Model\ResourceModel\Region\CollectionFactory
     */
    protected $citiesFactory;

    /**
     * @param \Magento\Eav\Model\ResourceModel\Entity\Attribute\Option\CollectionFactory $attrOptionCollectionFactory
     * @param \Magento\Eav\Model\ResourceModel\Entity\Attribute\OptionFactory $attrOptionFactory
     * @param \Acommerce\Address\Model\ResourceModel\City\CollectionFactory $citiesFactory
     */
    public function __construct(
        \Magento\Eav\Model\ResourceModel\Entity\Attribute\Option\CollectionFactory $attrOptionCollectionFactory,
        \Magento\Eav\Model\ResourceModel\Entity\Attribute\OptionFactory $attrOptionFactory,
        \Acommerce\Address\Model\ResourceModel\City\CollectionFactory $citiesFactory
    ) {
        $this->citiesFactory = $citiesFactory;
        parent::__construct($attrOptionCollectionFactory, $attrOptionFactory);
    }

    /**
     * Retrieve all region options
     *
     * @return array
     */
    public function getAllOptions()
    {
        if (!$this->_options) {
            $this->_options = $this->_createCityCollection()->load()->toOptionArray();
        }
        return $this->_options;
    }

    /**
     * @return \Acommerce\Address\Model\ResourceModel\City\Collection
     */
    protected function _createCityCollection()
    {
        return $this->citiesFactory->create();
    }
}
