<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\Smtp\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;

/**
 * Smtp Upgrade Schema
 */
class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * Upgrades DB Schema for a Module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '2.1.2', '<')) {
            $this->addLogTable($setup);
        }

        $setup->endSetup();
    }

    /**
     * Add Log Table
     *
     * @param SchemaSetupInterface $setup
     * @return void
     */
    private function addLogTable(SchemaSetupInterface $setup)
    {
        $installer = $setup;
        $connection = $installer->getConnection();

        /**
         * Create table 'faonni_smtp_log'
         */
        $tableName = 'faonni_smtp_log';
        if (!$installer->tableExists($tableName)) {
            $table = $connection->newTable($installer->getTable($tableName))
                ->addColumn(
                    'log_id',
                    Table::TYPE_INTEGER,
                    null,
                    ['unsigned' => true, 'identity' => true, 'nullable' => false, 'primary' => true],
                    'Log Id'
                )
                ->addColumn(
                    'recipient_email',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false],
                    'Recipient Email'
                )
                ->addColumn(
                    'subject',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false],
                    'Subject'
                )
                ->addColumn(
                    'message_body',
                    Table::TYPE_TEXT,
                    '1024k',
                    ['nullable' => false],
                    'Message Body'
                )
                ->addColumn(
                    'from',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false],
                    'From'
                )
                ->addColumn(
                    'error',
                    Table::TYPE_TEXT,
                    '64k',
                    [],
                    'Error'
                )
                ->addColumn(
                    'status',
                    Table::TYPE_SMALLINT,
                    null,
                    ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                    'Status'
                )
                ->addColumn(
                    'created_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                    'Creation Time'
                )
                ->addColumn(
                    'updated_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
                    'Update Time'
                )
                ->addIndex(
                    $installer->getIdxName($tableName, ['status']),
                    ['status']
                )
                ->addIndex(
                    $installer->getIdxName($tableName, ['created_at']),
                    ['created_at']
                )
                ->addIndex(
                    $installer->getIdxName($tableName, ['updated_at']),
                    ['updated_at']
                )
                ->addIndex(
                    $installer->getIdxName(
                        $tableName,
                        ['subject', 'message_body'],
                        AdapterInterface::INDEX_TYPE_FULLTEXT
                    ),
                    ['subject', 'message_body'],
                    ['type' => AdapterInterface::INDEX_TYPE_FULLTEXT]
                )
                ->setComment(
                    'Faonni Smtp Log Table'
                );
            $connection->createTable($table);
        }
    }
}
