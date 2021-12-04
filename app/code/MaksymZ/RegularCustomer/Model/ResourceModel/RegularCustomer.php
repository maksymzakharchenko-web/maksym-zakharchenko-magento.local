<?php

declare(strict_types=1);

namespace MaksymZ\RegularCustomer\Model\ResourceModel;

class RegularCustomer extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * @inheritDoc
     */
    protected function _construct(): void
    {
        $this->_init('maksymz_regular_customer_request', 'request_id');
    }
}
