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

class ChildSubCategoryLevelFour implements ResolverInterface
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
        $CategoryLevelThreeId = $value['entity_id'];
        return $this->getSubCategoryDataLevelFour($CategoryLevelThreeId);
    }

    /**
     * @param $CategoryLevelThreeId
     * @return array
     * @throws GraphQlNoSuchEntityException
     */

    public function getSubCategoryDataLevelFour($CategoryLevelThreeId){
        try {
            $CategoryThirdLevel = $this->categoryFactory->create()->load($CategoryLevelThreeId);
            $CategoryLevelFour = $CategoryThirdLevel->getChildrenCategories();
            $CatLevelFourArray = [];
            foreach ($CategoryLevelFour as $ChildCategoryLevelFour) {
                $CatLevelFourArray[$ChildCategoryLevelFour->getId()] = [
                    'name' => $ChildCategoryLevelFour->getName(),
                    'level' => $ChildCategoryLevelFour->getLevel(),
                    'url_key' => $ChildCategoryLevelFour->getUrlKey(),
                    'entity_id' => $ChildCategoryLevelFour->getEntityId(),
                    'product_count' => $ChildCategoryLevelFour->getProductCount(),
                    'children_count' => $ChildCategoryLevelFour->getChildrenCount()
                ];
            }
        }catch (NoSuchEntityException $e) {
            throw new GraphQlNoSuchEntityException(__($e->getMessage()), $e);
        }
        return $CatLevelFourArray;
    }

}
