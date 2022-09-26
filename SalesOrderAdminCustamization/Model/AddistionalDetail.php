<?php

namespace RightpointAssignment\SalesOrderAdminCustamization\Model;

use RightpointAssignment\SalesOrderAdminCustamization\Model\ResourceModel\AddistionalDetail as AddistionalDetailResourceModel;
use Magento\Framework\Model\AbstractModel;

class AddistionalDetail extends AbstractModel
{

    const CACHE_TAG = 'shipping_information';
    protected $_cacheTag = 'shipping_information';
    protected $_eventPrefix = 'shipping_information';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(AddistionalDetailResourceModel::class);
    }

    /**
     * @return string[]
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * @return array
     */
    public function getDefaultValues()
    {
        $values = [];
        return $values;
    }
}
