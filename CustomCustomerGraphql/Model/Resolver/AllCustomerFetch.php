<?php
declare(strict_types=1);

namespace RightpointAssignment\CustomCustomerGraphql\Model\Resolver;


use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Rightpoint\Test\Model\ContactFactory;
use Rightpoint\Test\Model\ResourceModel\Contact\CollectionFactory;


class AllCustomerFetch implements ResolverInterface
{
    /**
     * @var ContactFactory
     * @var CollectionFactory
     */
    protected $contactFactory;
    protected $collectionFactory;

    /**
     * @param ContactFactory $contactFactory
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        ContactFactory $contactFactory,
        CollectionFactory $collectionFactory
    ) {
        $this->contactFactory = $contactFactory;
        $this->collectionFactory = $collectionFactory;
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
        return $this->getCustomCustomerValue();
    }

    /**
     * @return array
     */
    public function getCustomCustomerValue():array
    {
        $Customers = $this->collectionFactory->create();
        $Customers->setOrder('id','DESC');
        $customCustomerArray = [];
        foreach ($Customers as $Customer){
            $customCustomerArray[] = [
                'id' => $Customer->getId(),
                'name' => $Customer->getName(),
                'email' => $Customer->getEmail(),
                'phone_number' => $Customer->getPhoneNumber()
            ];
        }
        return $customCustomerArray;
    }
}
