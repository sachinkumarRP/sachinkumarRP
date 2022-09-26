<?php

namespace RightpointAssignment\SalesOrderAdminCustamization\Model;

use RightpointAssignment\SalesOrderAdminCustamization\Model\ResourceModel\AddistionalDetail as AddistionalDetailResourceModel;
use Magento\Framework\Model\AbstractModel;

class AddistionalDetail extends AbstractModel
{
    const CACHE_TAG = 'shipping_information';
    protected $_cacheTag = 'shipping_information';
    protected $_eventPrefix = 'shipping_information';

    protected function _construct()
    {
        $this->_init(AddistionalDetailResourceModel::class);
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];
        return $values;
    }
}
