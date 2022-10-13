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


class ChildSubCategory implements ResolverInterface
{
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;
    protected $categoryCollection;
    protected $childCollection;
    protected $categoryFactory;

    /**
     * @param StoreManagerInterface $storeManager
     * @param CollectionFactory $categoryCollection
     * @param CategoryFactory $categoryFactory
     * @param $data
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        CollectionFactory $categoryCollection,
        CategoryFactory $categoryFactory,
        $data = []
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
        $childid = $value['entity_id'];
        return $this->getChildSubCategory($childid);

    }

    /**
     * @param $childId
     * @return array
     * @throws GraphQlNoSuchEntityException
     */
    public function getChildSubCategory($childId){
        try {
            $CategorySecondLevel = $this->categoryFactory->create()->load($childId);
            $CategoryThirdLevel = $CategorySecondLevel->getChildrenCategories();
            $CategoryThirdLevelArray = [];
            foreach ($CategoryThirdLevel as $ChildCategoryThirdLevel) {
                $CategoryThirdLevelArray[$ChildCategoryThirdLevel->getId()] = [
                    'name' => $ChildCategoryThirdLevel->getName(),
                    'level' => $ChildCategoryThirdLevel->getLevel(),
                    'url_key' => $ChildCategoryThirdLevel->getUrlKey(),
                    'entity_id' => $ChildCategoryThirdLevel->getEntityId(),
                    'product_count' => $ChildCategoryThirdLevel->getProductCount(),
                    'children_count' => $ChildCategoryThirdLevel->getChildrenCount()
                ];
            }
        }catch (NoSuchEntityException $e) {
            throw new GraphQlNoSuchEntityException(__($e->getMessage()), $e);
        }
        return $CategoryThirdLevelArray;
    }
}
