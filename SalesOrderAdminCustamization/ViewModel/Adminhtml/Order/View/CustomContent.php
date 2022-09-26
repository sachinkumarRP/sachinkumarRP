<?php

namespace RightpointAssignment\SalesOrderAdminCustamization\ViewModel\Adminhtml\Order\View;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\View\Element\Template;
use Magento\Backend\Block\Template\Context;
use RightpointAssignment\SalesOrderAdminCustamization\Model\ResourceModel\AddistionalDetail\CollectionFactory;
use Rightpoint\Test\Helper\Data;

class CustomContent implements ArgumentInterface
{
    public $collection;

    public function __construct(Context $context, CollectionFactory $collectionFactory)
    {
        $this->collection = $collectionFactory;
    }

    public function getOrderCustom()
    {
        $data = "Basic Information";
        return $data;
    }

    public function getCollection()
    {
        return $this->collection->create();
    }

    public function getFormAction()
    {
        return $this->getUrl('adminadditionalinfo/formcontroller/submitonclick');
    }
}
