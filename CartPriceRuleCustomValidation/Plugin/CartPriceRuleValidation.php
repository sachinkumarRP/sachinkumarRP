<?php

namespace RightpointAssignment\CartPriceRuleCustomValidation\Plugin;

use Magento\Checkout\Controller\Cart\CouponPost;
use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Message\ManagerInterface as MessageManagerInterface;

class CartPriceRuleValidation
{
    /**
     * Sales quote repository
     *
     * @var \Magento\Quote\Api\CartRepositoryInterface
     */
    protected $quoteRepository;

    /**
     * @var MessageManagerInterface
     */
    protected $messageManager;

    /**
     * Coupon factory
     *
     * @var \Magento\SalesRule\Model\CouponFactory
     */
    protected $couponFactory;
    protected $cart;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     * @param \Magento\Checkout\Model\Cart $cart
     * @param \Magento\SalesRule\Model\CouponFactory $couponFactory
     * @param \Magento\Quote\Api\CartRepositoryInterface $quoteRepository
     * @codeCoverageIgnore
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        \Magento\Checkout\Model\Cart $cart,
        \Magento\SalesRule\Model\CouponFactory $couponFactory,
        \Magento\Quote\Api\CartRepositoryInterface $quoteRepository,
        MessageManagerInterface $messageManager
    ) {
        $this->couponFactory = $couponFactory;
        $this->quoteRepository = $quoteRepository;
        $this->cart = $cart;
        $this->messageManager = $messageManager;
    }
    public function beforeExecute(CouponPost $subject) {
        $couponCode = $subject->getRequest()->getParam('coupon_code');
        if ($couponCode === '20PERCENTOFF') {
            $this->messageManager->addErrorMessage(__('20PERCENTOFF is invalid coupon.'));
        } else {
            $this->messageManager->addSuccessMessage(__('You used valid coupon code.'));
        }
    }
}
