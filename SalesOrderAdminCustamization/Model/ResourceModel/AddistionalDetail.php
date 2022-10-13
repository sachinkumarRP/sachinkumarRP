<?php
declare(strict_types=1);

namespace RightpointAssignment\SalesOrderAdminCustamization\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class AddistionalDetail extends AbstractDb
{
    public function _construct()
    {
        $this->_init('shipping_information', 'entity_id');
    }
}
