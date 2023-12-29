<?php
namespace  Hatslogic\Schedulemanager\Setup;
class Uninstall implements \Magento\Framework\Setup\UninstallInterface
{
    /**
     * Module uninstall code
     *
     * @param \Magento\Framework\Setup\SchemaSetupInterface $setup
     * @param \Magento\Framework\Setup\ModuleContextInterface $context
     * @return void
     */
    protected $eavSetupFactory;

    public function __construct(\Magento\Eav\Setup\EavSetupFactory $eavSetupFactory)
    {
            $this->eavSetupFactory = $eavSetupFactory;
    }

    public function uninstall(
        \Magento\Framework\Setup\SchemaSetupInterface $setup,
        \Magento\Framework\Setup\ModuleContextInterface $context
    )
    {
        $setup->startSetup();

        $eavSetup->removeAttribute(
                \Magento\Catalog\Model\Product::ENTITY,
                'product_scheduled_from'
            );
             $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
            $eavSetup->removeAttribute(
                \Magento\Catalog\Model\Product::ENTITY,
                'product_scheduled_to'
            );

        $setup->endSetup();
    } //end uninstall()

}//end class