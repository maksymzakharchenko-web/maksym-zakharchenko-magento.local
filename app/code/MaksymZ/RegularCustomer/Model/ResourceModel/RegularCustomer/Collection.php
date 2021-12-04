<?php

declare(strict_types=1);

namespace MaksymZ\RegularCustomer\Model\ResourceModel\RegularCustomer;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @inheritDoc
     */
    protected function _construct(): void
    {
        parent::_construct();
        $this->_init(
            \MaksymZ\RegularCustomer\Model\RegularCustomer::class,
            \MaksymZ\RegularCustomer\Model\ResourceModel\RegularCustomer::class
        );
    }
}
