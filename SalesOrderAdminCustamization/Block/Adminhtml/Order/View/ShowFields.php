<?php

namespace RightpointAssignment\SalesOrderAdminCustamization\Block\Adminhtml\Order\View;

use Magento\Framework\View\Element\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Data\Form\FormKey;
use RightpointAssignment\SalesOrderAdminCustamization\Model\ResourceModel\AddistionalDetail\CollectionFactory;
use Rightpoint\Test\Helper\Data;
use Magento\Store\Model\StoreManagerInterface;

class ShowFields extends Template
{
    /**
     * @var CollectionFactory
     * @var FormKey
     * @var StoreManagerInterface
     */
    public $collection;
    public $formKey;
    public $storeManager;

    /**
     * @param Context $context
     * @param CollectionFactory $collectionFactory
     * @param FormKey $formKey
     * @param StoreManagerInterface $storeManager
     * @param array $data
     */
    public function __construct(
        Context $context,
        CollectionFactory $collectionFactory,
        FormKey $formKey,
        StoreManagerInterface $storeManager,
        array $data = []
    )
    {
        $this->collection = $collectionFactory;
        $this->formKey = $formKey;
        $this->storeManager = $storeManager;
        parent::__construct($context, $data);
    }

    /**
     * @return mixed
     */
    public function getCollection()
    {
        return $this->collection->create();
    }

    /**
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getFormKey()
    {
        return $this->formKey->getFormKey();
    }

    /**
     * @return string
     */
    public function getFormAction()
    {
        return $this->getUrl('salesorderadmincustamization/formcontroller/submitonclick');
    }

    /**
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getBaseUrl()
    {
        return $this->storeManager->getStore()->getBaseUrl();
    }
}
