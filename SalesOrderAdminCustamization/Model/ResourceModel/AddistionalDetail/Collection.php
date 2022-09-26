<?php
declare(strict_types=1);

namespace RightpointAssignment\SalesOrderAdminCustamization\Model\ResourceModel\AddistionalDetail;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use RightpointAssignment\SalesOrderAdminCustamization\Model\ResourceModel\AddistionalDetail as AddistionalDetailResourceModel;
use RightpointAssignment\SalesOrderAdminCustamization\Model\AddistionalDetail as AddistionalDetailModel;

class Collection extends AbstractCollection
{
    public function _construct()
    {
        $this->_init(AddistionalDetailModel::class, AddistionalDetailResourceModel::class);
        parent::_construct();
    }
}
