<?php

declare(strict_types=1);

namespace MaksymZ\RegularCustomer\Block\TopLink\View\Element\Html;

use Magento\Customer\Block\Account\SortLinkInterface;

class Link extends \Magento\Framework\View\Element\Html\Link implements SortLinkInterface
{
    public function getSortOrder()
    {
        return $this->getData(self::SORT_ORDER);
    }
}
