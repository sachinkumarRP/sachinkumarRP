<?php
declare(strict_types=1);

namespace RightpointAssignment\CategoryNewGraphql\Model\Resolver;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Catalog\Model\CategoryFactory;


class Categories implements ResolverInterface
{
    /**
     * @var CategoryRepository
     */
    protected $storeManager;
    protected $categoryFactory;
    protected $childCollection;

    /**
     * @param StoreManagerInterface $storeManager
     * @param CollectionFactory $categoryCollection
     * @param CategoryFactory $categoryFactory
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        CategoryFactory $categoryFactory
    ) {
        $this->storeManager = $storeManager;
        $this->categoryFactory = $categoryFactory;
    }

    /**
     * @param Field $field
     * @param $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return array|\Magento\Framework\GraphQl\Query\Resolver\Value|mixed
     */
    public function resolve(
        Field $field,
              $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        return $this->getCategoriesByRoot();
    }

    /**
     * @return int
     * @throws NoSuchEntityException
     */

    public function getRootCategoryIds()
    {
       return $this->storeManager->getStore()->getRootCategoryId();

    }


    /**
     * @return array
     * @throws GraphQlNoSuchEntityException
     */
    public function getCategoriesByRoot()
    {
        try {
            $Rootcategory = $this->categoryFactory->create()->load($this->getRootCategoryIds());
            $RootCatLists = [];
            $RootCatLists[$Rootcategory->getId()] = [
                    'name' => $Rootcategory->getName(),
                    'level' => $Rootcategory->getLevel(),
                    'url_key' => $Rootcategory->getUrlKey(),
                    'entity_id' => $Rootcategory->getEntityId(),
                    'product_count' => $Rootcategory->getProductCount(),
                    'children_count' => $Rootcategory->getChildrenCount()
                ];
        } catch (NoSuchEntityException $e) {
            throw new GraphQlNoSuchEntityException(__($e->getMessage()), $e);
        }
       return $RootCatLists;
    }
}
