<?php
declare(strict_types=1);

namespace RightpointAssignment\CategoryNewGraphql\Model\Resolver;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;
use Magento\Catalog\Model\CategoryFactory;

class ChildCategoryData implements ResolverInterface
{
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;
    protected $categoryCollection;
    protected $categoryFactory;

    /**
     * @param StoreManagerInterface $storeManager
     * @param CategoryFactory $categoryFactory
     * @param CollectionFactory $categoryCollection
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        CategoryFactory $categoryFactory,
        CollectionFactory $categoryCollection
    ) {
        $this->storeManager = $storeManager;
        $this->categoryCollection = $categoryCollection;
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
        $RootId = $value['entity_id'];
        return $this->getSubCategoryData($RootId);
    }

    /**
     * @param $RootId
     * @return array
     * @throws GraphQlNoSuchEntityException
     */
    public function getSubCategoryData($RootId){
        try {
            $RootCategory = $this->categoryFactory->create()->load($RootId);
            $CategorySecondLevel = $RootCategory->getChildrenCategories();
            $CategorySecondLevelArray = [];
            foreach ($CategorySecondLevel as $ChildCategorySecondLevel) {
                $CategorySecondLevelArray[$ChildCategorySecondLevel->getId()] = [
                    'name' => $ChildCategorySecondLevel->getName(),
                    'level' => $ChildCategorySecondLevel->getLevel(),
                    'url_key' => $ChildCategorySecondLevel->getUrlKey(),
                    'entity_id' => $ChildCategorySecondLevel->getEntityId(),
                    'product_count' => $ChildCategorySecondLevel->getProductCount(),
                    'children_count' => $ChildCategorySecondLevel->getChildrenCount()
                ];
            }
        }catch (NoSuchEntityException $e) {
            throw new GraphQlNoSuchEntityException(__($e->getMessage()), $e);
        }
        return $CategorySecondLevelArray;
    }
}
