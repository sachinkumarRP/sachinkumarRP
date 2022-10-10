<?php

namespace RightpointAssignment\ProductAttributes\Migration\Data;

use Magento\Framework\Setup\SetupInterface;
use SomethingDigital\Migration\Api\MigrationInterface;
use SomethingDigital\Migration\Helper\Cms\Page as PageHelper;
use SomethingDigital\Migration\Helper\Cms\Block as BlockHelper;
use SomethingDigital\Migration\Helper\Email\Template as EmailHelper;
use Magento\Config\Model\ResourceModel\Config as ResourceConfig;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;

class M20220905055140Nutration implements MigrationInterface
{
    /**
     * @var PageHelper
     * @var BlockHelper
     * @var EmailHelper
     * @var ResourceConfig
     * @var EavSetupFactory
     */
    protected $page;
    protected $block;
    protected $email;
    protected $resourceConfig;
    private $eavSetupFactory;
    const ATTRIBUTE_VALUE = 'nutration';

    /**
     * @param PageHelper $page
     * @param BlockHelper $block
     * @param EmailHelper $email
     * @param ResourceConfig $resourceConfig
     * @param EavSetupFactory $eavSetupFactory
     */

    public function __construct(PageHelper $page, BlockHelper $block, EmailHelper $email, ResourceConfig $resourceConfig, EavSetupFactory $eavSetupFactory)
    {
        $this->page = $page;
        $this->block = $block;
        $this->email = $email;
        $this->resourceConfig = $resourceConfig;
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * @param SetupInterface $setup
     * @return void
     */
    public function execute(SetupInterface $setup)
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        $eavSetup->addAttribute(
            Product::ENTITY,
            self::ATTRIBUTE_VALUE,
            [
                'type' => 'text',
                'backend' => '',
                'frontend' => '',
                'label' => 'Nutration',
                'input' => 'text',
                'class' => '',
                'source' => '',
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'visible' => true,
                'required' => true,
                'user_defined' => false,
                'default' => "",
                'searchable' => false,
                'filterable' => false,
                'comparable' => false,
                'visible_on_front' => false,
                'used_in_product_listing' => true,
                'unique' => false,
                'apply_to' => ''
            ]
        );
    }
}
