<?php

namespace RightpointAssignment\ProductCmsPage\ViewModel;

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
        $product = $this->registry->registry('current_product');
        $productId = $product->getId();
        return $this->catalogHelper->productAttribute($product, $product->getData('nutration'), 'nutration');

    }

    /**
     * @return mixed
     */
    public function getProductAttributeLabel()
    {
        $prodvar = $this->registry->registry('current_product');
        $productId = $prodvar->getId();
        $product = $this->product->load($productId);
        $productattributelabel =$this->product->getResource()->getAttribute('nutration')->getFrontend()->getLabel();
        return $productattributelabel;
    }

}
