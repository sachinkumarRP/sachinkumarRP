<?php

namespace RightpointAssignment\ProductAttributes\Setup;

use Magento\Cms\Model\BlockFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    /**
     * @var BlockFactory
     */
    private $blockFactory;

    public function __construct(BlockFactory $blockFactory)
    {
        $this->blockFactory = $blockFactory;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $cmsBlockData = [
            'title' => 'product quality',
            'identifier' => 'custom_cms_block',
            'content' => 'Best quality product',
            'is_active' => 1,
            'stores' => [0],
            'sort_order' => 0,
        ];
        $this->blockFactory->create()->setData($cmsBlockData)->save();
    }
}
