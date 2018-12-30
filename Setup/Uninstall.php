<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\Smtp\Setup;

use Magento\Framework\Setup\UninstallInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Smtp Uninstall
 */
class Uninstall implements UninstallInterface
{
    /**
     * Uninstall DB schema for a module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function uninstall(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        $connection = $installer->getConnection();

        /**
         * Remove table 'faonni_smtp_log'
         */
        $tableName = 'faonni_smtp_log';
        if ($installer->tableExists($tableName)) {
            $connection->dropTable($installer->getTable($tableName));
        }
        $installer->endSetup();
    }
}
