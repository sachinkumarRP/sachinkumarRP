<?php

namespace RightpointAssignment\ProductAttributes\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Registry;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Helper\Output;

class Value implements ArgumentInterface
{
    /**
     * @var Output
     */

    private $catalogHelper;
    const ATTRIBUTE_VALUE = 'nutration';

    /**
     * @param Context $context
     * @param Product $product
     * @param ProductRepositoryInterface $productRepository
     * @param Registry $registry
     * @param Output $catalogHelper
     */
    public function __construct(
        Context $context,
        Product $product,
        ProductRepositoryInterface $productRepository,
        Registry $registry,
        Output $catalogHelper
    ) {
        $this->product = $product;
        $this->catalogHelper = $catalogHelper;
        $this->registry = $registry;
        $this->productRepository = $productRepository;
    }

    /**
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getProductAttribute()
    {
        $currentProduct = $this->registry->registry('current_product');
        $productId = $currentProduct->getId();
        return $this->catalogHelper->productAttribute($currentProduct, $currentProduct->getData(self::ATTRIBUTE_VALUE), self::ATTRIBUTE_VALUE);
    }

    /**
     * @return mixed
     */
    public function getProductAttributeLabel()
    {
        $currentProduct = $this->registry->registry('current_product');
        $productId = $currentProduct->getId();
        $product = $this->product->load($productId);
        $productattributelabel =$this->product->getResource()->getAttribute(self::ATTRIBUTE_VALUE)->getFrontend()->getLabel();
        return $productattributelabel;
    }

}
