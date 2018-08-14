<?php

namespace Acommerce\Address\Setup;

class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{
    /**
     * install tables
     *
     * @param \Magento\Framework\Setup\SchemaSetupInterface $setup
     * @param \Magento\Framework\Setup\ModuleContextInterface $context
     * @return void
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(\Magento\Framework\Setup\SchemaSetupInterface $setup, \Magento\Framework\Setup\ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        if ($installer->tableExists('directory_country_region')) {
            $installer->getConnection()->addIndex(
                $installer->getTable('directory_country_region'),
                $setup->getIdxName(
                    $installer->getTable('directory_country_region'),
                    ['default_name'],
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
                ),
                ['default_name'],
                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
            );
        }
        if (!$installer->tableExists('directory_country_region_city')) {
            $tableCity = $installer->getConnection()
                ->newTable($installer->getTable('directory_country_region_city'))
                ->addColumn(
                    'city_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                    'City Id'
                )
                ->addColumn(
                    'region_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    ['unsigned' => true, 'nullable' => false,],
                    'Region Id'
                )
                ->addColumn(
                    'default_name',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    null,
                    ['default' => null],
                    'City Name'
                )
                ->addForeignKey(
                    $setup->getFkName('directory_country_region_city', 'region_id', 'directory_country_region', 'region_id'),
                    'region_id',
                    $setup->getTable('directory_country_region'),
                    'region_id',
                    \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
                )
                ;
            $installer->getConnection()->createTable($tableCity);
        }
        if (!$installer->tableExists('directory_country_region_city_subdistrict')) {
            $tableCity = $installer->getConnection()
                ->newTable($installer->getTable('directory_country_region_city_subdistrict'))
                ->addColumn(
                    'subdistrict_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                    'Subdistrict Id'
                )
                ->addColumn(
                    'city_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    ['unsigned' => true, 'nullable' => false,],
                    'City Id'
                )
                ->addColumn(
                    'default_name',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    null,
                    ['default' => null],
                    'Subdistrict Name'
                )
                ->addForeignKey(
                    $setup->getFkName('directory_country_region_city_subdistrict', 'city_id', 'directory_country_region_city', 'city_id'),
                    'city_id',
                    $setup->getTable('directory_country_region_city'),
                    'city_id',
                    \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
                )
                ;
            $installer->getConnection()->createTable($tableCity);
        }
        $installer->endSetup();
    }
}
