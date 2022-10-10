<?php

namespace RightpointAssignment\SalesOrderNewSection\Block\Adminhtml\Order\View;

use Magento\Backend\Block\Template;

class CustomContent extends Template
{
    public function getOrderCustom()
    {
        $Data = "Static Content";
        return $Data;
    }
}
