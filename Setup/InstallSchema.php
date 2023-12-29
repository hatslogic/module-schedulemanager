<?php

namespace Hatslogic\Schedulemanager\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{

    
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup(); 

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); // Instance of object manager
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $cmsPage = $resource->getTableName('cms_page');

        $connection->addColumn($cmsPage, 'published_from', ['type' =>\Magento\Framework\DB\Ddl\Table::TYPE_DATE,'comment' => 'Published From']);
        $connection->addColumn($cmsPage, 'published_to', ['type' =>\Magento\Framework\DB\Ddl\Table::TYPE_DATE,'comment' => 'Published To']);
        $installer->endSetup();
    }
}
