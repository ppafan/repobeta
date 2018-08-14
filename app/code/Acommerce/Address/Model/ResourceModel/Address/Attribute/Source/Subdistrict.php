<?php

namespace Acommerce\Address\Model\ResourceModel\Address\Attribute\Source;

class Subdistrict extends \Magento\Eav\Model\Entity\Attribute\Source\Table
{
    /**
     * @var \Magento\Directory\Model\ResourceModel\Region\CollectionFactory
     */
    protected $subdistrictFactory;

    /**
     * @param \Magento\Eav\Model\ResourceModel\Entity\Attribute\Option\CollectionFactory $attrOptionCollectionFactory
     * @param \Magento\Eav\Model\ResourceModel\Entity\Attribute\OptionFactory $attrOptionFactory
     * @param \Acommerce\Address\Model\ResourceModel\Subdistrict\CollectionFactory $subdistrictFactory
     */
    public function __construct(
        \Magento\Eav\Model\ResourceModel\Entity\Attribute\Option\CollectionFactory $attrOptionCollectionFactory,
        \Magento\Eav\Model\ResourceModel\Entity\Attribute\OptionFactory $attrOptionFactory,
        \Acommerce\Address\Model\ResourceModel\Subdistrict\CollectionFactory $subdistrictFactory
    ) {
        $this->subdistrictFactory = $subdistrictFactory;
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
            $this->_options = $this->_createSubdistrictCollection()->load()->toOptionArray();
        }
        return $this->_options;
    }

    /**
     * @return \Acommerce\Address\Model\ResourceModel\Subdistrict\Collection
     */
    protected function _createSubdistrictCollection()
    {
        return $this->subdistrictFactory->create();
    }
}
