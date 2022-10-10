<?php

namespace RightpointAssignment\SalesOrderDataById\Model\Resolver;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Sales\Api\OrderRepositoryInterface;

class SalesOrderById implements ResolverInterface
{
    private $orderRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository
    ) {
        $this->orderRepository = $orderRepository;
    }

    /**
     * @inheritdoc
     */
    public function resolve(
        Field $field,
              $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        $salesId = $this->getSalesId($args);
        $salesData = $this->getSalesData($salesId);

        return $salesData;
    }

    /**
     * @param array $args
     * @return int
     * @throws GraphQlInputException
     */
    private function getSalesId(array $args): int
    {
        if (!isset($args['id'])) {
            throw new GraphQlInputException(__('"sales id should be specified'));
        }

        return (int)$args['id'];
    }

    /**
     * @param int $orderId
     * @return array
     * @throws GraphQlNoSuchEntityException
     */
    private function getSalesData(int $orderId): array
    {
        try {
            $order = $this->orderRepository->get($orderId);
            foreach ($order->getAllItems() as $item) {
                $itemsData[] = $item->getData();
                $pageData = [
                    'entity_id' => $order->getEntityId(),
                    'ordered_qty' => $order->getTotalQtyOrdered(),
                    'customer_name' => $order->getCustomerFirstname() . ' ' . $order->getCustomerLastname(),
                    'amount' => $order->getGrandTotal(),
                    'coupon_code' => $order->getcode(),
                    'shipping_method' => $order->getShippingMethod(),
                    'payment_methods' => $order->getPayment()->getMethod(),
                    'increment_id' => $order->getIncrementId(),
                    'items' => $itemsData
                ];
            }
        } catch (NoSuchEntityException $e) {
            throw new GraphQlNoSuchEntityException(__($e->getMessage()), $e);
        }
        return $pageData;

    }
}
