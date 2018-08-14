<?php

namespace Acommerce\Address\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * {@inheritdoc}
     */
    public function upgrade(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $setup->startSetup();
        if (version_compare($context->getVersion(), "1.0.1", "<")) {
            $customer_address = $setup->getTable('customer_address_entity');
            $quote_address = $setup->getTable('quote_address');
            $order_address = $setup->getTable('sales_order_address');
            $columns = [
                    'city_id' => [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        'unsigned' => true,
                        'nullable' => true, 
                        'comment' => 'City'
                    ],
                    'subdistrict' => [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'length' => 255,
                        'comment' => 'Subdistrict'
                    ],
                    'subdistrict_id' => [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        'unsigned' => true,
                        'nullable' => true, 
                        'comment' => 'Subdistrict'
                    ]
                ];
            if ($setup->getConnection()->isTableExists($customer_address) == true) {
                $connection = $setup->getConnection();
                foreach ($columns as $name => $definition) {
                    $connection->addColumn($customer_address, $name, $definition);
                }
            }
            if ($setup->getConnection()->isTableExists($quote_address) == true) {
                $connection = $setup->getConnection();
                foreach ($columns as $name => $definition) {
                    $connection->addColumn($quote_address, $name, $definition);
                }
            }
            if ($setup->getConnection()->isTableExists($order_address) == true) {
                $connection = $setup->getConnection();
                foreach ($columns as $name => $definition) {
                    $connection->addColumn($order_address, $name, $definition);
                }
            }
        }
        if (version_compare($context->getVersion(), "1.0.3", "<")) {
            $subdistrict_tbl = $setup->getTable('directory_country_region_city_subdistrict');
            $columns = [
                    'postcode' => [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'nullable' => true,
                        'comment' => 'Postcode'
                    ]
                ];
            if ($setup->getConnection()->isTableExists($subdistrict_tbl) == true) {
                $connection = $setup->getConnection();
                foreach ($columns as $name => $definition) {
                    $connection->addColumn($subdistrict_tbl, $name, $definition);
                }
            }
        }
        if (version_compare($context->getVersion(), "1.0.4", "<")) {
            $customer_address = $setup->getTable('customer_address_entity');
            $columns = [
                'zipcode' => [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'nullable' => true,
                    'comment' => 'Zip Code'
                ]
            ];
            if ($setup->getConnection()->isTableExists($customer_address) == true) {
                $connection = $setup->getConnection();
                foreach ($columns as $name => $definition) {
                    $connection->addColumn($customer_address, $name, $definition);
                }
            }
        }
        $setup->endSetup();
    }
}
