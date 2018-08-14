<?php

namespace Acommerce\Address\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Customer\Model\Customer;
use Magento\Eav\Model\Entity\Attribute\Set as AttributeSet;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;

class UpgradeData implements UpgradeDataInterface
{
    /**
     * EAV setup factory
     *
     * @var EavSetupFactory
     */
    protected $customerSetupFactory;
    /**
     * @var
     */
    protected $attributeSetFactory;

    /**
     * InstallData constructor.
     * @param CustomerSetupFactory $customerSetupFactory
     * @param AttributeSetFactory $attributeSetFactory
     */
    public function __construct(
        CustomerSetupFactory $customerSetupFactory,
        AttributeSetFactory $attributeSetFactory
    ) {
        $this->customerSetupFactory = $customerSetupFactory;
        $this->attributeSetFactory = $attributeSetFactory;
    }


    /**
     * {@inheritdoc}
     */
    public function upgrade(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $setup->startSetup();
        if (version_compare($context->getVersion(), "1.0.2", "<")) {
            $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);

            $customerEntity = $customerSetup->getEavConfig()->getEntityType('customer');
            $attributeSetId = $customerEntity->getDefaultAttributeSetId();

            /** @var $attributeSet AttributeSet */
            $attributeSet = $this->attributeSetFactory->create();
            $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);

            $customerSetup->addAttribute('customer_address', 'city_id', [
                'type' => 'static',
                'label' => 'City',
                'input' => 'hidden',
                'required' => false,
                'visible' => true,
                'user_defined' => false,
                'sort_order' => 90,
                'position' => 90,
                'system' => 1,
                'source_model' => 'Acommerce\Address\Model\ResourceModel\Address\Attribute\Source\City'
            ]);

            $customerSetup->addAttribute('customer_address', 'subdistrict', [
                'type' => 'static',
                'label' => 'Subdistrict',
                'input' => 'text',
                'required' => false,
                'visible' => true,
                'user_defined' => false,
                'sort_order' => 78,
                'position' => 78,
                'system' => 1,
            ]);

            $customerSetup->addAttribute('customer_address', 'subdistrict_id', [
                'type' => 'static',
                'label' => 'Subdistrict',
                'input' => 'hidden',
                'required' => false,
                'visible' => true,
                'user_defined' => false,
                'sort_order' => 79,
                'position' => 79,
                'system' => 1,
                'source_model' => 'Acommerce\Address\Model\ResourceModel\Address\Attribute\Source\Subdistrict'
            ]);

            $city_id = $customerSetup->getEavConfig()->getAttribute('customer_address', 'city_id')
                ->addData([
                    'attribute_set_id' => $attributeSetId,
                    'attribute_group_id' => $attributeGroupId,
                    'used_in_forms' => ['adminhtml_customer_address'],
                ]);
            $city_id->save();

            $subdistrict = $customerSetup->getEavConfig()->getAttribute('customer_address', 'subdistrict')
                ->addData([
                    'attribute_set_id' => $attributeSetId,
                    'attribute_group_id' => $attributeGroupId,
                    'used_in_forms' => ['adminhtml_customer_address'],
                ]);
            $subdistrict->save();

            $subdistrict_id = $customerSetup->getEavConfig()->getAttribute('customer_address', 'subdistrict_id')
                ->addData([
                    'attribute_set_id' => $attributeSetId,
                    'attribute_group_id' => $attributeGroupId,
                    'used_in_forms' => ['adminhtml_customer_address'],
                ]);
            $subdistrict_id->save();
        }
        if(version_compare($context->getVersion(), "1.0.4", "<")){

            $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);

            $customerEntity = $customerSetup->getEavConfig()->getEntityType('customer');
            $attributeSetId = $customerEntity->getDefaultAttributeSetId();

            /** @var $attributeSet AttributeSet */
            $attributeSet = $this->attributeSetFactory->create();
            $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);

            //$customerSetup->removeAttribute('customer_address','city_id');
           // $customerSetup->removeAttribute('customer_address','subdistrict_id');
            $customerSetup->updateAttribute('customer_address','city','sort_order',101);
            $customerSetup->updateAttribute('customer_address','city_id','source_model','Acommerce\Address\Model\ResourceModel\Address\Attribute\Source\City',102);
//            $customerSetup->addAttribute('customer_address', 'city_id', [
//                'type' => 'static',
//                'label' => 'City',
//                'input' => 'hidden',
//                'required' => false,
//                'visible' => true,
//                'user_defined' => false,
//                'sort_order' => 81,
//                'position' => 81,
//                'system' => 1,
//                'source' => 'Acommerce\Address\Model\ResourceModel\Address\Attribute\Source\City'
//            ]);
            $customerSetup->updateAttribute('customer_address','subdistrict_id','source_model','Acommerce\Address\Model\ResourceModel\Address\Attribute\Source\Subdistrict',103);
            $customerSetup->updateAttribute('customer_address','subdistrict','sort_order',104);
//            $customerSetup->addAttribute('customer_address', 'subdistrict_id', [
//                'type' => 'static',
//                'label' => 'Subdistrict',
//                'input' => 'hidden',
//                'required' => false,
//                'visible' => true,
//                'user_defined' => false,
//                'sort_order' => 82,
//                'position' => 82,
//                'system' => 1,
//                'source' => 'Acommerce\Address\Model\ResourceModel\Address\Attribute\Source\Subdistrict'
//            ]);
            $customerSetup->addAttribute('customer_address', 'zipcode', [
                'type' => 'static',
                'label' => 'Zip code',
                'input' => 'hidden',
                'required' => false,
                'visible' => true,
                'user_defined' => false,
                'sort_order' => 105,
                'position' => 105,
                'system' => 1,
                'source' => 'Acommerce\Address\Model\ResourceModel\Address\Attribute\Source\Zipcode'
            ]);

//
//            $city_id = $customerSetup->getEavConfig()->getAttribute('customer_address', 'city_id')
//                ->addData([
//                    'attribute_set_id' => $attributeSetId,
//                    'attribute_group_id' => $attributeGroupId,
//                    'used_in_forms' => ['adminhtml_customer_address'],
//                ]);
//            $city_id->save();
//
//            $subdistrict_id = $customerSetup->getEavConfig()->getAttribute('customer_address', 'subdistrict_id')
//                ->addData([
//                    'attribute_set_id' => $attributeSetId,
//                    'attribute_group_id' => $attributeGroupId,
//                    'used_in_forms' => ['adminhtml_customer_address'],
//                ]);
//            $subdistrict_id->save();
            $zipcode = $customerSetup->getEavConfig()->getAttribute('customer_address', 'zipcode')
                ->addData([
                    'attribute_set_id' => $attributeSetId,
                    'attribute_group_id' => $attributeGroupId,
                    'used_in_forms' => ['adminhtml_customer_address'],
                ]);
            $zipcode->save();


        }
        $setup->endSetup();
    }
}
