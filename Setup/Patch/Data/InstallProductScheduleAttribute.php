<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Hatslogic\Schedulemanager\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;

/**
* Patch is mechanism, that allows to do atomic upgrade data changes
*/
class InstallProductScheduleAttribute implements
    DataPatchInterface,
    PatchRevertableInterface
{
    /**
     * @var ModuleDataSetupInterface $moduleDataSetup
     */
    private $moduleDataSetup;

    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     */
    public function __construct(
    ModuleDataSetupInterface $moduleDataSetup,
    EavSetupFactory $eavSetupFactory)
    {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * Do Upgrade
     *
     * @return void
     */
    public function apply()
    {
        /**
         * Add attributes to the eav_attribute
        */
        
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'product_scheduled_from',
            [
                'group'                   => 'Product Scheduler',
                'type'                    => 'varchar',
                'backend'                 => '',
                'frontend'                => '',
                'label'                   => 'Product Scheduled From',
                'input'                   => 'date',
                'frontend_class'          => 'required-entry',
                'global'                  => ScopedAttributeInterface::SCOPE_GLOBAL,
                'visible'                 => true,
                'required'                => false,
                'user_defined'            => false,
                'default'                 => '',
                'searchable'              => false,
                'filterable'              => false,
                'comparable'              => false,
                'unique'                  => false,
                'visible_on_front'        => false,
                'used_in_product_listing' => false
            ]
        );

        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'product_scheduled_to',
            [
                'group'                   => 'Product Scheduler',
                'type'                    => 'varchar',
                'backend'                 => '',
                'frontend'                => '',
                'label'                   => 'Product Scheduled To',
                'input'                   => 'date',
                'frontend_class'          => 'required-entry',
                'global'                  => ScopedAttributeInterface::SCOPE_GLOBAL,
                'visible'                 => true,
                'required'                => false,
                'user_defined'            => false,
                'default'                 => '',
                'searchable'              => false,
                'filterable'              => false,
                'comparable'              => false,
                'unique'                  => false,
                'visible_on_front'        => false,
                'used_in_product_listing' => false
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function revert()
    {
        /**
         * Remove attributes to the eav_attribute
        */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $eavSetup->removeAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'product_scheduled_from'
        );
         $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        $eavSetup->removeAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'product_scheduled_to'
        );
    }

    /**
     * @inheritdoc
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public static function getDependencies()
    {
        return [];
    }
}
