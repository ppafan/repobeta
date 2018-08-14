<?php

namespace Autosupplyph\Support\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        /*
         * Drop tables if exists
         */
        $installer->getConnection()->dropTable($installer->getTable('autosupplyph_support_support'));
       

        /*
         * Create table autosupplyph_support_support
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('autosupplyph_support_support')
        )->addColumn(
            'id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            10,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Id'
        )->addColumn(
            'ticketnumber',
            \Magento\Framework\DB\Ddl\Table::TYPE_VARCHAR,
            255,
            ['nullable' => false, 'default' => ''],
            'Ticket Number'
        )->addColumn(
            'fullname',
            \Magento\Framework\DB\Ddl\Table::TYPE_VARCHAR,
            255,
            ['nullable' => true],
            ' Fullname'
        )->addColumn(
            'email',
            \Magento\Framework\DB\Ddl\Table::TYPE_VARCHAR,
            255,
            ['nullable' => false, 'default' => ''],
            'Email Address'
        )->addColumn(
            'topic',
            \Magento\Framework\DB\Ddl\Table::TYPE_VARCHAR,
            255,
            ['nullable' => false, 'default' => ''],
            'Topic'
        )->addColumn(
            'status',
            \Magento\Framework\DB\Ddl\Table::TYPE_VARCHAR,
            255,
            ['nullable' => false, 'default' => ''],
            'Status'
        )->addColumn(
            'date',
            \Magento\Framework\DB\Ddl\Table::TYPE_VARCHAR,
            255,
            ['nullable' => false, 'default' => ''],
            'Date'
        )->addColumn(
            'time',
            \Magento\Framework\DB\Ddl\Table::TYPE_VARCHAR,
            255,
            ['nullable' => false, 'default' => ''],
            'Time'
        );
        $installer->getConnection()->createTable($table);
        /*
         * End create table magestore_company_staffs
         */

       

        $installer->endSetup();
    }
}