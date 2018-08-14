<?php
namespace Acommerce\Address\Model\ResourceModel\Address\Attribute\Source;
class Zipcode extends \Magento\Eav\Model\Entity\Attribute\Source\Table
{
    protected $subdistrictFactory;

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
            $this->_options = $this->_createZipcodeCollection()->load()->zipcodetoOptionArray();
        }
        return $this->_options;
    }

    /**
     * @return \Acommerce\Address\Model\ResourceModel\City\Collection
     */
    protected function _createZipcodeCollection()
    {
        return $this->subdistrictFactory->create();
    }
}
