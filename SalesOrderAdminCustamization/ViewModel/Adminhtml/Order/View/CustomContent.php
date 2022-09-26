<?php

namespace RightpointAssignment\SalesOrderAdminCustamization\ViewModel\Adminhtml\Order\View;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\View\Element\Template;
use Magento\Backend\Block\Template\Context;
use RightpointAssignment\SalesOrderAdminCustamization\Model\ResourceModel\AddistionalDetail\CollectionFactory;
use Rightpoint\Test\Helper\Data;

class CustomContent implements ArgumentInterface
{
    /**
     * @var CollectionFactory
     */
    public $collection;

    /**
     * @param Context $context
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Context $context,
        CollectionFactory $collectionFactory
    ) {
        $this->collection = $collectionFactory;
    }

    /**
     * @return string
     */
    public function getOrderCustom()
    {
        $data = "Basic Information";
        return $data;
    }

    /**
     * @return mixed
     */
    public function getCollection()
    {
        return $this->collection->create();
    }

    /**
     * @return mixed
     */
    public function getFormAction()
    {
        return $this->getUrl('adminadditionalinfo/formcontroller/submitonclick');
    }
}
