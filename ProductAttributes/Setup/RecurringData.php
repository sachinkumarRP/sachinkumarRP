<?php

namespace RightpointAssignment\ProductAttributes\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\InstallDataInterface;
use SomethingDigital\Migration\Api\MigratorInterface;

class RecurringData implements InstallDataInterface
{
    /**
     * @var MigratorInterface
     */
    protected $migrator;

    public function __construct(MigratorInterface $migrator)
    {
        $this->migrator = $migrator;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $this->migrator->execute($setup, 'RightpointAssignment_ProductCmsPage', 'data');
    }
}
